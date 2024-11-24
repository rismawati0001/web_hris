<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ForgotPassword extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication/ForgotPasswordModel', 'forgotPasswordModel', TRUE);
  }

  function valid_email($id)
  {
    $data = $this->security->xss_clean($id);
    if ($this->forgotPasswordModel->checkEmailReq($data) == TRUE) {
      return TRUE;
    } else {
      $this->form_validation->set_message('valid_email', 'email '. $data . " not registered");
      return FALSE;
    }
  }

  function confirmresetpassword($status=null)
  {
    if($status==''){
      $data = array(
        'gettoken'   => $this->uri->segment(4),
        'validLink'   => 'valid',
      );
    }else{
      $data = array(
        'gettoken'   => '',
        'validLink'   => 'not valid',
      );
    }

    $this->load->view('accounts/confirmresetpassword', $data);
    
  }

  function resetpass()
  {

    $gettoken = $this->uri->segment(4);

    if(!$this->forgotPasswordModel->getValidLinkResetPassword($gettoken))
    {
      redirect('accounts/forgotpassword/confirmresetpassword/undefined');
      // return ;
    }
    

    // $gettoken = $this->uri->segment(4);

    $rules = array(
      [
        'field' => 'password',
        'label' => 'password',
        'rules' => 'callback_valid_password',
      ],
      [
        'field' => 'conf_password',
        'label' => 'confirm password is required',
        'rules' => 'required|matches[password]',

      ],
    );
    $this->form_validation->set_rules($rules);

    if ($this->form_validation->run() == FALSE) {
      $data['default']['v_password'] = $this->input->post('password');
      $data['default']['v_conf_password'] = $this->input->post('conf_password');
    } else {
      $data = array(
        'password'        => md5($this->input->post('password')),
        'date_update'     => date('Y-m-d H:i:s'),
      );

      
      $this->Accounts_model->update_password($data, $gettoken);


      $getUserIdFromToken = $this->Accounts_model->getUserIdFromToken($gettoken);
      $expPassword = date('Y-m-d', strtotime("+90 days"));
      $dataHistory = array(
        'user_id'      => $getUserIdFromToken,
        'password'     => $data['password'],
        'status'       => 'Active',
        'date_insert'  => date("Y-m-d H:i:s"),
        'date_expired' => $expPassword
      );
      $this->Accounts_model->insertHistoryForgotPassword($dataHistory);


      redirect('accounts/forgotpassword/confirmresetpassword');
    }

    $datax = array(
      'gettoken'   => $this->uri->segment(4),
    );

    $this->load->view('accounts/resetpassword', $datax);
  }

  function index()
  {
    $this->form_validation->set_rules(
      'email',
      'email name must be filled',
      'required|callback_valid_email',
      array('required' => '%s.')
    );

    if ($this->form_validation->run() == FALSE) {
      $data['default']['v_email'] = $this->input->post('email');
      // echo '<script>alert(1)</script>';
      // $this->security->xss_clean($data);
    } else {
      $data = array(
        'email'           => $this->input->post('email'),
        // 'date_insert'     => date('Y-m-d H:i:s'),
      );

      $this->load->helper('string');

      $token = str_replace("@", "at", $data['email']) . random_string('alnum', 16);
      $getFullName = $this->forgotPasswordModel->saveReqForgotPassword($data['email'], $token);
      $segments = ['request_forgot_password', '?id='.$token];
      $url_link = site_url($segments);

      $bodyMail = '<tr>
                            <td>
                              Dear '.$getFullName.',
                            </td>
                            </tr>

                            <tr>
                                <td>
                                    <br>This is an email for reset your password in Web Monitoring.
                                    please click link this below 
                                    <br><br>
                                    <table>
                                        <tr>
                                            <td
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                            <a href="' . $url_link . '"
                                                class="button button-primary"
                                                target="_blank"
                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1; border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1;">Go To Page Reset Password</a>
                                            </td>
                                        </tr>
                                    </table>    
                                </td>
                            </tr>';

      $this->sendmail->sendMail(
          $this->input->post('email')
          ,''
          ,'Requset Forgot Password Web Monitoring'
          ,$bodyMail
          ,''
      );

      $this->session->set_flashdata('messagereqresetpass', "Link reset password has sent, please check your email for verification");
      redirect('forgot_password');
    }

    $data['content_view']   = 'accounts/forgot_pass';
    $data['title']          = 'Forgot Password';
    $data['h5_title']       = 'Reset Account Password';
    $this->load->view(LAYOUT_AUTHENTICATION, $data);
  }


  function valid_password($password = '')
  {
    $password = trim($password);

    $regex_lowercase = '/[a-z]/';
    $regex_uppercase = '/[A-Z]/';
    $regex_number = '/[0-9]/';
    $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

    if (empty($password)) {
      $this->form_validation->set_message('valid_password', '{field} is required.');

      return FALSE;
    }

    if (preg_match_all($regex_lowercase, $password) < 1) {
      $this->form_validation->set_message('valid_password', '{field} field must be at least one lowercase letter.');

      return FALSE;
    }

    if (preg_match_all($regex_uppercase, $password) < 1) {
      $this->form_validation->set_message('valid_password', '{field} field must be at least one uppercase letter.');

      return FALSE;
    }

    if (preg_match_all($regex_number, $password) < 1) {
      $this->form_validation->set_message('valid_password', '{field} field must have at least one number.');

      return FALSE;
    }

    if (preg_match_all($regex_special, $password) < 1) {
      $this->form_validation->set_message('valid_password', '{field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));

      return FALSE;
    }

    if (strlen($password) < 8) {
      $this->form_validation->set_message('valid_password', '{field} field must be at least 8 characters in length.');

      return FALSE;
    }

    if (strlen($password) > 32) {
      $this->form_validation->set_message('valid_password', '{field} field cannot exceed 32 characters in length.');

      return FALSE;
    }

    $gettoken = $this->uri->segment(4);
    $getUserIdFromToken = $this->Accounts_model->getUserIdFromToken($gettoken);

    if (!$this->Accounts_model->checPrevForgotPassword($password,$getUserIdFromToken)) {
      $this->form_validation->set_message('valid_password', ' previous password cannot be reused');
      return FALSE;
    } 

    return TRUE;
  }
}

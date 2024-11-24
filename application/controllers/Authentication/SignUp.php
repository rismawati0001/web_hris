<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SignUp extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Authentication/SignUpModel', 'signUpModel', TRUE);
    }

    function validPassword($password = '')
    {
        $password = trim($password);

        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

        if (empty($password)) {
            $this->form_validation->set_message('validPassword', '{field} is required.');
            return FALSE;
        }

        if (preg_match_all($regex_lowercase, $password) < 1) {
            $this->form_validation->set_message('validPassword', '{field} field must be at least one lowercase letter.');
            return FALSE;
        }

        if (preg_match_all($regex_uppercase, $password) < 1) {
            $this->form_validation->set_message('validPassword', '{field} field must be at least one uppercase letter.');
            return FALSE;
        }

        if (preg_match_all($regex_number, $password) < 1) {
            $this->form_validation->set_message('validPassword', '{field} field must have at least one number.');
            return FALSE;
        }

        if (preg_match_all($regex_special, $password) < 1) {
            $this->form_validation->set_message('validPassword', '{field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));
            return FALSE;
        }

        if (strlen($password) < 8) {
            $this->form_validation->set_message('validPassword', '{field} field must be at least 8 characters in length.');
            return FALSE;
        }

        if (strlen($password) > 32) {
            $this->form_validation->set_message('validPassword', '{field} field cannot exceed 32 characters in length.');
            return FALSE;
        }

        return TRUE;
    }

    function validUserId($userId)
    {
        if(empty($userId)){
            $this->form_validation->set_message('validUserId', "user id must be filled");
            return FALSE;
        }

        if (!$this->signUpModel->checExistUserId($userId)) {
            $this->form_validation->set_message('validUserId', $userId . " already registered.");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function validEmail($emailAddress)
    {

        if(empty($emailAddress)){
            $this->form_validation->set_message('validEmail', "email address must be filled");
            return FALSE;
        }

        if(!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)){
            $this->form_validation->set_message('validEmail', $emailAddress . " not valid.");
            return FALSE;
        }

        if (!$this->signUpModel->checExistEmail($emailAddress)) {
            $this->form_validation->set_message('validEmail', $emailAddress . " already registered.");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function index()
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), getBrowser(), dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' ');

        $this->form_validation->set_rules(
            'fullname',
            'full name must be filled',
            'required',
            array('required' => '%s.')
        );
        $this->form_validation->set_rules(
            'gender',
            'please select one of gender',
            'required',
            array('required' => '%s.')
        );
        $this->form_validation->set_rules(
            'userid',
            'user id must be filled',
            'callback_validUserId',
            array('required' => '%s.')
        );
        $this->form_validation->set_rules(
            'email',
            'email must be filled',
            'callback_validEmail',
            array('required' => '%s.')
        );


        $rules = array(
            [
                'field' => 'password',
                'label' => 'password',
                'rules' => 'callback_validPassword',
            ],
            [
                'field' => 'conf_password',
                'label' => 'confirm password',
                'rules' => 'required|matches[password]',

            ],
        );
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $data['default']['v_fullname'] = $this->input->post('fullname');
            $data['default']['v_gender'] = $this->input->post('gender');
            $data['default']['v_userid'] = $this->input->post('userid');
            $data['default']['v_email'] = $this->input->post('email');
            $data['default']['v_password'] = $this->input->post('password');
            $data['default']['v_conf_password'] = $this->input->post('conf_password');
        } else {
            $expPassword = date('Y-m-d', strtotime("+90 days"));

            $dataUsers = array(
                'user_id'               => $this->input->post('userid'),
                'password'              => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'full_name'             => $this->input->post('fullname'),
                'gender'                => $this->input->post('gender'),
                'email'                 => $this->input->post('email'),
                'status_active'         => '0',
                'attempt_login'         => '0',
                'status_lock'           => '0',
                'email_verification'    => '0',
                'date_insert'           => date('Y-m-d H:i:s'),
                'expired_password'      => $expPassword,
                'user_role'             => '3',
            );

            $config = array(
                'upload_path'   => './assets/picture_profiles',
                'allowed_types' => 'jpg|png|jpeg|bmp',
            );

            $this->load->library('upload', $config);

            if (!empty($_FILES['file_avatar']['name'][0])) {

                $config['file_name'] = 'upload_avatar';
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file_avatar')) {
                    $upload_data = $this->upload->data();
                    $file_name_tmp = $upload_data['file_name'];

                    $dataUsers['profile_picture'] = $file_name_tmp;
                } else {
                }
            } else {
                $dataUsers['profile_picture'] = 'assets/picture_profiles/default_avatar.png';
            }

            $this->load->helper('string');

            $token = $dataUsers['user_id'] . random_string('alnum', 16);
            if($this->signUpModel->saveUserAccount($dataUsers, $token))
            {
                $this->session->set_flashdata('messageinsertuser', "Your account has been submitted, please check your email for verification");
                // $segments = ['accounts', 'verifyemail', 'verification', $token];
                $segments = ['verification_email', '?id='.$token];
                $url_link = site_url($segments);

                $bodyMail = '<tr>
                                <td>
                                Dear ' . $this->input->post('fullname') . ',
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <br>This is an email verification from Web Monitoring ATMI.
                                    For complete registration process, please click link this below 
                                    <br><br>
                                    <table>
                                        <tr>
                                            <td
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                            <a href="' . $url_link . '"
                                                class="button button-primary"
                                                target="_blank"
                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1; border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1;">Activation Link</a>
                                            </td>
                                        </tr>
                                    </table>    
                                </td>
                            </tr>';

                $this->sendmail->sendMail(
                        $this->input->post('email')
                        ,''
                        ,'Verification New Register Account In Web Monitoring'
                        ,$bodyMail
                        ,'');

                redirect('signup');
            }else{
                $data['default']['v_fullname'] = $this->input->post('fullname');
                $data['default']['v_gender'] = $this->input->post('gender');
                $data['default']['v_userid'] = $this->input->post('userid');
                $data['default']['v_email'] = $this->input->post('email');
                $data['default']['v_password'] = $this->input->post('password');
                $data['default']['v_conf_password'] = $this->input->post('conf_password');
                $this->session->set_flashdata('messageinsertuserfailed', " data register not submitted");
            }
        }


        $data['content_view']   = 'authentication/signup';
        $data['title']          = 'Sign Up';
        $data['h5_title']       = 'Registration User Account';
        $data['sideImage']      = 'signup.svg';
        $data['classBox']       = 'col-lg-7 col-sm-12';
        $data['classImage']     = 'col-lg-6 col-sm-12';
        
        $this->load->view(LAYOUT_AUTHENTICATION, $data);
    }

}
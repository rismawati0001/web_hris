<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ResetPassword extends CI_Controller
{

    var $getUserIdFromToken = '';

    function __construct()
    {
        parent::__construct();
        $this->load->model('Authentication/ResetPasswordModel', 'resetPasswordModel', TRUE);
        $this->load->model('Dashboard/UserAccount/ProfileModel', 'profileModel', TRUE);
    }

    function index()
    {

        $data['messageResetPassword']      = '';
        $url = parse_url($_SERVER['REQUEST_URI']);

        if(sizeof($url)==1){
            die("url not valid");
        }

        parse_str($url['query'], $params);

        // print_r($params);
        $keys = array_keys($params);
        // echo $keys[0]. PHP_EOL;

        if($keys[0] != "id"){
            die("parameter not valid");
        }

        if(empty($params['id'])){
            die("parameter is empty");
            die($params['id']);
        }

        if(!$this->resetPasswordModel->getValidLinkResetPassword($params['id'])){
            $data['messageResetPassword']      = 'has confirmed';
        }else{

            $getMailFromToken = $this->resetPasswordModel->getMailFromToken($params['id']);
            $this->getUserIdFromToken = $this->resetPasswordModel->getUserIdFromToken($getMailFromToken);
            

            $rules = array(
                [
                    'field' => 'password',
                    'label' => 'password',
                    'rules' => 'callback_validPassword',
                ],
                [
                    'field' => 'conf_password',
                    'label' => 'confirm password is required',
                    'rules' => 'required|matches[password]',
            
                ],
            );
    
            $this->form_validation->set_rules($rules);
        
            if ($this->form_validation->run() == FALSE) {
                $data['default']['v_password']      = $this->input->post('password');
                $data['default']['v_conf_password'] = $this->input->post('conf_password');
            }else{
    
                $getMailFromToken = $this->resetPasswordModel->getMailFromToken($params['id']);
    
                $expPassword = date('Y-m-d', strtotime("+90 days"));
                $vNewPassword    = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
    
                $dataUpdated = array(
                    'password'          => $vNewPassword,
                    'expired_password'  => $expPassword,
                    'date_update'       => date("Y-m-d H:i:s")
                );
    
                $whereUpdate = array(
                    'email'           => $getMailFromToken
                );
    
                $this->getUserIdFromToken = $this->resetPasswordModel->getUserIdFromToken($getMailFromToken);
            
                $this->profileModel->updatePasswordUser($dataUpdated, $whereUpdate);
    
                $dataHistory = array(
                    'user_id'      => $this->getUserIdFromToken,
                    'password'     => $vNewPassword,
                    'status'       => 'Active',
                    'date_insert'  => date("Y-m-d H:i:s"),
                    'date_expired' => $expPassword
                );
                $this->resetPasswordModel->insertHistoryPassword($dataHistory, $getMailFromToken);
    
                $data['messageResetPassword']      = 'success';
                // redirect('/');
    
            }
        }


        

        $data['urlSubmit']      = $url['query'];
        $data['content_view']   = 'accounts/reset_password';
        $data['title']          = 'Reset Password';
        $data['h5_title']       = 'Reset My Password';
        $this->load->view(LAYOUT_AUTHENTICATION, $data);
    }

    function validPassword($password = '')
    {
        $password = trim($password);

        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

        if (empty($password)) {
            $this->form_validation->set_message('validPassword', 'the {field} is required.');
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

        if (!$this->resetPasswordModel->checPrevPassword($this->getUserIdFromToken, $password)) {
            $this->form_validation->set_message('validPassword', 'previous {field} cannot be reused.');
            return FALSE;
        } 

        return TRUE;

    }

}
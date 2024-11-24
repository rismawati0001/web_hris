<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller
{
  
    function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard/UserAccount/ProfileModel', 'profileModel', TRUE);
    }

    function index($user_reg = "")
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), getBrowser(), $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' ');
        
        $dataUser = $this->profileModel->getProfileUser();
        $data = array(
            'titleWeb'            => 'Profile',
            'headerView'          => HEADER_VIEW,
            'navMenu'             => NAVIGATION_MENU,
            'headerTitle'         => 'PROFILE',
            'iconPathHeader'      => 'zmdi zmdi-balance-wallet',
            'pathHeader'          => 'Accounts - Profile',
            'contentView'         => 'dashboard/user_account/profile',
            'data_profile'        => $dataUser
        );

        $this->load->view(LAYOUT_DASHBOARD, $data);
    }

    function changeUserPassword()
    {
        $result = array();

        $result['status_field_old'] = "";
        if ($this->input->post('ajaxOldPassword') == "") {
            $result['status_field_old'] = "old password cannot empty";
        } else {
            if (!$this->profileModel->checkOldPassword($this->input->post('ajaxOldPassword'))) {
            $result['status_field_old'] = "wrong old password";
            };
        }
    
        if ($this->input->post('ajaxNewPassword') == "") {
            $result['status_field_new'] = "new password cannot empty";
        }else if ($this->input->post('ajaxNewPassword') == $this->input->post('ajaxOldPassword')) {
            $result['status_field_new'] = "new password same with old password";
        } else {
            $result['status_field_new'] = $this->valid_password($this->input->post('ajaxNewPassword'));
        }
    
        if ($this->input->post('ajaxConfPassword') == "") {
            $result['status_field_conf'] = "conf password cannot empty";
        } else {
            if ($this->input->post('ajaxConfPassword') != $this->input->post('ajaxNewPassword')) {
            $result['status_field_conf'] = "conf password not match";
            } else {
            $result['status_field_conf'] = "";
            }
        }
    
    
        if (
            $result['status_field_old'] == "" &&
            $result['status_field_new'] == "" &&
            $result['status_field_conf'] == ""
        ) {

            $expPassword = date('Y-m-d', strtotime("+90 days"));
            // $vNewPassword    = md5($this->input->post('ajaxNewPassword'));
            $vNewPassword    = password_hash($this->input->post('ajaxNewPassword'), PASSWORD_DEFAULT);

            $dataUpdated = array(
                'password'          => $vNewPassword,
                'expired_password'  => $expPassword,
                'date_update'       => date("Y-m-d H:i:s")
            );

            $whereUpdate = array(
                'user_id'           => $this->session->userdata('logged_user_id')
            );
        
            $this->profileModel->updatePasswordUser($dataUpdated, $whereUpdate);

            $dataHistory = array(
                'user_id'      => $this->session->userdata('logged_user_id'),
                'password'     => $vNewPassword,
                'status'       => 'Active',
                'date_insert'  => date("Y-m-d H:i:s"),
                'date_expired' => $expPassword
            );
            $this->profileModel->insertHistoryPassword($dataHistory);
        
            $result = array(
                "status_field" => "success",
            );
        }
        echo json_encode($result);
    }

    function valid_password($password = '')
    {
        $password = trim($password);

        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';


        if (preg_match_all($regex_lowercase, $password) < 1) {
            return 'password must be at least one lowercase letter';
        }

        if (preg_match_all($regex_uppercase, $password) < 1) {
            return 'password must be at least one uppercase letter';
        }

        if (preg_match_all($regex_number, $password) < 1) {
            return 'password must have at least one number';
        }

        if (preg_match_all($regex_special, $password) < 1) {
            return 'password must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~');
        }

        if (strlen($password) < 8) {
        return 'password must be at least 8 characters in length';
        }

        if (strlen($password) > 32) {
            return 'password cannot exceed 32 characters in length';
        }

        if (!$this->profileModel->checPrevPassword($password)) {
            return 'previous password cannot be reused';
        } 

        return '';
    }

    function changeProfilePicture()
    {
        $config = array(
            'upload_path'   => './assets/picture_profiles/',
            'allowed_types' => 'jpg|png|jpeg|bmp',
        );

        $this->load->library('upload', $config);

        if (!empty($_FILES['file_avatar']['name'][0])) {
            $files = $_FILES['file_avatar'];
            $title = "";
            $config['file_name'] = 'upload_avatar';
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file_avatar')) {
                $upload_data = $this->upload->data();
                $file_name_tmp = $upload_data['file_name'];


                $dataUpdated = array(
                    'profile_picture'     => 'assets/picture_profiles/'.$file_name_tmp,
                    'date_update'       => date("Y-m-d H:i:s")
                );
    
                $whereUpdate = array(
                    'user_id'           => $this->session->userdata('logged_user_id')
                );
            } 
        } 

        $this->profileModel->changeProfilePicture($dataUpdated, $whereUpdate);
        $this->session->set_userdata('logged_picture_profile', $dataUpdated['profile_picture']);
        echo json_encode($dataUpdated);
    }

}


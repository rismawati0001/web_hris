<?php

class SignUpModel extends CI_Model
{

    function checExistUserId($userId)
    {
        $this->db->escape($userId);
        $query = $this->db->get_where('user_accounts', array('user_id' => $userId));
        return ($query->num_rows() > 0) ? FALSE : TRUE;
    }

    function getDetailNewUserRegister($tokenEmail)
    {
        $query = $this->db->get_where('history_email_verfication', array('token' => $tokenEmail));
        
        if($query){
            if($query->num_rows() > 0){
                $mailAddress = $query->row()->email;

                $query = $this->db->get_where('user_accounts', array('email' => $mailAddress));
                if($query->num_rows() > 0){
                    $fullName = $query->row()->full_name;
                    return $fullName;
                }else{
                    return FALSE; 
                }
            }
        }else{
            return FALSE;
        }
        
    }

    function checkUserRoleAdministrator()
    {
        $query = $this->db->get_where('user_accounts', array('user_role' => '1'));
        $mailTo = '';
        if($query->num_rows() > 0){
            foreach ($query->result() as $dataUser) {
                $mailTo .= $dataUser->email. ';';
            }
            return $mailTo;
        }else{
            return 'there are no user admin';
        }
    }

    function checExistEmail($emailAddress)
    {
        $this->db->escape($emailAddress);
        $query = $this->db->get_where('user_accounts', array('email' => $emailAddress));
        return ($query->num_rows() > 0) ? FALSE : TRUE;
    }

    function saveUserAccount($dataUser, $token)
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                        . 'save data user to table iso_users' 
                    );

        if($this->db->insert('user_accounts', $dataUser)){
            if ($this->db->affected_rows() > 0) {

                $this->saveHistoryPasswordUsers($dataUser);
                $this->saveEmailVerify($dataUser,$token);

                logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                        . 'save data user account successfully' 
                    );
                
                return TRUE;
            }
        }else{
            $error_query = $this->db->error();
            logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                        . 'save data user_accounts failed : '. $error_query['message'] 
                    );
            return FALSE;
        }
    }

    function saveHistoryPasswordUsers($dataUsers)
    {
        $historyPass = array(
            'user_id'           => $dataUsers['user_id'],
            'password'          => $dataUsers['password'],
            'date_insert'       => date("Y-m-d H:i:s"),
            'date_expired'      => $dataUsers['expired_password'],
            'status'            => 'Active',
        );

        if($this->db->insert('history_password_users', $historyPass))
        {
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }else{
                return 'inserted record to history_password_users 0 rows';  
            }
        }else{
            $error_query = $this->db->error();
            logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                        . 'save data history_password_users failed : '. $error_query['message'] 
                    );
            return FALSE;
        }
    }

    function saveEmailVerify($dataUser,$token)
    {
        $now = date("Y-m-d H:m:s");
        $expiredLink = date("Y-m-d H:i:s", strtotime('+3 hours', strtotime($now))); // $now + 3 hours
        $dataEmail = array(
            'user_id'         => $dataUser['user_id'],
            'email'           => $dataUser['email'],
            'status'          => 'false',
            'expired_token'   => $expiredLink,
            'token'           => $token,
            'date_insert'     => date('Y-m-d H:i:s'),
        );

        if($this->db->insert('history_email_verfication', $dataEmail))
        {
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }else{
                return 'inserted record to history_email_verfication 0 rows';  
            }
        }else{
            $error_query = $this->db->error();
            logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                        . 'save data history_email_verfication failed : '. $error_query['message'] 
                    );
            return FALSE;
        }
    }

    function checkStatusTokenEmailVerify($tokenEmail)
    {
        $this->db->escape($tokenEmail);
        $query = $this->db->get_where('history_email_verfication', array('token' => $tokenEmail));
        
        if($query->num_rows() > 0){
            $statusToken = $query->row()->status;
            $mailAddress = $query->row()->email;
            if($statusToken=='false'){

                $updateData = array(
                    'status' => 'true'
                );
                $whereUpdate = array(
                    'token'           => $tokenEmail
                );

                $this->db->update('history_email_verfication', $updateData, $whereUpdate);
                if ($this->db->affected_rows() > 0) {

                    $updateData = array(
                        'email_verification' => '1'
                    );
                    $whereUpdate = array(
                        'email'           => $mailAddress
                    );
                    $this->db->update('user_accounts', $updateData, $whereUpdate);

                    if ($this->db->affected_rows() > 0) {
                        return 'token is valid';
                        // return TRUE;
                    }else{
                        return FALSE;
                    }

                }else{
                    return FALSE;
                }
            }else if($statusToken=='true'){
                return "token is verified";
            }
            return TRUE;
        }else{
            return FALSE;
        }
    }

}
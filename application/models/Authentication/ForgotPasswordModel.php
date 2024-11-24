<?php

class ForgotPasswordModel extends CI_Model
{

    function checkEmailReq($emailAddress)
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                    );
        $this->db->escape($emailAddress);
        $query = $this->db->get_where('user_accounts', array('email' => $emailAddress));
        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }

    function saveReqForgotPassword($email,$token)
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                    );
        $now = date("Y-m-d H:m:s");
        $expired_link = date("Y-m-d H:i:s", strtotime('+3 hours', strtotime($now))); // $now + 3 hours
        $data_email = array(
            'email'         => $email,
            'token'         => $token,
            'status'        => 'not confirmed',
            'date_insert'   => date('Y-m-d H:i:s'),
        );

        if($this->db->insert('request_forgot_password', $data_email))
        {
            $query = $this->db->get_where('user_accounts', array('email' => $email))->row();
            return $query->full_name;
        }else{
            return FALSE;
        }
    }

}
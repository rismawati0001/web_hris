<?php

class ResetPasswordModel extends CI_Model
{

    function getValidLinkResetPassword($token)
    {
        $query =  $this->db->get_where('request_forgot_password', 
                array(
                    'token' => $token,
                    'status' => 'not confirmed'
                ));

        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function getUserIdFromToken($mail)
    {
        $query =  $this->db->get_where(
            'user_accounts',
            array(
                'email' => $mail
            )
        )->row()->user_id;

        return $query;
    }

    function getMailFromToken($token)
    {
        $query =  $this->db->get_where(
            'request_forgot_password',
            array(
                'token' => $token
            )
        )->row()->email;

        return $query;
    }

    function insertHistoryPassword($historyPass,$emailUser)
    {

        $whereUpdate = array(
            'user_id'           => $historyPass['user_id'],
            'status'            => 'Active',
        );

        $updateData = array(
            'status' => 'NonActive'
        );
        
        if($this->db->update('history_password_users', $updateData, $whereUpdate)){
            if ($this->db->affected_rows() > 0){

                if($this->db->insert('history_password_users', $historyPass))
                {
                    if ($this->db->affected_rows() > 0) {

                        $whereUpdate = array(
                            'email'           => $emailUser,
                        );
                
                        $updateData = array(
                            'status'            => 'confirmed',
                            'date_update'       => date("Y-m-d H:i:s")
                        );
                        
                        $this->db->update('request_forgot_password', $updateData, $whereUpdate);

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

            }else{
                return FALSE;
            }
        }

    }

    function checPrevPassword($userId, $password)
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                    );

        $query = $this->db->query("select password from history_password_users
                                    where user_id = '".$userId."' order by id desc limit 4"
                        );
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $listPasswordUser) {
                if(password_verify($password, $listPasswordUser->password)){
                    return FALSE;
                }
            }
            return TRUE;
        } else {
            return TRUE;
        }
    }

}
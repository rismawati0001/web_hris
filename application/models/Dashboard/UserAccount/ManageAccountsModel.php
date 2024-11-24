<?php

class ManageAccountsModel extends CI_Model
{

    function updateReqOpenAccessNewUser($updateData, $userId)
    {
        $whereUpdate = array(
            'user_id'           => $userId
        );
        if($this->db->update('user_accounts', $updateData, $whereUpdate))
        {
            if ($this->db->affected_rows() > 0) {
                return 'success';
            }else{
                return FALSE;
            }
        }else{
            $error_query = $this->db->error();
            logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                        . 'save data user_accounts failed : '. $error_query['message'] 
                    );
            return $error_query['message'] ;
        }

    }

    function getDataUserAccounts()
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), getBrowser(), $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' ');
        // $query = $this->db->query('select * from user_accounts');
        $this->db->select('a.*');
		$this->db->select('b.role_name');
        $this->db->from('user_accounts a');
        $this->db->join('roles b', "a.user_role = b.role_id",'left');

        return $this->db->get()->result();
    }

    function getDataUserAccountsByUserId($userId)
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), getBrowser(), $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' ');
        // $query = $this->db->query('select * from user_accounts');

        $this->db->escape($userId);
        $query = $this->db->get_where('history_email_verfication', array('token' => $userId));
        
        if($query->num_rows() > 0){
            $mailAddress = $query->row()->email;
        }else{
            $mailAddress = '';
        }

        $this->db->select('a.*');
		$this->db->select('b.role_name');
        $this->db->from('user_accounts a');
        $this->db->join('roles b', "a.user_role = b.role_id",'left');
        $this->db->where('a.email', $mailAddress);
        return $this->db->get()->row();
    }

}
<?php

class ProfileModel extends CI_Model
{

    function getProfileUser()
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                    );

        $this->db->select('a.*');
        $this->db->select('b.role_name');
        $this->db->from('user_accounts a');
        $this->db->join('roles b', "a.user_role = b.role_id",'left');
        $this->db->where('a.user_id', $this->session->userdata('logged_user_id') );

        return $this->db->get()->row();

        // return $this->db->get_where('user_accounts', array('user_id' => $this->session->userdata('logged_user_id')))->row();

    }

    function checPrevPassword($password)
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                    );
        // $query = $this->db->query("select history_pass.* from (select password from history_password_users hpu
        //                 where user_id = '".$this->session->userdata('logged_user_id')."' order by id desc limit 4)as history_pass 
        //                 where history_pass.password = '".$password."'");

        $query = $this->db->query("select password from history_password_users
                                    where user_id = '".$this->session->userdata('logged_user_id')."' order by id desc limit 4"
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

    function checkOldPassword($password)
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                    );
        $query =  $this->db->get_where(
            'user_accounts',
            array(
                'user_id' => $this->session->userdata('logged_user_id')
            )
        );
        if ($query->num_rows() > 0) {
            
            $valRecord = $query->row();
            if(!password_verify($password, $valRecord->password)){
                return FALSE;
            }else{
                return TRUE;
            }
            
        } else {
            return FALSE;
        }
    }

    function updatePasswordUser($updateData, $whereUpdate)
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
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

        $this->db->set('expired_password', 'current_date + 90', false);
        $this->db->update('iso_users', $data, $where);
        return $this->db->affected_rows();
    }

    function insertHistoryPassword($historyPass)
    {
        if($this->db->insert('history_password_users', $historyPass))
        {
            if ($this->db->affected_rows() > 0) {

                $whereUpdate = array(
                    'user_id'           => $this->session->userdata('logged_user_id'),
                    'status'            => 'Active',
                    'password !='       => $historyPass['password']
                );
        
                $updateData = array(
                    'status' => 'NonActive'
                );
                
                if($this->db->update('history_password_users', $updateData, $whereUpdate)){
                    if ($this->db->affected_rows() > 0){
                        return TRUE;
                    }else{
                        return FALSE;
                    }
                }

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

    function changeProfilePicture($updateData, $whereUpdate)
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
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
                        . 'change profile picture user_accounts failed : '. $error_query['message'] 
                    );
            return $error_query['message'] ;
        }
    }

    

}
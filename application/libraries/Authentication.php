<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authentication
{
    var $CI = NULL;
    var $_valid = NULL;

    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        $this->CI->load->library('session');
        $this->CI->load->library('form_validation');
        $this->CI->load->helper(array('captcha','url','security'));
        $this->_valid = $this->CI->form_validation;
    }

    function create_captcha ()
    {
        $vals = array(
                'img_path'      => './assets/captcha/',
                'img_url'       => base_url().'assets/captcha/',
                'font_path'     => FCPATH.'system/fonts/texb.ttf',
                'img_width'     => '260',
                'img_height'    => '40',
                'font_size'     => '20',
                'img_id'        => 'captcha_login',
                'border'        => 0, 
                'word_length'   => 4,
                'expiration'    => 7200
            );
        $cap = create_captcha($vals);
        $this->CI->session->set_userdata('mycaptcha', $cap['word']);    
        return $cap['image'];
    }

    function check_captcha()
    {
        if($this->CI->input->post('captcha')!='') {
            if($this->CI->input->post('captcha')==$this->CI->session->set_userdata('mycaptcha'))
            {
                return true;
            }
            else
            {
                $this->CI->form_validation->set_message('check_captcha','Captcha salah');
                return false;
            }
        }
    }

    private function _cek_attemp($user_id){

        $this->CI->db->set('attempt_login', 'attempt_login+1', FALSE);
        $where = array('user_id' => $user_id);
        $this->CI->db->where($where);
        $this->CI->db->update('user_accounts');

        $this->CI->db->select('attempt_login');
        $this->CI->db->from('user_accounts');
        $this->CI->db->where('user_id', $user_id);
        $query = $this->CI->db->get()->row();

        return $query->attempt_login;

    }

    private function validation_login($user_id, $pass)
    {
        unset($_SESSION['msgValidation']);
        $valRecord = "";
        if($this->CI->input->post('captcha')!==$this->CI->session->userdata('mycaptcha')){
            $this->CI->session->set_flashdata('msgValidation', "Captcha Not Match");
        }

        if (empty($this->CI->session->flashdata('msgValidation'))){
            $record = $this->CI->db->get_where('v_validation_user_login', 
                    array(
                         'user_id' => $user_id
                    )    
                );
        
            if ($record->num_rows() > 0) {
                $valRecord = $record->row();
                
                if ($valRecord->status_lock == 0){
                    $this->CI->session->set_flashdata('msgValidation', "sory your account has locked, please contact administrator");
                // }else if ($valRecord->password != md5($pass)){
                }else if(!password_verify($pass, $valRecord->password)){

                    $attemp_login = $this->_cek_attemp($user_id);
                    if ($attemp_login >= 3){
                        
                        $this->CI->db->update(
                            'user_accounts',
                            array(
                                'status_lock' => 0,
                            ),
                            array(
                                'user_id' => $user_id,
                            )
                        );

                        $this->CI->session->set_flashdata('msgValidation', "sory your account has been locked, attemp login : ".$attemp_login. " please contact administrator");
                    }else{
                        $this->CI->session->set_flashdata('msgValidation', "user id or password not match, attemp login : ".$attemp_login);
                    }

                }else if ($valRecord->diff_days < 0){
                    $this->CI->session->set_flashdata('msgValidation', "sory your password has expired, please contact administrator");
                }else if ($valRecord->email_verification == 0){
                    $this->CI->session->set_flashdata('msgValidation', "please confirm your email addres first");
                }else if ($valRecord->status_active == 0){
                    $this->CI->session->set_flashdata('msgValidation', "your account is still non active");
                }
            }else{
                $this->CI->session->set_flashdata('msgValidation', "user id not registered");
            }
        }

        return $valRecord;
    }

    public function login($page)
    {
        $this->restrict(TRUE);
        $notif_captcha = '';

        if ($page == "") {
            $page = LAYOUT_AUTHENTICATION;
        }

        $this->_valid->set_rules(
            'username',
            'user name must be filled',
            'required',
            array('required' => '%s.')
        );

        $this->_valid->set_rules(
            'password',
            'password',
            'required|min_length[6]',
            array('required' => 'You must provide a %s.')
        );

        $this->CI->form_validation->set_rules('captcha','captcha must be filled', 'required');

        if ($this->_valid->run() !== FALSE and ($this->CI->input->post('submit_login') != FALSE || $this->CI->input->post('v_submit_login') == 'posting')) {

            $login = array(
                'user' => $this->CI->input->post('username'), 
                'pass' => $this->CI->input->post('password')
            );

            $getDataLogin = $this->validation_login($login['user'],$login['pass']);
            if (empty($this->CI->session->flashdata('msgValidation'))){
                $this->CI->db->update(
                    'user_accounts',
                    array(
                        'last_login' => date('Y-m-d H:i:s'),
                    ),
                    array(
                        'user_id' => $login['user'],
                    )
                );

                $this->CI->session->set_userdata('logged_user_id', $getDataLogin->user_id);
                $this->CI->session->set_userdata('logged_full_name', $getDataLogin->full_name);
                $this->CI->session->set_userdata('logged_last_login', $getDataLogin->last_login);
                $this->CI->session->set_userdata('logged_picture_profile', $getDataLogin->profile_picture);
                $this->CI->session->set_userdata('logged_role_name', $getDataLogin->role_name);
                $this->getUserAccessMenu($login['user']);

                $this->redirect();
            }
                
        }
        
        $data = array(
            'title'             => 'Sign In', 
            'h5_title'          => 'Human Resources Information System',
            'content_view'      => 'authentication/signin',
            'compare_captcha'   => $notif_captcha,
            'img'               => $this->create_captcha(),
            'sideImage'         => 'signin.svg',
            'classBox'          => 'col-lg-4 col-sm-12',
            'classImage'        => 'col-lg-8 col-sm-12'
        );
        $data['default']['v_username'] = $this->CI->input->post('username');
        $data['default']['v_password'] = $this->CI->input->post('password');
        $data['default']['captcha']    = $this->CI->input->post('captcha');
        $this->CI->load->view($page, $data);
    }

    public function logout()
    {
        $this->CI->session->sess_destroy();
        redirect('/');
    }

    public function logged_in()
    {
        if ($this->CI->session->userdata('logged_user_id') == "") {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function redirect()
    {
        if ($this->CI->session->userdata('redirector') == "") {
            redirect('dashboard');
        } else {
            redirect($this->CI->session->userdata('redirector'));
        }
    }

    public function restrict($logged_out = FALSE)
    {
        if ($logged_out and $this->logged_in()) {
            $this->redirect();
        }

        if (!$logged_out and !$this->logged_in()) {
            $this->CI->session->set_userdata('redirector', $this->CI->uri->uri_string());
            redirect('/', 'location');
        }
    }

    function getUserAccessMenu($user_id)
    {
        $this->CI->db->select('category');
        $this->CI->db->select('page_name');
        // $this->CI->db->select('count(*) over (partition by category) as count_category');
        $this->CI->db->select('count_menu');
        $this->CI->db->select('ROW_NUMBER() OVER (partition by category ORDER BY menu_id) as row_num_category');
        $this->CI->db->select('icon_menu');
        $this->CI->db->select('url_menu');
        $this->CI->db->select('count(*) over (partition by category) as count_category');
        $this->CI->db->order_by('menu_id', 'asc');
        $query = $this->CI->db->get_where('v_get_user_access_menu', 
                    array(
                        'user_id' => $user_id
                    )    
                )->result();

        $menuAccess = array();
        foreach ($query as $val) {
            $arrayMenu=array(
                    $val->category,
                    $val->page_name,
                    // $val->count_category,
                    $val->count_menu,
                    $val->row_num_category,
                    $val->icon_menu,
                    $val->url_menu,
                    $val->count_category
                );
            array_push ($menuAccess,$arrayMenu);
        }


        $this->CI->session->set_userdata('listAccessMenu', $menuAccess);

    }

    public function restrict_level($level)
    {
        if (TRUE == $this->check_level($level)) {
            $this->redirect_restrict();
        }
    }

    public function redirect_restrict()
    {
        redirect($this->CI->config->item('restrict_view'));
    }
    
    public function check_level($level = "1")
    {
        $cookie = substr($this->CI->session->userdata('logged_user_level'), 3);
        if ($cookie != $level) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function permission_page($page)
    {
        $this->CI->db->select('page_controller');
        $this->CI->db->from('iso_permission_page');
        $this->CI->db->where('user_name', $this->CI->session->userdata('logged_user_name'));
        $this->CI->db->where('page_controller', $page);
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            redirect($this->CI->config->item('restrict_view'));
        }
    }

    public function role_page()
    {
        $this->CI->db->select('user_right');
        $this->CI->db->from('iso_users');
        $this->CI->db->where('user_name', $this->CI->session->userdata('logged_user_name'));
        $query = $this->CI->db->get()->row()->user_right;

        if ($query==1) {
            return TRUE;
        } else {
            redirect($this->CI->config->item('restrict_view'));
        }
    }

    public function restrict_page($page)
    {
        $this->CI->db->select('page_controller');
        $this->CI->db->from('iso_permission_page');
        $this->CI->db->where('user_name', $this->CI->session->userdata('logged_user_name'));
        $this->CI->db->where('page_controller', $page);
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            redirect($this->CI->config->item('restrict_view'));
        }

    }
    
}

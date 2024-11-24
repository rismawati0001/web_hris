<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    var $_admin_view = "";

	function __construct()
	{
		parent::__construct();
        $this->authentication->restrict();
    }
    
    public function restrict_level($level)
    {
        $this->myauth->restrict_level($level);
        $this->_admin_view = $this->config->item('admin_view')."wrapper.php";
    }
    
    public function check_level($level)
    {
        return $this->myauth->check_level($level);
    }
    public function loadView()
    {
        $test_layout_view = array(
            'header_view'         => LAYOUT_HEADER_VIEW,
            'menu_dashboard'      => LAYOUT_MENU_DASHBOARD,
            'menu_accounts'       => LAYOUT_MENU_ACCOUNTS,
            'menu_atm'            => LAYOUT_MENU_ATM,
            'menu_oy'             => LAYOUT_MENU_OY,
            'menu_ptpr'           => LAYOUT_MENU_PTPR,
            'menu_reporting'      => LAYOUT_MENU_REPORTING,
            'menu_admin_card'     => LAYOUT_MENU_ADMIN_CARD,
        );
 
        return $test_layout_view;
    }
}

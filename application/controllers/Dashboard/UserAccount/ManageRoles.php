<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ManageRoles extends MY_Controller
{
  
    function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard/UserAccount/ManageAccountsModel', 'manageAccountsModel', TRUE);
    }

    function index($user_reg = "")
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), getBrowser(), $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' ');
        $data = array(
          'titleWeb'            => 'Manage Roles',
          'headerView'          => HEADER_VIEW,
          'navMenu'             => NAVIGATION_MENU,
          'headerTitle'         => 'MANAGE ROLES',
          'iconPathHeader'      => 'zmdi zmdi-balance-wallet',
          'pathHeader'          => 'Accounts - Manage Roles',
          'contentView'         => 'dashboard/user_account/manage_roles',
        );

        $this->load->view(LAYOUT_DASHBOARD, $data);
    }

}


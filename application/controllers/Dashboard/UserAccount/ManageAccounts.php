<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ManageAccounts extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard/UserAccount/ManageAccountsModel', 'manageAccountsModel', TRUE);
    }

    function index()
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), getBrowser(), $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' ');
        $data = array(
          'titleWeb'            => 'Manage Accounts',
          'headerView'          => HEADER_VIEW,
          'navMenu'             => NAVIGATION_MENU,
          'headerTitle'         => 'MANAGE USER ACCOUNTS',
          'iconPathHeader'      => 'zmdi zmdi-balance-wallet',
          'pathHeader'          => 'Accounts - Manage Accounts',
          'contentView'         => 'dashboard/user_account/manage_accounts',
          'userId'              => '',
          'fullName'            => '',
          'email'               => '',
          'gender'              => '',
          'status_active'       => '',
          'status_lock'         => '',
          'email_verification'  => '',
          'user_role'           => ''
        );

        $this->load->view(LAYOUT_DASHBOARD, $data);
    }

    function getListUserAccounts()
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), getBrowser(), $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' ');
        header('Content-Type: application/json');
        $query = $this->manageAccountsModel->getDataUserAccounts();
        $no = 1;
        $data = [];

        foreach ($query as $dtUserAccounts) {
            $data[] = array(
                "user_id"             => $dtUserAccounts->user_id,
                "full_name"           => $dtUserAccounts->full_name,
                "gender"              => $dtUserAccounts->gender,
                "email"               => $dtUserAccounts->email,
                "status_active"       => ($dtUserAccounts->status_active==1 ? 'True' : 'False'),
                "last_login"          => $dtUserAccounts->last_login,
                "attempt_login"       => $dtUserAccounts->attempt_login,
                "status_lock"         => ($dtUserAccounts->status_lock==1 ? 'Unlock' : 'Lock'),
                "email_verification"  => ($dtUserAccounts->email_verification==1 ? 'True' : 'False'),
                "date_insert"         => $dtUserAccounts->date_insert,
                "expired_password"    => $dtUserAccounts->expired_password,
                "user_role"           => $dtUserAccounts->role_name,
                'cell_actions'        => '<button class="btn btn-primary btn-sm edit-accounts"><i class="zmdi zmdi-edit"></i></button>
                                          <button class="btn btn-danger btn-sm" onclick="delete_manage_accounts(this.value,' . "'" . $dtUserAccounts->user_id . "'" . ',' . "'" . $dtUserAccounts->full_name . "'" . ')"><i class="zmdi zmdi-delete"></i></button>'
            );
        }
        $result = array(
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    function openAccessUser()
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), getBrowser(), $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' ');
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

        $getDetailUserId = $this->manageAccountsModel->getDataUserAccountsByUserId($params['id']);

        $data = array(
          'titleWeb'            => 'Manage Accounts',
          'headerView'          => HEADER_VIEW,
          'navMenu'             => NAVIGATION_MENU,
          'headerTitle'         => 'MANAGE USER ACCOUNTS',
          'iconPathHeader'      => 'zmdi zmdi-balance-wallet',
          'pathHeader'          => 'Accounts - Manage Accounts',
          'contentView'         => 'dashboard/user_account/manage_accounts',
          'userId'              => ($getDetailUserId==null ? '' : $getDetailUserId->user_id),
          'fullName'            => ($getDetailUserId==null ? '' : $getDetailUserId->full_name),
          'email'               => ($getDetailUserId==null ? '' : $getDetailUserId->email),
          'gender'              => ($getDetailUserId==null ? '' : $getDetailUserId->gender),
          'status_active'       => ($getDetailUserId==null ? '' : ($getDetailUserId->status_active==1 ? 'True' : 'False')),
          'status_lock'         => ($getDetailUserId==null ? '' : ($getDetailUserId->status_lock==1 ? 'Unlock' : 'Lock')),
          'email_verification'  => ($getDetailUserId==null ? '' : ($getDetailUserId->email_verification==1 ? 'True' : 'False')),
          'user_role'           => ($getDetailUserId==null ? '' : $getDetailUserId->role_name), 
          // 'detailUsers'         => print_r($getDetailUserId)
        );

        $this->load->view(LAYOUT_DASHBOARD, $data);
    }

    function submitReqOpenAccessNewUser()
    {
        $updateData = array(
          'status_active'       => ($this->input->post('ajaxActive')=='False' ? '0' : '1'),
          'status_lock'         => ($this->input->post('ajaxLock')=='Lock' ? '0' : '1'),
          'email_verification'  => ($this->input->post('ajaxEmailVerify')=='False' ? '0' : '1'),
          'user_role'           => ($this->input->post('ajaxRole')=='Administrator' ? '1' : '3'),
          'date_update'         => date("Y-m-d H:i:s")
        );
        $updateReqOpenAccessNewUser = $this->manageAccountsModel->updateReqOpenAccessNewUser($updateData, $this->input->post('ajaxUserId'));
        if($updateReqOpenAccessNewUser=='success'){
          echo json_encode(array("status" => 'success'));
        }else{
          echo json_encode(array("status" => $updateReqOpenAccessNewUser));
        }
    }

}


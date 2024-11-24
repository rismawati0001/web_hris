<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class RekapContract extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Dashboard/HomeModel' , 'homeModel', TRUE);
  }

  function index()  
  {
    logActivity(date("Y-m-d").' '.date("H:i:s"), getBrowser(), $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' ');
    
    $data = array(
      'titleWeb'            => 'Pegawai - Rekap Contract',
      'headerView'          => HEADER_VIEW,
      'navMenu'             => NAVIGATION_MENU,
      'headerTitle'         => 'Rekap Contract Pegawai',
      'iconPathHeader'      => 'zmdi zmdi-home',
      'pathHeader'          => 'Pegawai - Rekap Contract',
      'contentView'         => 'dashboard/pegawai/rekap_contract',
    );

    
    $this->load->view(LAYOUT_DASHBOARD, $data);
  }
  
}

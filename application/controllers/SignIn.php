<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SignIn extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        // require_once APPPATH."third_party/phpqrcode/qrlib.php";
        // QRcode::png("hari1234","test123.png","M",10,10);
        // echo "<img src='".base_url("test123.png")."'>" ;

        // try {
        //     // Step 1: Load the existing Excel file
        //     $inputFileName = 'assets/template_excel/test template.xlsx';  // Replace with your file path
        //     $spreadsheet = IOFactory::load($inputFileName);
        
        //     // Step 2: Modify the spreadsheet (e.g., change a value in a cell)
        //     $sheet = $spreadsheet->getActiveSheet();  // Get the active sheet
        //     $sheet->setCellValue('C28', '√');  // Set a new value in cell A1
        //     // $sheet->setCellValue('B2', 'Depok');  // Set a new value in cell A1
        
        //     // Step 3: Save the changes to the existing file or a new file
        //     $writer = new Xlsx($spreadsheet);
        //     $writer->save('assets/template_excel/modified_file.xlsx');  // You can overwrite the original file or save as a new one
        
        //     echo "File has been written successfully!";
        // } catch (Exception $e) {
        //     echo 'Error loading file: ', $e->getMessage();
        // }

        //load spreadsheet
        // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("/assets/template_excel/test template.xlsx");

        // //change it
        // $sheet = $spreadsheet->getActiveSheet();
        // $sheet->setCellValue('A2', 'New Value');
        // $sheet->setCellValue('B2', 'New Value 2');

        // //write it again to Filesystem with the same name (=replace)
        // $writer = new Xlsx($spreadsheet);
        // $writer->save('/assets/template_excel/test template.xlsx');
        // $this->sendmail->sendMail('haripramono360@gmail.com','','test subject','test body','coba');
        logActivity(date("Y-m-d").' '.date("H:i:s"), getBrowser(), dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' ');
        $this->authentication->login(LAYOUT_AUTHENTICATION);   
    }

    function reload_captcha()
    {
        $config = array(
            'img_path'      => './assets/captcha/',
            'img_url'       => base_url().'assets/captcha/',
            'font_path'     => FCPATH . 'system/fonts/texb.ttf',
            'img_width'     => '260',
            'img_height'    => '40',
            'font_size'     => '20',
            'img_id'        => 'captcha_login',
            'border'        => 0,
            'word_length'   => 4,
            'expiration'    => 7200
        );
        $captcha = create_captcha($config);
        $this->session->set_userdata('mycaptcha', $captcha['word']);
        echo $captcha['image'];
    }

    function logout()
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), getBrowser(), $this->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' ');
        $this->authentication->logout();
    }

}

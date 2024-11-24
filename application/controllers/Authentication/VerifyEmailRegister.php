<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class VerifyEmailRegister extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Authentication/SignUpModel', 'signUpModel', TRUE);
    }


    function index()
    {

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

        $checkStatusVerify = $this->signUpModel->checkStatusTokenEmailVerify($params['id']);

        if($checkStatusVerify=='token is valid'){
            $data['image_notif']    = 'success';
            $data['message']        = 'Thank you, your email has been verified. <br>your account will be soon activated by administrator';

            $getDetailNewUserRegister = $this->signUpModel->getDetailNewUserRegister($params['id']);

            $segments = ['open_access_new_user', '?id='.$params['id']];
            $url_link = site_url($segments);

            $bodyMail = '<tr>
                                <td>
                                Dear Administrator,
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <br>Need your review for open access user <strong>'.$getDetailNewUserRegister.'</strong> please click link this below 
                                    <br><br>
                                    <table>
                                        <tr>
                                            <td
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                            <a href="' . $url_link . '"
                                                class="button button-primary"
                                                target="_blank"
                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1; border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1;">Manage Accounts Link</a>
                                            </td>
                                        </tr>
                                    </table>    
                                </td>
                            </tr>';

            $checkUserRoleAdmin = $this->signUpModel->checkUserRoleAdministrator();

            if($checkUserRoleAdmin=='there are no user admin'){
                $mailTo = 'hari@alto.id';
            }else{
                $mailTo = $checkUserRoleAdmin;
            }
            $this->sendmail->sendMail(
                    $mailTo
                    ,''
                    ,'Review new user registration in web monitoring'
                    ,$bodyMail
                    ,'');

        }else if ($checkStatusVerify=="token is verified"){
            $data['image_notif']    = 'danger';
            $data['message']        = 'Oops, sory your link has been confirmed';
        }else{
            $data['image_notif']    = 'danger';
            $data['message']        = 'failed update verfication email';
        }
        
        

        $data['content_view']   = 'accounts/verify_email_reg';
        $data['title']          = 'Verification Page';
        $data['h5_title']       = 'Verification Register New Account';

        $this->load->view(LAYOUT_AUTHENTICATION, $data);
        
    }

  

}
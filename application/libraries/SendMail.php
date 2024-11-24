<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendMail
{

    var $CI = NULL;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function sendMail($to, $cc, $subject, $body, $folderAttach)
    {
        logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->CI->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                        . 'started send mail : to ' . $to . ' ,cc ' . $cc . ' ,subject ' . $subject 
                    );
        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';
        
        $mail = new PHPMailer;

        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host         = 'smtp.gmail.com';
        $mail->Port         = 587;
        $mail->SMTPSecure   = 'tls';
        $mail->SMTPAuth     = true;                 // Enable SMTP authentication
        $mail->Username     = 'haripramono360@gmail.com';    // SMTP username
        $mail->Password     = 'idqg dybg iiub bgdl';          // SMTP password

        $mail->setFrom('haripramono360@gmail.com');
        
        $multiple_to = explode(";",$to);
        foreach($multiple_to as $v_to_mail)
        {
            $mail->addAddress($v_to_mail);
        }

        $multiple_cc = explode(";",$cc);
        foreach($multiple_cc as $v_cc_mail)
        {
            $mail->addCC($v_cc_mail);
        }

        $mail->Subject = $subject;
        
        $bodyMail = '<!DOCTYPE html
                            PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                        
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        
                        </head>
                        
                            <body
                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
                                <style>
                                    @media only screen and (max-width: 600px) {
                                        .inner-body {
                                            width: 100% !important;
                                        }
                            
                                        .footer {
                                            width: 100% !important;
                                        }
                                    }
                            
                                    @media only screen and (max-width: 500px) {
                                        .button {
                                            width: 100% !important;
                                        }
                                    }
                                </style>
                                
                                <table>' . $body .
                                '</table>

                                <table >
                                                            
                                    <tr>
                                    <td>Best Regards,</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="cid:my-attach" alt="signature" />
                                        </td>   
                                    </tr>
                                    
                                </table>
                            </body>
                        </html>'
                            ;


        $mail->isHTML(true);
        $mail->AddEmbeddedImage("./assets/template/images/logo-title.png", "my-attach", "logo-title.png");
        
        $mailContent = $bodyMail;
        $mail->Body = $mailContent;
        
        if($folderAttach!=""){
            $path       = './assets/attach_mail/'.$folderAttach.'/';
            $file_names = directory_map($path);

            foreach($file_names as $v_attach)
            {
                $mail->addAttachment($path.$v_attach);
            }
        }

        if(!$mail->send()){
            die($mail->ErrorInfo);
            logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->CI->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                        . 'send mail failed : to ' . $to . ' ,cc ' . $cc . ' ,subject ' . $subject 
                        . ' ,Mailer Error: ' . $mail->ErrorInfo
                    );
            return FALSE;
        }else{
            if($folderAttach!="")
            {
                foreach($file_names as $v_attach)
                {
                    unlink($path.$v_attach);
                }
            }   
            $mail->ClearAddresses();
            $mail->ClearAttachments();
            $mail->ClearAllRecipients();
            $mail->ClearCCs();

            logActivity(date("Y-m-d").' '.date("H:i:s"), 
                        getBrowser(), 
                        $this->CI->session->userdata('logged_user_id').' : '.dirname(__FILE__).'\\' .get_class().'\\'.__FUNCTION__.' '
                        . 'send mail success : to ' . $to . ' ,cc ' . $cc . ' ,subject ' . $subject 
                    );
            return TRUE;
        }
    }

    

    
}
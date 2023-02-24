<?php
$appid = "L9a2C6#qBte@lKeoN3Ug";
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
/*
gmail setup
1. enable smtp in gmaail setup
2. enable two factor authentication in account settings
3. generate app password
*/
//ACCEPT POST REQUEST ONLY
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	http_response_code(405);echo "accepts post request only";die;
}
// RECEIVE INPUT
$json = file_get_contents('php://input');
$data = json_decode($json);
//=========CHECK REQUEST IS FROM VALID SOURCE
if(!isset($data->appid)){
	http_response_code(401);
	echo "UNAUTHENTICATED";die;
}
else{
	if($data->appid!=$appid){
		http_response_code(401);
		echo "UNAUTHENTICATED";die;
	}
}
//============================================
if(!isset($data->email)){http_response_code(400);echo "No email specified";die;}
if(!isset($data->otp)){http_response_code(400);echo "No otp specified";die;}
//
$receipant = $data->email;$otp = $data->otp;
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
    $smtp_email =  'HibyeEntertains@outlook.com';                  //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp_email;                     //SMTP username
    $mail->Password   = 'i@m@28now';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($smtp_email, 'HiBye');
    $mail->addAddress($receipant, 'Client');     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "[ $otp ] OTP for authenticating hibye is $otp";
    $mail->Body    = "OTP for authenticating hibye is <br><h1><b>$otp</b></h1>, <br>never share your otp with anyone ";
    $mail->AltBody = "OTP for authenticating hibye is <b>$otp";

    //$mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
	http_response_code(500);
	//echo "INTERNAL SERVER ERROR";

    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
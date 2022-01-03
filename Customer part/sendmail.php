<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require ('../vendor/autoload.php');
function config():PHPMailer
{
    $mail = new PHPMailer();
    // $mail->SMTPDebug = 3; 
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com"; 
    $mail->SMTPAuth = true;
    $mail->Username = "styleshopfyp0000@gmail.com";
    $mail->Password = '11223300aa';
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    $mail->SMTPKeepAlive = true;   
    $mail->isHTML(true);
    return $mail;
}

function send_new_password($password,$email){
    $mail = config();
    $mail->setFrom("styleshopfyp0000@gmail.com", "Style Shop FYP team");
    $mail->addAddress($email);
    $mail->Subject = ("User Account Password Reset");
    $mail->Body = "Dear user,<br><br>This is your new password $password <br><br><br>Best Regards,<br>Style Shop FYP team";
    
    if($mail->send()){
        $status = 1;
        $response = "Email is sent!";
    }
    else
    {
        $status = 0;
        $response = "Something is wrong: <br>" . $mail->ErrorInfo;
    }

    return (json_encode(array("status" => $status, "response" => $response))); //can be changed to exit
}

function send_new_password_admin($password,$email){
    $mail = config();
    $mail->setFrom("styleshopfyp0000@gmail.com", "Style Shop FYP team");
    $mail->addAddress($email);
    $mail->Subject = ("Admin Account Password Reset");
    $mail->Body = "Dear admin,<br><br>This is your new password $password <br><br><br>Best Regards,<br>Style Shop FYP team";
    
    if($mail->send()){
        $status = 1;
        $response = "Email is sent!";
    }
    else
    {
        $status = 0;
        $response = "Something is wrong: <br>" . $mail->ErrorInfo;
    }

    return (json_encode(array("status" => $status, "response" => $response))); //can be changed to exit
}
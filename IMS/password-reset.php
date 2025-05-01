<?php
session_start();
include('dbcon.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';
function send_password_reset($get_name, $get_email,$token)
{
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host ="smtp.gmail.com";
    $mail->Username = "digiwebnex@gmail.com";
    $mail->Password =
    $mail->SMTPSecure "tls";
    $mail->Port = 587;
    $mail->setFrom("digiwebnex@gmail.com",$name);
    $mail->addAddress($email);
    $mail->isHTML (true);
    $mail->Subject "Reset Password Notification";
    $email_template ="
    <h2>Hello</h2>
    <h3>You are receiving this email because we received a password reset request for your account.</h3>
    <br/><br/>
    <a href='http://localhost/fundaofwebit/register-login-with-verification/password-change.php?token=$token
    ";
    $mail->Body = $email_template;
    $mail->send();

} 
if(isset($_POST['password_reset_link']))
{
$email = mysqli_real_escape_string($con, $_POST['email']);
$token = md5(rand());
$check_email = "SELECT email FROM users WHERE email= '$email' LIMIT 1";
$check_email_run = mysqli_query($con, $check_email);
if(mysqli_num_rows($check_email_run) > 0)
$row = mysqli_fetch_array($check_email_run);
$get_name = $row['name'];
$get_email = $row ['email'];
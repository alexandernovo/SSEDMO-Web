<?php
// Include the PHPMailer class
require_once '../vendor/autoload.php';

// Create a new PHPMailer object
$mail = new PHPMailer\PHPMailer\PHPMailer();

$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->SMTPDebug = 1;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->Host = "smtp.gmail.com";
$mail->Username = 'alexandernovo84@gmail.com';
$mail->Password = 'ppifmucigtpvftsn';

// Set the sender and recipient email addresses
$mail->IsHTML(true);
$mail->SetFrom("ISATU@edu.ph", "Iloilo Science and Technology");
// $mail->AddAddress($user['email'], "Users");
// $mail->Subject = "Password Recovery";
// $content = 'Your verification code is: ' . $randomString;
// $mail->MsgHTML($content);
// if ($mail->send()) {
//     redirect('accountfind');
// } else {
//     returnError(['username' => 'Something goes wrong!']);
//     redirect('forgotpassword');
// }

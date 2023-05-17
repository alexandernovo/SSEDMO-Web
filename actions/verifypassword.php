<?php
require_once '../config/config.php';
if (!isset($_SESSION['ForgotID']) || !isset($_SESSION['ForgotGenerated'])) {
    redirect('index');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') : //check if the method is post
    $verificationCode = $_POST['verificationCode'];
    if ($verificationCode == $_SESSION['ForgotGenerated']) {
        setSession(['verified' => true]);
        redirect('forgotUpdatepass');
    } else {
        returnError(['verify' => 'Verification code is Incorrect!']);
        redirect('accountfind');
    }
endif;

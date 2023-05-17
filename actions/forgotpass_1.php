<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') : //check if the method is post
    $username = $_POST['username'];
    if ($user = first('users', ['username' => $username])) {
        $randomString = generateRandomString(); //Random String functions
        setSession(['ForgotID' => $user['id'], 'ForgotGenerated' => $randomString]); //set session the id and random string
        //Using Gmail
        $mail->AddAddress($user['email'], "Users");
        $mail->Subject = "Password Recovery";
        $content = 'Your verification code is: ' . $randomString;
        $mail->MsgHTML($content);

        if ($mail->send()) {
            redirect('accountfind');
        } else {
            returnError(['username' => 'Something goes wrong!']);
            redirect('forgotpassword');
        }
    } else {
        returnError(['username' => 'Username does not exist']);
        redirect('forgotpassword');
    }
endif;

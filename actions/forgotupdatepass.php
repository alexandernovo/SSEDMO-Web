<?php
require_once '../config/config.php';
if (!isset($_SESSION['ForgotID']) || !isset($_SESSION['ForgotGenerated']) || !isset($_SESSION['verified'])) {
    redirect('index');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') : //check if the method is post
    $confpass = $_POST['confpass'];
    $reconfpass = $_POST['reconfpass'];
    $id = $_SESSION['ForgotID'];
    $fields = [
        'confpass' => $confpass,
        'reconfpass' => $reconfpass,
    ];
    $validations = [
        'confpass' => [
            'required' => true,
            'min_length' => 6,
            'max_length' => 100
        ],
        'reconfpass' => [
            'required' => true,
            'match' => 'confpass'
        ],
    ];
    $errors = validate($fields, $validations);
    if (empty($errors)) {
        $check = update('users', ['id' => $id], ['password' => password_hash($confpass, PASSWORD_DEFAULT)]);
        if ($check) {
            setFlash('success', 'Password Updated Successfully'); //set message
            unset($_SESSION['ForgotID']);
            unset($_SESSION['ForgotGenerated']);
            unset($_SESSION['verified']);
            redirect('index'); //shortcut for header('location:index.php ');
        } else {
            setFlash('success', 'Password Updated Failed!, Please Try again'); //set message
            redirect('forgotUpdatepass'); //shortcut for header('location:index.php ');
        }
    } else {
        returnError($errors);
        redirect('forgotUpdatepass'); //shortcut for header('location:register.php?errors=$errors');
    }
endif;

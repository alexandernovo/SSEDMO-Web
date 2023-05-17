<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //check if the method is post

    $username = $_POST['username'];
    $password = $_POST['password'];

    //sample $first = first('users', ['username'=>$username]);  return the first value find
    if ($user = first('users', ['username' => $username])) { //find the first value or row of the query where username=$username
        if (password_verify($password, $user['password'])) { //password_verify built in php function to compare hashpasswords

            $session = [
                'id' => $user['id'],
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'],
                'isLogin' => true,
            ];

            setSession($session); //set the $session array
            // var_dump($_SESSION); //use to test the session variables
            setFlash('success', 'Welcome' . ' ' . $user['name']); //set message
            redirect('home'); //shortcut for header('location:index.php'); //uncomment to use if you have page to redirect
        } else {
            retainValue();
            returnError(['password' => 'Incorrect password']);
            redirect('index', $errors);
        }
    } else {
        returnError(['username' => 'Username do not exist']);
        redirect('index');
    }
}

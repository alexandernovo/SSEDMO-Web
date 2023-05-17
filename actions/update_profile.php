<?php
require_once '../config/config.php';

if (isset($_POST['update_name'])):
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //check if the method is post
        //get the value POST
        $name = $_POST['name'];

        //Input the fields
        $fields = [
            'name' => $name, //or 'name =>$_POST['name'],'
        ];

        //Create Validation if you want to see the choices ..go to database.php
        $validations = [
            'name' => [
                'required' => true,
                'max_length' => 100,
            ]
        ];

        $errors = validate($fields, $validations); //activate the validation

        if (empty($errors)) { //check if the errors is empty
            $data = [
                'name' => $name, //or $_POST['name']
            ]; //put it in array before saving

            $update = update('users', ['id' => $id], ['name' => $name]); // update('table_name', 1, ['column1' => 'new_value1', 'column2' => 'new_value2']);
            if ($update) {
                setFlash('success', 'Name Updated'); //set message
                setSession($data);
                redirect('profile'); //shortcut for header('location:index.php ');
            } else {
                setFlash('failed', 'Update Failed'); //set message
                redirect('update_profile_name'); //shortcut for header('location:index.php ');
            }
        } else {
            returnError($errors);
            redirect('update_profile_name'); //shortcut for header('location:register.php?errors=$errors');
        }
    }
endif;

if (isset($_POST['update_username'])):
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //check if the method is post
        //get the value POST
        $username = $_POST['username'];
        $id = $_POST['id'];
        //Input the fields
        $fields = [
            'username' => $username, //or 'name =>$_POST['name'],'
        ];

        //Create Validation if you want to see the choices ..go to database.php
        $validations = [
            'username' => [
                'required' => true,
                'min_length' => 2,
                'max_length' => 100,
                'unique' => [
                    'fieldName' => 'username',
                    'tableName' => 'users'
                ]
            ]
        ];

        $errors = validate($fields, $validations); //activate the validation

        if (empty($errors)) { //check if the errors is empty
            $data = [
                'username' => $username, //or $_POST['username']
            ]; //put it in array before saving

            $update = update('users', ['id' => $id], ['username' => $username]); // update('table_username', 1, ['column1' => 'new_value1', 'column2' => 'new_value2']);
            if ($update) {
                setFlash('success', 'Username Updated'); //set message
                setSession($data);
                redirect('profile'); //shortcut for header('location:index.php ');
            } else {
                setFlash('failed', 'Update Failed'); //set message
                redirect('update_profile_username'); //shortcut for header('location:index.php ');
            }
        } else {
            returnError($errors);
            redirect('update_profile_username'); //shortcut for header('location:register.php?errors=$errors');
        }
    }
endif;

if (isset($_POST['update_email'])):
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //check if the method is post
        //get the value POST
        $email = $_POST['email'];

        //Input the fields
        $fields = [
            'email' => $email, //or 'name =>$_POST['name'],'
        ];

        //Create Validation if you want to see the choices ..go to database.php
        $validations = [
            'email' => [
                'required' => true,
                'email' => true,
                'unique' => [
                    'fieldName' => 'email',
                    'tableName' => 'users'
                ]
            ]
        ];

        $errors = validate($fields, $validations); //activate the validation

        if (empty($errors)) { //check if the errors is empty
            $data = [
                'email' => $email, //or $_POST['email']
            ]; //put it in array before saving

            $update = update('users', ['id' => $id], ['email' => $email]); // update('table_name', 1, ['column1' => 'new_value1', 'column2' => 'new_value2']);
            if ($update) {
                setFlash('success', 'Email Updated'); //set message
                setSession($data);
                redirect('profile'); //shortcut for header('location:index.php ');
            } else {
                setFlash('failed', 'Update Failed'); //set message
                redirect('update_profile_email'); //shortcut for header('location:index.php ');
            }
        } else {
            returnError($errors);
            redirect('update_profile_email'); //shortcut for header('location:register.php?errors=$errors');
        }
    }
endif;


if (isset($_POST['update_password'])):
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //check if the method is post
        //get the value POST
        $current_pass = $_POST['current_pass'];
        $new_pass = $_POST['new_pass'];
        $conf_pass = $_POST['conf_new_pass'];
        $id = $_POST['id'];

        //Input the fields
        $fields = [
            'current_pass' => $current_pass,
            'new_pass' => $new_pass,
            'conf_new_pass' => $conf_pass, //or 'name =>$_POST['name'],'
        ];

        //Create Validation if you want to see the choices ..go to database.php
        $validations = [
            'current_pass' => [
                'required' => true,
                'max_length' => 100
            ],
            'new_pass' => [
                'required' => true,
                'min_length' => 6,
            ],
            'conf_new_pass' => [
                'required' => true,
                'match' => 'new_pass'
            ]
        ];

        $errors = validate($fields, $validations); //activate the validation

        if (empty($errors)) { //check if the errors is empty
            $password = first('users', ['id' => $id]);
            if (password_verify($current_pass, $password['password'])) {
                $data = [
                    'password' => password_hash($new_pass, PASSWORD_DEFAULT)
                ];
                $update = update('users', ['id' => $id], $data); // update('table_name', 1, ['column1' => 'new_value1', 'column2' => 'new_value2']);
                if ($update) {
                    setFlash('success', 'Password Updated'); //set message
                    setSession($data);
                    redirect('profile'); //shortcut for header('location:index.php ');
                } else {
                    setFlash('failed', 'Update Failed'); //set message
                    redirect('update_profile_password'); //shortcut for header('location:index.php ');
                }
            } else {
                $errors['current_pass'] = 'Password incorrect';
                returnError($errors);
                redirect('update_profile_password');
            }
        } else {
            returnError($errors);
            redirect('update_profile_password'); //shortcut for header('location:register.php?errors=$errors');
        }
    }
endif;
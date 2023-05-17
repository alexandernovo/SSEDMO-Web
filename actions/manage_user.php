<?php
require_once '../config/config.php';

if (isset($_POST['register_user'])) :
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //check if the method is post
        //get the value POST
        $name = $_POST['name'];
        $student_id = $_POST['student_id'];
        $username = $_POST['username'];
        $role = $_POST['role'];
        $password = $_POST['password'];
        $confpassword = $_POST['confpassword'];
        $email = $_POST['email'];

        if ($role === "student") {
            $status = 0;
            $fields = [
                'student_id' => $student_id,
                'name' => $name,
                //or 'name =>$_POST['name'],'
                'username' => $username,
                'role' => $role,
                'password' => $password,
                'confpassword' => $confpassword,
                'email' => $email,
            ];
            //Create Validation if you want to see the choices ..go to database.php
            $validations = [
                'student_id' => [
                    'required' => true,
                    'unique' => [
                        'fieldName' => 'student_id',
                        'tableName' => 'students'
                    ],
                ],
                'name' => [
                    'required' => true,
                    'min_length' => 2,
                    'max_length' => 100
                ],
                'username' => [
                    'required' => true,
                    'min_length' => 5,
                    'max_length' => 50,
                    'unique' => [
                        'fieldName' => 'username',
                        'tableName' => 'users'
                    ],
                    // 'unique' => [
                    //     'fieldName' => 'username',
                    //     'tableName' => 'users'
                    // ], //duplicate if you want to check multiple tables, mark and press ctrl + / to uncomment
                ],
                'email' => [
                    'required' => true,
                    'email' => true,
                    'unique' => [
                        'fieldName' => 'email',
                        'tableName' => 'users'
                    ],
                ],
                'password' => [
                    'required' => true,
                    'min_length' => 8,
                    'max_length' => 100
                ],
                'confpassword' => [
                    'required' => true,
                    'match' => 'password'
                ]
            ];
        } else {
            $status = 1;
            $fields = [
                'name' => $name,
                //or 'name =>$_POST['name'],'
                'username' => $username,
                'role' => $role,
                'password' => $password,
                'confpassword' => $confpassword,
                'email' => $email,
            ];
            //Create Validation if you want to see the choices ..go to database.php
            $validations = [
                'name' => [
                    'required' => true,
                    'min_length' => 2,
                    'max_length' => 100
                ],
                'username' => [
                    'required' => true,
                    'min_length' => 5,
                    'max_length' => 50,
                    'unique' => [
                        'fieldName' => 'username',
                        'tableName' => 'users'
                    ],
                    // 'unique' => [
                    //     'fieldName' => 'username',
                    //     'tableName' => 'users'
                    // ], //duplicate if you want to check multiple tables, mark and press ctrl + / to uncomment
                ],
                'email' => [
                    'required' => true,
                    'email' => true,
                    'unique' => [
                        'fieldName' => 'email',
                        'tableName' => 'users'
                    ],
                ],
                'password' => [
                    'required' => true,
                    'min_length' => 8,
                    'max_length' => 100
                ],
                'confpassword' => [
                    'required' => true,
                    'match' => 'password'
                ]
            ];
        }
        //Input the fields

        $errors = validate($fields, $validations); //activate the validation

        if (empty($errors)) { //check if the errors is empty

            $data = [
                'name' => $name,
                //or $_POST['name']
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                //encrypt the password like md5
                'email' => $email,
                'role' => $role,
                'status' => $status,
            ]; //put it in array before saving
            if ($role === "student") {
                $save = save('users', $data);
                save('students', ['student_id' => $student_id, 'id' => $save]);
            } else {
                $save = save('users', $data); // $save = save('table_name', ['colum_name'=>$username]); if there is one data to save use this
            }
            if ($save) {
                removeValue(); //remove the retain value in inputs
                setFlash('success', 'Registered Successfully'); //set message
                redirect('manage_user'); //shortcut for header('location:index.php ');
            } else {
                retainValue(); //retain value even if there is errors or refresh
                setFlash('failed', 'Register Failed'); //set message
                redirect('add_user'); //shortcut for header('location:index.php ');
            }
        } else {
            retainValue(); //retain value even if there is errors or refresh
            returnError($errors);
            redirect('add_user'); //shortcut for header('location:register.php?errors=$errors');
        }
    }
endif;

if (isset($_POST['update_user'])) :
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //check if the method is post
        //get the value POST
        $id = $_POST['id'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confpassword = $_POST['confpassword'];
        $email = $_POST['email'];
        $email_check = $_POST['email_check'];
        $user_check = $_POST['user_check'];
        $pass_check = $_POST['pass_check'];
        //Input the fields
        $fields = [
            'name' => $name,
            //or 'name =>$_POST['name'],'
            'username' => $username,
            'password' => $password,
            'confpassword' => $confpassword,
            'email' => $email
        ];
        if ($email_check == 1 && $user_check == 1 && $pass_check == 1) {
            $validations = [
                'name' => [
                    'required' => true,
                    'min_length' => 2,
                    'max_length' => 100
                ],
                'username' => [
                    'required' => true,
                    'min_length' => 5,
                    'max_length' => 50,
                    'unique' => [
                        'fieldName' => 'username',
                        'tableName' => 'users'
                    ],
                ],
                'email' => [
                    'required' => true,
                    'email' => true,
                    'unique' => [
                        'fieldName' => 'email',
                        'tableName' => 'users'
                    ],
                ],
                'password' => [
                    'required' => true,
                    'min_length' => 8,
                    'max_length' => 100
                ],
                'confpassword' => [
                    'required' => true,
                    'match' => 'password'
                ]
            ];

            $data = [
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];
        } else if ($email_check == 1 && $user_check == 1 && $pass_check == 0) {
            $validations = [
                'name' => [
                    'required' => true,
                    'min_length' => 2,
                    'max_length' => 100
                ],
                'username' => [
                    'required' => true,
                    'min_length' => 5,
                    'max_length' => 50,
                    'unique' => [
                        'fieldName' => 'username',
                        'tableName' => 'users'
                    ],
                ],
                'email' => [
                    'required' => true,
                    'email' => true,
                    'unique' => [
                        'fieldName' => 'email',
                        'tableName' => 'users'
                    ],
                ],
            ];
            $data = [
                'name' => $name,
                'email' => $email,
                'username' => $username
            ];
        } else if ($email_check == 1 && $user_check == 0 && $pass_check == 0) {
            $validations = [
                'name' => [
                    'required' => true,
                    'min_length' => 2,
                    'max_length' => 100
                ],
                'email' => [
                    'required' => true,
                    'email' => true,
                    'unique' => [
                        'fieldName' => 'email',
                        'tableName' => 'users'
                    ],
                ]
            ];
            $data = [
                'name' => $name,
                'email' => $email
            ];
        } else if ($email_check == 0 && $user_check == 0 && $pass_check == 0) {
            $validations = [
                'name' => [
                    'required' => true,
                    'min_length' => 2,
                    'max_length' => 100
                ],
            ];

            $data = [
                'name' => $name,
            ];
        } else if ($email_check == 0 && $user_check == 0 && $pass_check == 1) {
            $validations = [
                'name' => [
                    'required' => true,
                    'min_length' => 2,
                    'max_length' => 100
                ],
                'password' => [
                    'required' => true,
                    'min_length' => 8,
                    'max_length' => 100
                ],
                'confpassword' => [
                    'required' => true,
                    'match' => 'password'
                ]
            ];
            $data = [
                'name' => $name,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];
        } else if ($email_check == 0 && $user_check == 1 && $pass_check == 1) {
            $validations = [
                'name' => [
                    'required' => true,
                    'min_length' => 2,
                    'max_length' => 100
                ],
                'username' => [
                    'required' => true,
                    'min_length' => 5,
                    'max_length' => 50,
                    'unique' => [
                        'fieldName' => 'username',
                        'tableName' => 'users'
                    ],
                ],
                'password' => [
                    'required' => true,
                    'min_length' => 8,
                    'max_length' => 100
                ],
                'confpassword' => [
                    'required' => true,
                    'match' => 'password'
                ]
            ];
            $data = [
                'name' => $name,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];
        } else if ($email_check == 1 && $user_check == 0 && $pass_check == 1) {
            $validations = [
                'name' => [
                    'required' => true,
                    'min_length' => 2,
                    'max_length' => 100
                ],
                'email' => [
                    'required' => true,
                    'email' => true,
                    'unique' => [
                        'fieldName' => 'email',
                        'tableName' => 'users'
                    ],
                ],
                'password' => [
                    'required' => true,
                    'min_length' => 8,
                    'max_length' => 100
                ],
                'confpassword' => [
                    'required' => true,
                    'match' => 'password'
                ]
            ];
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];
        } else if ($email_check == 0 && $user_check == 1 && $pass_check == 0) {
            $validations = [
                'name' => [
                    'required' => true,
                    'min_length' => 2,
                    'max_length' => 100
                ],
                'username' => [
                    'required' => true,
                    'min_length' => 5,
                    'max_length' => 50,
                    'unique' => [
                        'fieldName' => 'username',
                        'tableName' => 'users'
                    ],
                ],
            ];
            $data = [
                'name' => $name,
                'username' => $username
            ];
        }

        $errors = validate($fields, $validations); //activate the validation

        if (empty($errors)) { //check if the errors is empty

            $update = update('users', ['id' => $id], $data); // update('table_name', 1, ['column1' => 'new_value1', 'column2' => 'new_value2']);

            if ($update) {
                setFlash('success', 'Profile Updated'); //set message
                redirect('manage_user'); //shortcut for header('location:index.php ');
            } else {
                setFlash('failed', 'Update Failed'); //set message
                redirect('manage_user_update', ['id' => $id]); //shortcut for header('location:index.php ');
            }
        } else {
            retainValue(); //retain value even if there is errors or refresh
            returnError($errors);
            redirect('manage_user_update', ['id' => $id]); //shortcut for header('location:register.php?errors=$errors');
        }
    }
endif;

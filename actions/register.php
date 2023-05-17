<?php
require_once '../config/config.php';

if (isset($_POST['register'])) :

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //check if the method is post
        //get the value POST
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confpassword = $_POST['confpassword'];
        $email = $_POST['email'];
        $year = $_POST['year'];
        $course = $_POST['course'];
        $student_id = $_POST['student_id'];

        //Input the fields
        $fields = [
            'student_id'    => $student_id,
            'name'          => $name,
            'username'      => $username,
            'year'          => $year,
            'course'        => $course,
            'password'      => $password,
            'confpassword'  => $confpassword,
            'email'         => $email,
        ];
        //Create Validation if you want to see the choices ..go to validate.php
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
            ],
            'email' => [
                'required' => true,
                'email' => true,
                'unique' => [
                    'fieldName' => 'email',
                    'tableName' => 'users'
                ],
            ],
            'course' => [
                'required' => true,
            ],
            'year' => [
                'required' => true,
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

        $errors = validate($fields, $validations); //activate the validation

        if (empty($errors)) { //check if the errors is empty
            $data = [
                'name' => $name,
                //or $_POST['name']
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                //encrypt the password like md5
                'email' => $email,
                'role' => 'student',
            ]; //put it in array before saving

            $save = save('users', $data); // $save = save('table_name', ['colum_name'=>$username]); if there is one data to save use this
            if ($save) {
                $save2 = save('students', ['student_id' => $student_id, 'id' => $save, 'year_level' => $year, 'course_ID' => $course]); //i have function that return the last id so i use the $save variable to make use of it
                removeValue(); //remove the retain value in inputs
                setFlash('success', 'Register Successfully'); //set message
                redirect('register'); //shortcut for header('location:register.php ');
            } else {
                retainValue(); //retain value even if there is errors or refresh
                setFlash('failed', 'Register Failed'); //set message
                redirect('register'); //shortcut for header('location:index.php ');
            }
        } else {
            retainValue(); //retain value even if there is errors or refresh
            returnError($errors); //return Errors 
            redirect('register'); //shortcut for header('location:register.php');
        }
    }

endif;

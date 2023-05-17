<?php
require_once '../config/config.php';

$encodedData = file_get_contents('php://input');  // take data from react native fetch API
$data = json_decode($encodedData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $process = $_GET['process'] ?? '';
    if ($process === 'register') {
        register($data);
    } else if ($process === 'login') {
        login($data);
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['errors' => ['process' => 'Invalid process']]);
    }
}

function register($data)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = $data['name'];
        $username = $data['username'];
        $password = $data['password'];
        $confirmPassword = $data['confirmPassword'];
        $email = $data['email'];
        $studentId = $data['studentId'];
        $course = $data['course'];
        $year = $data['year'];

        $fields = [
            'studentId' => $studentId,
            'name' => $name,
            'username' => $username,
            'password' => $password,
            'confirmPassword' => $confirmPassword,
            'email' => $email,
        ];
        $validations = [
            'studentId' => [
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
            'password' => [
                'required' => true,
                'min_length' => 8,
                'max_length' => 100
            ],
            'confirmPassword' => [
                'required' => true,
                'match' => 'password'
            ]
        ];

        $errors = validate($fields, $validations);

        if (empty($errors)) {
            $data = [
                'name' => $name,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'email' => $email,
                'role' => 'student',
            ];

            $save = save('users', $data); //save and return the last id and store it in $save variable

            if ($save) {
                save('students', ['student_id' => $studentId, 'id' => $save, 'year_level' => $year, 'course_ID' => $course]); //the $save is the last id, i foreign key it
                // Create an array with the success message
                $response = ['success' => 'Registration successful'];
                // Set the response headers and echo out the JSON response
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        } else {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['errors' => $errors]);
            exit();
        }
    }
}

function login($data)
{
    if (isset($_GET['process']) == "login") : //Login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //check if the method is post

            $username = $data['username'];
            $password = $data['password'];

            if ($user = first('users', ['username' => $username])) { //find the first value or row of the query where username=$username
                if (password_verify($password, $user['password'])) {
                    //return a response message and the $user variable to save as a session in react-native
                    if ($user['status'] === 1) {
                        $response = [
                            'success' => 'Login successful',
                            'session' => $user,
                        ];
                        http_response_code(200);
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    } else {
                        http_response_code(400);
                        header('Content-Type: application/json');
                        $errors = [
                            "password"  => "This account is not yet activated!",
                        ];
                        echo json_encode(['errors' => $errors]);
                        exit();
                    }
                } else {
                    http_response_code(400);
                    header('Content-Type: application/json');
                    $errors = [
                        "password"  => "Password is incorrect",
                    ];
                    echo json_encode(['errors' => $errors]);
                    exit();
                }
            } else {
                http_response_code(400);
                header('Content-Type: application/json');
                $errors = [
                    "username"  => "Username does not exist",
                ];
                echo json_encode(['errors' => $errors]);
                exit();
            }
        }
    endif;
}

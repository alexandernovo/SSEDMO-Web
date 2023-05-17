<?php
require_once '../config/config.php';

$encodedData = file_get_contents('php://input');  // take data from react native fetch API
$data = json_decode($encodedData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $process = $_GET['process'] ?? '';
    if ($process === 'UpdateUsername') {
        UpdateUsername($data);
    } else if ($process === 'UpdateEmail') {
        UpdateEmail($data);
    } else if ($process === 'UpdatePassword') {
        UpdatePassword($data);
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['errors' => ['process' => 'Invalid process']]);
    }
}

function UpdateUsername($data)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $data['userID'];
        $username = $data['username'];

        $fields = [
            'username' => $username,
        ];

        $validations = [
            'username' => [
                'required' => true,
                'username' => true,
                'unique' => [
                    'tableName' => 'users',
                    'fieldName' => 'username',
                ],
            ],
        ];

        $errors = validate($fields, $validations);

        if (empty($errors)) {

            $update = update('users', ['id' => $id], ['username' => $username]);

            if ($update) {
                // Create an array with the success message
                $response = ['success' => 'Updated Successfully'];
                // Set the response headers and echo out the JSON response
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['errors' => 'Something`s wrong']);
            }
        } else {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['errors' => $errors]);
            exit();
        }
    }
}

function UpdateEmail($data)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $data['userID'];
        $email = $data['email'];

        $fields = [
            'email' => $email,
        ];

        $validations = [
            'email' => [
                'required' => true,
                'email' => true,
                'unique' => [
                    'tableName' => 'users',
                    'fieldName' => 'email',
                ],
            ],
        ];

        $errors = validate($fields, $validations);

        if (empty($errors)) {

            $update = update('users', ['id' => $id], ['email' => $email]);

            if ($update) {
                // Create an array with the success message
                $response = ['success' => 'Updated Successfully'];
                // Set the response headers and echo out the JSON response
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['errors' => 'Something`s wrong']);
            }
        } else {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['errors' => $errors]);
            exit();
        }
    }
}

function UpdatePassword($data)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $data['userID'];
        $passwords = $data['Passwords'];
        $currentpassword = $passwords['currentpassword'];
        $newpassword = $passwords['newpassword'];
        $confnewpassword = $passwords['confnewpassword'];

        $fields = [
            'currentpassword' => $currentpassword,
            'newpassword' => $newpassword,
            'confnewpassword' => $confnewpassword,
        ];

        $validations = [
            'currentpassword' => [
                'required' => true,
            ],
            'newpassword' => [
                'required' => true,
            ],
            'confnewpassword' => [
                'required' => true,
                'match' => 'newpassword',
            ],
        ];

        $errors = validate($fields, $validations);


        if (empty($errors)) {
            if ($password = first('users', ['id' => $id])) {
                if (password_verify($currentpassword, $password['password'])) {
                    $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
                    $update = update('users', ['id' => $id], ['password' => $newpassword]);
                    if ($update) {
                        // Create an array with the success message
                        $response = ['success' => 'Updated Successfully'];
                        // Set the response headers and echo out the JSON response
                        http_response_code(200);
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    } else {
                        http_response_code(400);
                        header('Content-Type: application/json');
                        echo json_encode(['errors' => 'Something`s wrong']);
                    }
                } else {
                    $errors['currentpassword'] = 'Current password is incorrect';
                    http_response_code(400);
                    header('Content-Type: application/json');
                    echo json_encode(['errors' => $errors]);
                }
            } else {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['errors' => 'Something`s wrong']);
            }
        } else {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['errors' => $errors]);
            exit();
        }
    }
}

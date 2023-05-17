<?php
require_once '../config/config.php';

$encodedData = file_get_contents('php://input');  // take data from react native fetch API
$data = json_decode($encodedData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $process = $_GET['process'] ?? '';
    if ($process === 'help') {
        help($data);
    } else if ($process === 'cancelHelp') {
        cancelHelp($data);
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['errors' => ['process' => 'Invalid process']]);
    }
}

function help($data)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $data['id'];
        $room_id = $data['room_id'];
        $emergency_level = $data['emergency_level'];

        $data_save = [
            'id' => $id,
            'room_id' => $room_id,
            'emergency_level' => $emergency_level,
            'status' => 0,
        ];

        $save = save('emergency', $data_save); //save and return the last id and store it in $save variable

        if ($save) {
            // Create an array with the success message
            $response = ['success' => 'Waiting for the rescuer...'];
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
        echo json_encode(['errors' => ['process' => 'Invalid process']]);
        exit();
    }
}

function cancelHelp($data)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $emergency_id = $data['emergencyID'];

        $update = update('emergency', ['emergency_id' => $emergency_id], ['status' => 2]);

        if ($update) {
            // Create an array with the success message
            $response = ['success' => 'Help cancelled'];
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
        echo json_encode(['errors' => ['process' => 'Invalid process']]);
        exit();
    }
}

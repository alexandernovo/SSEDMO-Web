<?php
require_once '../config/config.php';

$process = $_GET['process'] ?? '';
if ($process === 'getBuilding') {
    building();
} else if ($process === 'getRoom') {
    $building_id = $_GET['building_id'];
    room($building_id);
} else if ($process === 'helpStatus') {
    $userID = $_GET['userID'];
    emergencyStatus($userID);
} else if ($process === 'EmergencyList') {
    getEmergencyList();
} else if ($process === 'EmergencySpecific') {
    $emergency_ID = $_GET['emergency_id'];
    emergencySpecific($emergency_ID);
} else if ($process === 'getCourse') {
    Courses();
} else {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['errors' => ['process' => 'Invalid process']]);
}

function building()
{
    $building =  findAll('building');
    if ($building) {
        $response = [
            'building' => $building
        ];
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['errors' => ['process' => 'Invalid process']]);
        exit();
    }
}
function room($building_id)
{
    $rooms = find_where('room', ['building_id' => $building_id]);
    if ($rooms) {
        $response = [
            'rooms' => $rooms
        ];
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['errors' => ['process' => 'Somethings Wrong']]);
        exit();
    }
}

function emergencyStatus($userID)
{
    $emergencyStatus = lastResult('emergency', 'emergency_id', ['id' => $userID]);
    if ($emergencyStatus) {
        $response = [
            'emergencyStatus' => $emergencyStatus,
        ];
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['errors' => ['error' => 'error']]);
        exit();
    }
}
function getEmergencyList()
{
    $emergencyList =  find_where('emergency', ['status' => '0']);
    if ($emergencyList) {
        $response = [
            'emergencyList' => $emergencyList
        ];
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['errors' => ['process' => 'Somethings Wrong']]);
        exit();
    }
}

function emergencySpecific($emergency_ID)
{
    $emergencySpecific = joinTable('emergency', [['users', 'emergency.id', 'users.id'], ['room', 'room.room_id', 'emergency.room_id'], ['building', 'room.building_id', 'building.building_id']], ['emergency.emergency_id' => $emergency_ID]);

    if ($emergencySpecific) {
        $response = [
            'emergencySpecific' => $emergencySpecific,
        ];
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['errors' => ['process' => 'Somethings Wrong']]);
        exit();
    }
}
function Courses()
{
    $course = findAll('course');
    if ($course) {
        $response = [
            'course' => $course,
        ];
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['errors' => ['process' => 'Somethings Wrong']]);
        exit();
    }
}

<?php
require_once '../config/config.php';

if (isset($_GET['room_id'])) {


    $id = $_GET['room_id'];
    $delete_room = delete('room', ['room_id' => $id]);

    $returnData = [
        'building_id' => $_GET['building_id'],
        'building_name' => $_GET['building_name']
    ];

    if ($delete_room) {
        setFlash('success', 'Deleted Successfully');
        redirect('rooms', $returnData);
    }
    else
    {
        setFlash('failed', 'Delete Failed');
        redirect('rooms', $returnData);
    }
}

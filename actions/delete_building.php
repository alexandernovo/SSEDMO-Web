<?php
require_once '../config/config.php';

if (isset($_GET['building_id'])) {
    $id = $_GET['building_id'];
    $delete_building = delete('building', ['building_id' => $id]);
    if ($delete_building) {
        setFlash('success', 'Deleted Successfuly');
        redirect('manage_place');
    } else {
        setFlash('failed', 'Delete Failed');
        redirect('manage_place');
    }
}

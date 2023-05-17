<?php
require_once '../config/config.php';

$id = $_GET['id'];
$check = first('users', ['id' => $id]);
if ($check['status'] === 1) {
    $update_deactivate = update('users', ['id' => $id], ['status' => 0]);
} else if ($check['status'] === 0) {
    $update_activate = update('users', ['id' => $id], ['status' => 1]);
}
if ($update_deactivate) {
    setFlash('success', 'Deactivated Sucessfully'); //set message
    redirect('manage_student');
} else if ($update_activate) {
    setFlash('success', 'Activated Successfully'); //set message
    redirect('manage_student');
} else {
    setFlash('failed', 'Something is Wrong'); //set message
    redirect('manage_student');
}

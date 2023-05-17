<?php
require_once '../config/config.php';

if (isset($_GET['colleges_ID'])) {
    $id = $_GET['colleges_ID'];
    $delete_colleges = delete('colleges', ['colleges_ID' => $id]);
    if ($delete_colleges) {
        setFlash('success', 'Deleted Successfuly');
        redirect('manageColleges');
    } else {
        setFlash('failed', 'Delete Failed');
        redirect('manageColleges');
    }
}

if (isset($_GET['course_ID'])) {
    $id = $_GET['course_ID'];
    $delete_course = delete('course', ['course_ID' => $id]);
    if ($delete_course) {
        setFlash('success', 'Deleted Successfuly');
        redirect('manageColleges');
    } else {
        setFlash('failed', 'Delete Failed');
        redirect('manageColleges');
    }
}

<?php
@include '../config/config.php';
//put your function queries here
//sample

// function getData($table_name, $id)
// {
//     find('$table_name', 1); using the database functions
// }

//in views

// $id = $_GET['id'];
// $data = getData('users', $id);
// 

function findUser($id)
{
    global $conn;
    $query = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    return $result;
}

//dashboard
$count_student = countResutlt('users', ['role' => 'student']);
$count_admin = countResutlt('users', ['role' => 'admin']);
$count_rescuer = countResutlt('users', ['role' => 'rescuer']);

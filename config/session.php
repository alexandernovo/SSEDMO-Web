<?php
include 'functions.php';
//Start session include config to your config.php files if wanted
session_start();

function setSession(array $data)
{
    foreach ($data as $key => $value) {
        $_SESSION[$key] = $value;
    }
}
<?php
require_once 'session.php';
if (isset($_SESSION['isLogin'])) {
    // setFlash('failed', 'Access to that page required you to logout');
    redirect('home');
}
?>
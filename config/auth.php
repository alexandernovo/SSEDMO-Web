<?php
if (!isset($_SESSION['isLogin'])) {
    setFlash('failed', 'Login First');
    redirect('index');
}

<?php
    session_start();
    require_once('../req/redirect.php');
    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        redirect();
        exit();
    }
    unset($_SESSION['user']);
?>
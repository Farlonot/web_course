<?php
    session_start();
    require_once('response.php');
    require_once('redirect.php');

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        redirect();
        exit();
    }
    if (!isset($_SESSION['user']))
        sendResponse(false,'user not authorized', null);

    sendResponse(true,'', ['id' => $_SESSION['user']['id']]);
?>
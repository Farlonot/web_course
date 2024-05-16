<?php
    session_start();
    require_once('../req/response.php');
    require_once('../req/redirect.php');

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        sendResponse(false, 'Incorrect Request Type', null, 405);
        exit();
    }
    $info=null;
    $msg = 'success';
    if (isset($_SESSION["user"])) {
        $info = [
            'userId'=> $_SESSION["user"]["id"],
        ];
    }
    sendResponse(isset($_SESSION["user"]), $msg, $info);
?>
<?php
    session_start();
    require_once('../req/connect.php');
    require_once('../req/response.php');
    require_once('../req/redirect.php');


    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        redirect();
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM `user` WHERE `login` = :login");
    $stmt->bindParam(':login', $_POST['login']);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user)
    {
        sendResponse(false, 'Данные введены неверно', $_POST['password'], 500);
        return;
    }


    if($user['password'] == $_POST['password'])
    {
        $_SESSION['user']=[
            'login' => $user['login'],
            'username' => $user['username'],
            'id' => $user['id']
        ];
        $info = [
            'id' => $_SESSION['user']['id'],
        ];
        sendResponse(true, '', $info);
    }
    else{
        sendResponse(false, 'Данные введены неверно', null, 500);
    }
?>
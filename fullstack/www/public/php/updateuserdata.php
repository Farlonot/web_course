<?php
    session_start();
    
    require_once('./req/redirect.php');
    require_once('./req/connect.php');


    if($_SERVER['REQUEST_METHOD'] !== 'POST' or !isset($_SESSION["user"]))
    {
        sendResponse(false, 'Incorrect Request Type', null, 405);
        exit();
    }

    $id =  $_SESSION['user']['id'];

    function tryGetValueFrom_POST($key){
        if (!isset($_POST[$key])) {
            redirect('./index.php');
            exit();
        }
        return $_POST[$key];
    }

    
    $description = tryGetValueFrom_POST('description');

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("UPDATE `user` SET `email`= :email,`username`= :username, `birthday`= :birthday WHERE `id`= :id");
        $stmt->bindParam(':id', $id);
        bindNullValue($stmt, 'email');
        bindNullValue($stmt, 'username');
        bindNullValue($stmt, 'birthday');
        $stmt->execute();

        $stmt = $pdo->prepare("UPDATE `userinfo` SET   `gender`= :egender, `color`= :color,`sport`= :sport,`film`= :film,`music`= :music,`art`= :art,`hobbie`= :hobbie, `description`= :description WHERE `id`= :id");
        $stmt->bindParam(':id', $id);
        bindNullValue($stmt, 'egender');
        bindNullValue($stmt, 'color');
        bindNullValue($stmt, 'sport'); 
        bindNullValue($stmt, 'film');
        bindNullValue($stmt, 'music');
        bindNullValue($stmt, 'art');
        bindNullValue($stmt, 'hobbie');
        bindNullValue($stmt, 'description');
        $stmt->execute();

        $pdo->commit();


        $filePath = '../userdescriptions/'.$id.'.txt';

        if (!file_exists($filePath)) {
            touch($filePath);
        }
        file_put_contents($filePath, $description);

        redirect('./edit.php');
        exit();
    } catch (PDOException $e) {
        echo 'error: '.$e->getMessage();
        $pdo->rollBack();
    }

    
?>
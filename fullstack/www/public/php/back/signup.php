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


    $errors = array();

    function validate($name, $maxLength=32){
        global $errors;
        if(!isset($_POST[$name]) or strlen($_POST[$name])==0){
            $errors[] = 'Введите '.$name;
        }elseif (strlen($_POST[$name]) < 3 or strlen($_POST[$name]) >  $maxLength) {
            $errors[] = $name.' должен быть не меньше 3 и не больше '.$maxLength.' символов';
        }
    }

    validate('email', 256);
    validate('login');
    validate('username');
    validate('password');
    if (isset($_POST['rpassword']) and $_POST['password'] != $_POST['rpassword']) {
        $errors['rpassword'] = 'Введенные пароли не совпадают';
    }
    if (count($errors) > 0){
        reset($errors);
        $msg = current($errors);
        sendResponse(false, $msg, $errors);
        exit();
    }


    $stmt = $pdo->prepare("SELECT * FROM `user` WHERE `login` = :login");
    $stmt->bindParam(':login', $_POST['login']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user)
    {
        $msg = 'Пользователь с таким логином уже сущесвует';
        sendResponse(false, $msg);
        exit();
    }


    $stmt = $pdo->prepare("INSERT INTO `user`(`login`, `email`, `password`, `username`, `birthday`) VALUES (:value1,:value2,:value3,:value4,:birthday)");
    $stmt->bindParam(':value1', $_POST['login']);
    $stmt->bindParam(':value2', $_POST['email']);
    $stmt->bindParam(':value3', $_POST['password']);
    $stmt->bindParam(':value4', $_POST['username']);
    bindNullValue($stmt, 'birthday');
    if(!$stmt->execute())
    {
        $msg = 'Ошибка создания пользователя';
        sendResponse(false, $msg);
        exit();
    }

    $gender = 'secret';
    if (isset($_POST['gender']) and $_POST['gender'] !== '' and $_POST['gender'] !== null) {
        $gender = $_POST['gender'];
    }

    $lastInsertedId = $pdo->lastInsertId();
    $stmt = $pdo->prepare("INSERT INTO `userinfo`( `id`, `gender`, `color`, `sport`, `film`, `music`, `art`, `hobbie`, `description`) VALUES (:id,:gender,:color,:sport,:film,:music,:art,:hobbie,:description)");
    $stmt->bindParam(':id', $lastInsertedId);
    $stmt->bindParam(':gender', $gender);
    bindNullValue($stmt, 'color');
    bindNullValue($stmt, 'sport'); 
    bindNullValue($stmt, 'film');
    bindNullValue($stmt, 'music');
    bindNullValue($stmt, 'art');
    bindNullValue($stmt, 'hobbie');
    bindNullValue($stmt, 'description');
    if(!$stmt->execute())
    {
        $msg = 'Ошибка добавления информации о пользователе';
        sendResponse(false, $msg);
        exit();
    }

    $msg = 'Регистрация прошла успешно';
    sendResponse(true, $msg);
?>
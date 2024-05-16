<?php
    
    session_start();

    require_once('../req/connect.php');
    require_once('../req/response.php');


    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        sendResponse(false, 'Incorrect Request Type', null, 405);
        exit();
    }

    $quantity = 5;
    $users = null;
    if (isset($_POST['quantity'])) {
        $quantity = $_POST['quantity'];
    }

    if (isset($_POST['keywords']) && $_POST['keywords'][0] !== '' && $_POST['keywords'] !== null){
        $msg = "keywords";
        $keywords= "";
        foreach ($_POST['keywords'] as $keyword){
            $keywords .= $keyword;
        }
        try {
            $request = "SELECT u.id, u.username, ui.gender, ui.color, ui.sport, ui.film, ui.music, ui.art, ui.hobbie, ui.description
            FROM `user` AS u
            JOIN `userinfo` AS ui ON u.id = ui.id";
            if (isset($_SESSION['user'])) {
                $request .= "  WHERE u.id != :id";
            }
            $request.= " AND MATCH(ui.description) AGAINST (:keywords IN BOOLEAN MODE)";
            $stmt = $pdo->prepare($request);
            $stmt->bindParam(':keywords', $keywords);
            if (isset($_SESSION['user'])) {
                $stmt->bindParam(':id', $_SESSION['user']['id']);
            }
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $msg = "Ошибка получения пользователей по запросу: " . $e->getMessage();
            sendResponse(false, $msg, null, 500);
        }
    }elseif (isset($_POST['likeMe']) && $_POST['likeMe'] === 'true' && isset($_SESSION['user'])) {
        $msg = "likeMe";
        if (!isset($_SESSION['user'])) {
            $msg = "Пользователь не авторизован";
            sendResponse(false, $msg, null, 401);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("SELECT color, sport, film, music, art, hobbie FROM `userinfo` WHERE `id` = :id");
            $stmt->bindParam(':id', $_SESSION['user']['id']);
            $stmt->execute();
            $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
            //print_r($currentUser);
            if (!$currentUser)
            {
                $msg = 'Пользователь не найден';
                sendResponse(false, $msg, null, 500);
                exit();
            }
            $request = "SELECT u.id, u.username, ui.gender, ui.color, ui.sport, ui.film, ui.music, ui.art, ui.hobbie, ui.description
                FROM userinfo ui JOIN  user u ON ui.id = u.id 
                WHERE ui.id <> :user_id";

            $isFirst = true;
            foreach ($currentUser as $key => $value) {
                if ($value != null  and $value !='null'){
                    if ($isFirst){
                        $request .=  " AND (";
                        $isFirst = false;
                    }
                    else{
                        $request .= " OR ";  
                    }
                    $request .= " ui.".$key." LIKE :".$key;
                }
            }
            if (!$isFirst) {
                $request.= ")";
            }
            
            $stmt = $pdo->prepare($request);
            $stmt->bindParam(':user_id', $_SESSION['user']['id']);
            foreach ($currentUser as $key => $value) {
                if ($value != null and $value != 'null'){
                    $stmt->bindParam(':'.$key, $currentUser[$key]);
                }
            }
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


            

        } catch (PDOException $e) {
            $msg = "Ошибка получения похожих пользователей: " . $e->getMessage();
            sendResponse(false, $msg, null, 500);
        
            exit();
        }
    }
    else{
        try {
            $msg = "Random user";
            $request = "SELECT u.id, u.username, ui.gender, ui.color, ui.sport, ui.film, ui.music, ui.art, ui.hobbie, ui.description
            FROM user u
            JOIN userinfo ui ON u.id = ui.id";
            
            if (isset($_SESSION['user'])) {
                $request .= " WHERE u.id != :userId";
            }
            $request .= " ORDER BY RAND() LIMIT ".$quantity;
            $stmt = $pdo->prepare($request);
            if (isset($_SESSION['user'])) {
                $stmt->bindParam(':userId', $_SESSION['user']['id']);
            }
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $msg = "Ошибка получения случайных пользователей: " . $e->getMessage();
            sendResponse(false, $msg, null, 500);
            exit();
        }
    }
    $info = [];
    foreach($users as $user){
        $info[] = [
            'data' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'gender' => $user['gender'],
            ],
            'interests' => [
                'color' => $user['color'],
                'sport' => $user['sport'],
                'film' => $user['film'],
                'music' => $user['music'],
                'art' => $user['art'],
                'hobbie' => $user['hobbie'],
            ],
            'description' => $user['description'],
        ];
    }
    if (isset($currentUser)&& $msg == "likeMe") {
        //print_r($currentUser);
        foreach ($info as &$item) {
            $matchingFields = 0;
            foreach ($item['interests'] as $key => $value) {
                if (isset($currentUser[$key]) && $currentUser[$key] == $value && $currentUser[$key] != null && $currentUser[$key] != 'null') {
                    //echo $key.": ".$value.' '.$item['data']['id'].' Ref: '.$currentUser[$key].'<br>';
                    
                    $matchingFields++;
                }
            }
            $item['priority'] = $matchingFields;
        }
        unset($item);
    }
    sendResponse(true,$msg, $info);
?>
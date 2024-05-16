<?php
    
    session_start();

    require_once('../req/connect.php');
    require_once('../req/response.php');
    require_once('../req/redirect.php');

    $url ="../edit.php";
    
    if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user']))
    {
        redirect();
        exit();
    }
    try {
        $userId = $_SESSION['user']['id'];
        $stmt = $pdo->prepare("SELECT user.username, user.email, user.birthday, userinfo.gender, userinfo.color, userinfo.sport, userinfo.film, userinfo.music, userinfo.art, userinfo.hobbie
                            FROM user
                            JOIN userinfo ON user.id = userinfo.id
                            WHERE user.id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user){
           redirect($url);
        }
    } catch(PDOException $e) {
        sendResponse(true,'', $e->getMessage(), 500);
        redirect($url);
    }

    /*test user */
    // $userFromDB = [
    //     'id' => 1,
    //     'email' => 'someEmail',
    //     'username' => 'someUsername',
    //     'birthday' => null,
    //     'gender' => 'female',
    //     'color' => 'red',
    //     'sport' => 'basketball',
    //     'film' => 'action',
    //     'music' => 'electronic',
    //     'art' => null,
    //     'hobbie' => null,
    // ];
    /*test user */
    
    $filePath = '../../userdescriptions/'.$userId.'.txt';
    $description = null;
    // Проверяем существование файла
    if (file_exists($filePath)) {
        // Читаем содержимое файла
        $description =  file_get_contents($filePath);
    }

    $info = [
        'data' => [
            'id' => $userId,
            'email' => $user['email'],
            'username' => $user['username'],
            'gender' => $user['gender'],
            'birthday' => $user['birthday']
        ],
        'interests' => [
            'color' => $user['color'],
            'sport' => $user['sport'],
            'film' => $user['film'],
            'music' => $user['music'],
            'art' => $user['art'],
            'hobbie' => $user['hobbie'],
        ],
        'description' => $description,
    ];

    sendResponse(true,'', $info);
?>
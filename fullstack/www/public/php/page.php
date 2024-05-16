<?php
    session_start();

    require_once('./req/connect.php');
    require_once('./req/redirect.php');
    require_once('./back/template.php');

   $url = './index.php';
    if($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_GET['id'])) {
        $userId = $_GET['id'];
        try {
            $stmt = $pdo->prepare("SELECT user.username, userinfo.gender, userinfo.color, userinfo.sport, userinfo.film, userinfo.music, userinfo.art, userinfo.hobbie
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
            redirect($url);
        }
    }else {
        redirect($url);
    }


    
    //print_r($user);

    /*test user */
    // $userFromDB = [
    //     'username' => 'someUsername',
    //     'gender' => 'female',
    //     'color' => 'red',
    //     'sport' => 'basketball',
    //     'film' => 'action',
    //     'music' => 'electronic',
    //     'art' => null,
    //     'hobbie' => null,
    // ];
    /*test user */
    $username = $user['username'];
    unset($user['username']);
    $gender = $user['gender'];
    unset($user['gender']);

    $interests = $user;

    $imageMap = [
        'male' => 'man.png',
        'female' => 'woman.png',
        'secret' => 'secret.png'
    ];
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/page.css">
        <link rel="icon" href="../images/zen.png" type="image/x-icon">
        <title>
            <?php
               echo htmlspecialchars($username);
            ?>
        </title>
    </head>
    <body>
        <?php
            getHeader();
        ?>
        
        <div class="page">
            <div class="dataContainer">
                <div class="data">
                    <div class="avatar">
                        <?php
                            echo '<img src="../images/'.htmlspecialchars($imageMap[$gender]).'" alt="">'
                        ?>
                    </div>
                    <div class="username">
                        <?php
                           echo htmlspecialchars($username);
                        ?>
                    </div>
                    <div class="interestsContainer">
                        <div class="interests">
                            <?php
                                foreach ($interests as $key => $value){
                                    if ($value != null && $value!== 'null')
                                        echo '<div class="interest"><p>'.$key.': '.htmlspecialchars($value).'</p></div>';}
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="descriptionContiner">
                <h1>О себе</h1>
                <p>
                    <?php
                        $filePath = '../userdescriptions/'.$_GET['id'].'.txt';

                        // Проверяем существование файла
                        if (file_exists($filePath)) {
                            // Читаем содержимое файла
                            $fileContent = file_get_contents($filePath);
                        
                            // Выводим содержимое файла
                            echo htmlspecialchars($fileContent);
                        }
                    ?>
                </p>

            </div>
        </div>

        <?php 
            getAuthWindow();
        ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../js/main.js"></script>
       
    </body>
</html>

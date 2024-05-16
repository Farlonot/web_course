<?php
    session_start();

    require_once('./req/connect.php');
    require_once('./req/redirect.php');
    require_once('./req/response.php');
    require_once('./back/template.php');


    function gerUserData(){
        $info = [
            'username' => '',
            'email' => '',
            'birthday' => '',
            'interests' => [
                'color' => '',
                'sport' => '',
                'film' => '',
                'music' => '',
                'art' => '',
                'hobbie' => ''
                ]
        ];
        return $info;
    }

    if(!isset($_SESSION['user']))
        redirect('./index.php');

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
        <link rel="stylesheet" href="../css/edit.css">
        <link rel="icon" href="../images/zen.png" type="image/x-icon">
        <title>Редактирование профиля</title>
    </head>
    <body>
        <?php
            getHeader();
        ?>
        <form action="./updateuserdata.php" method="post" class="edit">
            <div class="page">
                <div class="dataContainer">
                    <div class="data">
                        <div class="avatar">
                            <img src="../images/woman.png" alt="">
                        </div>
                        <div class="inputConteiner">
                            <p>Имя пользователя:</p>
                            <input type="text" name="username" value="">
                        </div>
                    </div>
                </div>
                <div class="rightContainer">
                    <h1>Персональные данные</h1>
                    <div class="inputConteiner">
                        <p>E-mail:</p>
                        <input type="text" name="email" value="">
                    </div>
                    <div class="inputConteiner">
                        <p>Дата рождения:</p>
                        <input type="date" name="birthday">
                    </div>
                    <div class="inputConteiner">
                        <p>Пол:</p>
                        <div class="radioContainer">
                            <input type="radio" name="egender" id="editmale"   value="male">
                            <label for="editmale">муж.</label>
                        
                            <input type="radio" name="egender" id="editfemale" value="female">
                            <label for="editfemale">жен.</label>
                      
                            <input type="radio" name="egender" id="editsecret" value="secret">
                            <label for="editsecret">секрет</label>
                        </div>  
                    </div>
                    <h1>Интересы</h1>
                    <div class="inputConteiner">
                        <p>Цвет:</p>
                        <?php
                            getSelect(0);
                        ?>
                    </div>
                    <div class="inputConteiner">
                        <p>Спорт:</p>
                        <?php
                            getSelect(1);
                        ?>
                    </div>
                    <div class="inputConteiner">
                        <p>Фильм:</p>
                        <?php
                            getSelect(2);
                        ?>
                    </div>
                    <div class="inputConteiner">
                        <p>Музыка:</p>
                        <?php
                            getSelect(3);
                        ?>
                    </div>
                    <div class="inputConteiner">
                        <p>Арт:</p>
                        <?php
                            getSelect(4);
                        ?>
                    </div>
                    <div class="inputConteiner">
                        <p>Хобби:</p>
                        <?php
                            getSelect(5);
                        ?>
                    </div>
                </div>
                <div class="footer"></div>
                <div class="textAreaContainer" >
                    <p>О себе</p>
                    <textarea id="myTextarea" name="description" rows="20">
                    </textarea>
                </div>
                <div class="buttonsContainer">
                    <button id="reset" type="reset">Отменить</button>
                    <button id="save" type="submit">Сохранить</button>
                </div>
            </div>
        </form>
        
        <?php 
            getAuthWindow()
        ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../js/main.js"></script>
        <script>
            loadForm();

        </script>
    
    </body>
</html>

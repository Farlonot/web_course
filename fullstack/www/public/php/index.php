<?php
    session_start();
    require_once('./back/template.php');
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/main_container.css">
        <link rel="icon" href="../images/zen.png" type="image/x-icon">
        <title>Сфера Синергии</title>
    </head>
    <body>
        <?php
            $keywords = null;
            $isLikeMe = false;
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['keywords']))
                    $keywords = $_GET['keywords'];
                elseif (isset($_GET['likeMe']) and $_GET['likeMe'] == true)
                    $isLikeMe = true;
            }
            getHeader(null, $keywords);
        ?>
        <div id="mainContainer">
            <div class="item" id="id_2">
                <div class="personalContainer">
                    <div class="avatar">
                        <img src="../images/woman.png" alt="">
                    </div>
                    <p class="username">username</p>
                    
                </div>
                <div class="textContainer">
                    <div class="text">
                        <p>Многие новички до сих пор попадают в тупик при написании простейшей аутентификации в PHP. На Тостере с завидной регулярностью попадаются вопросы о том, как сравнить сохраненный пароль с паролем полученным из формы логина. Здесь будет краткая статья-туториал на эту тему.</p>
                    </div>
                </div>
                <div class="interests">
                    <p>Color: coding</p>
                    <p>Sport: coding</p>
                    <p>Film: coding</p>
                    <p>Music: coding</p>
                    <p>Art: coding</p>
                    <p>Hobby: coding</p>
                </div>
            </div>
        </div>

        <?php
            getAuthWindow();
        ?>

        <aside class="ad">
            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/a3jbyl-OkQw?autoplay=1&controls=0&mute=1&disablekb=1&modestbranding=1&rel=1&showinfo=1" frameborder="0" allowfullscreen></iframe>
        </aside>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../js/main.js"></script>
        <script>
            isIndex = true;
            <?php
                if ($isLikeMe === true) {
                    echo 'findLikeMeHandler()';
                }else{

                    echo 'findHandler()';
                }
            ?>
        </script>
    </body>
</html>

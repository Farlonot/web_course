<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/main_container.css">
        <title>БелкАвто</title>
    </head>
    <body>
        <header>
            <nav>
                <div id="buttonHome" class="navItem"><a href='www/public/php/front/index.php'>Главная</a></div>
                <form action="" class="navItem">
                    <input type="text" id="searchInput" placeholder="поиск по описанию">
                    <svg id="find"   xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                
                </form>
                <div id="createAnnounce" class="navItem">Моя<br>страничка</div>
                <div id="accountMenu" class="navItem dropdown"  >Профиль
                    <div class="dropdownContent active" id="dropdownAccountMenu">
                        <div class="dropdown-content">
                            <div id="">Настройки</div>
                            <div id="signOut">Выйти</div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div id="mainContainer">
            <div class="item" id="item-1">
                <div class="personalContainer">
                    <div class="avatar">
                        <img src="./images/woman.png" alt="">
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
            <div class="item">3</div>
        </div>

        <div class="blurayBox" id="authorizationWindow" >
            <div class="signUpContainer" id="signUpContainer">
                
                <div class="formContainer signIn" id="signIn">
                    <form>
                        <h1>Войти</h1>
                        <input name="loginSignIn" type="text" placeholder="логин">
                        <input  name="passwordSignIn" type="password" placeholder="пароль">
                        <div id="signInmsg" class="msg">Данные не найдены</div>
                        <button id="signInButton">Войти</button>
                    </form>
                </div>
                <div class="formContainer signUp" id="signUp">
                    <form>
                        <h1>Создать аккаунт</h1>
                        <input name="email" type="email" placeholder="email" value=''>
                        <input name="login" type="text" placeholder="логин">
                        <input name="username" type="text" placeholder="имя пользователя">
                        <input name="password" type="password" placeholder="пароль">
                        <input name="rpassword" type="password" placeholder="повторите пароль">
                        <input name="birthday" type="date">
                        <div class="radioContainer">
                            <input type="radio" name="gender" id="male"   value="male">
                            <label for="male">муж.</label>
                        
                            <input type="radio" name="gender" id="female" value="female">
                            <label for="female">жен.</label>
                      
                            <input type="radio" name="gender" id="secret" value="secret">
                            <label for="secret">секрет</la>
                        </div>  
                        <p>Выберите интересы</p>
                        <div class="selectContainer">
                            <select name="color"> 
                                <option value="" selected disabled>Цвет</option>
                                <option value="red">Красный</option>
                                <option value="orange">Оранжевый</option>
                                <option value="yellow">Желтый</option>
                                <option value="green">Зеленый</option>
                                <option value="blue">Голубой</option>
                                <option value="cyan">Синий</option>
                                <option value="purple">Фиолетовый</option>
                                <option value="black">Черный</option>
                                <option value="white">Белый</option>
                                <option value="gray">Серый</option>
                            </select>
                            <select name="sport">
                                <option value="" selected disabled>Спорт</option>
                                <option value="Футбол">Футбол</option>
                                <option value="Баскетбол">Баскетбол</option>
                                <option value="Теннис">Теннис</option>
                                <option value="Хоккей">Хоккей</option>
                                <option value="Бег">Бег</option>
                                <option value="Плавание">Плавание</option>
                                <option value="Бокс">Бокс</option>
                                <option value="Волейбол">Волейбол</option>
                                <option value="Гольф">Гольф</option>
                                <option value="Борьба">Борьба</option>
                            </select>
                            <select name="film">
                                <option value="" selected disabled>Фильмы</option>
                                <option value="Боевик">Боевик</option>
                                <option value="Комедия">Комедия</option>
                                <option value="Драма">Драма</option>
                                <option value="Триллер">Триллер</option>
                                <option value="Ужасы">Ужасы</option>
                                <option value="Фантастика">Фантастика</option>
                                <option value="Мелодрама">Мелодрама</option>
                                <option value="Приключения">Приключения</option>
                                <option value="Детектив">Детектив</option>
                                <option value="Фэнтези">Фэнтези</option>
                            </select>
                            <select name="music">
                                <option value="" selected disabled>Музыка</option>
                                <option value="Рок">Рок</option>
                                <option value="Поп">Поп</option>
                                <option value="Хип-хоп">Хип-хоп</option>
                                <option value="Электронная">Электронная</option>
                                <option value="Классическая">Классическая</option>
                                <option value="Джаз">Джаз</option>
                                <option value="Металл">Металл</option>
                                <option value="Рэгги">Рэгги</option>
                                <option value="Кантри">Кантри</option>
                                <option value="Панк">Панк</option>
                            </select>
                            <select name="art">
                                <option value="" selected disabled>Арт</option>
                                <option value="Живопись">Живопись</option>
                                <option value="Скульптура">Скульптура</option>
                                <option value="Графика">Графика</option>
                                <option value="Фотография">Фотография</option>
                                <option value="Коллаж">Коллаж</option>
                                <option value="Иллюстрация">Иллюстрация</option>
                                <option value="Архитектура">Архитектура</option>
                                <option value="Кинематограф">Кинематограф</option>
                                <option value="Мода">Мода</option>
                                <option value="Дизайн">Дизайн</option>
                            </select>  
                            <select name="hobbie">
                                <option value="" selected disabled>Хобби</option>
                                <option value="Фотография">Фотография</option>
                                <option value="Рисование">Рисование</option>
                                <option value="Вышивание">Вышивание</option>
                                <option value="Рукоделие">Рукоделие</option>
                                <option value="Садоводство">Садоводство</option>
                                <option value="Рыбалка">Рыбалка</option>
                                <option value="Путешествия">Путешествия</option>
                                <option value="Кулинария">Кулинария</option>
                                <option value="Музыка">Музыка</option>
                                <option value="Литература">Литература</option></select>
                        </div>
                        <div id="signUpmsg" class="msg">Ошибка ввода. Проверьте, что все данные введены корректно. Все текстовые поля, должны быть длиннее 3 символов. И все, кроме почты, короче 32 символов.</div>
                        <button id="signUpButton">Создать</button>
                    </form>
                </div>
                <div class="toggle-container">
                    <div class="toggle">
                        <div class="toggle-panel" id="toggleSignIn">
                            <h1>С возвращением!</h1>
                            <p>Если вы здесь не в первый раз, <i><b>войдите в аккаунт</b></i>, чтобы использовать все возможности сайта</p>
                            <button id="toSignIn"   >Войти в аккаунт</but>
                        </div>
                        <div class="toggle-panel" id="toggleSignUp">
                            <h1>Привет!</h1>
                            <p>Если ты здесь впервые, <i><b>создайте аккаунт</b></i>, чтобы использовать все возможности сайта</p>
                            <button id="toSignUp"  >Создать аккаунт</button>
                        </div>
                    </div>
                </div>
                
                <div class="exitButton" id="exitButton" >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                </div>
            </div>
        </div>
        <footer></footer>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="../js/main.js"></script>
       
    </body>
</html>

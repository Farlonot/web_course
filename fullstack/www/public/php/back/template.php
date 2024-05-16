<?php 
    function getHeader($url=null, $keywords=null){
        $baseurl = '../php/index.php';
        echo '<header>
            <nav>
                <div id="buttonHome" class="navItem"><a href="'.(($url ===null) ? $baseurl : $url).'">Главная</a></div>
                <form id="findform" class="navItem">
                    <input type="text" id="searchInput" placeholder="поиск по описанию"'. (($keywords!=null and $keywords!=="")? ('value="'.$keywords.'"'):'').'>
                    <svg id="find"   xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                
                </form>
                <div id="createAnnounce" class="navItem">Моя<br>страничка</div>
                <div id="accountMenu" class="navItem dropdown"  >Профиль
                    <div class="dropdownContent active" id="dropdownAccountMenu">
                        <div class="dropdown-content">
                            <div id="edit">Редактировать</div>
                            <div id="findLikeMe">Возможные друзья</div>
                            <div id="signOut">Выйти</div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>';
    }

    function getAuthWindow(){
            echo '<div class="blurayBox" id="authorizationWindow" >
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
                                    <input name="email" type="email" placeholder="email" value="">
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
                                    <div class="selectContainer">'
                                        .getSelect().
                                    '</div>
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
                                        <p>Если вы здесь впервые, <i><b>создайте аккаунт</b></i>, чтобы использовать все возможности сайта</p>
                                        <button id="toSignUp"  >Создать аккаунт</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="exitButton" id="exitButton" >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                            </div>
                        </div>
                    </div>';
    }


    function getSelect($index=null){
        $selects=['
        <select name="color"> 
        <option value="null">Цвет</option>
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
        </select>',
        '<select name="sport">
        <option value="null">Спорт</option>
        <option value="football">Футбол</option>
        <option value="basketball">Баскетбол</option>
        <option value="tennis">Теннис</option>
        <option value="hockey">Хоккей</option>
        <option value="running">Бег</option>
        <option value="swimming">Плавание</option>
        <option value="boxing">Бокс</option>
        <option value="volleyball">Волейбол</option>
        <option value="golf">Гольф</option>
        <option value="wrestling">Борьба</option>
        </select>',
        '<select name="film">
        <option value="null">Фильмы</option>
        <option value="action">Боевик</option>
        <option value="comedy">Комедия</option>
        <option value="drama">Драма</option>
        <option value="thriller">Триллер</option>
        <option value="horror">Ужасы</option>
        <option value="science-fiction">Фантастика</option>
        <option value="melodrama">Мелодрама</option>
        <option value="adventure">Приключения</option>
        <option value="detective">Детектив</option>
        <option value="fantasy">Фэнтези</option>
        </select>',
        '<select name="music">
        <option value="null">Музыка</option>
        <option value="rock">Рок</option>
        <option value="pop">Поп</option>
        <option value="hip-hop">Хип-хоп</option>
        <option value="electronic">Электронная</option>
        <option value="classical">Классическая</option>
        <option value="jazz">Джаз</option>
        <option value="metal">Металл</option>
        <option value="reggae">Рэгги</option>
        <option value="country">Кантри</option>
        <option value="punk">Панк</option>
        </select>',
        '<select name="art">
        <option value="null">Арт</option>
        <option value="painting">Живопись</option>
        <option value="sculpture">Скульптура</option>
        <option value="graphics">Графика</option>
        <option value="photography">Фотография</option>
        <option value="collage">Коллаж</option>
        <option value="illustration">Иллюстрация</option>
        <option value="architecture">Архитектура</option>
        <option value="cinema">Кинематограф</option>
        <option value="fashion">Мода</option>
        <option value="design">Дизайн</option>
        </select>',
        '<select name="hobbie">
        <option value="null">Хобби</option>
        <option value="photography">Фотография</option>
        <option value="drawing">Рисование</option>
        <option value="embroidery">Вышивание</option>
        <option value="handicraft">Рукоделие</option>
        <option value="gardening">Садоводство</option>
        <option value="fishing">Рыбалка</option>
        <option value="traveling">Путешествия</option>
        <option value="cooking">Кулинария</option>
        <option value="music">Музыка</option>
        <option value="literature">Литература</option>
        </select>'
        ];
        if ($index!==null)
        {
            echo $selects[$index];
            
        }
        return implode(" ", $selects) ;
    }
?>
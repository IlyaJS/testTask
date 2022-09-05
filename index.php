<?php
session_start();
error_reporting(-1);

if (!empty($_SESSION['user'])){echo "Hello -> User : ".$_SESSION['user']['name']; echo '<a href="logout.php">'."Выход".'</a>';}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<noscript>
    <?php if(basename($_SERVER['REQUEST_URI']) != "disable.html"){ ?>
        <meta http-equiv="Refresh" content="0;disable.html">
    <?php } ?>
</noscript>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <p class="statusSession"></p>
    <div class="vision">
        <h3>Регистрация</h3>
        <form id="signup" method="POST" onsubmit="return false">

            <ul>
                <li>
                    <input type="text" name="name" placeholder="Введите имя" required>
                    <p class="validErrorName"></p>
                </li>
                <li>
                    <input type="text" name="email" placeholder="Введите почту" required>
                    <p class="validErrorEmail"></p>
                </li>
                <li>
                    <input type="text" name="login" placeholder="Введите логин" required>
                    <p class="validErrorLogin"></p>
                </li>
                <li>
                    <input type="password" name="password" placeholder="Введите пароль" required>
                    <p class="validErrorPassword"></p>
                </li>
                <li>
                    <input type="password" name="confirm_password" placeholder="Подтвердите пароль" required>
                    <p class="validErrorConfirm_password"></p>
                </li>
                <li>
                    <input type="submit" value="Зарегистрироваться">
                </li>
            </ul>
            <p class="msg none"></p>
        </form>

        <br>



        <h3>Авторизация</h3>

        <form id="signin" method="POST" onsubmit="return false">

            <ul>
                <li>
                    <input type="text" name="loginaut" placeholder="Введите логин">
                    <p class="validErrorLoginAut"></p>
                </li>
                <li>
                    <input type="password" name="passwordaut" placeholder="Введите пароль">
                    <p class="validErrorPasswordAut"></p>
                </li>
                <li>
                    <input type="submit" value="войти">
                </li>
            </ul>
            <p class="msgaut none"></p>


        </form>
    </div>
    <div class="userAut userAutNone">
        <h3>Профиль пользователя</h3>
        <form id="userLogout" method="POST" onsubmit="return false">
            <h1 class="userProfile"></h1>
            <input type="text" name="nameUser" placeholder="Введите имя" hidden>
            <input type="text" name="messageUser" placeholder="Введите имя" hidden>
            <input type="submit" value="Выход">

        </form>
        <p class="responseLogout"></p>
    </div>



    <script src="js/main.js"></script>
    <script src="js/aut.js"></script>
    <script src="js/logout.js"></script>
</body>

</html>
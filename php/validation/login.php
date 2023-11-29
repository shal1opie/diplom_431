<?php
//__DIR__;
require_once('../db_connect.php');


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/reset.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Авторизация</title>
  </head>
  <body>
    <div class="container_autorisation">
      <div class="content">
        <div class="right-side">
          <div class="topic-text">Авторизация</div>
          <form action="../main/main.php" name="form" method="POST">
            <div class="input-box">
              <input
                type="text"
                placeholder="Логин"
                name="name_email"
                id="name"
                data-reg="^[a-zA-Z][a-zA-Z0-9-_\.]{2,15}$|^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$"
                is-valid=0
                />
              <label for="name">Только латиница</label>
            </div>
            <div class="input-box">
              <input
                type="password"
                placeholder="Введите пароль"
                name="password"
                id="password"
                data-reg="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                is-valid=0
                />
              <label for="password">Пароль</label>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script
      src="https://kit.fontawesome.com/fce9a50d02.js"
      crossorigin="anonymous"
    ></script>
    <script src="../js/registration.js"></script>
  </body>
</html>

<?php

?>
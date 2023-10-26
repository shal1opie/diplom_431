<?php

require_once('../db_connect.php');

$sql_select="SELECT * FROM `roles`";
$result_select=$connect->query($sql_select);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/reset.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Регистрация</title>
  </head>
  <body>
    <div class="container">
      <div class="content">
        <div class="right-side">
          <div class="topic-text">Регистрация</div>
          <form action="../main/main.php" name="form" method="POST">
            <div class="input-box">
              <input
                type="text"
                placeholder="Логин"
                name="name"
                id="name"
                data-reg="^[a-zA-Z][a-zA-Z0-9-_\.]{2,15}$"
                is-valid=0
                />
              <label for="name">Только латиница</label>
            </div>
            <div class="input-box">
              <input
                type="text"
                placeholder="Введите email"
                name="email"
                id="email"
                data-reg="^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$"
                is-valid=0
                />
              <label for="email">В формате: name@email.com</label>
            </div>
            <div class="input-box">
              <select name="select" id="select">
                <?php 
                    if($result_select->num_rows > 0) {
                      while($row = $result_select->fetch_assoc()) {
                      echo "<option value=\"".$row["id"]."\">".$row["role_name"]."</option>";
                      }
                    }
                ?>
              </select>
              <label for="select">Выберите роль</label>
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
            <div class="input-box">
                <input
                type="password"
                placeholder="Повторный ввод пароля"
                name="password_repeat"
                id="password_repeat"
                data-reg="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                is-valid=0
                />
              <label for="password_repeat">Повторите пароль</label>
              </div>
            <!-- <div class="button" id="div_btn">
              <input type="submit" id="button" value="Отправить" class="btn"/> 
            </div> -->
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
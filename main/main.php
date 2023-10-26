<?php
//__DIR__;
require_once('../db_connect.php');

print_r($_POST);


$pass=$_POST["password"];

if(isset($_POST["name"],$_POST["email"],$_POST["password_repeat"],$_POST["select"])) {
    $nickname=$_POST["name"];
    $email=$_POST["email"];
    $repeat_pass=$_POST["password_repeat"];
    $selected_role=$_POST["select"];

    $sql_reg="INSERT INTO `users` (nick_name, role, email, password) VALUES ('$nickname', '$selected_role', '$email', '$pass')";
    if($connect->query($sql_reg) === TRUE) {
        echo "Успешная регистрация под логином " . $nickname . "!";
    } else {
        echo "Ошибка: " . $connect->error;  
    }


}


if(isset($_POST["name_email"])) {
    $name_mail=$_POST["name_email"];
    $sql_login = "SELECT * FROM `users` WHERE (`nick_name`='$name_mail' OR `email`='$name_mail') AND `password`='$pass'";
    $result_login = $connect->query($sql_login);


    if($result_login->num_rows > 0) {
        while($row = $result_login->fetch_assoc()) {
            echo "<br>Добро пожаловать " . $row["nick_name"];
            $role=$row["role"];
            $sql_role = "SELECT * FROM `roles` WHERE `id`='$role'";
            $result_role = $connect->query($sql_role);
            if($result_role->num_rows > 0) {
                while($row_role = $result_role->fetch_assoc()) {
                    echo "<br>Ваша роль - " . $row_role["role_name"];
                }
            } else {
                echo "Ошибка";
            }
        }
    } else {
        echo "Пользователь не найден";
    }
}



?>
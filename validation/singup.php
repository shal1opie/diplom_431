<?php 
session_start();

require_once('../db_connect.php');

$sql_select="SELECT * FROM `roles`";
$result_select=$connect->query($sql_select);


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
//print_r($_POST);
// Получение данных с формы регистрации


$_SESSION['validation']['password_repeat'] = ' ';

//Тестирование получения данных
/* var_dump($rname);
var_dump($rfamil);
var_dump($rotshet);
var_dump($rlogin);
var_dump($rpassword);
var_dump($rpassword_dubl);
var_dump($remail); */

$_SESSION['validation'] = [];

/* if(empty($rname)){
    $_SESSION['validation']['rname'] = 'style="border-bottom: 1px solid red;"';
}else{
    $_SESSION['validation']['rname'] = ' ';
}


if(!filter_var($remail, filter: FILTER_VALIDATE_EMAIL)){
    $_SESSION['validation']['remail'] = 'style="border-bottom: 1px solid red;"';
}else{
    $_SESSION['validation']['remail'] = ' ';
}

if(empty($rpassword)){
    $_SESSION['validation']['rpassword'] = 'style="border-bottom: 1px solid red;"';
}else{
    $_SESSION['validation']['rpassword'] = ' ';
} */

if(!($pass == $repeat_pass)){
    $_SESSION['validation']['password_repeat'] = '<p class="msg">Пароли не совпадают</p>';
} else{
    $_SESSION['validation']['password_repeat'] = ' ';
    if(isset($send2)){
        $rresult = mysqli_query($connect, "INSERT INTO users (id, Role, Name, Surname, Otchestvo, Login, Password, Email) VALUES (NULL, '1', '$rname', '$rfamil', '$rotshet', '$rlogin', '$rpassword', '$remail')") or die ("Error : ".mysqli_error());
    }
}

if(!empty($_SESSION['validation'])){

    redirect('/validation/registration.php');
}


  
?>
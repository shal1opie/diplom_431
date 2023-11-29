<?php
    $connect = mysqli_connect('localhost','root','','space_achiv');
    mysqli_set_charset ($connect, 'utf8');

    if(!$connect){
        die("Connection Failed". mysqli_connect_error());
    } else {

    }
?>
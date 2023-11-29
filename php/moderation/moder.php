<?php

require_once('../db_connect.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/moder.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>Авторизация</title>
  </head>
<body>
    
<div class="page">

<header>
<div class="logo">
            <img src="..\image\logo.svg" alt="" class="logoimg">
        </div>

        <div class="main_name">
            Модерация
        </div>

        <div class="change_table">
            <div class="chng_name">Изменить страницу</div> <div class="strelka"></div>
        </div>
</header>

<main class="main">

<div class="dbmain">

<div class="search">
    <form action="" method="get">
        <input type="search" name="" id="" class="search_txt">
</div>

<div class="btn">
    <input type="submit" value="Поиск" class="search_btn">
    </form>
</div>

<div class="table" data-simplebar>
    <table id="table">

    <tr>
    <th>ID</th>
    <th>Логин</th>
    <th>Роль</th>
    <th>Повышение роли</th>
    <th>Действие</th>                      
    </tr>

<?php 
    $query = "SELECT * FROM users";
    $result = mysqli_query($connect,$query);

    $count = 1;
    while($row = mysqli_fetch_array($result) ){
    $id = $row['id'];
    $role=$row["role"];
    $role_raise=$row["role_raise"];
    if(empty($role_raise)) {
    ?>
    <tr class="no_need">
    <?php
    } else {
    ?>
    <tr class="need">
    <?php
    }
    //echo $role_raise;

    ?>
    <td align='center'><?= $count; ?></td>
								
    <td><?php echo $row['nick_name'] ?></td>

    <?php include 'moder_help.php'; //понизить роль заблокать .. одобрить отколонить
    if ($i==0) {
    ?>
    
    <td><div class='delete' data-id='<?= $id; ?>'><i class="fa fa-trash-o btn btn-danger" aria-hidden="true"></i></div></td>
    </tr>
<?php
    } else {
    ?>
    <td><div class='change' data-id='<?= $id; ?>'></div></td>
    <?php    
    }
    $count++;
    }
?>
    </table>
</div>

<div class="filters">
    <div class="filter_name">Фильтры</div>
    <div class="filter_labels">
        <!-- <input type="radio" name="filter" id="option_1"><label for="option_1">Фильтры</label><br> -->
    <input type="checkbox" id="chkTest" />
    <label for="chkTest">Изменение роли</label>
    </div>
</div>

</div>


</main>

<footer>

</footer>

</div>

</body>

<script>
    $(document).ready(function(){

        $('.delete').click(function(){
            let el=this;

            let deleteid=$(this).data('id');

            let confirmalert=confirm("Are you sure?");
            if (confirmalert == true) {
                $.ajax({
                    url:'remove.php',
                    type: 'POST',
                    data: { id:deleteid },
                    success: function(response){
                        if(response == 1) {
                            $(el).closest('tr').css('background','tomato');
                            $(el).closest('tr').fadeOut(800, function(){
                                $(this).remove();
                            });
                        }else{
                            alert('Invalid ID.');
                        }
                    }
                });
            }
        });
    });
</script>
    <script src="../js/moder.js"></script>
</html>
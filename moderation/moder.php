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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    <th>Name</th>
    <th>Option</th>                      
    </tr>

<?php 
    $query = "SELECT * FROM users";
    $result = mysqli_query($connect,$query);

    $count = 1;
    while($row = mysqli_fetch_array($result) ){
    $id = $row['id'];
    ?>
    <tr>
    <td align='center'><?= $count; ?></td>
								
    <td><?php echo $row['nick_name'] ?></td>
                               
    <td><span class='delete' data-id='<?= $id; ?>'><i class="fa fa-trash-o btn btn-danger" aria-hidden="true"></i></span></td>
    </tr>
<?php
    $count++;
    }
?>
        <!-- <tr>
            <th>Имена</th>
            <th>Столбцов</th>
            <th>Берутся</th>
            <th>Из</th>
            <th id="last">Базы Данных</th>
        </tr>

        <tr>
            <td id="first">Lorem, ipsum.</td>
            <td id="first">Lorem, ipsum.</td>
            <td id="first">Lorem, ipsum.</td>
            <td id="first">Lorem, ipsum.</td>
            <td id="firstlast">Lorem, ipsum.</td>
        </tr> -->

    </table>
</div>

<div class="filters">
    <div class="filter_name">Фильтры</div>
    <div class="filter_labels">
        <!-- <input type="radio" name="filter" id="option_1"><label for="option_1">Фильтры</label><br> -->

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

</html>
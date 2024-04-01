<?php
// require_once('db_connect.php');
session_start();

$servername = "localhost";
$username = "root";
$password_host = "";
$dbname = "cosmodb";

if(isset($_GET['table'])) {
    $table = htmlspecialchars($_GET['table']);
} else {
    $table = 'space_achiv';
}

if(isset($_GET['id_change_form'])) {
    $id_change_form = $_GET['id_change_form'];
} else {
    $id_change_form = "";
}

if(isset($_GET['article'])) {
    $article = htmlspecialchars($_GET['article']);
} else {
    $article = null;
}

if(isset($_SERVER['HTTP_REFERER'])) {
  $refer = $_SERVER['HTTP_REFERER']; 
   }
else
{
  $refer = "http://localhost/cosmodb/main/cosmodb.php";
}


if(isset($_SESSION['user_loged_in'])) {
  $user_loged_in = $_SESSION['user_loged_in']; 
   }
else
{
  $user_loged_in = false;
}

if(isset($_SESSION['role'])&&isset($_SESSION['user_name'])) {
  $user_role = $_SESSION['role'];
  $user_name = $_SESSION['user_name'];
} else {
  $user_role = 0;
  $user_name = "";
}

$insert_query = "INSERT INTO `$table` ";
$select_query = " FROM $table";
$order_by = " ORDER BY `id`";
switch ($table) {
    case 'app_types':
        $select_query = "SELECT `id` AS `#`, `type` AS `Тип`".$select_query.$order_by;

        if(isset($_GET['type'])&&!is_array($_GET['type'])) {
            $type = $_GET['type'];
            $insert_query = $insert_query."(`id`, `type`) VALUES ('$id_change_form', '$type')";
        } else {
        $type = "";
        }

        break;

    case 'people':
        $select_query = "SELECT `id` AS `#`, `initials` AS `Инициалы`, 
        CONCAT(`surename`,' ',`name`,' ',`last_name`) AS `ФИО`".$select_query.$order_by;
        
        if(isset($_GET['initials'])&&isset($_GET['surename'])&&isset($_GET['name'])&&isset($_GET['last_name'])&&!is_array($_GET['initials'])&&!is_array($_GET['surename'])&&!is_array($_GET['name'])&&!is_array($_GET['last_name'])) {
            $initials = $_GET['initials'];
            $surename = $_GET['surename'];
            $name = $_GET['name'];
            $last_name = $_GET['last_name'];
            $insert_query = $insert_query."(`id`,`initials`,`surename`,`name`,`last_name`) 
            VALUES ('$id_change_form', '$initials', '$surename', '$name', '$last_name')";
        } else {
            $initials = $surename = $name = $last_name = "";
        }

        break;
        
    case 'roles':
        $select_query = "SELECT `id` AS `#`, `role_name` AS `Роль`".$select_query.$order_by;

        if(isset($_GET['role_name'])&&!is_array($_GET['role_name'])) {
            $role_name = $_GET['role_name'];
            $insert_query = $insert_query."(`id`,`role_name`) VALUES ('$id_change_form','$role_name')";
        } else {
        $role_name = "";
        }

        break;

    case 'space_achiv':
        $order_by = " ORDER BY space_achiv.id";
        $select_query = "SELECT space_achiv.id AS `#`, `country` AS `Страна`, people.initials AS `Причастное лицо`,
        `achiv_name` AS `Наименование`, `date` AS `Дата`, `text` AS `Текст`, app_types.type AS 'Тип аппарата'".$select_query."
        INNER JOIN people ON space_achiv.people = people.id
        INNER JOIN app_types ON space_achiv.type_app = app_types.id".$order_by;

        if(isset($_GET['country'])&&isset($_GET['people'])&&isset($_GET['achiv_name'])&&isset($_GET['date'])&&isset($_GET['text'])&&isset($_GET['type_app'])&&!is_array($_GET['country'])&&!is_array($_GET['people'])&&!is_array($_GET['achiv_name'])&&!is_array($_GET['date'])&&!is_array($_GET['text'])&&!is_array($_GET['type_app'])) {
            $country = $_GET['country'];
            $people = $_GET['people'];
            $achiv_name = $_GET['achiv_name'];
            $date = $_GET['date'];
            $text = $_GET['text'];
            $type_app = $_GET['type_app'];
            $insert_query = $insert_query."(`id`, `country`, `people`, `achiv_name`, `date`, `text`, `type_app`) 
        VALUES ('$id_change_form','$country',(SELECT `id` FROM `people` WHERE `id`='$people'),'$achiv_name','$date','$text',(SELECT `id` FROM `app_types` WHERE `id`='$type_app'))";
        } else {
            $country = $people = $achiv_name = $date = $text = $type_app = "";
        }
        
        
        break;

    case 'users':
        $order_by = " ORDER BY users.id";
        $select_query = "SELECT users.id AS `#`, `nick_name` AS `Логин`, roles.role_name AS `Роль пользователя`, 
        r1.role_name AS `Запрашиваемая роль`, `email` AS `Электронная почта`".$select_query."
        INNER JOIN roles ON users.role = roles.id
        LEFT JOIN roles r1 ON users.role_raise = r1.id".$order_by;

        if(isset($_GET['nick_name'])&&isset($_GET['role'])&&isset($_GET['role_raise'])&&isset($_GET['email'])&&isset($_GET['password'])&&!is_array($_GET['nick_name'])&&!is_array($_GET['role'])&&!is_array($_GET['role_raise'])&&!is_array($_GET['email'])&&!is_array($_GET['password'])) {
            $nick_name = $_GET['nick_name'];
            $role = $_GET['role'];
            $role_raise = $_GET['role_raise'];
            $email = $_GET['email'];
            $password = password_hash($_GET['password'], PASSWORD_DEFAULT);
            $insert_query = $insert_query."(`id`, `nick_name`, `role`, `role_raise`, `email`, `password`) 
            VALUES ('$id_change_form','$nick_name', (SELECT `id` FROM `roles` WHERE `id`='$role'),
            (SELECT `id` FROM `roles` WHERE `id`='$role_raise'),'$email','$password')";
        } else {
            $nick_name = $role = $role_raise = $email = $password = "";
        }


        break;

    default:
        header("Location: {$refer}");
        break;
}

try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_host, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$db_exists = $conn->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'")->fetchColumn();
$result = $conn->query("SELECT id FROM users");
while ($row = $result->fetch()) {
    if (empty($row['id'])) {
        $users_set = null;
    } else {
        $users_set = true;
    }
}
$result = $conn->query("SELECT `role` FROM users");
while ($row = $result->fetch()) {
    if (!empty($users_set)&&$row['role']=="4") {
        $user_admin_exists = true;
    } else {
        $user_admin_exists = false;
    }
}
} catch(PDOException $e) {
    echo database_eror();
}

function database_eror () {
    global $db_exists;
    switch ($db_exists) {
        case null:
            $error_msg = "<article class=\"container-fluid\"><h1 align=\"center\">
            <strong class=\"pico-color-indigo-300\"><i>506</i></strong><hr />Система не настроена<br></h1>Система требует настройки. <a href=\"../init/db_connect.php\">Настроить</a>
            </article>";
            return $error_msg;
            break;
        default:
            $error_msg = "";
            return $error_msg;
            break;
    }
}

function change_table () {
    global $table, $user_name, $user_role;
    $logo = file_get_contents("../image/logo.svg");
    $user_roles = [
        "1" => "Пользователь",
        "2" => "Модератор",
        "3" => "Оператор БД",
        "4" => "Администратор",
    ];
    ?>
    <header class="container-fluid row mt-1">
        <div class="col d-flex justify-content-start mx-4">
            <?= $logo ?>
        </div>
        <div class="col d-flex justify-content-end align-items-center mx-4">
            <strong><?= $user_roles[$user_role] ?> <?= $user_name ?> <a href="cosmodb.php?logout=1">выйти</a></strong>
        </div>
    </header>
    <?php
}

function view_table ($table) {
    global $conn, $select_query, $db_exists;
    $table_names = [
        "app_types" => "Тип аппарата",
        "people" => "Знаковые личности",
        "roles" => "Роли",
        "space_achiv" => "Космические достижения",
        "users" => "Пользователи",
    ];
    ?>
    <main class="container-fluid h-100">
        <div class="row row-cols-auto mx-5 mt-5">
    <?php
    foreach($table_names as $key => $value) {
        switch ($key) {
            case $table:
                echo "<div class=\"col px-0\"><a href=\"cosmodb.php?table=".$key."\" role=\"button\" class=\"btn rounded-0 rounded-top-4 btn-primary\">".$value."</a></div>";
                $current_table_name = $value;
                break;
            default:
                echo "<div class=\"col px-0\"><a href=\"cosmodb.php?table=".$key."\" role=\"button\" class=\"btn rounded-0 rounded-top-4 btn-light\">".$value."</a></div>";
                break;
        }
    }
    ?>
        </div>
    <?php
try {
    $result = $conn -> query($select_query);
    ?>
    <form action="cosmodb.php" method="get" class="row mx-4">
    <?php
    echo "<input type=\"hidden\" name=\"table\" value=\"".$table."\" />";
    ?>
    <div class="table-responsive col-11 border border-primary rounded-4 px-0" data-simplebar>
        <table class="table table-hover table-striped mb-0">
    <?php
    $once = 0;
    while ($row = $result -> fetch()) {
        if($once < 1) {echo "<thead><tr>";}
        foreach($row as $key => $value) {
            if (is_string($key) && $once < 1) {echo "<th class=\"text-center\">$key</th>";}
        }
        if($once < 1) {echo "</tr></thead><tbody>";}
        echo "<tr>";
        $once = 1;
        foreach($row as $key => $value) {
            $length = strlen($value);
            switch (true) {
                case (is_string($key)&&$key=='#'):
                    $id=$value;
                    if($table=='users'&&$id==1) {
                        echo "<td>$value</td>";
                    } else {
                        echo "<td class=\"px-0 text-center form-check-input\"><input class=\"input_m\" type=\"checkbox\" name=\"id_change_form[]\" value=\"$value\" readonly />$value</td>";
                    }
                    break;
                case (is_string($key)&&$length<150&&$key!='Страна'&&$key!='Дата'):
                    if($key =='Наименование') {
                        echo "<td>$value</td>";
                    } else {
                        echo "<td class=\"text-center\">$value</td>";
                    }
                    break;
                case (is_string($key)&&$length>150):
                    $substr=mb_substr($value,0,30,'UTF-8');
                    echo "<td >$substr... <a href=\"cosmodb.php?article=$id\">Прочесть статью</a></td>";                    break;
                case ($table=='space_achiv'&&is_string($key)&&$key=="Страна"):
                    if($value==1) {
                        echo "<td class=\"text-center\">СССР</td>";
                    } elseif($value==2) {
                        echo "<td class=\"text-center\">Россия</td>";
                    }
                    break;
                case ($table=='space_achiv'&&is_string($key)&&$key=="Дата"):
                    $date_text = date("d.m.Y", strtotime($value));
                    echo "<td class=\"text-center\">$date_text</td>";
                    break;
            }
        }
        
        echo "</tr>";

    }
    ?>
        </tbody>
        </table>
    </div>
    <div class="col-1 px-4">
        <div class="row">
        <input 
            type="submit" 
            value="Добавить строку" 
            name="action" 
            class="btn btn-outline-primary rounded-0 rounded-top-4 border-bottom-0" 
        />
        </div>

        <div class="row">
        <input 
            type="submit" 
            value="Редактировать выбранное" 
            name="action" 
            class="btn btn-outline-primary rounded-0 border-bottom-0"
        />
        </div>

        <div class="row">
        <input 
            type="submit" 
            value="Удалить выбранное" 
            name="action" 
            class="btn btn-outline-primary rounded-0 border-bottom-0"
        />
        </div>

        <div class="row">
        <input 
            type="submit" 
            value="SQL" 
            name="action"
            class="btn btn-outline-primary rounded-0 rounded-bottom-4"
        />
        </div>
    </div>
    </form>
    <?php
} catch(PDOException $e) {
    echo database_eror();
}
    echo "</main>";
}


function reset_session () {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    session_start(); // Start a new session
}

function edit () {
    global $conn, $table, $id_change_form, $insert_query, $action;
    switch (true) {
        case (!empty($id_change_form)):
            var_dump($id_change_form);
            break;
        case (empty($id_change_form)&&$table=='space_achiv'):
            echo "<input type=\"hidden\" name=\"action\" value=\"Добавить строку\"/>
            <input type=\"hidden\" name=\"table\" value=\"space_achiv\"/>
            <label> Наименование
            <input type=\"text\" name=\"achiv_name\" placeholder=\"Наименование\"/>
            </label>
            <label> Страна
            <select name=\"country\">
                <option value=\"1\">СССР</option>
                <option value=\"2\">Россия</option>
            </select>
            </label>
            <label> Причастное лицо
            <select name=\"people\">";
            $sql = "SELECT `id`, `initials` FROM `people`";
            $result = $conn -> query($sql);
            while($row = $result -> fetch()) {
                echo "<option value=\"".$row['id']."\">".$row['initials']."</option>";
            }
            echo "</select>
            </label>
            <label> Дата
            <input type=\"date\" name=\"date\"/>
            </label>
            <label> Текст
            <textarea name=\"text\" rows=\"10\"></textarea>
            </label>
            <label> Тип аппарата
            <select name=\"type_app\">";
            $sql = "SELECT `id`, `type` FROM `app_types`";
            $result = $conn -> query($sql);
            while($row = $result -> fetch()) {
                echo "<option value=\"".$row['id']."\">".$row['type']."</option>";
            }
            echo "</select>
            <input type=\"submit\" value=\"Добавить\" />";
            if(!empty($_GET['achiv_name'])&&!empty($_GET['country'])&&!empty($_GET['date'])&&!empty($_GET['text'])&&!empty($_GET['type_app'])&&!empty($_GET['people'])) {
                    try {
                        $conn -> exec($insert_query);         
                    } catch(PDOException $e) {
                        echo $e->getMessage();
                    }
                header("Location: cosmodb.php");
            } else {
                echo "<small class=\"pico-color-green-500\">Заполните все поля</small>";
            }
            break;
        case (empty($id_change_form)&&$table=='users'):
            echo "<input type=\"hidden\" name=\"action\" value=\"Добавить строку\"/>
            <input type=\"hidden\" name=\"table\" value=\"users\"/>
            <label> Имя пользователя
            <input type=\"text\" name=\"nick_name\" placeholder=\"Имя пользователя\"/>
            </label>";
            $sql = "SELECT `id`, `role_name` FROM `roles`";
            $result = $conn -> query($sql);
            $ss = 0;
            echo "<label> Роль 
            <select name=\"role\">";
            while($row = $result -> fetch()) {
                echo "<option value =\"".$row['id']."\">".$row['role_name']."</option>";
                $s[$ss] = "<option value =\"".$row['id']."\">".$row['role_name']."</option>";
                $ss++;
            }
            $max = $ss+1;
            echo "</select>
            </label>
            <label> Повышение роли
            <select name=\"role_raise\">";
            for ($ss=0; $ss < $max; $ss++) { 
                echo $s[$ss];
            }
            echo "</select>
            </label>
            <label> Эл почта
            <input type=\"email\" name=\"email\" placeholder=\"Эл почта\"/>
            </label>
            <label> Пароль
            <input type=\"password\" name=\"password\" placeholder=\"Пароль\"/>
            </label>
            <input type=\"submit\" value=\"Добавить\"/>";
            if(!empty($_GET['role_raise'])&&!empty($_GET['role'])&&!empty($_GET['nick_name'])&&!empty($_GET['email'])&&!empty($_GET['password'])) {
                $sql_search_user = "SELECT `nick_name`, `role`, `email`, `password` FROM `users` WHERE (`nick_name`='".$_GET['nick_name']."' OR `email`='".$_GET['email']."')";
                $result = $conn -> query($sql_search_user);
                $row = $result -> fetch();
                if($result->rowCount()==0) {
                    try {
                        $conn -> exec($insert_query);         
                    } catch(PDOException $e) {
                        echo $e->getMessage();
                    }
                    header("Location: ../main/cosmodb.php?table=users");
                } else {
                    echo "<small class=\"pico-color-red-500\">Такой пользователь уже существует!</small>";
                }
                
        } else {
            echo "<small class=\"pico-color-green-500\">Заполните все поля!</small>";
        }
            break;
        case (empty($id_change_form)&&$table=='app_types'):
            echo "<input type=\"hidden\" name=\"action\" value=\"Добавить строку\"/>
            <input type=\"hidden\" name=\"table\" value=\"app_types\"/>
            <label> Название типа
            <input type=\"text\" name=\"type\" placeholder=\"Название типа\"/>
            </label>
            <input type=\"submit\" value=\"Добавить\" />";
            if(!empty($_GET['type'])) {
                try {
                    $conn -> exec($insert_query);
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
                header("Location: cosmodb.php?table=app_types");
            } else {
                echo "<small class=\"pico-color-green-500\">Заполните все поля</small>";
            }
            break;
        case (empty($id_change_form)&&$table=='roles'):
            echo "<input type=\"hidden\" name=\"action\" value=\"Добавить строку\"/>
            <input type=\"hidden\" name=\"table\" value=\"roles\"/>
            <label> Название роли
            <input type=\"text\" name=\"role_name\" placeholder=\"Название роли\"/>
            </label>
            <input type=\"submit\" value=\"Добавить\" />";
            if(!empty($_GET['role_name'])) {
                try {
                    $conn -> exec($insert_query);
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
                header("Location: cosmodb.php?table=roles"); 
            } else {
                echo "<small class=\"pico-color-green-500\">Заполните все поля</small>";
            }
            break;
        case (empty($id_change_form)&&$table=='people'):
            echo "<input type=\"hidden\" name=\"action\" value=\"Добавить строку\"/>
            <input type=\"hidden\" name=\"table\" value=\"people\"/>
            <label> Инициалы персоны
            <input type=\"text\" name=\"initials\" placeholder=\"Инициалы\"/>
            </label>
            <label> Имя
            <input type=\"text\" name=\"name\" placeholder=\"Имя\"/>
            </label>
            <label> Фамилия
            <input type=\"text\" name=\"surename\" placeholder=\"Фамилия\"/>
            </label>
            <label> Отчество
            <input type=\"text\" name=\"last_name\" placeholder=\"Отчество\"/>
            <input type=\"submit\" value=\"Добавить\" />";
            if(!empty($_GET['initials'])&&!empty($_GET['name'])&&!empty($_GET['surename'])&&!empty($_GET['last_name'])) {
                try {
                    $conn -> exec($insert_query);
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
                header("Location: cosmodb.php?table=people");
            } else {
                echo "<small class=\"pico-color-green-500\">Заполните все поля</small>";
            }
    }
}
function forms ($action) {
    global $id_change_form, $table, $refer, $conn, $select_query;?>
<header class="container">
    <nav>
        <ul>
            <li><a href="cosmodb.php?table=<?=$table?>"><img src="../image/logo.svg" alt="logo"></a></li>
        </ul>
        <ul>
            <li><h1><?=$action?> в таблице "<?=$table?>"</h1></li>
        </ul>
    </nav>
</header>
<main class="container">
    <article class="container-fluid">
    <form action="cosmodb.php" method="get">
    <?php
    switch (true) {
        case ($action=='Добавить строку'):
            edit();
            break;
        case ($action=='Редактировать выбранное'&&!empty($id_change_form)):
            if(!isset($_GET['edit'])) {
            echo "<input type=\"hidden\" name=\"table\" value=\"".$table."\"/>
            <input type=\"hidden\" name=\"action\" value=\"Редактировать выбранное\"/>";
            $num_ids = count($id_change_form);
            foreach ($id_change_form as $ids){
                if($table=='users'&&$ids==1) {
                    echo "<article class=\"container-fluid\"><h1 align=\"center\">
                    <strong class=\"pico-color-indigo-300\"><i>403</i></strong><hr />Редактирование запрещено<br></h1>Попытка редактирования профиля администратора.<a href=\"javascript:history.back()\">Вернуться</a>
                    </article>";
                    break;
                } else {
                    $select_where = str_replace('ORDER BY', 'WHERE '.$table.'.id = '.$ids.' ORDER BY', $select_query);
                    $input_names = [
                        "Логин" => "login[]",
                        "Роль пользователя" => "role[]",
                        "Запрашиваемая роль" => "role_raise[]",
                        "Электронная почта" => "email[]",
                        "Пароль" => "password[]",
                        "Инициалы" => "initials[]",
                        "Имя" => "name[]",
                        "Фамилия" => "surename[]",
                        "Отчество" => "last_name[]",
                        "Роль" => "role_name[]",
                        "Тип" => "type[]",
                        "Страна" => "country[]",
                        "Причастное лицо" => "people[]",
                        "Наименование" => "achiv_name[]",
                        "Дата" => "date[]",
                        "Текст" => "text[]",
                        "Тип аппарата" => "type_app[]"
                    ];
                    $word_value = [];
                    $words_to_find = [
                        "Роль" => "roles",
                        "Страна" => "country",
                        "Причастное лицо" => "people",
                        "Повышение роли" => "roles",
                        "Тип аппарата" => "app_types"
                    ];
                    foreach ($words_to_find as $key_name => $word) {
                        $pos = strpos($select_query, $word);
                        if ($pos !== false) {
                            $word_value[$key_name] = $word;
                            //echo $word_value[$key_name]."<br />";
                        }
                    }
                    $row = $conn->query($select_where)->fetch();
                    foreach($row as $key => $value) {
                        if ($key!=0) {
                        switch ($key) {
                            case (is_string($key)&&$key!='Текст'&&!isset($word_value[$key])&&$key!='#'&&!is_numeric($value)&&$key!=0&&$key!='Дата'):
                                echo "<label> $key
                                <input type=\"text\" name=\"$input_names[$key]\" value=\"$value\"/>
                                </label>";
                                break;
                            case (is_string($key)&&is_numeric($value)&&!isset($word_value[$key])):
                                echo "<label> ".$key."
                                <input type=\"text\" name=\"id_change_form[]\" value=\"".$value."\" readonly/>
                                </label>";
                                break;
                            case (is_string($key)&&$key=='Текст'&&!isset($word_value[$key])):
                                echo "<label> ".$key."
                                <textarea name=\"".$input_names[$key]."\" rows=\"10\">".$value."</textarea>
                                </label>";
                                break;
                            case (is_string($key)&&$key=='Дата'&&!isset($word_value[$key])):
                                echo "<label> ".$key."
                                <input type=\"date\" name=\"".$input_names[$key]."\" value=\"".$value."\"/>
                                </label>";
                                break;
                            case (is_string($key)&&isset($word_value[$key])):
                                echo "<label> ".$key."
                                <select name=\"".$input_names[$key]."\">";
                                if ($key!='Страна') {
                                echo "<option value=\"0\">".$value."</option>";
                                }
                                switch ($word_value[$key]) {
                                    case "roles":
                                        $sql = "SELECT * FROM roles";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch()) {
                                            if ($row['role_name']!=$value) {
                                                echo "<option value=\"".$row['id']."\">".$row['role_name']."</option>";
                                            }
                                        }
                                        break;
                                    case "country":
                                        if($value==1) {
                                            echo "<option value=\"0\">СССР</option><option value=\"2\">Россия</option>";
                                        } else {
                                            echo "<option value=\"0\">Россия</option><option value=\"1\">СССР</option>";
                                        }
                                        break;
                                    case "people":
                                        $sql = "SELECT * FROM people";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch()) {
                                            if ($row['initials']!=$value) {
                                                echo "<option value=\"".$row['id']."\">".$row['initials']."</option>";
                                            }
                                        }
                                        break;
                                    case "app_types":
                                        $sql = "SELECT * FROM app_types";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch()) {
                                            if ($row['type']!=$value) {
                                                echo "<option value=\"".$row['id']."\">".$row['type']."</option>";
                                            }
                                        }
                                        break;
                                }
                                echo "</select></label>";
                                break;
                            }
                        }
                    }

                    echo "<hr />";
                }

            }
            echo "<input type=\"submit\" value=\"Редактировать\" name=\"edit\"/>";
        } else {
                $ii = 0;
                echo $num_ids."<br />";
                var_dump($_GET);
                foreach ($_GET as $key_1 => $value) {
                    foreach ($_GET["id_change_form"] as $key_2 => $value2) {
                        if($key_1!='id_change_form'&&$key_1!='table'&&$key_1!='action'&&$key_1!='edit') {
                            foreach ($_GET[$key_1] as $key_3 => $value3) {
                                $sql_select_compare = "SELECT * FROM ".$table." WHERE id = $value2";
                                $ssttmmtt = $conn->query($sql_select_compare);
                                $row_compare = $ssttmmtt->fetch();
                                if($key_2==$key_3&&$row_compare[$key_1]!=$value3&&$value3!=0) {
                                    $update[$ii] = "UPDATE $table SET $key_1 = '$value3' WHERE $table.id = $value2";
                                    $ii++;
                                }
                            }
                        }
                    }
                }
                if(!empty($update)) {
                foreach ($update as $key_update => $value_update) {
                    $_SESSION['update'] = $value_update;
                    try {
                        $conn->query($value_update);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }
                header("Location: cosmodb.php?table=$table");
                exit();
            }
            
            break;
        case ($action=='Удалить выбранное'&&!empty($id_change_form)):
            $sql = "DELETE FROM ".$table." WHERE id IN (";
            $num_ids = count($id_change_form);
            foreach ($id_change_form as $ids){
                if($table=='users'&&$ids==1) {
                    echo "<article class=\"container-fluid\"><h1 align=\"center\">
                    <strong class=\"pico-color-indigo-300\"><i>403</i></strong><hr />Редактирование запрещено<br></h1>Попытка редактирования профиля администратора.<a href=\"javascript:history.back()\">Вернуться</a>
                    </article>";
                    break;
                } else {
                    echo "<input type=\"hidden\" name=\"id_change_form[]\" value=\"$ids\"/>";
                    $sql .= $ids.", ";
                    echo $ids."<br />";
                }
            }
            $sql = substr($sql, 0, -2);
            $sql .= ");";
            echo "<input type=\"hidden\" name=\"action\" value=\"Удалить выбранное\"/>
            <input type=\"hidden\" name=\"table\" value=\"".$table."\"/>
            <article class=\"container-fluid\">
            <h1>Вы действительно хотите удалить строку?</h1>
            </article>
            <div class=\"grid\">
            <a type=\"button\" href=\"javascript:history.back()\">Отменить</a>
            <input type=\"submit\" value=\"Удалить\" class=\"pico-color-red-500 outline\" name=\"delete\"/>
            </div>";
            if(isset($_GET['delete'])) {
                try {
                    $conn -> exec($sql);
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
                echo $sql;
                header("Location: cosmodb.php?table=$table");
                exit();
            } 
            break;
        case ($action=='SQL'):
            if (!isset($_GET['sql'])) {
                echo "<input type=\"hidden\" name=\"action\" value=\"SQL\"/>
                <input type=\"hidden\" name=\"table\" value=\"".$table."\"/>
                <textarea name=\"sql\" placeholder=\"SQL запрос\" rows=\"10\" cols=\"50\"></textarea>
                <input type=\"submit\" value=\"Выполнить\" name=\"sql\"/>";
            } else {
                $sql = $_GET['sql'];
                $conn -> exec($sql);
                header("Location: cosmodb.php?table=$table");
                exit();
            }
            break;
        default:
            header("Location: cosmodb.php?table=$table");
            break;
    }
?></form></article></main><?php
}

function additional_set_up ($auto_reg_form) {
    global $conn, $user_admin_exists;
?>
    <header class="container-fluid">
        <div class="row">
            <div class="col mt-1 d-flex justify-content-center">
                <img src="../image/logo.svg" class ="img-fluid" alt="logo">
            </div>
        </div>
    </header>
<?php
switch ($auto_reg_form) {
	case "Регистрация":
		?>
		<main class="container mt-5 border border-primary rounded-4 p-3">
		<form action="../main/cosmodb.php" method="get">
            <?php if(!$user_admin_exists) { 
                $value = [
                    "nick_name" => "value = \"admin\"",
                    "email" => "value = \"admin@cfdb.ru\"",
                    "password" => "value = \"admin1337_KU\"",
                ];
                $role_set_up = 4;
                $role_raise_set_up = 4;
                $have_account = "";
            ?>
            <legend class="h1 text-center text-primary">Регистрация администратора</legend>
            <?php } else {
                    $role_set_up = 1;
                    $role_raise_set_up = 1;
                    $have_account = "<p class=\"h5 text-center mt-3\">Есть аккаунт? <a href=\"cosmodb.php?auto_reg_form=Авторизоваться\">Авторизоваться</a></p>";
                    ?>
            <legend class="h1 text-center text-primary">Регистрация</legend>
            <?php } ?>
            
			<fieldset>
			<label for="nick_name" class="form-label h4">Имя пользователя</label>
                <input
                    name="nick_name"
                    class="form-control form-control-lg mb-3"
                    id="nick_name"
                    placeholder="Имя пользователя"
                    <?= !$user_admin_exists ? $value['nick_name'] : "" ?>
                />
			<label for="email" class="form-label h4">Эл почта</label>
                <input
                    type="email"
                    class="form-control form-control-lg mb-3"
                    name="email"
                    id="email"
                    placeholder="Эл почта"
                    <?= !$user_admin_exists ? $value['email'] : "" ?>
                    aria-describedby="emailHelp"
                />            
			<label for="password" class="form-label h4">Пароль</label>
                <input 
                type="password"
                class="form-control form-control-lg mb-3"
                name="password"
                id="password"
                placeholder="Пароль"
                <?= !$user_admin_exists ? $value['password'] : "" ?>/>
            <label for="password_repeat" class="form-label h4">Повторите пароль</label>
				<input
                type="password"
                class="form-control form-control-lg mb-3"
                name="password_repeat"
                id="password_repeat"
                placeholder="Повторите пароль"
                <?= !$user_admin_exists ? $value['password'] : "" ?>/>
            <input type="hidden" name="auto_reg_form" value="Регистрация" />


			<?php
        if(isset($_GET['set_up'])&&!empty($_GET['nick_name'])&&!empty($_GET['email'])
        &&!empty($_GET['password'])&&!empty($_GET['password_repeat'])) {
            if($_GET['password']==$_GET['password_repeat']) {
                $nick_name_set_up = $_GET['nick_name'];
                $email_set_up = $_GET['email'];
                $password_set_up = password_hash($_GET['password'], PASSWORD_DEFAULT);
                try {
                    $conn -> exec("INSERT INTO `users` (`id`, `nick_name`, `role`, `role_raise`, `email`, `password`) VALUES ('','$nick_name_set_up', (SELECT `id` FROM `roles` WHERE `id`='$role_set_up'),(SELECT `id` FROM `roles` WHERE `id`='$role_raise_set_up'),'$email_set_up','$password_set_up')"); 
                    
                    
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
                header("Location: ../main/cosmodb.php?auto_reg_form=Авторизоваться");
            } else {
                echo "<p class=\"h5 text-danger mt-3\">Пароли не совпадают</p>";
            }
            } elseif (isset($_GET['set_up'])) {
                echo "<p class=\"h5 text-danger mt-3\">Заполните все поля</p>";
            }
            ?>
                        <div class="row mt-3">
                <div class="col d-flex justify-content-end">
                    <button type="button" onclick="showPassword()" class="btn btn-primary btn-lg">Показать пароль</button>
                </div>
                <div class="col d-flex justify-content-start">
                    <input
                        type="submit"
                        value="Зарегистрироваться"
                        name = "set_up"
                        class="btn btn-success btn-lg"
                    />
                </div>
            </div>
		<?= $have_account ?>
        </fieldset>
		</form>
            <?php
    break;

	case "Авторизоваться":
		?>
		<main class="container mt-5 border border-primary rounded-4 p-3">
		<form action="../main/cosmodb.php" method="get">
            <legend class="h1 text-center text-primary">Вход в систему</legend>
			<fieldset>
			<label for="name_mail" class="form-label h4">Имя пользователя или эл почта</label>
            <input
                id="name_mail"
				name="name_mail"
				placeholder="Имя пользователя или эл почта"
                class="form-control form-control-lg mb-3"
			/>
			<label for="password" class="form-label h4">Пароль</label>
                <input 
				type="password"
                id="password" 
				name="password" 
				placeholder="Пароль"
                class="form-control form-control-lg mb-3"
				/>
            <input type="hidden" name="auto_reg_form" value="Авторизоваться" />
            <div class="row">
                <div class="col d-flex justify-content-center">
                <input
                    type="submit"
                    value="Войти"
                    name = "set_up"
                    class="btn btn-success btn-lg"
                />
                </div>
            </div>
        <p class="h5 text-center mt-3">Нет аккаунта? <a href="cosmodb.php?auto_reg_form=Регистрация">Зарегистрироваться</a></p>
		</fieldset>
		</form>
    <?php
        if(isset($_GET['set_up'])&&!empty($_GET['name_mail'])&&!empty($_GET['password'])) {
            $name_mail = $_GET['name_mail'];
            $password = $_GET['password'];
            $sql_search_user = "SELECT `nick_name`, `role`, `email`, `password` FROM `users` WHERE (`nick_name`='$name_mail' OR `email`='$name_mail')";
            $result_search_user = $conn->query($sql_search_user);
            if($result_search_user->rowCount() > 0) {
                while($row = $result_search_user->fetch()) {
                    if(password_verify($password, $row["password"])) {
                        $_SESSION['user_loged_in'] = true;
                        $_SESSION['role'] = $row["role"];
                        $_SESSION['user_name'] = $row["nick_name"];
                        header("Location: cosmodb.php");
                    } else {
                        echo "<small class=\"pico-color-red-500\">Неправильный пароль или имя пользователя</small>";
                    }
                }
            } else {
                echo "<small class=\"pico-color-red-500\">Неправильное имя пользователя или пароль</small>";
            }
        } elseif (isset($_GET['enter'])) {
            echo "<small class=\"pico-color-green-500\">Заполните все поля</small>";
        }
    break;
	} ?>
    			</article>
			</main>
			<script>
		function showPassword() {
			var x = document.getElementsByName("password")[0];
			if (x.type === "password") {
			x.type = "text";
			} else {
			x.type = "password";
			}
			var y = document.getElementsByName("password_repeat")[0];
			if (y.type === "password") {
			y.type = "text";
			} else {
			y.type = "password";
			}
		}
		</script>
		<?php

}

function article ($article) {
    global $conn, $refer;
    $sql = "SELECT `text` FROM `space_achiv` WHERE `id`=$article";
    $stmt = $conn->query($sql);
    //$stmt->execute(["text"]);
    $row = $stmt->fetch();
    $article_text = nl2br($row['text']);
    $article_text = "<p class=\"indent\">".str_replace("\n", "</p><p class=\"indent\">", $article_text);
    $logo = file_get_contents("../image/logo.svg");
    ?>
    <header class="container">
    <nav>
        <ul>
            <li><a href="cosmodb.php"><?= $logo?></a></li>
        </ul>
        <ul>
            <li><h1><a href="<?= $refer?>">Вернуться</a></h1></li>
        </ul>
    </nav>
    </header>
    <main class="container">
    <?php
    echo "<h5>$article_text</h5>";
    ?>
    </main>
    <?php
}

function main () {
    global $table, $db_exists, $users_set, $user_loged_in, $user_role, $article, $user_admin_exists;
    switch (true) {
        case (isset($_GET['action'])&&$db_exists&&$users_set&&$user_loged_in&&$user_role>0):
            // echo "926";
            $form_action = $_GET['action'];
            forms($form_action);
            break;
        case (!isset($_GET['action'])&&$db_exists&&$users_set&&$user_loged_in&&$user_role>0&&empty($article)): //!$_GET['auto_reg_form']
            // echo "930";
            change_table();
            view_table($table);
            break;
        case ($db_exists&&!$user_loged_in&&$user_role==0):
            // echo "933";
            if(isset($_GET['auto_reg_form'])) {
                $auto_reg_form = $_GET['auto_reg_form'];
            } else {
                $auto_reg_form = "Регистрация";
            }
            additional_set_up($auto_reg_form);
            break;
        case ($user_loged_in&&$db_exists&&$users_set&&$user_role>0&&!empty($article)):
            // echo "941";
            article($article);
            break;
        case (isset($_GET['logout'])&&$db_exists&&$users_set&&$user_loged_in&&$user_role>0):
            // echo "945";
            session_unset(); // Unset all session variables
            session_destroy(); // Destroy the session
            session_start();
            header ("Location: cosmodb.php?auto_reg_form=Регистрация");
            break;
        case (!$db_exists):
            header ("Location: ../init/db_connect.php");
            database_eror();
            break;
    }
}


?>
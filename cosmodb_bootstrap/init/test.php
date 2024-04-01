<?php
if(isset($_GET['edit'])) {
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
                foreach ($update as $key_update => $value_update) {
                    $_SESSION['update'] = $value_update;
                    try {
                        $conn->query($value_update);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }
			?>
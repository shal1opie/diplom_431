<?php
            if(isset($_GET['edit'])) {
                $ii = 0;
                echo $num_ids."<br />";
                //var_dump($_GET);
                $sql_update_start = "UPDATE $table SET ";
                $sql_update = $mega_update = "";
                foreach ($_GET as $key_1 => $value) {
                    if($key_1!='id_change_form'&&$key_1!='table'&&$key_1!='action'&&$key_1!='edit') {
                    
                    foreach ($_GET["id_change_form"] as $key_2 => $value2) {
                        
                            foreach ($_GET[$key_1] as $key_3 => $value3) {
                                //$sql_update = "$key_1 = CASE";
                                $sql_select_compare = "SELECT * FROM ".$table." WHERE id = $value2";
                                $ssttmmtt = $conn->query($sql_select_compare);
                                $row_compare = $ssttmmtt->fetch();
                                if($key_2==$key_3&&$row_compare[$key_1]!=$value3&&$value3!=0) {
                                    $update[$ii] = "$key_1 = CASE WHEN $table.id = $value2 THEN '$value3' END, ";
                                    $ii++;
                                }
                                if(!empty($update)) {
                                    //$update .= $update;
                                }
                            }
                            
                        //$update = $update."END,";
                        }
                    }
                    //$sql_update = $sql_update.$update;
                }
                echo $sql_update_start;
                foreach ($update as $key_update => $value_update) {
                    echo $value_update;
                    // try {
                    //     $conn->query($value_update);
                    // } catch (Exception $e) {
                    //     echo $e->getMessage();
                    // }
                }
            }
?>
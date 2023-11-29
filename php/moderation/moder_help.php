    <?php
    $sql_role = "SELECT * FROM `roles` WHERE `id`='$role'";
    $result_role = $connect->query($sql_role);
    if($result_role->num_rows > 0) {
                while($row_role = $result_role->fetch_assoc()) {
    ?>
                <td><?php echo $row_role["role_name"] ?></td>

    <?php
                }
            }
        
    ?>
        
    <?php
    if(empty($role_raise)) {
    ?>
    <td>Не нуждается в повышении</td>
    <?php
    $i=0;
    } else {
    $i=1;
    $sql_role_raise = "SELECT * FROM `roles` WHERE `id`='$role_raise'";
    $result_role_raise = $connect->query($sql_role_raise);
    if($result_role_raise->num_rows > 0) {
                while($row_role = $result_role_raise->fetch_assoc()) {
    ?>
                <td class="last"><?php echo $row_role["role_name"] ?></td>

    <?php
                }
            }
        }
    ?>
<?php require_once('../main/header.php');
?>

<?php 
    additional_set_up();
?>
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
<?php require_once('../main/footer.php'); ?>
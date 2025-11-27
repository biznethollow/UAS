<?php 
    include __DIR__."/../../model/login_model.php";

    if (isset($_POST['submit'])) {
        $error = validateLogin($_POST['username'], $_POST['password']);
        if($error) {
            $display = "display: block";
        } else {
            $display = "display: none";
        }
    }
?>

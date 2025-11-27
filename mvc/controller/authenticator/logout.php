<?php 
    session_start();
    session_unset();
    header("location: /UAS/mvc/view/index.php");
    exit();
?>
<?php 
    session_start();
    if(empty($_SESSION)) {
        header('location: /UAS/mvc/view/index.php');
        exit();
    }
?>
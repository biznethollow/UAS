<?php 
    include "../../model/add_account_model.php";

    $hasil = user();

    if(isset($_POST['submit'])) {
        tambahUser(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']), $_POST['role'], $_POST['sekolah']);
    }
?>
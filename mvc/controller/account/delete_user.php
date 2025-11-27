<?php
    include "../../koneksi.php";
    include "../authenticator/auth.php";

    $id = htmlspecialchars($_GET['id']);

    $query = $conn->prepare("DELETE FROM user WHERE id_user = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->close();
    header("location: /UAS/mvc/view/account/account.php");
?>
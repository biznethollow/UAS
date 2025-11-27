<?php
    include "../../koneksi.php";
    include "../authenticator/auth.php";

    $id = htmlspecialchars($_GET['id']);

    $query = $conn->prepare("DELETE FROM sekolah WHERE id_sekolah = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->close();
    header("location: /UAS/mvc/view/school/school.php");
?>
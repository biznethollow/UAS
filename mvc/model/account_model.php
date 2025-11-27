<?php
    include __DIR__."/../koneksi.php";
    include "../../controller/authenticator/auth.php";

    function user() {
        global $conn;
        $id = $_SESSION['id_user'];
        $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
        $hasil = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
        return $hasil;
    }

    function dataUser() {
        global $conn;
        $query = $conn->prepare("SELECT * FROM user");
        $query->execute();
        $data_user = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $query->close();
        return $data_user;
    }
?>
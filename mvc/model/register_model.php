<?php 
    include __DIR__."/../koneksi.php";

    function tambahUser($username, $password, $role, $sekolah) {
        global $conn;
        $query = $conn->prepare("INSERT INTO user (username, password, role, id_sekolah)
        VALUES (?, ?, ?, ?)");
        $query->bind_param("sssi", $username, $password, $role, $sekolah);
        $query->execute();
        $query->close();
    }

    function cariSekolah($nama) {
        global $conn;
        $query = $conn->prepare("SELECT * FROM sekolah WHERE nama_sekolah = ?");
        $query->bind_param("s", $nama);
        $query->execute();
        $hasil = $query->get_result()->fetch_assoc();
        $query->close();
        return $hasil;
    }

    function tambahSekolah($sekolah) {
        global $conn;
        $query = $conn->prepare("INSERT INTO sekolah (nama_sekolah)
        VALUES (?)");
        $query->bind_param("s", $sekolah);
        $query->execute();
        $query->close();
    }

    $query = $conn->prepare("SELECT * FROM sekolah");
    $query->execute();
    $data_sekolah = $query->get_result()->fetch_all(MYSQLI_ASSOC);
    $query->close();
?>
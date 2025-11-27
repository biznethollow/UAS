<?php 
    include "../../model/register_model.php";

    if (isset($_POST['submit'])) {
        if(empty($_POST['sekolah']) && isset($_POST['tambah_sekolah'])) {
            tambahSekolah(htmlspecialchars($_POST['tambah_sekolah']));
            $hasil = cariSekolah(htmlspecialchars($_POST['tambah_sekolah']));
            tambahUser(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']), 'student', $hasil['id_sekolah']);
            header('location: /UAS/mvc/view/index.php');
        }
        $hasil = cariSekolah(htmlspecialchars($_POST['sekolah']));
        tambahUser(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']), 'student', $hasil['id_sekolah']);
        header('location: /UAS/mvc/view/index.php');
    }  
?>
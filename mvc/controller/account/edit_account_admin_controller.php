<?php 
    include "../../model/edit_account_model.php";

    $id_user = (int)htmlspecialchars($_GET['id']);
    $hasil = cariUser($id_user);
    $error = [];
    $error['username'] = "";
    $error['password'] = "";
    if(isset($_POST['submit'])) {
        // validasi username
        if(empty($_POST["username"])) {
            $error["username"] = "Tidak boleh kosong";
        } elseif(preg_match("/^[a-z\s0-9]{2,}$/i", $_POST["username"])) {
            $error["username"] = "";
        } else {
            $error["username"] = "Harus lebih dari 2 karakter";
        }
        
        // validasi password
        if(empty($_POST["password"])) {
            $error["password"] = "Tidak boleh kosong";
        } else {
            $error["password"] = "";
        }

        if($error['username'] == "" && $error['password'] == "") {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $role = $_POST['role'];
            $sekolah = $_POST['sekolah'];
            $query = $conn->prepare("UPDATE user SET username = ?, password = ?, role = ?, id_sekolah = ? WHERE id_user = ?");
            $query->bind_param("sssii", $username, $password, $role, $sekolah, $id_user);
            $query->execute();
            $query->close();
            $conn->close();
        }
    }
?>
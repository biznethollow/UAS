<?php 
    include __DIR__."/../koneksi.php";

    function validateUser($username, $password) {
        global $conn;
        
        $query = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
        $query->bind_param("ss", $username, $password);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        $query->close();
        
        if (!$result) {
            return false;
        }
        
        if ($result['password'] === $password) {
            session_start();
            $_SESSION['id_user'] = $result['id_user'];
            return true;
        }
        
        // if (password_verify($password, $result['password'])) {
            //     return true;
            // }
            
        return false;   
    }

    function validateLogin($username, $password) {
        $error = "";

        if (empty($username) || empty($password)) {
            $error = "Username and Password can't be empty";
            return $error;
        }

        if (validateUser($username, $password)) {
            header("location: /UAS/mvc/view/dashboard/dashboard.php");
            exit();
        } else {
            $error = "Username and Password didn't match";
            return $error;
        }
    }
?>
<?php
    session_start();
    if(!empty($_SESSION)) {
        header("location: /UAS/mvc/view/dashboard/dashboard.php");
    }

    include "../../controller/authenticator/login.php";
    include "../../controller/register/register_controller.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../controller/css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="login">
        <div>
            <span class="error"><?php echo $error ?? ''; ?></span>
            <h1>Register New Account</h1>
            <form action="" method="POST">
                <div>
                    <p>Username</p>
                    <input type="text" name="username" required autocomplete="off">
                </div>
                <div>
                    <p>Password</p>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <p>School</p>
                    <input list="sekolahs" name="sekolah" placeholder="Search your school">
                    <datalist id="sekolahs">
                        <?php foreach($data_sekolah as $d): ?>
                            <option value="<?php echo $d['nama_sekolah'] ?>">
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div>
                    <span>Your school didn't exist?</span>
                    <input type="text" name="tambah_sekolah" value="<?php echo $_POST['tambah_sekolah'] ?? '' ?>" placeholder="Add your school in here">
                </div>
                <div>
                    <a href="../index.php">Back</a>
                    <input type="submit" value="submit" name="submit">
                </div>
            </form>
        </div>
    </div>
</body>
</html>

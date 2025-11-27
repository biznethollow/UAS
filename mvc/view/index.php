<?php
    session_start();
    if(!empty($_SESSION)) {
        header("location: /UAS/mvc/view/dashboard/dashboard.php");
    }

    include __DIR__."/../controller/authenticator/login.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../controller/css/style.css">
    <title>Login</title>
</head>
<body>
    <span class="error" style="<?php echo $display ?? '' ?>"><?php echo $error ?? ''; ?></span>
    <div class="login">
        <div>
            <h1>Login To Flashcard</h1>
            <form action="" method="POST">
                <div>
                    <p>Username</p>
                    <input type="text" name="username" required autocomplete="off">
                </div>
                <div>
                    <p>Password</p>
                    <input type="password" name="password" required>
                </div>
                <input type="submit" value="Login" name="submit">
            </form>
            <p>
                Don’t have an account?
                <a href="register/register.php">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>

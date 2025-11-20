<?php
    include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/style.css">
    <title>Login</title>
</head>
<body>
    <div class="content">
        <div class="login">
            <h1>Login To Flashcard</h1>
            <form action="" method="POST">
                <div>
                    <p>Username</p>
                    <input type="text" name="username">
                </div>
                <div>
                    <p>Password</p>
                    <input type="password" name="password">
                </div>
                <input type="submit" value="submit" name="submit">
            </form>
            <span>Click </span><a href="">here</a><span> if doesn't have an account</span>
        </div>
    </div>
</body>
</html>
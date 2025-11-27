<?php
    include "../../controller/account/edit_account_controller.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../controller/css/style.css">
    <title>Edit User</title>
</head>
<body>
    <div class="header">
        <div class="left">
            <h1>Flashcard</h1>
            <a href="../dashboard/dashboard.php">Home</a>
            <a href="../play/play.php">Play Flashcard</a>
            <div class="menu">Menu
                <div>
                    <a href="../flashcard_deck/flashcard_deck.php">My Flashcard Deck</a>
                    <a href="../history/history.php">History</a>
                </div>
            </div>
            <?php if($hasil['role'] == "admin"): ?>
                <div class="menu">Management
                    <div>
                        <a href="account.php">Account</a>
                        <a href="../school/school.php">School</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="right">
            <div class="user">
                <?php echo $hasil['username'] ?>
                <div>
                    <a href="edit_account.php">Edit My Account</a>
                    <a href="../../controller/authenticator/logout.php">logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <h1>Edit User</h1>
        <form action="" method="POST">
            <div>
                <p style="color:red"><?php echo $error["username"] ?? ""; ?></p>
                <span>Username</span>
                <input type="text" name="username" value="<?php echo $_POST['username'] ?? $hasil['username'] ?>" required>
            </div>
            <div>
                <p style="color:red"><?php echo $error["password"] ?? ""; ?></p>
                <span>Password</span>
                <input type="password" name="password" value="<?php echo $_POST['password'] ?? $hasil['password'] ?>" required>
            </div>
            <div>
                <span>Role</span>
                <select name="role" id="role">
                    <?php $role = ['student', 'admin']; ?>
                    <?php foreach($role as $r): ?>
                        <?php if($hasil['role'] == $r): ?>
                            <option value="<?php echo $r; ?>" selected><?php echo $r; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $r; ?>"><?php echo $r; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <span>School</span>
                <select name="sekolah" id="sekolah">
                    <?php foreach($data_sekolah as $r): ?>
                        <?php if($hasil['id_sekolah'] == $r['id_sekolah']): ?>
                            <option value="<?php echo $r['id_sekolah'] ?>" selected><?php echo $r['nama_sekolah'] ?></option>
                        <?php else: ?>
                            <option value="<?php echo $r['id_sekolah'] ?>"><?php echo $r['nama_sekolah'] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <a href="account.php" class="batal">Back</a>
                <button type="submit" value="submit" name="submit" class="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php 
    include "../../controller/account/add_account_controller.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../controller/css/style.css">
    <title>Add Account</title>
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
        <h1>Add Account</h1>
        <form action="" method="POST">
            <div>
                <span>Username</span>
                <input type="text" name="username" value="<?php echo $_POST['username'] ?? '' ?>" required>
            </div>
            <div>
                <span>Password</span>
                <input type="password" name="password" value="<?php echo $_POST['password'] ?? '' ?>" required>
            </div>
            <div>
                <span>Role</span>
                <select name="role" id="role">
                    <?php foreach($role as $r): ?>
                        <?php if($_POST['role'] == ""): ?>
                            <option value="<?php echo $r ?>"><?php echo $r ?></option>
                        <?php elseif($r == $_POST['role']): ?>
                            <option value="<?php echo $r ?>" selected><?php echo $r ?></option>
                        <?php else: ?>
                            <option value="<?php echo $r ?>"><?php echo $r ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <span>Nama Sekolah</span>
                <select name="sekolah" id="sekolah">
                    <?php foreach($data_sekolah as $r): ?>
                        <?php if($_POST['sekolah'] == ""): ?>
                            <option value="<?php echo $r['id_sekolah'] ?>"><?php echo $r['nama_sekolah'] ?></option>
                        <?php elseif($r['id_sekolah'] == $_POST['sekolah']): ?>
                            <option value="<?php echo $r['id_sekolah'] ?>" selected><?php echo $r['nama_sekolah'] ?></option>
                        <?php else: ?>
                            <option value="<?php echo $r['id_sekolah'] ?>"><?php echo $r['nama_sekolah'] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <a href="account.php">Back</a>
                <button type="submit" name="submit" value="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
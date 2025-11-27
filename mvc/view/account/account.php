<?php
    include "../../controller/account/account_controller.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../controller/css/style.css">
    <title>Account Management</title>
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
        <h1>Account Management</h1>
        <a href="add_account.php">Add Account</a>
        <table>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php $num = 1; ?>
            <?php foreach($data_user as $m): ?>
                <tr>
                    <td><?php echo $num++ ?></td>
                    <td><?php echo $m['username'] ?></td>
                    <td><?php echo $m['role'] ?></td>
                    <td>
                        <a href="edit_account_admin.php?id=<?php echo $m['id_user'] ?>" class="edit">Edit</a>
                        <a href="../../controller/account/delete_user.php?id=<?php echo $m['id_user'] ?>" class="hapus" onclick="return confirm('Are you want to delete <?php echo $m['username'] ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
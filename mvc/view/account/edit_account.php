<?php 
    include "../../controller/authenticator/auth.php";
    include "../../model/fungsi.php";

    $id = $_SESSION['id_user'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
    $hasil = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

    $hasil2 = cariUser($id);
    if(isset($_POST['submit'])) {
        editUser(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../controller/css/style.css">
    <title>Add School</title>
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
        <h1>Edit Your Account</h1>
        <form action="" method="POST">
            <div>
                <span>Username</span>
                <input type="text" name="username" value="<?php echo $_POST['username'] ?? $hasil2['username'] ?>" required>
            </div>
            <div>
                <span>Password</span>
                <input type="password" name="password" value="<?php echo $_POST['password'] ?? $hasil2['password'] ?>" required>
            </div>
            <div>
                <a href="../dashboard/dashboard.php">Back</a>
                <button type="submit" name="submit" value="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
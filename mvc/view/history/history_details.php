<?php 
    include "../../controller/authenticator/auth.php";
    include "../../model/fungsi.php";

    $id = $_SESSION['id_user'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
    $hasil = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

    $hasil2 = cariHistory(htmlspecialchars($_GET['id']));
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
                    <a href="history.php">History</a>
                </div>
            </div>
            <?php if($hasil['role'] == "admin"): ?>
                <div class="menu">Management
                    <div>
                        <a href="../account/account.php">Account</a>
                        <a href="../school/school.php">School</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="right">
            <div class="user">
                <?php echo $hasil['username'] ?>
                <div>
                    <a href="../account/edit_account.php">Edit My Account</a>
                    <a href="../../controller/authenticator/logout.php">logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <h1>History Detail</h1>
        <a href="history.php">Back</a>
        <table>
            <tr>
                <th>Date Submitted</th>
                <th>Score</th>
                <th>Title</th>
                <th>Description</th>
            </tr>
            <?php if($hasil2): ?>
                <?php foreach($hasil2 as $h): ?>
                    <td><?php echo $h['tanggal'] ?></td>
                    <td><?php echo $h['judul'] ?></td>
                    <td><?php echo $h['deskripsi'] ?></td>
                    <td><?php echo $h['skor'] ?></td>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
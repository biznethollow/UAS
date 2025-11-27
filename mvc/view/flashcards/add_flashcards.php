<?php 
    include "../../controller/authenticator/auth.php";
    include "../../model/fungsi.php";

    $id = $_SESSION['id_user'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
    $hasil = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

    if(isset($_POST['submit'])) {
        tambahFlashcards(htmlspecialchars($_GET['id']), htmlspecialchars($_POST['teks_depan']), htmlspecialchars($_POST['teks_belakang']));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../controller/css/style.css">
    <title>My Flashcard Deck</title>
</head>
<body>
    <div class="header">
        <div class="left">
            <h1>Flashcard</h1>
            <a href="../dashboard/dashboard.php">Home</a>
            <a href="../play/play.php">Play Flashcard</a>
            <div class="menu">Menu
                <div>
                    <a href="../flahscard/flashcard_deck.php">My Flashcard Deck</a>
                    <a href="../history/history.php">History</a>
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
        <h1>Add Flashcards</h1>
        <form action="" method="POST">
            <div>
                <span>Word</span>
                <input type="text" name="teks_depan" value="<?php echo $_POST['teks_depan'] ?? '' ?>">
            </div>
            <div>
                <span>Description</span>
                <input type="text" name="teks_belakang" value="<?php echo $_POST['teks_belakang'] ?? '' ?>">
            </div>
            <div>
                <a href="../flashcard_deck/edit_flashcard_deck.php?id=<?php echo htmlspecialchars($_GET['id']) ?>">Back</a>
                <button type="submit" name="submit" value="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php 
    include "../../controller/authenticator/auth.php";
    include "../../model/fungsi.php";

    $id = $_SESSION['id_user'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
    $hasil = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

    $id = htmlspecialchars($_GET['id']);
    $hasil2 = tampilFlashcardDeck(htmlspecialchars($_GET['id']));
    $hasil3 = cariFlashcards(htmlspecialchars($_GET['id']));
    if(isset($_POST['submit'])) {
        editFlashcardDeck(htmlspecialchars($_POST['judul']), htmlspecialchars($_POST['deskripsi']), htmlspecialchars($_GET['id']));
        header("location: /UAS/view/flashcard_deck/edit_flashcard_deck.php?id=$id");
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
                    <a href="flashcard_deck.php">My Flashcard Deck</a>
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
        <h1>Edit Flashcard Deck</h1>
        <form action="" method="POST">
            <div>
                <span>Title</span>
                <input type="text" name="judul" value="<?php echo $_POST['judul'] ?? $hasil2['judul'] ?>">
            </div>
            <div>
                <span>Description</span>
                <input type="text" name="deskripsi" value="<?php echo $_POST['deskripsi'] ?? $hasil2['deskripsi'] ?>">
            </div>
            <div>
                <a href="flashcard_deck.php">Back</a>
                <button type="submit" name="submit" value="submit">Submit</button>
                <a href="../flashcards/add_flashcards.php?id=<?php echo htmlspecialchars($_GET['id']) ?>">Add Flashcard</a>
            </div>
        </form>
        <div>
            <?php foreach($hasil3 as $h): ?>
                <div>
                    <p><?php echo $h['teks_depan'] ?></p>
                    <p><?php echo '"'.$h['teks_belakang'].'"' ?></p>
                    <div>
                        <a href="../flashcards/edit_flashcards.php?id=<?php echo htmlspecialchars($h['id_card']) ?>&id2=<?php echo htmlspecialchars($_GET['id']) ?>">Edit</a>
                        <a href="../../controller/flashcards/delete_flashcards.php?id=<?php echo htmlspecialchars($h['id_card']) ?>&id2=<?php echo htmlspecialchars($_GET['id']) ?>" onclick="return confirm('Are you want to delete <?php echo htmlspecialchars($h['id_card']) ?>')">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
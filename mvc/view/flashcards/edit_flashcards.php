<?php 
    include "../../controller/authenticator/auth.php";
    include "../../model/fungsi.php";

    $id = $_SESSION['id_user'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
    $hasil = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

    $hasil2 = tampilFlashcards(htmlspecialchars($_GET['id']));
    $hasil3 = tampilOpsi(htmlspecialchars($_GET['id']));
    $id = htmlspecialchars($_GET['id2']);
    $id1 = htmlspecialchars($_GET['id']);
    if(isset($_POST['submit'])) {
        editFlashcards(htmlspecialchars($_POST['teks_depan']), htmlspecialchars($_POST['teks_belakang']), htmlspecialchars($_GET['id']));
        header("location: /UAS/view/flashcards/edit_flashcards.php?id=$id1&id2=$id");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../controller/css/style.css">
    <title>My Flashcards</title>
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
        <h1>Edit Flashcards</h1>
        <form action="" method="POST" >
            <div>
                <span>Word</span>
                <input type="text" name="teks_depan" value="<?php echo $_POST['teks_depan'] ?? $hasil2[0]['teks_depan'] ?>">
            </div>
            <div>
                <span>Word Description</span>
                <input type="text" name="teks_belakang" value="<?php echo $_POST['teks_belakang'] ?? $hasil2[0]['teks_belakang'] ?>">
            </div>
            <div>
                <a href="../flashcard_deck/edit_flashcard_deck.php?id=<?php echo htmlspecialchars($_GET['id2']) ?>">Back</a>
                <button type="submit" name="submit" value="submit">Submit</button>
                <a href="../answer/add_answer.php?id=<?php echo htmlspecialchars($hasil2[0]['id_card']) ?>&id2=<?php echo htmlspecialchars($_GET['id2']) ?>">Add Answer</a>
            </div>
        </form>
        <div>
            <?php foreach($hasil3 as $h): ?>
                <div>
                    <p><?php echo $h['jawaban'] ?></p>
                    <?php if($h['is_correct'] == 1): ?>
                        <p>True</p>
                    <?php else: ?>
                        <p>False</p>
                    <?php endif; ?>
                    <div>
                        <a href="../answer/edit_answer.php?id=<?php echo htmlspecialchars($h['id_jawaban']) ?>&id2=<?php echo htmlspecialchars($_GET['id']) ?>&id3=<?php echo htmlspecialchars($_GET['id2']) ?>">Edit</a>
                        <a href="../../controller/answer/delete_answer.php?id=<?php echo htmlspecialchars($h['id_jawaban']) ?>&id2=<?php echo htmlspecialchars($_GET['id']) ?>&id3=<?php echo htmlspecialchars($_GET['id2']) ?>" onclick="return confirm('Are you want to delete <?php echo $h['jawaban'] ?>')">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
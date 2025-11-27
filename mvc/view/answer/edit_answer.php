<?php 
    include "../../controller/authenticator/auth.php";
    include "../../model/fungsi.php";

    $id = $_SESSION['id_user'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
    $hasil = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

    $id1 = htmlspecialchars($_GET['id']);
    $id = htmlspecialchars($_GET['id2']);
    $id3 = htmlspecialchars($_GET['id3']);
    $hasil2 = tampilJawaban($id1);
    if(isset($_POST['submit'])) {
        editjawaban($id1, htmlspecialchars($_POST['is_correct']), htmlspecialchars($_POST['jawaban']));
        header("location: /UAS/view/answer/edit_answer.php?id=$id1&id2=$id&id3=$id3");
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
        <h1>Edit Answer</h1>
        <form action="" method="POST" >
            <div>
                <span>Word / Sentences</span>
                <input type="text" name="jawaban" value="<?php echo $_POST['jawaban'] ?? $hasil2['jawaban'] ?>">
            </div>
            <div>
                <span>Is This The Answer?</span>
                <?php if($hasil2['is_correct'] == 1 && empty($_POST['is_correct'])): ?>
                    <label for="1">
                        <input id="1" type="radio" name="is_correct" value="1" checked>
                        <span>True</span>
                    </label>
                    <label for="0">
                        <input id="0" type="radio" name="is_correct" value="0">
                        <span>False</span>
                    </label>
                <?php elseif(empty($_POST['is_correct'])): ?>
                    <label for="1">
                        <input id="1" type="radio" name="is_correct" value="1" >
                        <span>True</span>
                    </label>
                    <label for="0">
                        <input id="0" type="radio" name="is_correct" value="0" checked>
                        <span>False</span>
                    </label>
                <?php elseif($_POST['is_correct'] == 1): ?>
                    <label for="1">
                        <input id="1" type="radio" name="is_correct" value="1" checked>
                        <span>True</span>
                    </label>
                    <label for="0">
                        <input id="0" type="radio" name="is_correct" value="0" >
                        <span>False</span>
                    </label>
                <?php else: ?>
                    <label for="1">
                        <input id="1" type="radio" name="is_correct" value="1" >
                        <span>True</span>
                    </label>
                    <label for="0">
                        <input id="0" type="radio" name="is_correct" value="0" checked>
                        <span>False</span>
                    </label>
                <?php endif; ?>
            </div>
            <div>
                <a href="../flashcards/edit_flashcards.php?id=<?php echo htmlspecialchars($_GET['id2']) ?>&id2=<?php echo htmlspecialchars($_GET['id3']) ?>">Back</a>
                <button type="submit" name="submit" value="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php
    include "../../controller/authenticator/auth.php";
    include "../../model/fungsi.php";

    $id = $_SESSION['id_user'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
    $hasil = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

    $hasil2 = cariFlashcards(htmlspecialchars($_GET['id']));
    $num = 0;
    if(isset($_POST['next'])) {
        if(empty($_POST['jawaban'])) {
            $error = "You must choose at leaset 1";
            $display = "display: block";
        } else {
            logJawaban($id, $_POST['id_card'], $_POST['id_jawaban'], $_POST['jawaban']);
            $display = "display: none";
            $error = "";
            $num++;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../controller/css/style.css">
        <title>Play Flashcard</title>
    </head>
<body>
    <span class="error" style="<?php echo $display ?? '' ?>"><?php echo $error ?? ''; ?></span>
    <div class="header">
        <div class="left">
            <h1>Flashcard</h1>
            <a href="../dashboard/dashboard.php">Home</a>
            <a href="play.php">Play Flashcard</a>
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
        <h1>Take Your Time</h1>
        <?php if($hasil2): ?>
            <form action="" method="POST">
                <div class="question">
                    <span><?php echo $hasil2[$num]['teks_belakang'] ?></span>
                </div>
                <?php $hasil3 = tampilOpsi($hasil2[$num]['id_card']) ?>
                <input type="hidden" value="<?php echo $hasil2[$num]['id_card'] ?>" name="id_card">
                <div class="option">
                    <?php foreach($hasil3 as $h): ?>
                        <input type="hidden" name="id_jawaban" value="<?php echo $h['id_jawaban'] ?>">
                        <label for="<?php echo $h['id_jawaban'] ?>" class="options">
                            <input type="radio" name="jawaban" id="<?php echo $h['id_jawaban'] ?>">
                            <span><?php echo $h['jawaban'] ?></span> 
                        </label>
                    <?php endforeach; ?>
                </div>
                <div>
                    <?php if(count($hasil2) == $num+1): ?>
                        <a href="finish.php?id=<?php echo $hasil2[0]['id_deck'] ?>">Finish</a>
                    <?php else: ?>
                        <button type="submit" name="next" value="submit">Next</button>
                    <?php endif; ?>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
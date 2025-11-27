<?php 
    include "../../controller/authenticator/auth.php";
    include "../../model/fungsi.php";

    $id = $_SESSION['id_user'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
    $hasil = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
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
        <h1>Global Rank</h1>
        <div class="rangking">
            <a href="../dashboard/dashboard.php">Back</a>
            <form action="">
                <div>
                    <input type="text" id="filter" placeholder="Search Your Name">
                </div>
            </form>
        </div>
        <table id="table">
            <tr>
                <th>No</th>
                <th>Username</th>
            </tr>
            <?php $num=1; ?>
            <?php foreach($data_rangking_global as $d): ?>
                <tr>
                    <td><?php echo $num++ ?></td>
                    <td><?php echo $d['username'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script>
        const filter = document.getElementById("filter")
        let table = document.getElementById("table")
        
        filter.addEventListener("keyup", () => {
            let keyword = filter.value.toLowerCase();

            for (let index = 1; index < table.rows.length; index++) {
                const rowText = table.rows[index].textContent.toLowerCase();

                if (rowText.includes(keyword)) {
                    table.rows[index].style.display = "";
                } else {
                    table.rows[index].style.display = "none";
                }
            }
        });
    </script>
</body>
</html>
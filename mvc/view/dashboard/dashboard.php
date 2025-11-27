<?php 
    include "../../controller/authenticator/auth.php";
    include "../../koneksi.php";
    include "../../model/fungsi.php";
    
    $id = $_SESSION['id_user'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
    $hasil = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

    $hasil2 = cariRangkingGlobal($id, $data_rangking_global);
    $hasil3 = tampilRangkingSekolah($hasil['id_sekolah']);
    $hasil4 = cariRangkingSekolah($id, $hasil3);
    $hasil5 = tampilNamaSekolah($hasil['id_sekolah']);
    $hasil6 = wordOfTheDay()[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../controller/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard</title>
</head>
<body>
    <div class="header">
        <div class="left">
            <h1>Flashcard</h1>
            <a href="dashboard.php">Home</a>
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
        <div class="dash">
            <div>
                <h1>Overall Score</h1>
                <p><?php echo $hasil2['total_skor'] ?></p>
            </div>
            <div>
                <h1>School Name</h1>
                <p><?php echo $hasil5['nama_sekolah'] ?? '' ?></p>
            </div>
            <div>
                <h1>Word Of The Day</h1>
                <p><?php echo $hasil6['teks_depan'] ?></p>
                <p>"<?php echo $hasil6['teks_belakang'] ?>"</p>
            </div>
        </div>
        <a href="../rank/global_rank.php">
            <div>
                <p>My Global Rank Is:</p>
                <p><?php echo $hasil2['rangking'] ?></p>
            </div>
        </a>
        <a href="../rank/school_rank.php">
            <div>
                <p>My School Rangking Is:</p>
                <p><?php echo $hasil4 ?></p>
            </div>
        </a>
        <a href="">
            <div class="canvas-diagram">Word Statistics
                <canvas id="diagram"></canvas>
            </div>
        </a>
    </div>
    <script>
        const ctx = document.getElementById('diagram');

        new Chart(ctx, {
            data: {
                labels: <?php echo json_encode($data_kata_susah); ?>,
                
            datasets: [{
                type: 'bar',
                label: 'Answers',
                data: <?php echo json_encode($data_kata_susah_jawaban); ?>,
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
    </script>
</body>
</html>
<?php
    include "../controller/control_manajemen_akun.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Account Management</title>
</head>
<body>
    <div class="manajemen_akun">
        <h1>Account Management</h1>
        <a href="">Add Account</a>
        <div>
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Sekolah</th>
                    <th>Aksi</th>
                </tr>
                <?php $num = 1; ?>
                <?php foreach($manajemen_akun as $m): ?>
                    <tr>
                        <td><?php echo $num++ ?></td>
                        <td><?php echo $m['nama_user'] ?></td>
                        <td><?php echo $m['role'] ?></td>
                        <td><?php echo $m['nama_sekolah'] ?></td>
                        <td>
                            <a href="" class="edit">Edit</a>
                            <a href="" class="hapus">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
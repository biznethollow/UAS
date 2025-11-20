<?php
    include "../koneksi.php";

    // manajemen akun
    $query1 = mysqli_query($conn, "select user.id_user, user.nama_user, role, sekolah.nama_sekolah 
                        from user inner join sekolah on user.id_sekolah = sekolah.id_sekolah;");
    $manajemen_akun = mysqli_fetch_all($query1, MYSQLI_ASSOC);

    if()
?>

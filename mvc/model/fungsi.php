<?php
    include __DIR__."/../koneksi.php";

    $role = ['student', 'admin'];

    $query = $conn->prepare("SELECT * FROM user");
    $query->execute();
    $data_user = $query->get_result()->fetch_all(MYSQLI_ASSOC);
    $query->close();

    $query = $conn->prepare("SELECT * FROM sekolah");
    $query->execute();
    $data_sekolah = $query->get_result()->fetch_all(MYSQLI_ASSOC);
    $query->close();

    $query = $conn->prepare("SELECT * FROM flashcard_deck");
    $query->execute();
    $data_flashcard_deck = $query->get_result()->fetch_all(MYSQLI_ASSOC);
    $query->close();

    $query = $conn->prepare("SELECT * FROM sekolah");
    $query->execute();
    $data_sekolah = $query->get_result()->fetch_all(MYSQLI_ASSOC);
    $query->close();

    $query = $conn->prepare("SELECT 
                                c.teks_depan AS kata,
                                COUNT(l.id_log) AS total_jawaban,
                                SUM(CASE WHEN l.is_correct = 1 THEN 1 ELSE 0 END) AS jawaban_benar,
                                ROUND(SUM(CASE WHEN l.is_correct = 1 THEN 1 ELSE 0 END) / COUNT(l.id_log) * 100, 2) AS persen_benar
                            FROM log_jawaban_flashcard l
                            JOIN flashcards c ON l.id_card = c.id_card
                            GROUP BY l.id_card
                            ORDER BY persen_benar ASC;");
    $query->execute();
    $data_statistik_kata = $query->get_result()->fetch_all(MYSQLI_ASSOC);
    $query->close();

    $data_kata_susah = [];
    foreach($data_statistik_kata as $d) {
        if(count($data_kata_susah) < 10) {
            $data_kata_susah[] = $d['kata'];
        }
    }

    $data_kata_susah_jawaban = [];
    foreach($data_statistik_kata as $d) {
        if(count($data_kata_susah_jawaban) < 10) {
            $data_kata_susah_jawaban[] = $d['jawaban_benar'];
        }
    }

    $data_kata_susah_persentase = [];
    foreach($data_statistik_kata as $d) {
        if(count($data_kata_susah_jawaban) < 10) {
            $data_kata_susah_jawaban[] = $d['persen_benar'];
        }
    }

    $query = $conn->prepare("SELECT 
                                u.id_user,
                                u.username,
                                SUM(h.skor) AS total_skor
                            FROM flashcard_history h
                            JOIN user u ON h.id_user = u.id_user
                            GROUP BY u.id_user, u.username
                            ORDER BY total_skor DESC;");
    $query->execute();
    $data_rangking_global = $query->get_result()->fetch_all(MYSQLI_ASSOC);
    $query->close();

    function wordOfTheDay() {
        global $conn;
        $query = $conn->prepare("SELECT f.teks_depan, f.teks_belakang, d.judul AS deck
                                FROM word_of_the_day w
                                JOIN flashcards f ON w.id_card = f.id_card
                                JOIN flashcard_deck d ON f.id_deck = d.id_deck
                                WHERE w.tanggal = CURRENT_DATE;");
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $query->close();
        
        if($hasil) {
            return $hasil;
        } else {
            $query = $conn->prepare("INSERT INTO word_of_the_day (id_card, tanggal)
                                    SELECT id_card, CURRENT_DATE
                                    FROM flashcards
                                    WHERE id_card NOT IN (
                                        SELECT id_card FROM word_of_the_day
                                    )
                                    ORDER BY id_card ASC
                                    LIMIT 1;");
            $query->execute();
            $query->close();
            return wordOfTheDay();
        }
    }

    function cariRangkingGlobal($id, $data_rangking_global) {
        $hasil = [];
        $hasil['total_skor'] = 0;
        $hasil['rangking'] = 0;
        $num = 1;
        foreach($data_rangking_global as $d) {
            if($d['id_user'] == $id) {
                $hasil['total_skor'] = $d['total_skor'];
                $hasil['rangking'] = $num;
                return $hasil;
            }
            $num++;
        }
        return $hasil;
    }

    function cariRangkingSekolah($id, $data_rangking) {
        $num = 1;
        foreach($data_rangking as $d) {
            if($d['id_user'] == $id) {
                return $num;
            }
            $num++;
        }
        return 0;
    }

    // function cariSekolah($nama) {
    //     global $conn;
    //     $query = $conn->prepare("SELECT * FROM sekolah WHERE nama_sekolah = ?");
    //     $query->bind_param("s", $nama);
    //     $query->execute();
    //     $hasil = $query->get_result()->fetch_assoc();
    //     $query->close();
    //     return $hasil;
    // }

    function cariHistory($id) {
        global $conn;
        $query = $conn->prepare("select fh.id_history, fh.tanggal, fh.skor, fd.judul, fd.deskripsi from flashcard_history fh
                                join flashcard_deck fd on fh.id_deck = fd.id_deck
                                where fh.id_history= ?");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $query->close();
        return $hasil;
    }

    function cariFlashcards($id) {
        global $conn;
        $query = $conn->prepare("SELECT * FROM flashcards WHERE id_deck = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $query->close();
        return $hasil;
    }

    function cariFlashcardDeck($id) {
        global $conn;
        $query = $conn->prepare("SELECT * FROM flashcard_deck WHERE id_user = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $query->close();
        return $hasil;
    }

    function cariUser($id) {
        global $conn;
        $query = $conn->prepare("SELECT * FROM user WHERE id_user = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_assoc();
        $query->close();
        return $hasil;
    }

    // function tambahUser($username, $password, $role, $sekolah) {
    //     global $conn;
    //     $query = $conn->prepare("INSERT INTO user (username, password, role, id_sekolah)
    //     VALUES (?, ?, ?, ?)");
    //     $query->bind_param("sssi", $username, $password, $role, $sekolah);
    //     $query->execute();
    //     $query->close();
    // }

    function tambahFlashcardDeck($judul, $deskripsi) {
        global $conn;
        $query = $conn->prepare("INSERT INTO flashcard_deck (judul, deskripsi, id_user)
        VALUES (?, ?, ?)");
        $query->bind_param("ssi", $judul, $deskripsi, $_SESSION['id_user']);
        $query->execute();
        $query->close();
    }

    // function tambahSekolah($sekolah) {
    //     global $conn;
    //     $query = $conn->prepare("INSERT INTO sekolah (nama_sekolah)
    //     VALUES (?)");
    //     $query->bind_param("s", $sekolah);
    //     $query->execute();
    //     $query->close();
    // }

    function tambahJawaban($id_card, $is_correct, $jawaban) {
        global $conn;
        $query = $conn->prepare("INSERT INTO jawaban_flashcard (id_card, is_correct, jawaban)
        VALUES (?, ?, ?)");
        $query->bind_param("iis", $id_card, $is_correct, $jawaban);
        $query->execute();
        $query->close();
    }

    function tambahHistory($id_user, $id_deck) {
        global $conn;
        $query = $conn->prepare("SELECT
                                    ROUND(
                                        SUM(CASE WHEN jf.is_correct = 1 THEN 1 ELSE 0 END) / COUNT(*) * 100,
                                        2
                                    ) AS skor
                                FROM log_jawaban_flashcard l
                                JOIN jawaban_flashcard jf ON l.id_jawaban = jf.id_jawaban
                                JOIN flashcards f ON l.id_card = f.id_card
                                WHERE l.id_user = ?
                                AND f.id_deck = ?;");
        $query->bind_param("ii", $id_user, $id_deck);
        $query->execute();
        $hasil = $query->get_result()->fetch_assoc()['skor'];

        $query = $conn->prepare("INSERT INTO flashcard_history (id_user, id_deck, skor)
                                VALUES (?, ?, ?);");
        $query->bind_param("iii", $id_user, $id_deck, $hasil);
        $query->execute();
        $query->close();

        $hasil2 = tampilHistory($id_user)[count(tampilHistory($id_user))-1];
        return $hasil2;
    }

    function logJawaban($id_user, $id_card, $id_jawaban, $is_correct) {
        global $conn;
        $query = $conn->prepare("INSERT INTO log_jawaban_flashcard (id_user, id_card, id_jawaban, is_correct)
        VALUES (?, ?, ?, ?)");
        $query->bind_param("iiii", $id_user, $id_card, $id_jawaban, $is_correct);
        $query->execute();
        $query->close();
    }

    function tambahFlashcards($id, $teks_depan, $teks_belakang) {
        global $conn;
        $query = $conn->prepare("INSERT INTO flashcards (id_deck, teks_depan, teks_belakang)
        VALUES (?, ?, ?)");
        $query->bind_param("iss", $id, $teks_depan, $teks_belakang);
        $query->execute();
        $query->close();
    }

    function tampilHistory($id) {
        global $conn;
        $query = $conn->prepare("select fh.id_history, fh.tanggal, fh.skor, fd.judul, fd.deskripsi from flashcard_history fh
                                join flashcard_deck fd on fh.id_deck = fd.id_deck
                                where fh.id_user = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $query->close();
        return $hasil;
    }

    function tampilNamaSekolah($id) {
        global $conn;
        $query = $conn->prepare("SELECT nama_sekolah FROM sekolah WHERE id_sekolah = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_assoc();
        $query->close();
        return $hasil;
    }

    function tampilRangkingSekolah($id) {
        global $conn;
        $query = $conn->prepare("SELECT 
                                    u.id_user,
                                    u.username,
                                    SUM(h.skor) AS total_skor
                                FROM flashcard_history h
                                JOIN user u ON h.id_user = u.id_user
                                WHERE u.id_sekolah = ?
                                GROUP BY u.id_user, u.username
                                ORDER BY total_skor DESC;");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $query->close();
        return $hasil;
    }

    function tampilFlashcardDeck($id) {
        global $conn;
        $query = $conn->prepare("SELECT * FROM flashcard_deck WHERE id_deck = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_assoc();
        $query->close();
        return $hasil;
    }

    function tampilFlashcards($id) {
        global $conn;
        $query = $conn->prepare("select * from flashcards where id_card = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $query->close();
        return $hasil;
    }

    function tampilSekolah($id) {
        global $conn;
        $query = $conn->prepare("SELECT * FROM sekolah WHERE id_sekolah = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_assoc();
        $query->close();
        return $hasil;
    }

    function tampilJawaban($id) {
        global $conn;
        $query = $conn->prepare("SELECT * FROM jawaban_flashcard WHERE id_jawaban = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_assoc();
        $query->close();
        return $hasil;
    }

    function tampilOpsi($id) {
        global $conn;
        $query = $conn->prepare("SELECT * FROM jawaban_flashcard WHERE id_card = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $query->close();
        return $hasil;
    }

    function editSekolah($id, $sekolah) {
        global $conn;
        $query = $conn->prepare("UPDATE sekolah SET nama_sekolah = ? WHERE id_sekolah = ?");
        $query->bind_param("si", $sekolah, $id);
        $query->execute();
        $query->close();
    }

    function editFlashcardDeck($judul, $deskripsi, $id) {
        global $conn;
        $query = $conn->prepare("UPDATE flashcard_deck SET judul = ?, deskripsi = ? WHERE id_deck = ?");
        $query->bind_param("ssi", $judul, $deskripsi, $id);
        $query->execute();
        $query->close();
    }

    function editFlashcards($teks_depan, $teks_belakang, $id) {
        global $conn;
        $query = $conn->prepare("UPDATE flashcards SET teks_depan = ?, teks_belakang = ? WHERE id_card = ?");
        $query->bind_param("ssi", $teks_depan, $teks_belakang, $id);
        $query->execute();
        $query->close();
    }

    function editjawaban($id, $is_correct, $jawaban) {
        global $conn;
        $query = $conn->prepare("UPDATE jawaban_flashcard SET is_correct = ?, jawaban = ? WHERE id_jawaban = ?");
        $query->bind_param("isi", $is_correct, $jawaban, $id);
        $query->execute();
        $query->close();
    }

    function editUser($username, $password) {
        global $conn;
        $id = $_SESSION['id_user'];
        $query = $conn->prepare("UPDATE user SET username = ?, password = ? WHERE id_user = ?");
        $query->bind_param("ssi", $username, $password, $id);
        $query->execute();
        $query->close();
        $conn->close();
    }
    
    // function validateUser($username, $password) {
    //     global $conn;
        
    //     $query = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
    //     $query->bind_param("ss", $username, $password);
    //     $query->execute();
    //     $result = $query->get_result()->fetch_assoc();
    //     $query->close();
        
    //     if (!$result) {
    //         return false;
    //     }
        
    //     if ($result['password'] === $password) {
    //         session_start();
    //         $_SESSION['id_user'] = $result['id_user'];
    //         return true;
    //     }
        
    //     // if (password_verify($password, $result['password'])) {
    //         //     return true;
    //         // }
            
    //     return false;   
    // }   
?>
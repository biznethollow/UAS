<?php
    include "../../koneksi.php";
    include "../authenticator/auth.php";

    $id = htmlspecialchars($_GET['id']);
    $id2 = htmlspecialchars($_GET['id2']); 
    $id3 = htmlspecialchars($_GET['id3']);

    $query = $conn->prepare("DELETE FROM jawaban_flashcard WHERE id_jawaban = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->close();
    header("location: /UAS/mvc/view/flashcards/edit_flashcards.php?id=$id2&id2=$id3");
?>
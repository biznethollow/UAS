<?php
    include "../../koneksi.php";
    include "../authenticator/auth.php";

    $id = htmlspecialchars($_GET['id']);
    $id2 = htmlspecialchars($_GET['id2']); 

    $query = $conn->prepare("DELETE FROM flashcards WHERE id_card = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->close();
    header("location: /UAS/mvc/view/flashcard_deck/edit_flashcard_deck.php?id=$id2");
?>
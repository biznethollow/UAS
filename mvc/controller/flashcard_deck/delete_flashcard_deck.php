<?php
    include "../../koneksi.php";
    include "../authenticator/auth.php";

    $id = htmlspecialchars($_GET['id']);

    $query = $conn->prepare("DELETE FROM flashcard_deck WHERE id_deck = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->close();
    header("location: /UAS/mvc/view/flashcard_deck/flashcard_deck.php");
?>
<?php
require './../../database/databaseConnect.php';
session_start();
if (!isset($_SESSION['mail'])) {
    header('Location: ./../../index.php'); // Redirige vers la page de connexion si non connecté
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commentId = (int)$_POST['id'];

    // Suppression des réactions associées
    $deleteReactions = $conn->prepare("DELETE FROM ReactionComment WHERE id_comment = :id");
    $deleteReactions->bindParam(':id', $commentId);
    $deleteReactions->execute();

    // Suppression du commentaire
    $sql = $conn->prepare("DELETE FROM Comments WHERE id = :id");
    $sql->bindParam(':id', $commentId);

    if ($sql->execute()) {
        echo json_encode(["message" => "Comment deleted successfully"]);
    } else {
        echo json_encode(["message" => "Failed to delete comment"]);
    }
}
?>

<?php
require './../../database/databaseConnect.php';
session_start();
if (!isset($_SESSION['mail'])) {
    header('Location: ./../../index.php'); // Redirige vers la page de connexion si non connecté
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $publicationId = (int)$_GET['publication_id'];
    $sql = $conn->prepare("SELECT Comments.*, Compte.prenom FROM Comments JOIN Compte ON Comments.id_compte = Compte.id WHERE Comments.id_publication = :pub_id ORDER BY Comments.date ASC");
    $sql->bindParam(':pub_id', $publicationId);
    $sql->execute();
    $comments = $sql->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($comments);
}
?>

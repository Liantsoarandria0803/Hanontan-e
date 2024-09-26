<?php
require './../database/databaseConnect.php';
session_start();
if (!isset($_SESSION['mail'])) {
    header('Location: ./../index.php'); // Redirige vers la page de connexion si non connecté
    exit();
}

$sql = $conn->prepare("
    SELECT Publication.*, Compte.prenom 
    FROM Publication
    JOIN Compte ON Publication.id_compte = Compte.id
    ORDER BY date_pub DESC
");
$sql->execute();
$publications = $sql->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($publications);
?>
<?php
require './../database/databaseConnect.php';
session_start();
if (!isset($_SESSION['mail'])) {
    header('Location: ./../index.php'); // Redirige vers la page de connexion si non connecté
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $content = $_POST['content'];

    $sql = $conn->prepare("UPDATE Publication SET  contenu = :content WHERE id = :id");
    $sql->bindParam(':content', $content);
    $sql->bindParam(':id', $id);

    if ($sql->execute()) {
        echo json_encode(["message" => "Publication updated successfully"]);
    } else {
        echo json_encode(["message" => "Failed to update publication"]);
    }
}
?>

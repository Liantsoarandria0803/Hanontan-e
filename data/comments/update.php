<?php
require './../../database/databaseConnect.php';
session_start();
if (!isset($_SESSION['mail'])) 
{
    header('Location: ./../../index.php'); // Redirige vers la page de connexion si non connecté
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commentId = (int)$_POST['id'];
    $newContent = $_POST['content'];

    if (!empty($newContent)) {
        $sql = $conn->prepare("UPDATE Comments SET contenu = :content, date = NOW() WHERE id = :id");
        $sql->bindParam(':content', $newContent);
        $sql->bindParam(':id', $commentId);

        if ($sql->execute()) {
            echo json_encode(["message" => "Comment updated successfully"]);
        } else {
            echo json_encode(["message" => "Failed to update comment"]);
        }
    } else {
        echo json_encode(["message" => "Comment content cannot be empty"]);
    }
}
?>

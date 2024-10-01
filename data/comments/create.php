<?php
require './../../database/databaseConnect.php';
session_start();
if (!isset($_SESSION['mail'])) {
    header('Location: ./../../index.php'); // Redirige vers la page de connexion si non connecté
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $publicationId = (int)$_POST['publication_id'];
    $userId = (int)$_POST['user_id'];
    $commentContent = $_POST['content'];

    if (!empty($commentContent)) {
        $sql = $conn->prepare("INSERT INTO Comments (id_Publication, id_compte, contenu, date) VALUES (:pub_id, :user_id, :content, NOW())");
        $sql->bindParam(':pub_id', $publicationId);
        $sql->bindParam(':user_id', $userId);
        $sql->bindParam(':content', $commentContent);

        if ($sql->execute()) 
        {
            echo json_encode(["message" => "Comment created successfully"]);
        } 
        else 
        {
            echo json_encode(["message" => "Failed to create comment"]);
        }
    } else {
        echo json_encode(["message" => "Comment content cannot be empty"]);
    }
}
?>

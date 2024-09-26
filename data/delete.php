<?php
require './../database/databaseConnect.php';
session_start();
if (!isset($_SESSION['mail'])) {
    header('Location: ./../index.php'); // Redirige vers la page de connexion si non connecté
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $publication_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($publication_id <= 0) {
        echo json_encode(["message" => "Invalid publication ID"]);
        exit;
    }

    // Supprimer les réactions associées à la publication
    $delete_reactions = $conn->prepare("DELETE FROM Reaction WHERE id_publication = :publication_id");
    $delete_reactions->bindParam(':publication_id', $publication_id);
    $delete_reactions->execute();

    // Récupérer tous les commentaires associés à cette publication
    $get_comments = $conn->prepare("SELECT id FROM Comments WHERE id_Publication = :publication_id");
    $get_comments->bindParam(':publication_id', $publication_id);
    $get_comments->execute();
    $comments = $get_comments->fetchAll(PDO::FETCH_ASSOC);

    // Supprimer les réactions associées à chaque commentaire
    $delete_comment_reactions = $conn->prepare("DELETE FROM ReactionComment WHERE id_comment = :comment_id");
    foreach ($comments as $comment) {
        $delete_comment_reactions->bindParam(':comment_id', $comment['id']);
        $delete_comment_reactions->execute();
    }

    // Supprimer les commentaires associés
    $delete_comments = $conn->prepare("DELETE FROM Comments WHERE id_Publication = :publication_id");
    $delete_comments->bindParam(':publication_id', $publication_id);
    $delete_comments->execute();

    // Maintenant, supprimer la publication
    $delete_publication = $conn->prepare("DELETE FROM Publication WHERE id = :publication_id");
    $delete_publication->bindParam(':publication_id', $publication_id);

    if ($delete_publication->execute()) {
        http_response_code(200);
        echo json_encode(["message" => "Publication deleted successfully"]);
    } else {
        http_response_code(400);
        error_log("Database error: " . implode(", ", $delete_publication->errorInfo()));
        echo json_encode(["message" => "Failed to delete publication"]);
    }
}
?>

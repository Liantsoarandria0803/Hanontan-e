<?php
require './../../database/databaseConnect.php';

$comment_id = $_GET['comment_id'];

// Requête pour récupérer le nombre de likes et dislikes, ainsi que les utilisateurs correspondants
$sql = $conn->prepare("
    SELECT 
        SUM(CASE WHEN r.type = 'like' THEN 1 ELSE 0 END) AS likes,
        SUM(CASE WHEN r.type = 'dislike' THEN 1 ELSE 0 END) AS dislikes,
        GROUP_CONCAT(CASE WHEN r.type = 'like' THEN c.prenom END) AS liked_by,
        GROUP_CONCAT(CASE WHEN r.type = 'dislike' THEN c.prenom END) AS disliked_by
    FROM ReactionComment r
    JOIN Compte c ON r.id_compte = c.id
    WHERE r.id_comment = :comment_id
");

$sql->bindParam(':comment_id', $comment_id);
$sql->execute();
$reactions = $sql->fetch(PDO::FETCH_OBJ);

// Préparation de la réponse
$response = [
    'likes' => (int)$reactions->likes,
    'dislikes' => (int)$reactions->dislikes,
    'liked_by' => array_filter(explode(',', $reactions->liked_by)), // Convertir en tableau et filtrer les valeurs vides
    'disliked_by' => array_filter(explode(',', $reactions->disliked_by)) // Convertir en tableau et filtrer les valeurs vides
];

echo json_encode($response);
?>

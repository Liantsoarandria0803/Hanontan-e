<?php
require './../../database/databaseConnect.php';

$id_comment = $_POST['comment_id'];
$id_compte = $_POST['user_id'];
$type = $_POST['type'];

// Check if the user already reacted
$sql = $conn->prepare("SELECT * FROM ReactionComment WHERE id_comment = :id_comment AND id_compte = :id_compte");
$sql->bindParam(':id_comment', $id_comment);
$sql->bindParam(':id_compte', $id_compte);
$sql->execute();
$existingReaction = $sql->fetch(PDO::FETCH_OBJ);

if ($existingReaction) {
    // Update reaction if it already exists
    $sql = $conn->prepare("UPDATE ReactionComment SET type = :type WHERE id = :id");
    $sql->bindParam(':type', $type);
    $sql->bindParam(':id', $existingReaction->id);
} else {
    // Insert new reaction
    $sql = $conn->prepare("INSERT INTO ReactionComment (id_comment, id_compte, type, date) VALUES (:id_comment,:id_compte, :type, NOW())");
    $sql->bindParam(':id_comment', $id_comment);
    $sql->bindParam(':id_compte', $id_compte);
    $sql->bindParam(':type', $type);
}

if ($sql->execute()) {
    echo json_encode(['message' => 'Reaction saved successfully']);
} else {
    echo json_encode(['message' => 'Failed to save reaction']);
}
?>

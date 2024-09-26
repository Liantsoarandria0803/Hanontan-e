<?php
require './../../database/databaseConnect.php';

$id_publication = $_POST['id_publication'];
$id_compte = $_POST['id_compte'];
$type = $_POST['type'];

// Check if the user already reacted
$sql = $conn->prepare("SELECT * FROM Reaction WHERE id_publication = :id_publication AND id_compte = :id_compte");
$sql->bindParam(':id_publication', $id_publication);
$sql->bindParam(':id_compte', $id_compte);
$sql->execute();
$existingReaction = $sql->fetch(PDO::FETCH_OBJ);

if ($existingReaction) {
    // Update reaction if it already exists
    $sql = $conn->prepare("UPDATE Reaction SET type = :type WHERE id = :id");
    $sql->bindParam(':type', $type);
    $sql->bindParam(':id', $existingReaction->id);
} else {
    // Insert new reaction
    $sql = $conn->prepare("INSERT INTO Reaction (id_publication, id_compte, type, date) VALUES (:id_publication, :id_compte, :type, NOW())");
    $sql->bindParam(':id_publication', $id_publication);
    $sql->bindParam(':id_compte', $id_compte);
    $sql->bindParam(':type', $type);
}

if ($sql->execute()) {
    echo json_encode(['message' => 'Reaction saved successfully']);
} else {
    echo json_encode(['message' => 'Failed to save reaction']);
}
?>

<?php
// Configurations de la base de données
$host = 'localhost';  // Adresse du serveur de base de données
$dbname = 'SocialMedia'; // Nom de la base de données
$username = 'liantsoa'; // Nom d'utilisateur
$password = 'liantsoa08'; // Mot de passe

// Créer une connexion à la base de données
try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $conn = new PDO($dsn, $username, $password);

    // Définir le mode d'erreur de PDO sur les exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Afficher un message d'erreur si la connexion échoue
    echo "Échec de la connexion : " . $e->getMessage();
}
?>

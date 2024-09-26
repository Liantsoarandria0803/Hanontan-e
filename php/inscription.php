<?php
session_start();

$servername = "localhost";
$username = "liantsoa";
$password = "liantsoa08"; // mot de passe admin
$database = "SocialMedia"; // nom de la base de données
$table = "Compte"; // nom de la table

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $passwd = $_POST['passwd'];

        // Prepare SQL statement to insert data into the Compte table
        $sql = $conn->prepare("INSERT INTO $table (nom, prenom, email, passwd) VALUES (:nom, :prenom, :email, :passwd)");
        $sql->bindParam(':nom', $nom, PDO::PARAM_STR);
        $sql->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->bindParam(':passwd', $passwd, PDO::PARAM_STR);
        $sql->execute();

        // Getting user ID after registration
        $requete = $conn->prepare("SELECT * FROM $table WHERE BINARY email=:email AND BINARY passwd=:passwd");
        $requete->bindParam(':email', $email, PDO::PARAM_STR);
        $requete->bindParam(':passwd', $passwd, PDO::PARAM_STR);
        $requete->execute();
        $resultats = $requete->fetchAll(PDO::FETCH_OBJ);

        if (!empty($resultats)) {
            $objectInfo = $resultats[0];
            $userId = $objectInfo->id;
            $retour['userName'] = $nom;
            $retour['userId'] = $userId;
            $_SESSION['mail'] = $email;

            // Save the user name into a JSON file
            $fp = fopen('./../data/user.json', 'w');
            fwrite($fp, json_encode($retour));
            fclose($fp);

            header("Location: ./../app/application.php");
            exit; // Ensure no further script execution
        }
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSCRIPTION</title>
    <link rel="stylesheet" href="./../front/inscription.css">
</head>
<body>
    <form action="" method="post">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" required>
        
        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        
        <label for="passwd">Mot de passe:</label>
        <input type="password" name="passwd" required>
        
        <button type="submit">ENREGISTRER</button>
    </form>
</body>
</html>

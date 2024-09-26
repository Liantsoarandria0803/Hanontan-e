<?php
session_start();
require './../database/databaseConnect.php'; // Assure-toi que $conn est un objet PDO

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $to = $_POST['mail'];

    // Vérifier si l'e-mail existe dans la base de données en utilisant une requête préparée
    $requete = $conn->prepare("SELECT * FROM Compte WHERE email = :email");
    $requete->bindParam(':email', $to, PDO::PARAM_STR);
    $requete->execute();
    $resultats = $requete->fetchAll(PDO::FETCH_OBJ);

    if (count($resultats) > 0) {  // Vérifie si l'e-mail existe
        // L'e-mail est trouvé dans la base de données
        $key = rand(100, 99999); // Générer un code aléatoire
        $_SESSION['code'] = $key; // Stocker le code dans la session
        $_SESSION['mail'] = $to; // Stocker l'e-mail dans la session

        // Détails de l'e-mail
        $subject = "CODE UNIV m-ELAMINA";
        $message = "Bonjour, votre code est : " . $key . " merci";
        $headers = "From: Admin@univ.com";

        // Envoi de l'e-mail
        if (mail($to, $subject, $message, $headers)) {
            echo "Email envoyé avec succès";
            header("Location: ./confirmeCode.php");
            exit();  // Assure-toi que le script s'arrête après redirection
        } else {
            echo "L'envoi de l'email a échoué";
            header("Location: ./../index.php");
            exit();
        }
    } else {
        // L'e-mail n'est pas trouvé dans la base de données
        echo "<p style='color:red;'>Compte non trouvé</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de saisie d'e-mail</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            text-align: center;
        }

        h3 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="email"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        p {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Saisissez votre email</h3>
        <form action="" method="post">
            <input type="email" name="mail" placeholder="Entrez votre email" required>
            <button type="submit">Envoyer un code</button>
        </form>
    </div>
</body>
</html>

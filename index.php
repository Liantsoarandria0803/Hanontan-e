<?php
session_start();
$servername = "localhost";
$username = "liantsoa";
$password = "liantsoa08"; // mot de passe anle admin ana admnin
$database = "SocialMedia"; // nom de la base de donnée
$table = "Compte"; // nom de la table

// se connecter avec mysql avec pdo
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database",$username,$password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $mail = $_POST['mail'];
        $passwd = $_POST['password'];

        // detecter si ce login est dans le database 
        $sql = "SELECT * FROM $table WHERE BINARY email='$mail' AND BINARY passwd='$passwd'";
        $result = $conn->query($sql);

        $requete = $conn->prepare("SELECT * FROM $table WHERE BINARY email='$mail' AND BINARY passwd='$passwd'");
        $requete->execute();
        $resultats = $requete->fetchAll(PDO::FETCH_OBJ);

        if (!empty($resultats)) {
            $objectINfo = $resultats[0];
            $userId = $objectINfo->id;
            echo $userId;

            if ($result->rowCount() > 0) {
                $retour['mail'] = $mail;
                $retour['userId'] = $userId;
                $_SESSION['mail'] = $mail;

                // save the user name in to a json file
                $fp = fopen('./data/user.json', 'w');
                fwrite($fp, json_encode($retour));
                fclose($fp);

                header("Location: ./app/application.php");
            }
        } else {
            // Handle login failure
            header("Location: ./index.php");
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
    <title>Tsy ay</title>
    <link rel="stylesheet" href="./front/login.css">
    <script src="./front/log.js"></script>
</head>
<body>
    <div class="container">
        <section class="login-section">
            <div class="login-form">
                <h3 class="title">Se connecter à HANONTAN-e</h3>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="mail">Email :</label>
                        <input type="email" name="mail" placeholder="Adresse e-mail" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <div class="password-wrapper">
                            <input id="pass" type="password" name="password" placeholder="Mot de passe" required>
                            <img id="eye" src="./img/eye.svg" alt="Afficher/Masquer le mot de passe" onclick="togglePasswordVisibility()">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-login">Se connecter</button>
                </form>
            </div>
        </section>

        <div class="signup">
            Vous n'avez pas de compte ? 
            <button><a href="./php/inscription.php">Inscrivez-vous</a></button>
        </div>
        
        <div class="forgot-password">
            <a href="./passForget/keySend.php">Mot de passe oublié ?</a>
        </div>
    </div>

    <script src="./front/passCache.js"></script>
</body>
</html>

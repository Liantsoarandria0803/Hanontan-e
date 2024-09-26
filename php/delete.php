<?php
    session_start();
    if(isset($_SESSION['userName'])){
      $servername = "localhost";
      $username = "liantsoa";
      $password = "liantsoa08"; // mot de passe anle admin ana admnin
      $database = "ChatApp"; // nom de la base de donnée
      $table = "message"; // nom de la table
      // se connecter avec mysql avec pdo
      try {
          $conn = new PDO("mysql:host=$servername;dbname=$database",$username,$password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          // echo "Connected successfully";
          $requete=$conn->prepare("DELETE  FROM $table");
          $requete->execute();
          header('Location:./../app/messageGroupe.php');
          
      }
      catch(PDOException $e) {
          // echo "Connection failed: " . $e->getMessage();
      }
  }
    else{
      header('Location: ./../index.php');
    }
?>
<?php
  if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST'){

    $code = $_POST['code'] ?? "";
    $nom = $_POST['nom'] ?? "";

    if(empty($errors)) {
      require_once 'db_Connect.php';

      $statement = $pdo -> prepare("INSERT INTO filiere (codeFiliere, nomFiliere) VALUES (:codeFiliere, :nomFiliere)");
      $statement->bindValue(':codeFiliere', $code);
      $statement->bindValue(':nomFiliere', $nom);
      $statement->execute();
    }
    header("Location: filiere.php");

  }
 ?>

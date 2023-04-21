<!DOCTYPE html>
<?php
  require_once 'db_Connect.php';
  require_once 'header.php';
  require_once 'nav.php';
  require_once 'variables.php';

  if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";*/

    $codeEnseignant = $_POST['codeEnseignant'];
    $nomEnseignant = $_POST['nomEnseignant'];
    $prenomEnseignant = $_POST['prenomEnseignant'];
    $adresseEnseignant = $_POST['adresseEnseignant'];

    if(empty($codeEnseignant)){
      $errorCodeEnseignant = "<div class='alert alert-danger message' role='alert'>
        Code Enseignant invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($nomEnseignant)){
      $errorNomEnseignant = "<div class='alert alert-danger message' role='alert'>
        Nom Enseignant invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($prenomEnseignant)){
      $errorPrenomEnseignant = "<div class='alert alert-danger message' role='alert'>
        Prenom Enseignant invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($adresseEnseignant)){
      $errorAdresseEnseignant = "<div class='alert alert-danger message' role='alert'>
        Adresse Enseignant invalid!
      </div>";
      $errorCheck = true;
    }

    if(!$errorCheck){
      $statement = $pdo->prepare('SELECT * FROM enseignant WHERE codeEnseignant = :codeEnseignant');
      $statement->bindValue(':codeEnseignant', $codeEnseignant);
      $statement->execute();
      $check = $statement->fetchAll(PDO::FETCH_ASSOC);

      if(!empty($check)){
        $errorCodeUnique = "<div class='alert alert-warning' role='alert'>
          <strong>Code Enseignant - </strong>".$codeEnseignant." existe deja!
        </div>";
      }else{
        $statement = $pdo -> prepare("INSERT INTO enseignant (codeEnseignant, nomEnseignant, prenomEnseignant, adresseEnseignant) VALUES (:codeEnseignant, :nomEnseignant, :prenomEnseignant, :adresseEnseignant)");
        $statement->bindValue(':codeEnseignant', $codeEnseignant);
        $statement->bindValue(':nomEnseignant', $nomEnseignant);
        $statement->bindValue(':prenomEnseignant', $prenomEnseignant);
        $statement->bindValue(':adresseEnseignant', $adresseEnseignant);
        $statement->execute();

        $done = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
          <strong>Enseignant ajouter!</strong>
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

      }
    }
  }
  $statement = $pdo->prepare('SELECT * FROM enseignant');
  $statement->execute();
  $enseignant = $statement->fetchAll(PDO::FETCH_ASSOC);
 ?>
<html lang="en" dir="ltr">
  <body>
    <?php if(!empty($enseignant)){
      echo "<div class='filiere-block'>";
      foreach ($enseignant as $key => $enseignant) {
        echo "<div class='filiere-content'>";
        echo "<h1>".$enseignant['codeEnseignant']."</h1>";
        echo "<p><strong>Nom</strong> : ".$enseignant['nomEnseignant']." ".$enseignant['prenomEnseignant']."</p>";
        echo "<p><strong>Adresse</strong> : ".$enseignant['adresseEnseignant']."</p>";
        echo "</div>";
      }
    } echo "</div>"; ?>
    <form class="form" method="post">
      <h2>ENSEIGNANT</h2>
      <?php if(!empty($errorCodeUnique)){
        echo $errorCodeUnique;
      } ?>

      <?php if(!empty($errorCodeEnseignant)){
        echo $errorCodeEnseignant;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Enseignant</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeEnseignant" value="<?php echo $codeEnseignant; ?>">
      </div>

      <?php if(!empty($errorNomEnseignant)){
        echo $errorNomEnseignant;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Nom Enseignant</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="nomEnseignant" value="<?php echo $nomEnseignant; ?>">
      </div>

      <?php if(!empty($errorPrenomEnseignant)){
        echo $errorPrenomEnseignant;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Prenom Enseignant</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="prenomEnseignant" value="<?php echo $prenomEnseignant; ?>">
      </div>

      <?php if(!empty($errorAdresseEnseignant)){
        echo $errorAdresseEnseignant;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Adresse Enseignant</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="adresseEnseignant" value="<?php echo $adresseEnseignant; ?>">
      </div>

      <?php if(!empty($done)){
        echo $done;
      } ?>

      <button type="submit" class="btn btn-primary" name="submit">Confimer</button>
    </form>
    <script src="message.js" charset="utf-8"></script>
  </body>
</html>

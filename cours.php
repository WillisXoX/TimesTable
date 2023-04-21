<!DOCTYPE html>
<?php
  require_once 'db_Connect.php';
  require_once 'header.php';
  require_once 'nav.php';
  require_once 'variables.php';

  /*echo "<pre>";
  print_r($_POST);
  echo "</pre>";*/
  if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
    $codeFiliere = $_POST['codeFiliere'];
    $codeNiveau = $_POST['codeNiveau'];
    $codeCours = $_POST['codeCours'];
    $nomCours = $_POST['nomCours'];

    if(empty($codeFiliere)){
      $errorCodeFiliere = "<div class='alert alert-danger message' role='alert'>
        Code Filiere invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($codeNiveau)){
      $errorCodeNiveau = "<div class='alert alert-danger message' role='alert'>
        Code Niveau invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($codeCours)){
      $errorCodeCours = "<div class='alert alert-danger message' role='alert'>
        Code Cours invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($nomCours)){
      $errorNomCours = "<div class='alert alert-danger message' role='alert'>
        Nom Cours invalid!
      </div>";
      $errorCheck = true;
    }

    if(!$errorCheck){
      $statement = $pdo->prepare('SELECT * FROM cours WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau AND codeCours = :codeCours');
      $statement->bindValue(':codeFiliere', $codeFiliere);
      $statement->bindValue(':codeNiveau', $codeNiveau);
      $statement->bindValue(':codeCours', $codeCours);
      $statement->execute();
      $check = $statement->fetchAll(PDO::FETCH_ASSOC);

      if(!empty($check)){
        $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
          Code Cours - ".$codeCours."<strong> existe deja pour Code Niveau - </strong> ".$codeNiveau." dans <strong>Code Filiere - </strong> ".$codeFiliere."!
        </div>";
      }else{

        $statement = $pdo -> prepare("INSERT INTO cours (codeFiliere, codeNiveau, codeCours, nomCours) VALUES (:codeFiliere, :codeNiveau, :codeCours, :nomCours)");
        $statement->bindValue(':codeFiliere', $codeFiliere);
        $statement->bindValue(':codeNiveau', $codeNiveau);
        $statement->bindValue(':codeCours', $codeCours);
        $statement->bindValue(':nomCours', $nomCours);
        $statement->execute();

        $done = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
          <strong>Cours ajouter!</strong>
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
      }
    }

  }

 ?>
<html lang="en" dir="ltr">
  <body>
    <form class="form" method="post">
      <h2>COURS</h2>
      <?php if(!empty($errorCodeUnique)){
        echo $errorCodeUnique;
      } ?>

      <?php if(!empty($errorCodeFiliere)){
        echo $errorCodeFiliere;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Filiere</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeFiliere" value="<?php echo $codeFiliere ?>">
      </div>

      <?php if(!empty($errorCodeNiveau)){
        echo $errorCodeNiveau;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Niveau</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeNiveau" value="<?php echo $codeNiveau ?>">
      </div>

      <?php if(!empty($errorCodeCours)){
        echo $errorCodeCours;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Cours</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeCours" value="<?php echo $codeCours ?>">
      </div>

      <?php if(!empty($errorNomCours)){
        echo $errorNomCours;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Nom Cours</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="nomCours" value="<?php echo $nomCours ?>">
      </div>

      <?php if(!empty($done)){
        echo $done;
      } ?>

      <button type="submit" class="btn btn-primary" name="submit">Confimer</button>
      <script src="message.js" charset="utf-8"></script>
    </form>
  </body>
</html>

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

    $codeFiliere = $_POST['codeFiliere'];
    $codeNiveau = $_POST['codeNiveau'];

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
    if(!$errorCheck){
      $statement = $pdo->prepare('SELECT * FROM niveau WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau');
      $statement->bindValue(':codeFiliere', $codeFiliere);
      $statement->bindValue(':codeNiveau', $codeNiveau);
      $statement->execute();
      $check = $statement->fetch(PDO::FETCH_ASSOC);

      if($check['specialite']){
        $specialite = 1;
      }else{
        $specialite = 0;
      }

      if(!$check){
        $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
          Code Niveau -</strong> ".$codeNiveau." n'existe pas dans <strong>Code Filiere -</strong> ".$codeFiliere."!
        </div>";
        $errorCheck = true;
      }else{
        header("Location: ajouterPlage.php?codeFiliere=".$codeFiliere."&codeNiveau=".$codeNiveau."&specialite=".$specialite);
      }
    }

  }
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="form" method="post">
      <h2>PLAGE</h2>
      <?php if(!empty($errorCodeUnique)){
        echo $errorCodeUnique;
      } ?>

      <?php if(!empty($errorCodeFiliere)){
        echo $errorCodeFiliere;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Filiere</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeFiliere" value="<?php echo $codeFiliere; ?>">
      </div>

      <?php if(!empty($errorCodeNiveau)){
        echo $errorCodeNiveau;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Niveau</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeNiveau" value="<?php echo $codeNiveau ?>">
      </div>
      <?php if(!empty($done)){
        echo $done;
      } ?>
      <button type="submit" class="btn btn-primary" name="submit">Confimer</button>
    </form>
  </body>
</html>

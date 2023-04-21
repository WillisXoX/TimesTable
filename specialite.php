<!DOCTYPE html>
<?php
  require_once 'db_Connect.php';
  require_once 'header.php';
  require_once 'nav.php';
  require_once 'variables.php';

  if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
  /*  echo "<pre>";
    print_r($_POST);
    echo "</pre>";*/

    $codeFiliere = $_POST['codeFiliere'];
    $codeNiveau = $_POST['codeNiveau'];
    $codeSpecialite = $_POST['codeSpecialite'];
    $nomSpecialite = $_POST['nomSpecialite'];
    $effectif = $_POST['effectif'];

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
    if(empty($codeSpecialite)){
      $errorCodeSpecialite = "<div class='alert alert-danger message' role='alert'>
        Code Specialite invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($nomSpecialite)){
      $errorNomSpecialite = "<div class='alert alert-danger message' role='alert'>
        Nom Specialite invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($effectif)){
      $errorEffectif = "<div class='alert alert-danger message' role='alert'>
        Effectif invalid!
      </div>";
      $errorCheck = true;
    }

    if(!$errorCheck){
      echo "done";
      $statement = $pdo->prepare('SELECT * FROM specialite WHERE codeSpecialite = :codeSpecialite');
      $statement->bindValue(':codeSpecialite', $codeSpecialite);
      $statement->execute();
      $check = $statement->fetchAll(PDO::FETCH_ASSOC);

      if(!empty($check)){
        $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
          Code Specialite -</strong> existe deja!
        </div>";
      }else{
        $statement = $pdo->prepare('SELECT * FROM niveau WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau');
        $statement->bindValue(':codeFiliere', $codeFiliere);
        $statement->bindValue(':codeNiveau', $codeNiveau);
        $statement->execute();
        $check = $statement->fetch(PDO::FETCH_ASSOC);

        if(empty($check)){
          $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
            Code Niveau - </strong> ".$codeNiveau." n'existe deja dans <strong>Code Filiere -</strong> ".$codeFiliere."!
          </div>";
        }else{
          if($check['specialite'] == 0){
            $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
              Code Niveau -</strong>".$codeNiveau." n'est un niveau de specialite!
            </div>";
          }else{
            if($check['effectif'] < $effectif){
              $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
                Effectif - </strong>".$effectif." superieur a effectif du niveau!
              </div>";
            }else{
              $statement = $pdo -> prepare("INSERT INTO specialite (codeFiliere, codeNiveau, codeSpecialite, nomSpecialite, effectif) VALUES (:codeFiliere, :codeNiveau, :codeSpecialite, :nomSpecialite, :effectif)");
              $statement->bindValue(':codeFiliere', $codeFiliere);

              $statement->bindValue(':codeNiveau', $codeNiveau);
              $statement->bindValue(':codeSpecialite', $codeSpecialite);
              $statement->bindValue(':nomSpecialite', $nomSpecialite);
              $statement->bindValue(':effectif', $effectif);
              $statement->execute();

              $done = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Specialite ajouter!</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
            }
          }

        }
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
      <h2>SPECIALITE</h2>
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

      <?php if(!empty($errorCodeSpecialite)){
        echo $errorCodeSpecialite;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Specialite</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeSpecialite" value="<?php echo $codeSpecialite; ?>">
      </div>

      <?php if(!empty($errorNomSpecialite)){
        echo $errorNomSpecialite;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Nom Specialite</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="nomSpecialite" value="<?php echo $nomSpecialite ?>">
      </div>
      <?php if(!empty($errorEffectif)){
        echo $errorEffectif;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Effectif</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="effectif" value="<?php echo $effectif ?>">
      </div>
      <?php if(!empty($done)){
        echo $done;
      } ?>
      <button type="submit" class="btn btn-primary" name="submit">Confimer</button>
    </form>

  </body>
</html>

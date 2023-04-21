<!DOCTYPE html>
  <?php
    require_once 'db_Connect.php';
    require_once 'header.php';
    require_once 'nav.php';
    require_once 'variables.php';

    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
      $codeFiliere = $_POST['codeFiliere'];
      $codeNiveau = $_POST['codeNiveau'];
      $nomNiveau = $_POST['nomNiveau'];
      $effectif = $_POST['effectif'];
      $specialite = $_POST['specialite'] ?? '';

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
      if(empty($nomNiveau)){
        $errorNomNiveau = "<div class='alert alert-danger message' role='alert'>
          Nom Niveau invalid!
        </div>";
        $errorCheck = true;
      }
      if(empty($effectif)){
        $errorEffectif = "<div class='alert alert-danger message' role='alert'>
          Effectif invalid!
        </div>";
        $errorCheck = true;
      }
      if(empty($specialite)){
        $errorSpecialite = "<div class='alert alert-danger message' role='alert'>
          Effectif invalid!
        </div>";
        $errorCheck = true;
      }

      if(!$errorCheck){
        $statement = $pdo->prepare('SELECT * FROM filiere WHERE codeFiliere = :codeFiliere');
        $statement->bindValue(':codeFiliere', $codeFiliere);
        $statement->execute();
        $check = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(empty($check)){
          $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>Code Filiere - </strong> ".$codeFiliere." existe deja pas!
          </div>";
          $errorCheck = true;
        }
      }

      if(!$errorCheck){
        $statement = $pdo->prepare('SELECT * FROM niveau WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau');
        $statement->bindValue(':codeFiliere', $codeFiliere);
        $statement->bindValue(':codeNiveau', $codeNiveau);
        $statement->execute();
        $check = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($check)){
          $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
            Code Niveau -</strong> ".$codeNiveau." existe deja dans <strong>Code Filiere -</strong> ".$codeFiliere."!
          </div>";
        }else{
          if($specialite == 'oui'){
            $boolval = true;
          }else{
            $boolval = false;
          }

          $statement = $pdo -> prepare("INSERT INTO niveau (codeFiliere, codeNiveau, nomNiveau, effectif, specialite) VALUES (:codeFiliere, :codeNiveau, :nomNiveau, :effectif, :specialite)");
          $statement->bindValue(':codeFiliere', $codeFiliere);
          $statement->bindValue(':codeNiveau', $codeNiveau);
          $statement->bindValue(':nomNiveau', $nomNiveau);
          $statement->bindValue(':nomNiveau', $nomNiveau);
          $statement->bindValue(':effectif', $effectif);
          $statement->bindValue(':specialite', $boolval);
          $statement->execute();

          $done = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>Niveau ajouter!</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";

        }
      }

    }
   ?>
  <html lang="en" dir="ltr">
  <body>
    <form class="form" method="post">
      <h2>NIVEAU</h2>
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

      <?php if(!empty($errorNomNiveau)){
        echo $errorNomNiveau;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Nom Niveau</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="nomNiveau" value="<?php echo $nomNiveau ?>">
      </div>

      <?php if(!empty($errorEffectif)){
        echo $errorEffectif;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Effectif</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="effectif" value="<?php echo $effectif ?>">
      </div>

      <?php if(!empty($errorSpecialite)){
        echo $errorSpecialite;
      } ?>
      <div class="input-group mb-3">
        <label for="specialite">Est-ce un niveau de specialite ?</label>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="specialite" id="inlineRadio1" value="oui">
          <label class="form-check-label" for="inlineRadio1">Oui</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="specialite" id="inlineRadio2" value="non">
          <label class="form-check-label" for="inlineRadio2">Non</label>
        </div>
      </div>

      <?php if(!empty($done)){
        echo $done;
      } ?>

      <button type="submit" class="btn btn-primary" name="submit">Confimer</button>
    </form>
    <script src="message.js" charset="utf-8"></script>
  </body>
</html>

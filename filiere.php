<!DOCTYPE html>
  <?php
    require_once 'db_Connect.php';
    require_once 'header.php';
    require_once 'nav.php';
    require_once 'variables.php';

    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST'){

      $codeFiliere = $_POST['codeFiliere'];
      $nomFiliere = $_POST['nomFiliere'];

      if(empty($codeFiliere)){
        $errorCodeFiliere = "<div class='alert alert-danger message' role='alert'>
          Code Filiere invalid!
        </div>";
        $errorCheck = true;
      }
      if(empty($nomFiliere)){
        $errorNomFiliere = "<div class='alert alert-danger message' role='alert'>
          Nom Filiere invalid!
        </div>";
        $errorCheck = true;
      }

      if(!$errorCheck){
        $statement = $pdo->prepare('SELECT * FROM filiere WHERE codeFiliere = :codeFiliere');
        $statement->bindValue(':codeFiliere', $codeFiliere);
        $statement->execute();
        $check = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($check)){
          $errorCodeUnique = "<div class='alert alert-warning' role='alert'>
            <strong>Code Filiere</strong> existe deja!
          </div>";
        }else{
          $statement = $pdo -> prepare("INSERT INTO filiere (codeFiliere, nomFiliere) VALUES (:codeFiliere, :nomFiliere)");
          $statement->bindValue(':codeFiliere', $codeFiliere);
          $statement->bindValue(':nomFiliere', $nomFiliere);
          $statement->execute();

          $done = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>Filiere ajouter!</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";

        }
      }
    }

    $statement = $pdo->prepare('SELECT * FROM filiere');
    $statement->execute();
    $filiere = $statement->fetchAll(PDO::FETCH_ASSOC);
   ?>
  <html lang="en" dir="ltr">
  <body>
      <?php if(!empty($filiere)){
        echo "<div class='filiere-block'>";
        foreach ($filiere as $key => $filiere) {
          echo "<div class='filiere-content'>";
          echo "<h1>".$filiere['codeFiliere']."</h1>";
          echo "<p><strong>Nom Filiere</strong> : ".$filiere['nomFiliere']."</p>";
          echo "</div>";
        }
      }
      echo "</div>";?>
    </div>

    <form class="form" method="post">
      <h2>FILIERE</h2>
      <?php if(!empty($errorCodeUnique)){
        echo $errorCodeUnique;
      } ?>

      <?php if(!empty($errorCodeFiliere)){
        echo $errorCodeFiliere;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Filiere</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeFiliere" value="<?php echo $codeFiliere; ?>">
      </div>

      <?php if(!empty($errorNomFiliere)){
        echo $errorNomFiliere;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Nom Filiere</span>
        <input type="text" class="form-control nom" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="nomFiliere" value="<?php echo $nomFiliere; ?>">
      </div>

      <?php if(!empty($done)){
        echo $done;
      } ?>

      <button type="submit" class="btn btn-primary" name="submit">Confimer</button>
    </form>
    <script src="message.js" charset="utf-8"></script>
  </body>
</html>

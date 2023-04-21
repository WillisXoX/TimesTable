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

    $codeSalle = $_POST['codeSalle'];
    $salleCapacite = $_POST['salleCapacite'];

    if(empty($codeSalle)){
      $errorCodeSalle = "<div class='alert alert-danger message' role='alert'>
        Code Salle invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($salleCapacite)){
      $errorSalleCapacite = "<div class='alert alert-danger message' role='alert'>
        Capacite Salle invalid!
      </div>";
      $errorCheck = true;
    }

    if(!$errorCheck){
      $statement = $pdo->prepare('SELECT * FROM salle WHERE codeSalle = :codeSalle');
      $statement->bindValue(':codeSalle', $codeSalle);
      $statement->execute();
      $check = $statement->fetchAll(PDO::FETCH_ASSOC);

      if(!empty($check)){
        $errorCodeUnique = "<div class='alert alert-warning' role='alert'>
          <strong>Code Salle - </strong>".$codeSalle." existe deja!
        </div>";
      }else{
        $statement = $pdo -> prepare("INSERT INTO salle (codeSalle, capacite) VALUES (:codeSalle, :salleCapacite)");
        $statement->bindValue(':codeSalle', $codeSalle);
        $statement->bindValue(':salleCapacite', $salleCapacite);
        $statement->execute();

        $done = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
          <strong>Salle ajouter!</strong>
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

      }
    }
  }
  $statement = $pdo->prepare('SELECT * FROM salle');
  $statement->execute();
  $salle = $statement->fetchAll(PDO::FETCH_ASSOC);
 ?>
<html lang="en" dir="ltr">
  <body>
    <?php if(!empty($salle)){
      echo "<div class='filiere-block'>";
      foreach ($salle as $key => $salle) {
        echo "<div class='filiere-content'>";
        echo "<h1>".$salle['codeSalle']."</h1>";
        echo "<p><strong>Capacite</strong> : ".$salle['capacite']." places</p>";
        echo "</div>";
      }
    }
    echo "</div>";?>
    <form class="form" method="post">
      <h2>SALLE</h2>
      <?php if(!empty($errorCodeUnique)){
        echo $errorCodeUnique;
      } ?>

      <?php if(!empty($errorCodeSalle)){
        echo $errorCodeSalle;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Salle</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeSalle" value="<?php echo $codeSalle; ?>">
      </div>

      <?php if(!empty($errorSalleCapacite)){
        echo $errorSalleCapacite;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Capacite</span>
        <input type="text" class="form-control nom" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="salleCapacite" value="<?php echo $salleCapacite; ?>">
      </div>

      <?php if(!empty($done)){
        echo $done;
      } ?>

      <button type="submit" class="btn btn-primary" name="submit">Confimer</button>
    </form>
    <script src="message.js" charset="utf-8"></script>
  </body>
</html>

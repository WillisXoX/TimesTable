<!DOCTYPE html>
<?php
  require_once 'db_Connect.php';
  require_once 'header.php';
  require_once 'nav.php';
  require_once 'variables.php';

  $specialiteCheck = false;

  if(isset($_GET)){
    if(isset($_GET['codeFiliere']) && isset($_GET['codeNiveau']) && isset($_GET['specialite'])){

      $codeFiliere = $_GET['codeFiliere'];
      $codeNiveau = $_GET['codeNiveau'];
      $specialite = $_GET['specialite'];

      if($specialite == 1){
        $specialiteCheck = true;
      }
    }

  }

  if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST'){

    $codeFiliere = $_POST['codeFiliere'];
    $codeNiveau = $_POST['codeNiveau'];
    if($specialiteCheck){
      $codeSpecialite = $_POST['codeSpecialite'];
    }

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
    if($specialiteCheck){
      if(empty($codeSpecialite)){
        $errorCodeSpecialite = "<div class='alert alert-danger message' role='alert'>
          Code Specialite invalid!
        </div>";
        $errorCheck = true;
      }
    }

    if(!$errorCheck && $specialiteCheck){
      $statement = $pdo->prepare('SELECT * FROM specialite WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau AND codeSpecialite = :codeSpecialite');
      $statement->bindValue(':codeFiliere', $codeFiliere);
      $statement->bindValue(':codeNiveau', $codeNiveau);
      $statement->bindValue(':codeSpecialite', $codeSpecialite);
      $statement->execute();
      $check = $statement->fetch(PDO::FETCH_ASSOC);

      if(!$check){
        $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
          Code Specialite - </strong> ".$codeSpecialite." n'existe pas dans <strong>
            Code Niveau - </strong> ".$codeNiveau." de <strong>Code Filiere - </strong> ".$codeFiliere."!
          </div>";
      }
    }

    if(!$errorCheck && !$specialiteCheck){
      $statement = $pdo->prepare('SELECT * FROM niveau WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau');
      $statement->bindValue(':codeFiliere', $codeFiliere);
      $statement->bindValue(':codeNiveau', $codeNiveau);
      $statement->execute();
      $check = $statement->fetch(PDO::FETCH_ASSOC);

      if(!$check){
        $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
            Code Niveau - </strong> ".$codeNiveau." n'existe pas dans <strong>Code Filiere - </strong> ".$codeFiliere."!
          </div>";
      }
    }
  }
 ?>
<html lang="en" dir="ltr">
  <body>
    <form class="form" id='noPrint' method="post">
      <h2>Emploi de Temps</h2>
      <?php if(!empty($errorCodeUnique)){
        echo $errorCodeUnique;
      } ?>

      <?php if(!empty($errorCodeFiliere)){
        echo $errorCodeFiliere;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Filiere</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeFiliere" value="<?php echo $codeFiliere; ?>"readonly>
      </div>

      <?php if(!empty($errorCodeNiveau)){
        echo $errorCodeNiveau;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Niveau</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeNiveau" value="<?php echo $codeNiveau ?>"readonly>
      </div>

      <?php if($specialiteCheck){
        if(!empty($errorCodeSpecialite)){
          echo $errorCodeSpecialite;
        }
        echo "<div class='input-group mb-3'>";
        echo "<span class='input-group-text' id='inputGroup-sizing-default'>Code Specialite</span>";
        echo "<input type='text' class='form-control code' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default' name='codeSpecialite' value=".$codeSpecialite.">";
        echo "</div>";
        }
      ?>

      <button type="submit" class="btn btn-primary" name="submit">Confimer</button>
    </form>

      <?php
        if(!empty($check)){
          echo "<button type='button' onclick='window.print();' id='noPrint' class='btn btn-danger'>Imprimer</button>";
          $days = ["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"];
          echo "<div class='block'>";
          for ($i=0; $i < sizeof($days); $i++) {
            if($specialiteCheck){
              $statement = $pdo->prepare("SELECT * FROM plage WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau AND codeSpecialite = :codeSpecialite AND jour = :jour  ORDER BY heureDebut");
              $statement->bindValue(':codeFiliere', $codeFiliere);
              $statement->bindValue(':codeNiveau', $codeNiveau);
              $statement->bindValue(':codeSpecialite', $codeSpecialite);
              $statement->bindValue(':jour', $days[$i]);
              $statement->execute();
              $product = $statement->fetchALL(PDO::FETCH_ASSOC);
            }else{
              $statement = $pdo->prepare("SELECT * FROM plage WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau AND jour = :jour  ORDER BY heureDebut");
              $statement->bindValue(':codeFiliere', $codeFiliere);
              $statement->bindValue(':codeNiveau', $codeNiveau);
              $statement->bindValue(':jour', $days[$i]);
              $statement->execute();
              $product = $statement->fetchALL(PDO::FETCH_ASSOC);
            }

            echo "<table class='table table-striped'>";
            echo "<tr>";
            echo "<th scope='col'>".$days[($i)]."</th>";
            echo "</tr>";
            if($product != null){
            foreach ($product as $key => $product){
              $statement = $pdo->prepare("SELECT * FROM cours WHERE codeCours = :codeCours");
              $statement->bindValue(':codeCours', $product['codeCours']);
              $statement->execute();
              $cours = $statement->fetch(PDO::FETCH_ASSOC);

              $statement = $pdo->prepare("SELECT * FROM enseignant WHERE codeEnseignant = :codeEnseignant");
              $statement->bindValue(':codeEnseignant', $product['codeEnseignant']);
              $statement->execute();
              $enseignant = $statement->fetch(PDO::FETCH_ASSOC);

              echo "<tr>";
                echo "<td>";
                	echo "<ul>";
                    echo "<li><strong>".$product['heureDebut']." - ".$product['heureFin']."</strong></li>";
                    echo "<li>".$product['codeCours']."</li>";
                    echo "<li><strong>".$cours['nomCours']."</strong></li>";
                    echo "<li>".$product['codeSalle']."</li>";
                    echo "<li><strong>".$enseignant['nomEnseignant']." ".$enseignant['prenomEnseignant']."</strong></li>";
                    if($product['nomGroupe'] != null){
                      echo "<li>".$product['nomGroupe']."</li>";
                    }
                	echo "</ul>";
                echo "</td>";
              echo "</tr>";
            }
            echo "</table>";
          }
        }
          echo "</div>";
        }
       ?>

      <?php if(!empty($done)){
        echo $done;
      } ?>
      <script type="text/javascript">

        document.getElementsByClassName('block')[0].scrollIntoView();
        function printDiv() {
         var printContents = document.getElementsByClassName('block')[0].innerHTML;
         var originalContents = document.body.innerHTML;

         document.body.innerHTML = printContents;

         window.print();

         document.body.innerHTML = originalContents;
        }

      </script>
  </body>
</html>

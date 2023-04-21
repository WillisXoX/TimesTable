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
    $codeSalle = $_POST['codeSalle'];
    $codeCours = $_POST['codeCours'];
    $codeEnseignant = $_POST['codeEnseignant'];
    $jour = $_POST['jour'];
    $heureDebut = $_POST['heureDebut'];
    $heureFin = $_POST['heureFin'];
    $nomGroupe = $_POST['nomGroupe'];

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

    if(empty($codeSalle)){
      $errorCodeSalle = "<div class='alert alert-danger message' role='alert'>
        Code Salle invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($heureDebut)){
      $errorHeureDebut = "<div class='alert alert-danger message' role='alert'>
        Heure Debut invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($heureFin)){
      $errorHeureFin = "<div class='alert alert-danger message' role='alert'>
        Heure Fin invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($codeCours)){
      $errorCodeCours = "<div class='alert alert-danger message' role='alert'>
        Code Cours invalid!
      </div>";
      $errorCheck = true;
    }
    if(empty($codeEnseignant)){
      $errorCodeEnseignant = "<div class='alert alert-danger message' role='alert'>
        Code Enseignant invalid!
      </div>";
      $errorCheck = true;
    }
    if(isset($_POST['answer'])){
      $checkGroupe = $_POST['answer'];
      if($checkGroupe == 'yes' && empty($nomGroupe)){
        $errorCheck = true;
      }else{
        $nomGroupe = null;
      }
    }else{
      $errorCheckGroupe = "<div class='alert alert-danger message' role='alert'>
        Selection invalid!
      </div>";
      $errorCheck = true;
    }

    //With Specialite
    if(!$errorCheck && $specialiteCheck){
      $statement = $pdo->prepare('SELECT * FROM niveau WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau');
      $statement->bindValue(':codeFiliere', $codeFiliere);
      $statement->bindValue(':codeNiveau', $codeNiveau);
      $statement->execute();
      $check = $statement->fetchAll(PDO::FETCH_ASSOC);

      if(!$check){
        $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
          Code Niveau - </strong> ".$codeNiveau." n'existe pas dans <strong>Code Filiere -</strong> ".$codeFiliere."!
        </div>";
      }else{
        $statement = $pdo->prepare('SELECT * FROM enseignant WHERE codeEnseignant = :codeEnseignant');
        $statement->bindValue(':codeEnseignant', $codeEnseignant);
        $statement->execute();
        $check = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(!$check){
          $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
            Code Enseignant - </strong> ".$codeEnseignant." n'existe pas!</div>";
        }else{
          $statement = $pdo->prepare('SELECT * FROM cours WHERE codeCours = :codeCours AND codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau');
          $statement->bindValue(':codeFiliere', $codeFiliere);
          $statement->bindValue(':codeNiveau', $codeNiveau);
          $statement->bindValue(':codeCours', $codeCours);
          $statement->execute();
          $check = $statement->fetchAll(PDO::FETCH_ASSOC);

          if(!$check){
            $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
              Code Cours - </strong> ".$codeCours." n'existe pas dans <strong>Code Filiere - </strong> ".$codeFiliere." de <strong>Code Niveau - </strong>".$codeNiveau."!
            </div>";
          }else{
            $statement = $pdo->prepare('SELECT * FROM salle WHERE codeSalle = :codeSalle');
            $statement->bindValue(':codeSalle', $codeSalle);
            $statement->execute();
            $check = $statement->fetch(PDO::FETCH_ASSOC);

            if(!$check){
              $errorCodeUnique= "<div class='alert alert-warning' role='alert'><strong>
                Code Salle - </strong> ".$codeSalle." n'existe pas!</div>";
            }else{
                  $statement = $pdo->prepare('SELECT * FROM specialite WHERE codeSpecialite = :codeSpecialite');
                  $statement->bindValue(':codeSpecialite', $codeSpecialite);
                  $statement->execute();
                  $check = $statement->fetchALL(PDO::FETCH_ASSOC);

                  if(!$check){
                    $errorCodeUnique= "<div class='alert alert-warning' role='alert'><strong>
                      Code Specialite - </strong> ".$codeSpecialite." n'existe pas!</div>";
                  }else{
                  $statement = $pdo->prepare('SELECT * FROM specialite WHERE codeSpecialite = :codeSpecialite');
                  $statement->bindValue(':codeSpecialite', $codeSpecialite);
                  $statement->execute();
                  $check = $statement->fetch(PDO::FETCH_ASSOC);


                  $statement = $pdo->prepare('SELECT * FROM salle WHERE codeSalle = :codeSalle');
                  $statement->bindValue(':codeSalle', $codeSalle);
                  $statement->execute();
                  $check1 = $statement->fetch(PDO::FETCH_ASSOC);

                  if($check['effectif'] > $check1['capacite']){
                    $errorCodeUnique = "<div class='alert alert-warning' role='alert'>Effectif <strong>
                    Code Specialite - </strong>".$codeSpecialite." superieur a <strong>
                        Code Salle - </strong>".$codeSalle." effectif du niveau!
                    </div>";
                  }else{
                    $statement = $pdo->prepare('SELECT * FROM plage WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau AND codeSpecialite = :codeSpecialite AND jour = :jour AND codeSalle = :codeSalle AND heureDebut BETWEEN :heureDebut AND :heureFin OR  codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau AND codeSpecialite = :codeSpecialite AND jour = :jour AND codeSalle = :codeSalle AND heureFin BETWEEN :heureDebut AND :heureFin');

                    $statement->bindValue(':codeFiliere', $codeFiliere);
                    $statement->bindValue(':codeNiveau', $codeNiveau);
                    $statement->bindValue(':codeSpecialite', $codeSpecialite);
                    $statement->bindValue(':codeSalle', $codeSalle);
                    $statement->bindValue(':jour', $jour);
                    $statement->bindValue(':heureDebut', $heureDebut);
                    $statement->bindValue(':heureFin', $heureFin);
                    $statement->execute();
                    $check = $statement->fetchAll(PDO::FETCH_ASSOC);

                    if(!empty($check)){
                      $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>Cette horraire est deja occupe!</strong>
                      </div>";
                    }else{
                      $statement = $pdo -> prepare("INSERT INTO plage (codeFiliere, codeNiveau, codeSpecialite, codeSalle, jour, heureDebut, heureFin, codeCours, codeEnseignant, nomGroupe) VALUES (:codeFiliere, :codeNiveau, :codeSpecialite, :codeSalle, :jour, :heureDebut, :heureFin, :codeCours, :codeEnseignant, :nomGroupe)");
                      $statement->bindValue(':codeFiliere', $codeFiliere);
                      $statement->bindValue(':codeNiveau', $codeNiveau);
                      $statement->bindValue(':codeSpecialite', $codeSpecialite);
                      $statement->bindValue(':codeSalle', $codeSalle);
                      $statement->bindValue(':codeCours', $codeCours);
                      $statement->bindValue(':codeEnseignant', $codeEnseignant);
                      $statement->bindValue(':jour', $jour);
                      $statement->bindValue(':heureDebut', $heureDebut);
                      $statement->bindValue(':heureFin', $heureFin);
                      $statement->bindValue(':nomGroupe', $nomGroupe);
                      $statement->execute();


                      $done = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Plage ajouter!</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                    }
                  }
                }
              }
            }
          }
        }
      }


  //Without Specialite
    if(!$errorCheck && !$specialiteCheck){
      $statement = $pdo->prepare('SELECT * FROM niveau WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau');
      $statement->bindValue(':codeFiliere', $codeFiliere);
      $statement->bindValue(':codeNiveau', $codeNiveau);
      $statement->execute();
      $check = $statement->fetchAll(PDO::FETCH_ASSOC);

      if(!$check){
        $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
          Code Niveau - </strong> ".$codeNiveau." n'existe pas dans <strong>Code Filiere -</strong> ".$codeFiliere."!
        </div>";
      }else{
        $statement = $pdo->prepare('SELECT * FROM enseignant WHERE codeEnseignant = :codeEnseignant');
        $statement->bindValue(':codeEnseignant', $codeEnseignant);
        $statement->execute();
        $check = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(!$check){
          $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
            Code Enseignant - </strong> ".$codeEnseignant." n'existe pas!</div>";
        }else{
          $statement = $pdo->prepare('SELECT * FROM cours WHERE codeCours = :codeCours AND codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau');
          $statement->bindValue(':codeFiliere', $codeFiliere);
          $statement->bindValue(':codeNiveau', $codeNiveau);
          $statement->bindValue(':codeCours', $codeCours);
          $statement->execute();
          $check = $statement->fetchAll(PDO::FETCH_ASSOC);

          if(!$check){
            $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
              Code Cours - </strong> ".$codeCours." n'existe pas dans <strong>Code Filiere - </strong> ".$codeFiliere." de <strong>Code Niveau - </strong>".$codeNiveau."!
            </div>";
          }else{
            $statement = $pdo->prepare('SELECT * FROM salle WHERE codeSalle = :codeSalle');
            $statement->bindValue(':codeSalle', $codeSalle);
            $statement->execute();
            $check = $statement->fetch(PDO::FETCH_ASSOC);

            if(!$check){
              $errorCodeUnique= "<div class='alert alert-warning' role='alert'><strong>
                Code Salle - </strong> ".$codeSalle." n'existe pas!</div>";
            }else{
                $statement = $pdo->prepare('SELECT * FROM niveau WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau');
                $statement->bindValue(':codeFiliere', $codeFiliere);
                $statement->bindValue(':codeNiveau', $codeNiveau);
                $statement->execute();
                $check1 = $statement->fetch(PDO::FETCH_ASSOC);

                if($check['capacite'] < $check1['effectif']) {
                  $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>
                    Code Salle - </strong> ".$codeSalle." capacite insuffisant!</div>";
                }else{
                    $codeSpecialite = null;

                    $statement = $pdo->prepare('SELECT * FROM plage WHERE codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau AND codeSpecialite = :codeSpecialite AND jour = :jour AND codeSalle = :codeSalle AND heureDebut BETWEEN :heureDebut AND :heureFin OR  codeFiliere = :codeFiliere AND codeNiveau = :codeNiveau AND codeSpecialite = :codeSpecialite AND jour = :jour AND codeSalle = :codeSalle AND heureFin BETWEEN :heureDebut AND :heureFin');

                    $statement->bindValue(':codeFiliere', $codeFiliere);
                    $statement->bindValue(':codeNiveau', $codeNiveau);
                    $statement->bindValue(':codeSpecialite', $codeSpecialite);
                    $statement->bindValue(':codeSalle', $codeSalle);
                    $statement->bindValue(':jour', $jour);
                    $statement->bindValue(':heureDebut', $heureDebut);
                    $statement->bindValue(':heureFin', $heureFin);
                    $statement->execute();
                    $check = $statement->fetchAll(PDO::FETCH_ASSOC);

                    if(!empty($check)){
                      $errorCodeUnique = "<div class='alert alert-warning' role='alert'><strong>Cette horraire est deja occupe!</strong>
                      </div>";
                    }else{
                      /*echo "<pre>";
                      print_r($_GET);
                      echo "</pre>";*/
                      $statement = $pdo -> prepare("INSERT INTO plage (codeFiliere, codeNiveau, codeSpecialite, codeSalle, jour, heureDebut, heureFin, codeCours, codeEnseignant, nomGroupe) VALUES (:codeFiliere, :codeNiveau, :codeSpecialite, :codeSalle, :jour, :heureDebut, :heureFin, :codeCours, :codeEnseignant, :nomGroupe)");
                      $statement->bindValue(':codeFiliere', $codeFiliere);
                      $statement->bindValue(':codeNiveau', $codeNiveau);
                      $statement->bindValue(':codeSpecialite', $codeSpecialite);
                      $statement->bindValue(':codeSalle', $codeSalle);
                      $statement->bindValue(':codeCours', $codeCours);
                      $statement->bindValue(':codeEnseignant', $codeEnseignant);
                      $statement->bindValue(':jour', $jour);
                      $statement->bindValue(':heureDebut', $heureDebut);
                      $statement->bindValue(':heureFin', $heureFin);
                      $statement->bindValue(':nomGroupe', $nomGroupe);
                      $statement->execute();


                      $done = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Plage ajouter!</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                    }
                  }
                }
              }
            }
          }
        }
      }

 ?>
<html lang="en" dir="ltr">
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
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeFiliere" value="<?php echo $codeFiliere; ?>"readonly>
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

      <?php if(!empty($errorCodeSalle)){
        echo $errorCodeSalle;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Salle</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeSalle" value="<?php echo $codeSalle ?>">
      </div>

      <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupSelect01">Jour</label>
        <select class="form-select" id="inputGroupSelect01" name="jour">
          <option value="Lundi" selected>Lundi</option>
          <option value="Mardi">Mardi</option>
          <option value="Mercredi">Mercredi</option>
          <option value="Jeudi">Jeudi</option>
          <option value="Vendredi">Vendredi</option>
          <option value="Samedi">Samedi</option>
        </select>
      </div>

      <?php if(!empty($errorHeureDebut)){
        echo $errorHeureDebut;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Heure Debut</span>
        <input type="time" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="heureDebut">
      </div>

      <?php if(!empty($errorHeureFin)){
        echo $errorHeureFin;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Heure Fin</span>
        <input type="time" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="heureFin">
      </div>

      <?php if(!empty($errorCodeCours)){
        echo $errorCodeCours;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Cours</span>
        <input type="text" class="form-control code" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeCours" value="<?php echo $codeCours ?>">
      </div>

      <?php if(!empty($errorCodeEnseignant)){
        echo $errorCodeEnseignant;
      } ?>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Code Enseignant</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="codeEnseignant" value="<?php echo $codeEnseignant; ?>">
      </div>

      <?php if(!empty($errorCheckGroupe)){
        echo $errorCheckGroupe;
      } ?>
      <h6>Ajouter nom de groupe ?</h6>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="answer" value="yes" id="yes">
        <label class="form-check-label" for="yes">Oui</label>
        <br>
        <input class="form-check-input" type="radio" name="answer" value="no" id="no">
          <label class="form-check-label" for="no">Non</label>
      </div>
      <?php if(!empty($errorNomGroupe)){
        echo $errorNomGroupe;
      } ?>
      <div class="car-block active">
        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default">Nom Groupe</span>
          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="nomGroupe" value="<?php echo $nomGroupe; ?>">
        </div>
      </div>

      <?php if(!empty($done)){
        echo $done;
      } ?>

      <button type="submit" class="btn btn-primary" name="submit">Confimer</button>
    </form>
      <script src="message.js" charset="utf-8"></script>
      <script type="text/javascript">
      const carBlock = document.getElementsByClassName('car-block');
      const current = document.getElementsByClassName('car-block active');
      const ansYes = document.getElementById('yes');
      const ansNo = document.getElementById('no');

      ansYes.addEventListener("change", function() {
        current[0].className = current[0].className.replace(" active", "");
      });
      ansNo.addEventListener("change", function() {
        carBlock[0].className += " active";
      });
      </script>

  </body>
</html>

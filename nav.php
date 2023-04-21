<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php require_once 'header.php'; ?>
  <header>
    <link rel="stylesheet" href="style.css">
  </header>
  <body>
    <nav id='noPrint'>
      <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="filiere.php">Filiere</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="niveau.php">Niveau</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="salle.php">Salle</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cours.php">Cours</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="enseignant.php">Enseignant</a>
        </li>
        <!-- Example split danger button -->
      </ul>
    </nav>
    <script type="text/javascript">
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
    return new bootstrap.Dropdown(dropdownToggleEl);
    });
    </script>
  </body>
</html>

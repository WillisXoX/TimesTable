<?php
  $pdo = new PDO('mysql:host=localhost;port=3306;dbname=test1;', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 ?>

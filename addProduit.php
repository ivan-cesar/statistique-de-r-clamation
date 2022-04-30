<?php
  session_start();
  require 'inc/functions.php';
  require 'inc/db.php';
  logged_only();
  if (!empty($_POST)) {
      $errors = array();
      if (empty($_POST['libelle'])) {
        $errors['description'] = "Entrez un produit";
      }      

      if (empty($errors)) {
        $req = $pdo->prepare("INSERT INTO produits SET libelle = ?");
        $req->execute(array($_POST['libelle']));
        $_SESSION['flash']['success'] = 'Votre produit a bien été enregistré';
        header('Location:index.php');
        exit();
      }
  }

?>
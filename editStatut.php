<?php
  session_start();
  require 'inc/db.php';
  require 'inc/functions.php';
   
  if(!empty($_SESSION['support']->id ))
    {
      $statut_id = $_SESSION['support']->id ; 
    }
    if(null == $statut_id)
    {
         header('Location: index.php');
    }
  if(!empty($_POST))
  {
      $req = $pdo->prepare('SELECT * FROM support WHERE id = ?');
      $req->execute(array($statut_id));
      $statut= $req->fetch();
   
      if ($statut) {
          $pdo->prepare('UPDATE support SET statut = ? WHERE id = ?')->execute(array($_POST['statut'],$statut_id));
          $_SESSION['flash']['success'] = 'Le statut a été ajouter';
          header('Location: index.php');
      }else{
          $_SESSION['flash']['danger'] = "EEEERRRRRRROOOOOORRRRRR";
        header('Location: login.php');

      }
    }

?>
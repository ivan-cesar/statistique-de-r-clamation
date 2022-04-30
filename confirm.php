<?php
require 'inc/db.php';
  $user_id = $_GET['id'];
  $token = $_GET['token'];

  $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
  $req->execute(array($user_id));
  $user= $req->fetch();
  session_start();

  if ($user && $user->confirmation_token == $token) {
      $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute(array($user_id));
      $_SESSION['flash']['success'] = 'Votre compte à bien été validé';
      $_SESSION['auth'] = $user;
      header('Location: index.php');
  }else{
      $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header('Location: login.php');

  }





?>
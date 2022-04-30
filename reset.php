<?php
 session_start();
/*if (session_start() == PHP_SESSION_NONE) {
   
}*/
  require 'inc/functions.php';
  if (isset($_GET['id']) && isset($_GET['email'])) {
      require 'inc/db.php';
      $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
      $req->execute(array($_GET['id'],$_GET['token']));
      $user = $req->fetch();
      if($user){
          if (!empty($_POST)) {
              if (!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']) {
                  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                  $pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL')->execute(array($password));
                  $_SESSION['flash']['success'] = 'Votre mot de passe a bien été modifié';
                  $_SESSION['auth'] = $user;
                  header('Location:login.php');
                  exit();
              }
          }
      }else {
          
          $_SESSION['flash']['danger'] = "Ce token n'est pas valide";
          header('Location:login.php');
          exit();

      }
  }else {
      header('Location:login.php');
      exit();
  }
?>


<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Forgot Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2"> Réinitialiser mot de passe </h1>
                                        <p class="mb-4">On comprend, il se passe des choses. Entrez simplement votre adresse e-mail ci-dessous
                                            et nous vous enverrons un lien pour réinitialiser votre mot de passe !</p>
                                    </div>
                                    <form action="" method="POST" class="user">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Mot de passe">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_confirm" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Confirmation du mot de passe">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Réinitialiser mon mot de passe
                                       </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Créer un compte!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Vous avez déjà un compte? Connexion!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
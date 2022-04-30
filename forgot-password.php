<?php
 session_start();
/*if (session_start() == PHP_SESSION_NONE) {
   
}*/
  require 'inc/functions.php';
  if (!empty($_POST) && !empty($_POST['email'])) {
      require 'inc/db.php';
      $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
      $req->execute(array('email' => $_POST['email']));
      $user = $req->fetch();
      if($user){
          $reset_token = str_random(60);
          $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW()  WHERE id = ?')->execute(array($reset_token,$user->id));
          $_SESSION['flash']['success'] = 'Les instructions du rappel de mot de passe vous ont été envoyées par emails';
          mail($_POST['email'],'Réinitiatilisation de votre mot de passe',"Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://localhost/propulse/reset.php?id={$user->id}&token=$reset_token");
          header('Location:login.php');
          exit();
      }else {
          $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cet adresse';
      }
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
                                        <h1 class="h4 text-gray-900 mb-2">Mot de passe oublié?</h1>
                                        <p class="mb-4">On comprend, il se passe des choses. Entrez simplement votre adresse e-mail ci-dessous
                                            et nous vous enverrons un lien pour réinitialiser votre mot de passe !</p>
                                    </div>
                                    <form action="" method="POST" class="user">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Entrer l'adresse e-mail...">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Réinitialiser le mot de passe
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
 <!-- Footer -->
 <footer class="sticky-footer ">
     <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span class="text-white">Copyright &copy; 2022 Design by  <a class="text-warning" href="https://propulsegroup.com">Propulse Group</a></span>
        </div>
    </div>
 </footer>
<!-- End of Footer -->
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
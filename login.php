<?php
 session_start();
/*if (session_start() == PHP_SESSION_NONE) {
   
}*/
  require 'inc/functions.php';
  require 'inc/db.php';
   reconnect_cookie();
   if (isset($_SESSION['auth'])) {
       header('Location:index.php');
       exit();
   }
  if (!empty($_POST) && !empty($_POST['username'] && !empty($_POST['password']))) {
      $req = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL');
      $req->execute(array('username' => $_POST['username']));
      $user = $req->fetch();
      if(password_verify($_POST['password'],$user->password)){
          $_SESSION['auth'] = $user;
          $_SESSION['flash']['success'] = 'vous êtes bien maintenant connecté';
          if ($_POST['remember']) {
            $remember_token = str_random(250);
              $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute(array($remember_token,$user->id));
              setcookie('remember',$user->id. '==' .$remember_token . sha1($user->id . 'reclamationlonancipropulse'), time() + 60 * 60 * 24 * 7);
          }
          header('Location:index.php');
          exit();
      }else {
          $_SESSION['flash']['danger'] = 'Idenfiant ou mot de passe incorrecte';
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

    <title>Lonaci - Connexion</title>

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
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Connexion!</h1>
                                    </div>
                                    <?php if (isset($_SESSION['flash'])):?>
                                        <?php foreach($_SESSION['flash'] as $type => $message):?>
                                            <div class="alert alert-<?=$type;?>">
                                               <?= $message;?>
                                            </div>
                                        <?php endforeach;?>
                                        <?php unset($_SESSION['flash']);?>
                                    <?php endif;?>
                                    <form action="" method="POST" class="user">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Entrer e-mail ou le mot de passe">
        
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Mot de passe">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name="remember" class="custom-control-input" id="customCheck" value="1">
                                                <label class="custom-control-label" for="customCheck">Se souvenir
                                                    de moi</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Connexion
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.php">Mot de passe oublié?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Créer un compte!</a>
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
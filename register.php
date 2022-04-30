
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lonaci - S'inscrire</title>

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
    <?php
    session_start();
 require 'inc/functions.php';
 require_once 'inc/db.php';
  if (!empty($_POST)) {
      $errors = array();
      if (empty($_POST['username']) || !preg_match('/^[a-z0-9_]+$/',$_POST['username'])) {
          $errors['username'] = "Votre nom d'utilisateur n'est pas valide (alphanumérique)";
      }else {
          $req = $pdo->prepare('SELECT id FROM users WHERE username = ?');
          $req->execute(array($_POST['username']));
          $user = $req->fetch();
          if($user){
              $errors['username'] = "Ce nom d'utilisateur est déjà pris";
          }
      }
      if (empty($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
          $errors['email'] = "Votre email n'est pas valide";
      }else {
        $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $req->execute(array($_POST['email']));
        $user = $req->fetch();
        if($user){
            $errors['username'] = "Cet email est déjà pris";
        }
     }
      if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
          $errors['password'] = "Vous devez rentrer un mot de passe valide";
      }
      if (empty($errors)) {
        $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?,type = ?");
        $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
        $token = str_random(60);
        $req->execute(array($_POST['username'],$password,$_POST['email'],$token,'user'));
        $user_id = $pdo->lastInsertId();
        mail($_POST['email'],'Confirmation de votre compte',"Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/propulse/confirm.php?id=$user_id&token=$token");
        $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
        header('Location:login.php');
        exit();
      }
   }

?>

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Créer un compte!</h1>
                            </div>
                            <?php if (!empty($errors)):?>
                             <div class="alert alert-danger">
                                 <p>Vous n'avez pas rempli le formulaire correctement</p>
                                 <?php foreach($errors as $error):?>
                                    <ul>
                                        <li><?= $error; ?></li>
                                    </ul>
                                 <?php endforeach;?>
                             </div>
                            
                            <?php endif;?>
                            <form action="" method="POST" class="user">
                                <div class="form-group ">
                                        <input type="text" name="username" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Nom d'utilisateur">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Adresse e-mail">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Mot de passe">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirm" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Répéter le mot de passe">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Créer un compte
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.php">Mot de passe oublié?</a>
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
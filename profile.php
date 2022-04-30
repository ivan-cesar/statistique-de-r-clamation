<?php
session_start();
    require 'inc/db.php';
    require 'inc/functions.php';
    logged_only();
  if (!empty($_POST)) {
      if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
          $_SESSION['flash']['danger'] = "Les mots de passes ne correspondent pas ";
      }else {
          $user_id = $_SESSION['auth']->id;
          $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
          $pdo->prepare('UPDATE users SET password = ?')->execute(array($password));
          $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
      }
  }
?>
 <?php if (isset($_SESSION['flash'])):?>
        <?php foreach($_SESSION['flash'] as $type => $message):?>
            <div class="alert alert-<?=$type;?>">
                <?= $message;?>
            </div>
        <?php endforeach;?>
        <?php unset($_SESSION['flash']);?>
<?php endif;?>
<form action="" method="post">
    <div class="form-group">
        <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Changer de mot de passe">
    </div>
    <div class="form-group">
        <input type="password" name="password_confirm" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Confirmation du mot de passe">
    </div>
    <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Changer mon mot de passe
                                        </button>
</form>
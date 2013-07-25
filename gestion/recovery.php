<?php

namespace lib;
use lib\content\Message;
use lib\users\UserAdmin;
use lib\users\RecoverPassword;

error_reporting(E_ERROR);

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();
//error_reporting (0);

session_name('fsc_gestion');
session_start();

require '../config/config.php';

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
	header('Location: '. _GESTION_ .'/');
	exit;
}
elseif (isset($_SESSION['to_ban']) && $_SESSION['to_ban'] > 3) {
  $_SESSION['msg'] = new Message('Trop de tentatives de récupération de mot de passe ont été tentées sans succès. Merci de réessayer plus tard.', -1, 'Oups... !');
  header ('Location: '. _GESTION_ .'/login.php');
  exit();
}
// demande envoie
elseif (isset($_POST['user']) && $_POST['user'] != NULL) {
  // si user est bien dans la BDD, on lui envoie le mail
  if (UserAdmin::isUser(htmlspecialchars($_POST['user']))) {
    unset($_SESSION['to_ban']);
    $u = new UserAdmin(UserAdmin::getID(htmlspecialchars($_POST['user'])));
    try {
      RecoverPassword::insert($u->id(), $u->login(), 1);
      $content = '
      <form class="form-signin">
        <h2 class="form-signin-heading">Envoyé</h2>
        <p>Un email contenant un lien pour réinitialiser votre mot de passe a bien été envoyé à <code>'. $u->login() .'</code>.</p>
        <p>Vérifier vos emails :)</p>
      </form> 
      ';
    }
    // s'il a déja fait une demande, il doit attendre pour en faire une autre
    catch (\Exception $e) {
      $content = '
      <form class="form-signin">
        <h3 class="text-error">Oups... !</h3>
        <p>'. $e->getMessage() .'</p>
      </form> 
      ';
    }
  }
  // sinon c'est peut être un hack
  else {
    $_SESSION['msg'] = new Message('Cet utilisateur est inconnu.', -1, 'Oups... !');
    $_SESSION['to_ban'] = (isset($_SESSION['to_ban']) ? $_SESSION['to_ban']+1 : 1);
    header ('Location: /recovery.php');
    exit();
  }
}
// accept token
elseif (isset($_GET['token']) && $_GET['token'] != NULL && isset($_GET['user']) && $_GET['user'] != NULL) {
  if (RecoverPassword::accept(htmlspecialchars($_GET['token']), UserAdmin::getID(htmlspecialchars($_GET['user'])))) {
    if (isset($_POST['new-password']) && $_POST['new-password'] != NULL && isset($_POST['confirm-new-password']) && $_POST['confirm-new-password'] != NULL) {
      $u = new UserAdmin(UserAdmin::getID(htmlspecialchars($_GET['user'])));
      try {
        if ($_POST['new-password'] != $_POST['confirm-new-password'])
          throw new \Exception('Les mots de passes ne correspondent pas.');
        if (! $u->setPassword($_POST['new-password'], 8))
          throw new \Exception('Votre mot de passe n’est pas valide. Il doit comporter au minimum 8 caractères.');

        $u->update();
        RecoverPassword::remove(UserAdmin::getID(htmlspecialchars($_GET['user'])));


        $_SESSION['msg'] = new Message('Votre mot de passe a bien été réinitialisé. Vous pouvez maintenant vous connecter :)', 1, 'Réinitialisation réussie !');
        header ('Location: '. _GESTION_ .'/login.php');
        exit(); 
      }
      catch (\Exception $e) {
        $_SESSION['msg'] = new Message($e->getMessage(), -1, 'Oups... !');
        header ('Location: '. _GESTION_ .'/recovery.php?token='. htmlspecialchars($_GET['token']) .'&user='. urlencode(htmlspecialchars($_GET['user'])));
        exit(); 
      }
    }
    else {
      $content = '
      <form class="form-signin form" action="recovery.php?user='. urlencode(htmlspecialchars($_GET['user'])) .'&amp;token='. htmlspecialchars($_GET['token']) .'" method="post">
          <h2 class="form-signin-heading">Réinitialisation</h2>
          <p class="alert alert-info"><strong>Note :</strong> votre nouveau mot de passe doit comporter au moins 8 caractères !</p>
          <div class="control-group">
            <label class="control-label">Compte</label>
            <div class="controls">
              <input type="text" disabled="disabled" value="'. htmlspecialchars($_GET['user']) .'" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="new-password">Nouveau mot de passe</label>
            <div class="controls">
              <input type="password" id="new-password" name="new-password" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="confirm-new-password">Confirmation</label>
            <div class="controls">
              <input type="password" id="confirm-new-password" name="confirm-new-password" />
            </div>
          </div>
            <input type="submit" class="btn btn-primary btn-large" value="Réinitialiser" />

      </form> 
      ';
    }
  }
  else {
    $_SESSION['msg'] = new Message('Autorisation de réinitialisation de votre mot de passe invalide ou expirée.', -1, 'Oups... !');
    $_SESSION['to_ban'] = (isset($_SESSION['to_ban']) ? $_SESSION['to_ban']+1 : 1);
    header ('Location: /login.php');
    exit(); 
  }
}

?><!DOCTYPE html>
<html lang="fr">
	<head>
    <meta charset="UTF-8" />
    <title>Récupération de mot de passe &ndash; Gestion &ndash; FSC Bezannes</title>
    <meta name="author" content="Nicolas Devenet" />
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOARCHIVE" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo _STATIC_; ?>/img/favicon/round_diago_16.ico" />
    <link rel="icon"          type="image/png"    href="<?php echo _STATIC_; ?>/img/favicon/round_diago_32.png" />
    <link rel="apple-touch-icon" href="<?php echo _STATIC_; ?>/img/logo/fsc-128x128.png" />
    <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/bootstrap.min.css" media="screen" />
    <link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/bootstrap-responsive.css" />
		<style type="text/css">
			body {
        background-color: #f5f5f5;
      }
			.alert {
				max-width: 300px;
        margin: 0 auto 20px;
			}
      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 20px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
			.form-signin .btn {
				margin-top: 10px;
			}
			label {
				font-size: 16px;
			}
			</style>
	</head>

	<body>
		
		<header class="container">
			<div class="page-header">
				<h1 style="text-align: center;"><a href="<?php echo _GESTION_; ?>">Gestion &mdash; FSC Bezannes</a></h1>
			</div>
		</header>
		
		<!-- container -->
		<div class="container">
			
			<?php
				if (isset($_SESSION['msg'])) {
					echo $_SESSION['msg'];
					unset($_SESSION['msg']);
				}

        if (isset($content))
          echo $content;
        else { ?>

      <form class="form-signin" action="recovery.php" method="post">
        <h2 class="form-signin-heading">Récupération</h2>
        <p>Merci d’indiquer votre nom d’utilisateur. Un email contenant un lien pour réinitialiser votre mot de passe vous sera envoyé.</p>
        
        <!--<label for="user">Utilisateur</label>-->
        <input type="text" class="input-block-level" placeholder="Utilisateur" name="user" id="user" autofocus/>

        <button class="btn btn-large btn-primary btn-block" type="submit">Envoyer</button>
      </form> 

      <?php }
			?>
			
		</div>
		<!-- /container -->
		
		<script src="<?php echo _JQUERY_; ?>"></script>
		<script src="<?php echo _STATIC_; ?>/js/bootstrap.min.js"></script>
		<?php
			echo (_ANALYTICS_GESTION_ ? "
			<script>
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', 'UA-37435384-2']);
				_gaq.push(['_trackPageview']);
			
				(function() {
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();
			</script>": NULL);
		?>
	</body>
</html>
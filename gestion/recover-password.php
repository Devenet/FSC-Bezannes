<?php

namespace lib;
use lib\content\Message;
use lib\users\UserAdmin;
use lib\users\RecoverPassword;

error_reporting(E_ERROR);

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();

session_start();

require '../config/config.php';

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
	header('Location: /');
	exit;
}
elseif (isset($_SESSION['to_ban']) && $_SESSION['to_ban'] > 3) {
  $_SESSION['msg'] = new Message('Trop de tentatives de récupération de mot de passe ont été tentées sans succès. Merci de réessayer plus tard.', -1, 'Oups... !');
  header ('Location: /login.php');
  exit();
}
// demande envoie
elseif (isset($_POST['user']) && $_POST['user'] != null) {
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
    header ('Location: /recover-password.php');
    exit();
  }
}
// accept token
elseif (isset($_GET['token']) && $_GET['token'] != null && isset($_GET['user']) && $_GET['user'] != null) {
  if (false) {
    $content = "ok new passwords here";
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
		<meta charset="UTF-8">
		<title>Récupération de mot de passe &ndash; Gestion &ndash; FSC Bezannes</title>
		<meta name="author" content="FSC Bezannes" />
		<link rel="canonical" href="/" />
		<meta name="robots" content="NOINDEX, NOFOLLOW, NOARCHIVE" />
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.png" />
		<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<link href="<?php echo _FSC_; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen" />
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
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="<?php echo _FSC_; ?>/css/bootstrap-responsive.css" rel="stylesheet" />
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

      <form class="form-signin" action="recover-password.php" method="post">
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
		<script src="<?php echo _FSC_; ?>/js/bootstrap.min.js"></script>
		<?php
			echo (_ANALYTICS_GESTION_ ? "
			<script type=\"text/javascript\">
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', 'UA-37435384-2']);
				_gaq.push(['_trackPageview']);
			
				(function() {
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();
			</script>": null);
		?>
	</body>
</html>
<?php

namespace lib;
use lib\content\Message;
use lib\users\UserAdmin;

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();

session_start();

require '../config/config.php';

if (isset($_GET['logout'])) {
	$_SESSION['authentificated'] = false;
	unset($_SESSION['authentificated']);
	unset($_SESSION['user_admin']);
	$_SESSION['msg'] = new Message('Vous avez bien été déconnecté', 1, 'À bientôt !');
	header('Location: /login.php');
	exit;
}
elseif (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
	header('Location: /');
	exit;
}
elseif (isset($_GET['login']) && isset($_POST['user']) && isset($_POST['pwd'])) {
	$path = isset($_GET['path']) ? htmlspecialchars($_GET['path']) : '';
	if (UserAdmin::isAuthorizedUser($_POST['user'], $_POST['pwd'])) {
		$_SESSION['user_name'] = UserAdmin::getName(htmlspecialchars($_POST['user']));
		$_SESSION['authentificated'] = true;
		header('Location: /'. $path);
		exit;
	}
	else {
		$_SESSION['msg'] = new Message('Mauvais utilisateur et/ou mot de passe', -1, 'Oups... !');
		header('Location: /login.php?path='. $path);
		exit;
	}
}
else {
	$path = isset($_GET['path']) ? htmlspecialchars(preg_replace('#/#', '', $_GET['path'])) : '';

?><!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Connexion &ndash; Administration &ndash; FSC Bezannes</title>
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
    </style>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="<?php echo _FSC_; ?>/css/bootstrap-responsive.css" rel="stylesheet" />
	</head>

	<body>
		
		<header class="container">
			<div class="page-header">
				<h1 style="text-align: center;"><a href="<?php echo _FSC_; ?>">Foyer Social et Culturel de Bezannes</a></h1>
			</div>
		</header>
		
		<!-- container -->
		<div class="container">
			
			<?php
				if (isset($_SESSION['msg'])) {
					echo $_SESSION['msg'];
					unset($_SESSION['msg']);
				}
			?>
			
      <form class="form-signin" action="login.php?login&amp;path=<?php echo $path; ?>" method="post">
        <h2 class="form-signin-heading">Connexion</h2>
				<!--<label for="user">Utilisateur</label>-->
        <input type="text" class="input-block-level" placeholder="Utilisateur" name="user" id="user" autofocus/>
				<!--<label for="pwd">Mot de passe</label>-->
        <input type="password" class="input-block-level" placeholder="Mot de passe" name="pwd" id="pwd" />
        <button class="btn btn-large btn-primary btn-block" type="submit">Se connecter</button>
      </form> 
		</div>
		<!-- /container -->
		
		<script src="<?php echo _JQUERY_; ?>"></script>
		<script src="<?php echo _FSC_; ?>/js/bootstrap.min.js"></script>
		<?php
			echo (_ANALYTICS_ADMIN_ ? "
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
<?php
	}
?>
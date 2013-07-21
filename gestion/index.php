<?php

namespace lib;
use lib\content\Page;
use lib\content\Menu;

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();
//error_reporting (0);
error_reporting(E_ALL & ~E_STRICT);

session_name('fsc_gestion');
session_start();

require '../config/config.php';

if (!isset($_SESSION['authentificated']) || !$_SESSION['authentificated']) {
	header('Location: '. _GESTION_ .'/login.php');
	exit();
}
else {
	
// Menu navigation
$mainMenu = new Menu();
	$mainMenu->addLink('Dashboard', _GESTION_, 'dashboard');
	$mainMenu->addLink('Activités', _GESTION_.'/?page=activities', 'globe');
	$mainMenu->addLink('Membres', _GESTION_.'/?page=members', 'male');
	$mainMenu->addLink('Préinscriptions', _GESTION_.'/?page=preinscriptions', 'hand-right');

// Contenu de la page
if (empty($_GET['page'])) $_GET['page'] = 'home';
$_GET['page'] = str_replace("\0", '', $_GET['page']);
$_GET['page'] = str_replace(DIRECTORY_SEPARATOR, '', $_GET['page']);

$_SCRIPT = array();
$controller = ($_GET['page'] == 404 || $_GET['page'] == 403) ? '../'. _PATH_PUBLIC_ .'/pages/errors/'.$_GET['page'].'/controller.php' : '../'._PATH_GESTION_.'/pages/'.$_GET['page'].'/controller.php';
$controller = file_exists($controller) ? $controller : '../'. _PATH_PUBLIC_ .'/pages/errors/404/controller.php';
require_once _PATH_GESTION_. DIRECTORY_SEPARATOR .$controller;

?><!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<title><?php echo ($page->url() != _GESTION_) ? $page->admin_title() .' &ndash; ' : null; ?>Gestion &ndash; FSC Bezannes</title>
		<meta name="author" content="Nicolas Devenet" />
		<meta name="robots" content="NOINDEX, NOFOLLOW, NOARCHIVE" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo _STATIC_; ?>/img/favicon/round_diago_16.ico" />
		<link rel="icon"          type="image/png"    href="<?php echo _STATIC_; ?>/img/favicon/round_diago_32.png" />
		<link rel="apple-touch-icon" href="<?php echo _STATIC_; ?>/img/logo/fsc-128x128.png" />
		<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/font-awesome.min.css" />
		<!--[if IE 7]><link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/font-awesome-ie7.min.css"><![endif]-->
		<link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/bootstrap-fileupload.min.css" />
		<link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/common.css" />
		<link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/bootstrap-wysihtml5.css" />
		<link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/bootstrap-select2.css" />
		<link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/bootstrap-notify.css" />
		<style>
			header {
				margin: 20px 0 0 0;
			}
			.page-header {
				margin-top: 0;
			}
			footer hr {
				margin-bottom: 10px;
			}
			table thead th a {
				text-decoration: none !important;
			}
		</style>
	</head>

	<body>
		
		<!-- menu -->
		<div class="navbar navbar-static-top">
			<div class="navbar-inner">
				<div class="container">
				<a class="brand" href="<?php echo _FSC_; ?>" rel="external"><span class="fsc-blue">F</span><span class="fsc-green">S</span><span class="fsc-orange">C</span></a>
				<ul class="nav"><?php echo $mainMenu->display($page->url()); ?></ul>
				<!-- settings -->
				<ul class="nav pull-right">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="./?page=users">
							<img src="<?php echo $_SESSION['user']->gravatar(20); ?>" alt="\o/" class="gravatar" />
							<?php echo $_SESSION['user']->name(); ?>
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="./?page=account"><i class="icon-user"></i> Mon compte</a></li>
						<li><a href="./?page=users"><i class="icon-group"></i> Utilisateurs</a></li>
						<li class="divider"></li>
						<li><a href="./?page=history"><i class="icon-table"></i> Historique</a></li>
						<li><a href="./?page=settings"><i class="icon-cog"></i> Configuration</a></li>
						<li><a href="mailto:nicolas+fsc@devenet.info" rel="external"><i class="icon-bullhorn"></i> Feedback</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo _FSC_; ?>" rel="external"><i class="icon-home"></i> Accueil <span class="fsc-blue fsc-hover-white">F</span><span class="fsc-green fsc-hover-white">S</span><span class="fsc-orange fsc-hover-white">C</span> <span class="normal external-link"><i class="icon-external-link"></i></span></a></li>
						<li><a href="<?php echo _PREINSCRIPTION_; ?>" rel="external"><i class="icon-hand-right"></i> Présincriptions <span class="normal external-link"><i class="icon-external-link"></i></span></a></li>
						<li class="divider"></li>
						<li><a href="./login.php?logout"><i class="icon-signout"></i> Déconnexion</a></li>
					</ul>
					</li>
				</ul>
				</div>
			</div>
		</div>
		<!-- /menu -->
		
		<header class="container">
			<?php echo $page->breadcrumb('Gestion', _GESTION_.'?'); ?>
		</header>
		
		<!-- container -->
		<div class="container">
			
			<!-- messages -->
			<?php
				if (isset($_SESSION['msg'])) {
					//echo '<div class="row"><div class="span8 offset2">', $_SESSION['msg'], '</div></div>';
					echo '<div class="notifications top-right">', $_SESSION['msg'], '</div>';
					unset($_SESSION['msg']);
				}
			?>
			<!-- /messages -->
			
			<?php
				include dirname($controller) . '/view.php';
			?>   
		</div>
		<!-- /container -->
		
		<!-- footer -->
		<footer>
			<hr />
			<div class="container">
				<p class="pull-left">
          &copy; 2012-<?php echo date('Y'); ?> &mdash; Foyer Social et Culturel de Bezannes
          <br /><small>Developped with love by <a href="http://nicolas.devenet.info" rel="external">Nicolas Devenet</a></small>
        </p>
        <ul class="nav nav-pills pull-right">
          <li><a href="#" id="go_home_you_are_drunk"><i class="icon-arrow-up"></i> Remonter</a></li>
        </ul>
			</div>
		</footer>
		<!-- /footer -->
		
		<script src="<?php echo _JQUERY_; ?>"></script>
		<script src="<?php echo _STATIC_; ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo _STATIC_; ?>/js/fsc-common.js"></script>
		<?php
      foreach ($_SCRIPT as $script) {
        echo $script, PHP_EOL;
      }
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
				</script>": null), PHP_EOL;
		?>
	</body>
</html>
<?php
	}
?>
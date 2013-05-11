<?php

namespace lib;
use lib\content\Page;
use lib\content\Menu;

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();

session_start();

require '../config/config.php';

if (!isset($_SESSION['authentificated']) || !$_SESSION['authentificated']) {
	header('Location: /login.php');
	exit();
}
else {
	
// Menu navigation
$mainMenu = new Menu();
	$mainMenu->addLink('Dashbord', '/', 'dashboard');
	$mainMenu->addLink('Activités', '/?page=activities', 'globe');
	$mainMenu->addLink('Membres', '/?page=members', 'group');
// Menu secondaire droite
$rightMenu = new Menu();
	$rightMenu->addLink('<span class="fsc-blue">F</span><span class="fsc-green">S</span><span class="fsc-orange">C</span>', _FSC_, 'caret-right', true, true, true);


// Contenu de la page
if (empty($_GET['page'])) $_GET['page'] = 'home';
$_GET['page'] = str_replace("\0", '', $_GET['page']);
$_GET['page'] = str_replace(DIRECTORY_SEPARATOR, '', $_GET['page']);

$_SCRIPT = array();
$controller = '../gestion/pages/'.$_GET['page'].'/controller.php';
$controller = file_exists($controller) ? $controller : '../pages/errors/404/controller.php';
require_once 'gestion/'.$controller;

?><!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title><?php echo ($page->url() != '/') ? $page->admin_title() .'&ndash; ' : null; ?>Gestion &ndash; FSC Bezannes</title>
		<meta name="author" content="FSC Bezannes" />
		<meta name="robots" content="NOINDEX, NOFOLLOW, NOARCHIVE" />
    <!--<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />-->
    <link rel="icon" type="image/png" href="/favicon.png" />
		<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<link href="<?php echo _FSC_; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen" />
		<link rel="stylesheet" href="<?php echo _FSC_; ?>/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo _FSC_; ?>/css/font-awesome-ie7.min.css">
    <![endif]-->
		<link href="<?php echo _FSC_; ?>/css/bootstrap-fileupload.min.css" rel="stylesheet" media="screen" />
		<link href="<?php echo _FSC_; ?>/css/common.css" rel="stylesheet" media="screen" />
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
		</style>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="<?php echo _FSC_; ?>/css/bootstrap-responsive.min.css" rel="stylesheet" />
	</head>

	<body>
		
		<!-- menu -->
		<div class="navbar navbar-static-top">
			<div class="navbar-inner">
				<div class="container">
				<ul class="nav"><?php echo $mainMenu->display($page->url()); ?></ul>
				<ul class="nav pull-right"><?php echo $rightMenu->display($page->url()); ?></ul>
				<!-- settings -->
				<ul class="nav pull-right">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="/?page=account"><?php echo $_SESSION['user']->name(); ?>
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="/?page=account"><i class="icon-user"></i> Mon compte</a></li>
						<li class="divider"></li>
						<li><a href="/?page=history"><i class="icon-table"></i> Historique</a></li>
						<li><a href="/?page=settings"><i class="icon-cog"></i> Configuration</a></li>
						<li><a href="mailto:nicolas+fsc@devenet.info" target="_blank"><i class="icon-bullhorn"></i> Feedback</a></li>
						<li class="divider"></li>
						<li><a href="/login.php?logout"><i class="icon-signout"></i> Déconnexion</a></li>
					</ul>
					</li>
				</ul>
				</div>
			</div>
		</div>
		<!-- /menu -->
		
		<header class="container">
			<?php echo $page->breadcrumb('Dashbord'); ?>
		</header>
		
		<!-- container -->
		<div class="container">
			
			<!-- messages -->
			<?php
				if (isset($_SESSION['msg'])) {
					echo '<div class="row"><div class="span8 offset2">', $_SESSION['msg'], '</div></div>';
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
		<script src="<?php echo _FSC_; ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo _FSC_; ?>/js/fsc-common.js"></script>
		<?php
      foreach ($_SCRIPT as $script) {
        echo $script;
      }
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
<?php
	}
?>
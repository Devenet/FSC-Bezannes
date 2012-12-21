<?php

namespace lib;
use lib\content\Page;
use lib\content\Menu;

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();

session_start();

if (!isset($_SESSION['authentificated']) || !$_SESSION['authentificated']) {
	header('Location: /login.php');
	exit();
}
else {
	
// Menu navigation
$mainMenu = new Menu();
	$mainMenu->addLink('Administration', '/', 'cog');
	$mainMenu->addLink('Activités', '/?page=activites', 'globe');
// Menu secondaire droite
$rightMenu = new Menu();
	$rightMenu->addLink('Feedback', '#', 'bullhorn');


// Contenu de la page
if (empty($_GET['page'])) $_GET['page'] = 'home';
str_replace("\0", '', $_GET['page']);
str_replace(DIRECTORY_SEPARATOR, '', $_GET['page']);

$infosPage = '../admin/pages/'.$_GET['page'].'/infos.php';
$infosPage = file_exists($infosPage) ? $infosPage : '../pages/errors/404/infos.php';
include 'admin/'.$infosPage;

?><!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title><?php echo ($page->url() != '/') ? $page->admin_title() .'&ndash; ' : null; ?>Administration &ndash; FSC Bezannes</title>
		<meta name="author" content="FSC Bezannes" />
		<meta name="robots" content="NOINDEX, NOFOLLOW, NOARCHIVE" />
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
		<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<link href="//fsc.localhost.local/css/bootstrap.min.css" rel="stylesheet" media="screen" />
		<style>
			header {
				margin: 10px 0 0 0;
			}
			.page-header {
				margin-top: 0;
			}
			footer hr {
				margin-bottom: 10px;
			}
		</style>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="//fsc.localhost.local/css/bootstrap-responsive.css" rel="stylesheet" />
	</head>

	<body>
		
		<!-- menu -->
		<div class="navbar navbar-static-top">
			<div class="navbar-inner">
				<div class="container-fluid">
				<a class="brand" href="//fsc.localhost.local">FSC Bezannes</a>
				<?php echo $mainMenu->display($page->url(), false); ?>
				<!-- activites --
				<ul class="nav">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-globe"></i> Activités
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="/?page=activites">Voir</a></li>
						<li><a href="/?page=activites&rel=ajout">Ajouter</a></li>
					</ul>
					</li>
				</ul>-->
				<!-- user -->
				<ul class="nav pull-right">
					<li class="divider-vertical"></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i> Nicolas
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="/login.php?logout"><i class="icon-off"></i> Déconnexion</a></li>
					</ul>
					</li>
				</ul>
				<?php echo $rightMenu->display($page->url(), true); ?>
				</div>
			</div>
		</div>
		<!-- /menu -->

		<header class="container">
			<!--<h1><a href="/">Foyer Social et Culturel de Bezannes</a></h1>-->
			<?php echo $page->breadcrumb(); ?>
		</header>
		
		<!-- container -->
		<div class="container">
		<?php
			// Controller
			$controllerPage = dirname($infosPage) . '/controller.php';
			if (file_exists($controllerPage))
				require $controllerPage;
			
			// View
			include dirname($infosPage) . '/view.php';
		?>   
		</div>
		<!-- /container -->
		
		<!-- footer -->
		<footer>
			<hr />
			<div class="container">
				<p class="pull-left">&copy; 2012 &mdash; Foyer Social et Culturel de Bezannes</p>
				<p class="pull-right"><a href="/mentions-legales.html">Mentions légales</a></p>
			</div>
		</footer>
		<!-- /footer -->
		
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="//fsc.localhost.local/js/bootstrap.min.js"></script>  
	</body>
</html>
<?php
	}
?>
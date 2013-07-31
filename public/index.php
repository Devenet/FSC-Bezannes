<?php

namespace lib;
use lib\content\Page;
use lib\content\Menu;
use lib\db\SQL;

$timestart=microtime(true);

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();
//error_reporting (0);

require '../config/config.php';
require '../config/version.php';

// Menu navigation
$mainMenu = new Menu();
	$mainMenu->addLink('Accueil', _FSC_.'/', 'home');
	$mainMenu->addLink('<!--À propos-->', _FSC_.'/a-propos', 'ban-circle');
	$mainMenu->addLink('En savoir plus', _FSC_.'/en-savoir-plus', 'info-sign');
	$mainMenu->addLink('Activités', _FSC_.'/activites', 'globe');
	//$mainMenu->addLink('Actualités', _FSC_.'/actualites', 'star');
	//$mainMenu->addLink('Agenda', _FSC_.'/agenda', 'calendar');
	//$mainMenu->addLink('Contact', _FSC_.'/contact', 'envelope');
// Menu secondaire droite
$rightMenu = new Menu();
	$rightMenu->addLink('Préinscriptions', _PREINSCRIPTION_, 'hand-right', false);
// Menu footer
$footerMenu = new Menu();
	$footerMenu->addLink('Accueil', _FSC_.'/', 'home');
	$footerMenu->addLink('Contact', _FSC_.'/contact', 'envelope-alt');
	$footerMenu->addLink('Mentions légales', _FSC_.'/mentions-legales', 'legal');
	$footerMenu->addLink('', _GESTION_, 'lock', true);

// Contenu de la page
if (empty($_GET['page'])) $_GET['page'] = 'home';
$_GET['page'] = htmlspecialchars($_GET['page']);
$_GET['page'] = str_replace("\0", '', $_GET['page']);
$_GET['page'] = str_replace(DIRECTORY_SEPARATOR, '', $_GET['page']);

// Get controller
$_SCRIPT = array();
$controller = ($_GET['page'] == 404 || $_GET['page'] == 403) ? 'pages/errors/'.$_GET['page'].'/controller.php' : 'pages/'.$_GET['page'].'/controller.php';
$controller = file_exists($controller) ? $controller : 'pages/errors/404/controller.php';
require_once $controller;

?><!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<title><?php echo $page->title() ; ?> &middot; FSC Bezannes</title>
		
		<!--
		$$$$$$$$\  $$$$$$\   $$$$$$\        $$$$$$$\                                                                       
		$$  _____|$$  __$$\ $$  __$$\       $$  __$$\                                                                      
		$$ |      $$ /  \__|$$ /  \__|      $$ |  $$ | $$$$$$\  $$$$$$$$\ $$$$$$\  $$$$$$$\  $$$$$$$\   $$$$$$\   $$$$$$$\ 
		$$$$$\    \$$$$$$\  $$ |            $$$$$$$\ |$$  __$$\ \____$$  |\____$$\ $$  __$$\ $$  __$$\ $$  __$$\ $$  _____|
		$$  __|    \____$$\ $$ |            $$  __$$\ $$$$$$$$ |  $$$$ _/ $$$$$$$ |$$ |  $$ |$$ |  $$ |$$$$$$$$ |\$$$$$$\  
		$$ |      $$\   $$ |$$ |  $$\       $$ |  $$ |$$   ____| $$  _/  $$  __$$ |$$ |  $$ |$$ |  $$ |$$   ____| \____$$\ 
		$$ |      \$$$$$$  |\$$$$$$  |      $$$$$$$  |\$$$$$$$\ $$$$$$$$\\$$$$$$$ |$$ |  $$ |$$ |  $$ |\$$$$$$$\ $$$$$$$  |
		\__|       \______/  \______/       \_______/  \_______|\________|\_______|\__|  \__|\__|  \__| \_______|\_______/ 
		-->
		
		<meta name="description" content="Foyer Social et Culturel de Bezannes, association proposant de nombreuses activit&eacute;s culturelles, sportives et artistiques. Venez vite nous rejoindre !" />
		<meta name="keywords" content="FSC, Foyer, Bezannes, FSC Bezannes, activit&eacute;s, bonne humeur, enfants, adultes"/>
		
		<!-- Parce qu’il y a toujours un peu d’humain derrière un site... -->
		<meta name="author" content="Nicolas Devenet" />
		<link rel="author" href="<?php echo _FSC_; ?>/humans.txt" />
		
		<meta name="robots" content="<?php echo $page->search_engine(); ?>" />
		<meta name="google-site-verification" content="OvBA7LsULbvmZK3bYWaF_m_pDzrnKY9_KIITGB1K4XU" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="shortcut icon"    type="image/x-icon" href="<?php echo _STATIC_; ?>/img/favicon/round_16.ico" />
		<link rel="icon"             type="image/png"    href="<?php echo _STATIC_; ?>/img/favicon/round_32.png" />
		<link rel="apple-touch-icon" href="<?php echo _STATIC_; ?>/img/logo/fsc-128x128.png" />
		
		<link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/bootstrap-<?php echo _VERSION_CSS_; ?>.min.css" />
		<link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/font-awesome-<?php echo _VERSION_CSS_; ?>.min.css" />
		<link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/fsc-<?php echo _VERSION_CSS_; ?>.css" />
		<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/fsc-ie-<?php echo _VERSION_CSS_; ?>.css" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/font-awesome-ie7-<?php echo _VERSION_CSS_; ?>.min.css"><![endif]-->
		<!--[if IE 6]><link rel="stylesheet" href="<?php echo _STATIC_; ?>/css/ie6-<?php echo _VERSION_CSS_; ?>.min.css"><![endif]-->
	</head>

	<body class="page-<?php echo strtolower($_GET['page']); ?>">

		<!-- head -->
		<header>
		<div class="container">
			<a href="<?php echo _FSC_; ?>"><img src="<?php echo _STATIC_; ?>/img/logo/fsc-<?php echo $page->url() != _FSC_.'/' ? '113x75' : '225x150'; ?>.png" alt="FSC Bezannes" /></a>
			<h1><span class="fsc-blue">Foyer</span> <span class="fsc-green">Social</span> et <span class="fsc-orange">Culturel</span> <?php echo $page->url() != _FSC_.'/' ? '' : '<span class="bezannes">de Bezannes</span>'; ?></h1>
		</div>
		</header>
		<!-- /head -->
		
		<!-- menu -->
		<div class="navbar navbar-static-top clearfix" id="menu">
		<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="nav-collapse collapse">
				<ul class="nav"><?php echo $mainMenu->display($page->parent_url()); ?></ul>
				<ul class="nav pull-right"><?php echo $rightMenu->display($page->url()); ?></ul>
			</div>
		</div>
		</div>
		</div>
		<!-- /menu -->
		
		<!-- content -->
		<?php
			echo !$page->option('no-container') ? '<div class="container">' : null;
			include dirname($controller) . '/view.php';
			echo !$page->option('no-container') ? '</div>' : null;
		?>
		<!-- /content -->
		
		<!-- footer -->
		<footer>
		<hr />
		<div class="container">
		<div class="clearfix">
			<ul class="nav nav-pills pull-right">
				<li><a href="#" id="go_home_you_are_drunk"><i class="icon-arrow-up"></i> Remonter</a></li>
			</ul>
			<ul class="nav nav-pills pull-left">
				<?php echo $footerMenu->display(); ?>
			</ul>
		</div>
			
		<div class="clearfix">
			<p class="pull-left">
				&copy; 2012-<?php echo date('Y'); ?> &mdash; Foyer Social et Culturel de Bezannes
				<br /><small>Developped with love by <a href="http://nicolas.devenet.info" rel="external">Nicolas Devenet</a></small>
			</p>
		</div>
		</div>
		</footer>
		<!-- /footer -->
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?php echo _STATIC_; ?>/js/jquery.min.js"><\/script>')</script>
		<script src="<?php echo _STATIC_; ?>/js/bootstrap-<?php echo _VERSION_JS_; ?>.min.js"></script>
		<script src="<?php echo _STATIC_; ?>/js/fsc-common-<?php echo _VERSION_JS_; ?>.js"></script>
		<!--[if IE 6]><script src="<?php echo _STATIC_; ?>/js/ie6.min.js"></script><![endif]-->
		<?php
			foreach ($_SCRIPT as $script) {
				echo $script, PHP_EOL;
			}
			echo (_ANALYTICS_FSC_ ? "
			<script>
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', 'UA-37435384-1']);
				_gaq.push(['_trackPageview']);
			
				(function() {
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();
			</script>" : null);

			$timeend=microtime(true);
			$page_time = number_format(($timeend-$timestart)*1000, 2);
			echo '<div class="execution">', $page_time, ' ms<br />', SQL::access(),' db</div>' . PHP_EOL;
		?>
	</body>
</html>
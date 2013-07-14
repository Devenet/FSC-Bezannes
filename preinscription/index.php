<?php

namespace lib;
use lib\content\Page;
use lib\content\Menu;

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();
//error_reporting (0);

session_name('preinscription');
session_start();

require '../config/config.php';

// Menu navigation
$mainMenu = new Menu();
	$mainMenu->addLink('Préinscriptions', _INSCRIPTION_.'/', 'hand-right');
// Menu secondaire
$rightMenu = new Menu();
	$rightMenu->addLink((isset($_SESSION['authentificated']) && $_SESSION['authentificated'] ? 'Accueil' : 'Retour'). ' site <span class="fsc-blue">F</span><span class="fsc-green">S</span><span class="fsc-orange">C</span>', _FSC_, (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) ? 'external-link' : 'share-alt', (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) ? true : false, true, true);

// Contenu de la page
if (empty($_GET['page'])) $_GET['page'] = 'home';
$_GET['page'] = str_replace("\0", '', $_GET['page']);
$_GET['page'] = str_replace(DIRECTORY_SEPARATOR, '', $_GET['page']);

$_SCRIPT = array();
$controller = ($_GET['page'] == 404 || $_GET['page'] == 403) ? '../'. _PATH_PUBLIC_ .'/pages/errors/'.$_GET['page'].'/controller.php' : '../'._PATH_INSCRIPTION_.'/pages/'.$_GET['page'].'/controller.php';
$controller = file_exists($controller) ? $controller : '../'. _PATH_PUBLIC_ .'/pages/errors/404/controller.php';
require_once _PATH_INSCRIPTION_. DIRECTORY_SEPARATOR .$controller;

?><!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<title><?php echo ($page->url() != _INSCRIPTION_.'/') ? $page->title() .' &middot; ' : null; ?>Présinscriptions &middot; FSC Bezannes</title>
		<meta name="description" content="Foyer Social et Culturel de Bezannes, association proposant de nombreuses activit&eacute;s culturelles, sportives et artistiques. Venez vite nous rejoindre !" />
		<meta name="keywords" content="FSC, Foyer, Bezannes, FSC Bezannes, activit&eacute;s, bonne humeur, enfants, adultes"/>
		<meta name="author" content="Nicolas Devenet" />
		<meta name="robots" content="<?php echo $page->search_engine(); ?>" />
		<meta name="google-site-verification" content="nVrzZ_xZ8UdawohpsECIOvSgTsaU0R0GDWNqxnNpeis" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo _FSC_; ?>/img/favicon/round_16.ico" />
		<link rel="icon"          type="image/png"    href="<?php echo _FSC_; ?>/img/favicon/round_32.png" />
		<link rel="apple-touch-icon" href="<?php echo _FSC_; ?>/img/logo/fsc-128x128.png" />
		<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<link rel="stylesheet" href="<?php echo _FSC_; ?>/css/bootstrap.min.css" media="screen" />
		<link rel="stylesheet" href="<?php echo _FSC_; ?>/css/font-awesome.min.css" />
		<!--[if IE 7]><link rel="stylesheet" href="<?php echo _FSC_; ?>/css/font-awesome-ie7.min.css"><![endif]-->
		<link rel="stylesheet" href="<?php echo _FSC_; ?>/css/inscription.css" media="screen" />
		<link rel="stylesheet" href="<?php echo _FSC_; ?>/css/bootstrap-responsive.min.css" />
		<?php if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) { ?><link rel="stylesheet" href="<?php echo _FSC_; ?>/css/select2.css" /><?php } ?> 
	</head>

	<body>
		
		<!-- menu -->
		<div class="navbar navbar-static-top">
			<div class="navbar-inner">
				<div class="container">
					<ul class="nav"><?php echo $mainMenu->display(); ?></ul>

					<ul class="nav pull-right"><?php echo $rightMenu->display(); ?></ul>
					<?php if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) { ?>
					<!-- settings -->
					<ul class="nav pull-right">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo _INSCRIPTION_; ?>/account"><?php echo $_SESSION['user']->login(); ?>
							<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo _INSCRIPTION_; ?>/list"><i class="icon-hand-right"></i> Mes préinscriptions</a></li>
								<li><a href="<?php echo _INSCRIPTION_; ?>/account"><i class="icon-user"></i> Mon compte</a></li>
								<li class="divider"></li>
								<li><a href="<?php echo _INSCRIPTION_; ?>/logout"><i class="icon-signout"></i> Déconnexion</a></li>
							</ul>
						</li>
					</ul>
					<?php } else { ?>
					<div class="nav pull-right" style="padding-right:8px;">
						<a href="<?php echo _INSCRIPTION_; ?>/signup" class="btn btn-success btn-small hidden-phone" style="margin-top: 6px;">Se préinscrire</a> 
						<a href="<?php echo _INSCRIPTION_; ?>/login" class="btn btn-small btn-primary" style="margin-top: 6px;">Connexion</a>
					</div>
					<?php } ?>
	
				</div>
			</div>
		</div>
		<!-- /menu -->
		
		<header class="container">
			<?php if(! $page->option('no-title')) { ?>
			<div class="row">
				<div class="span8">
						<h1><?php echo $page->name(); ?></h1>
				</div>
				<?php if ($page->option('steps')) { ?>
				<div class="span4 hidden-phone">
					<ul class="unstyled">
						<li><span class="strong">Étape <?php echo $page->parameter('step'); ?></span> : <?php echo ($page->parameter('step-info') != null ? $page->parameter('step-info') : $pageInfos['name']); ?>
							<div class="progress progress-important">
								<div class="bar<?php echo $page->option('bar') ? ' bar-'. $page->parameter('bar') : null; ?>" style="width: <?php echo $page->parameter('step-width'); ?>%;"></div>
							</div>
						</li>
					</ul>
				</div>
				<?php } ?>
			</div>
			<hr style="margin-top:0;" />
			<?php }
			
			if (! $page->option('no-breadcrumb'))
				echo $page->breadcrumb('Préinscriptions', _INSCRIPTION_); ?>
		</header>
		

		<!-- message -->
		<?php 
			if (isset($_SESSION['msg'])) {
				echo '<div class="container"><div class="row"><div class="span8 offset2">', $_SESSION['msg'], '</div></div></div>';
				unset($_SESSION['msg']);
			}
		?>

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
			echo (_ANALYTICS_INSCRIPTION_ ? "
			<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			  ga('create', 'UA-37435384-4', 'fsc-bezannes.fr');
			  ga('send', 'pageview');
			</script>": null);
		?>
	</body>
</html>
<?php

namespace lib;
use lib\content\Page;
use lib\content\Menu;

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();

session_start();

require '../config/config.php';

// Menu navigation
$mainMenu = new Menu();
	$mainMenu->addLink('Préinscriptions', '/', 'bookmark');
// Menu secondaire
$rightMenu = new Menu();
	$rightMenu->addLink('<span class="fsc-blue">F</span><span class="fsc-green">S</span><span class="fsc-orange">C</span>', _FSC_, 'caret-right', false, true, true);

// Contenu de la page
if (empty($_GET['page'])) $_GET['page'] = 'home';
$_GET['page'] = str_replace("\0", '', $_GET['page']);
$_GET['page'] = str_replace(DIRECTORY_SEPARATOR, '', $_GET['page']);

$controller = '../'._PATH_INSCRIPTION_.'/pages/'.$_GET['page'].'/controller.php';
$controller = file_exists($controller) ? $controller : '../pages/errors/404/controller.php';
require_once _PATH_INSCRIPTION_. DIRECTORY_SEPARATOR .$controller;

$scripts = '';

?><!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title><?php echo ($page->url() != '/') ? $page->admin_title() .'&ndash; ' : null; ?>Présinscriptions &ndash; FSC Bezannes</title>
		<meta name="author" content="FSC Bezannes" />
		<meta name="robots" content="INDEX, FOLLOW, NOARCHIVE" />
    <!--<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />-->
    <link rel="icon" type="image/png" href="/favicon.png" />
		<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<link href="<?php echo _FSC_; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen" />
		<link rel="stylesheet" href="<?php echo _FSC_; ?>/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo _FSC_; ?>/css/font-awesome-ie7.min.css">
    <![endif]-->
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
				<!--<a class="brand" href="<?php echo _FSC_; ?>"><span class="fsc-blue">F</span><span class="fsc-green">S</span><span class="fsc-orange">C</span></a>-->
				<ul class="nav"><?php echo $mainMenu->display($page->url()); ?></ul>
				<ul class="nav pull-right"><?php echo $rightMenu->display(); ?></ul>
				<?php if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) { ?>
				<!-- settings -->
				<ul class="nav pull-right">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="/account.html"><?php echo $_SESSION['user']->login(); ?>
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="/account.html"><i class="icon-user"></i> Mon compte</a></li>
						<li><a href="/settings.html"><i class="icon-cog"></i> Préférences</a></li>
						<li class="divider"></li>
						<li><a href="/logout.html"><i class="icon-signout"></i> Déconnexion</a></li>
					</ul>
					</li>
				</ul>
				<?php } else { ?>
				<div class="nav pull-right" style="padding-right:8px;">
					<a href="/signup.html" class="btn btn-success btn-small" style="margin-top: 6px;">Se préinscrire</a> 
					<a href="/login.html" class="btn btn-small btn-primary" style="margin-top: 6px;">Connexion</a>
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
						<h2><?php echo $pageInfos['name']; ?></h2>
				</div>
				<?php if ($page->option('steps')) { ?>
				<div class="span4">
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
				echo $page->breadcrumb('Préinscriptions'); ?>
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
				<p class="pull-left">&copy; 2012-<?php echo date('Y'); ?> &mdash; Foyer Social et Culturel de Bezannes</p>
			</div>
		</footer>
		<!-- /footer -->
		
		<script src="<?php echo _JQUERY_; ?>"></script>
		<script src="<?php echo _FSC_; ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo _FSC_; ?>/js/fsc.js"></script>
		<?php
			echo (isset($scripts) ? $scripts : null);
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
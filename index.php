<?php

namespace lib;
use lib\content\Page;
use lib\content\Menu;

spl_autoload_extensions('.php');
spl_autoload_register();

session_start();

require 'config/config.php';

// Menu navigation
$mainMenu = new Menu();
  $mainMenu->addLink('Accueil', _FSC_.'/', 'home');
  $mainMenu->addLink('À propos', _FSC_.'/a-propos', 'info-sign');
  $mainMenu->addLink('Activités', _FSC_.'/activites', 'globe');
  $mainMenu->addLink('Actualités', _FSC_.'/actualites', 'star');
  $mainMenu->addLink('Agenda', _FSC_.'/agenda', 'calendar');
  $mainMenu->addLink('Contact', _FSC_.'/contact', 'envelope');
// Menu secondaire droite
$rightMenu = new Menu();
  $rightMenu->addLink('Préinscriptions', _INSCRIPTION_, 'bookmark', false, false);
// Menu footer
$footerMenu = new Menu();
  $footerMenu->addLink('Accueil', _FSC_.'/', 'home');
  $footerMenu->addLink('Contact', _FSC_.'/contact', 'envelope');
  $footerMenu->addLink('Mentions légales', _FSC_.'/mentions-legales', 'legal');
  $footerMenu->addLink('', _GESTION_, 'lock', true);

// Contenu de la page
if (empty($_GET['page'])) $_GET['page'] = 'home';
$_GET['page'] = htmlspecialchars($_GET['page']);
$_GET['page'] = str_replace("\0", '', $_GET['page']);
$_GET['page'] = str_replace(DIRECTORY_SEPARATOR, '', $_GET['page']);

// Get controller
$_SCRIPT = array();
$controller = 'pages/'.$_GET['page'].'/controller.php';
$controller = file_exists($controller) ? $controller : 'pages/errors/404/controller.php';
require_once $controller;

?><!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title><?php echo $page->title() ; ?> &ndash; FSC Bezannes</title>
    <meta name="description" content="Foyer Social et Culturel de Bezannes, association proposant de nombreuses activit&eacute;s culturelles, sportives et artistiques. Venez vite nous rejoindre !" />
    <meta name="keywords" content="FSC, Foyer, Bezannes, FSC Bezannes, activit&eacute;s, bonne humeur, enfants, adultes"/>
    <meta name="author" content="FSC Bezannes" />
    <meta name="robots" content="<?php echo $page->search_engine(); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo _FSC_; ?>/img/favicon.ico" />
    <link rel="icon" type="image/png" href="<?php echo _FSC_; ?>/img/favicon.png" />
    <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link href="<?php echo _FSC_; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="<?php echo _FSC_; ?>/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css">
    <![endif]-->
    <link href="<?php echo _FSC_; ?>/css/fsc.css" rel="stylesheet" media="screen" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?php echo _FSC_; ?>/css/bootstrap-responsive.min.css" rel="stylesheet" />
  </head>

	<body class="page-<?php echo strtolower($_GET['page']); ?>">

    <!-- head -->
    <header>
      <div class="container">
        <a href="/"><img src="<?php echo _FSC_; ?>/img/logo-fsc<?php echo $page->url() != _FSC_.'/' ? '-small' : null; ?>.png" alt="FSC Bezannes" /></a>
        <h1><span class="fsc-blue">Foyer</span> <span class="fsc-green">Social</span> et <span class="fsc-orange">Culturel</span> <span class="bezannes">de Bezannes</span></h1>
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
          <!--
          <ul class="inline pull-right">
            <li><a href="#" title="Site valide HTML5"><img src="/img/badge-html5.png" alt="HTML5" /></a></li>
            <li><a href="https://nicolabricot.com" title="Site adapté par nicolabricot"><img src="//nicolabricot.com/favicon.png" alt="nicolabricot" /></a></li>
          </ul>
          <p class="pull-right social">
            <a href=""><i class="icon-facebook-sign"></i></a> 
            <a href=""><i class="icon-twitter"></i></a> 
            <a href=""><i class="icon-google-plus"></i></a>
          </p>
          -->
        </div>
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
      echo (_ANALYTICS_FSC_ ? "
      <script type=\"text/javascript\">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-37435384-1']);
        _gaq.push(['_trackPageview']);
      
        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
      </script>" : null);
    ?>
  </body>
</html>
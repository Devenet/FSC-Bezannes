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
  $mainMenu->addLink('Accueil', '/', 'home');
  $mainMenu->addLink('À propos', '/a-propos.html', 'info-sign');
  $mainMenu->addLink('Activités', '/activites.html', 'globe');
  $mainMenu->addLink('Actualités', '/actualites.html', 'star');
  $mainMenu->addLink('Agenda', '/agenda.html', 'calendar');
  $mainMenu->addLink('Contact', '/contact.html', 'envelope');
// Menu secondaire droite
$rightMenu = new Menu();
  $rightMenu->addLink('Feedback', 'mailto:nicolas+fsc@devenet.info', 'bullhorn');
// Menu footer
$footerMenu = new Menu();
  $footerMenu->addLink('Accueil', '/', 'home');
  $footerMenu->addLink('Contact', '/contact.html', 'envelope');
  $footerMenu->addLink('Mentions légales', '/mentions-legales.html', 'asterisk');
  $footerMenu->addLink('Gestion', _ADMIN_, 'lock');

// Contenu de la page
if (empty($_GET['page'])) $_GET['page'] = 'home';
$_GET['page'] = htmlspecialchars($_GET['page']);
str_replace("\0", '', $_GET['page']);
str_replace(DIRECTORY_SEPARATOR, '', $_GET['page']);

$controller = 'pages/'.$_GET['page'].'/controller.php';
$controller = file_exists($controller) ? $controller : 'pages/errors/404/controller.php';
require_once $controller;

// Redirection enfants
if (isset($_GET['rel']) && !$page->option('has-children')) {
  header ('Location: /'.$_GET['page'].'.html');
  exit();
}

?><!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title><?php echo $page->title(); ?> &ndash; FSC Bezannes</title>
    <meta name="description" content="Foyer Social et Culturel de Bezannes, association proposant des activit&eacute;s culturelles, sportives et artistiques." />
    <meta name="keywords" content="FSC, Foyer, Bezannes, FSC Bezannes, activit&eacute;s, bonne humeur, enfants, adultes"/>
    <meta name="author" content="FSC Bezannes" />
    <link rel="canonical" href="/" />
    <meta name="robots" content="<?php echo $page->search_engine(); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico" />
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="/css/fsc.css" rel="stylesheet" media="screen" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/css/bootstrap-responsive.css" rel="stylesheet" />
  </head>

	<body class="page-<?php echo strtolower($_GET['page']); ?>">

    <!-- head -->
    <header>
      <a href="/"><img src="/img/logo-fsc.png" /></a>
      <h1>Foyer Social et Culturel <span>de Bezannes</span></h1>
    </header>
    <!-- /head -->
    
    <!-- menu -->
    <div class="navbar navbar-static-top clearfix" id="menu">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="/"><span class="fsc-blue">F</span><span class="fsc-green">S</span><span class="fsc-orange">C</span></a>
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
    
    <?php if (!$page->option('hide-breadcrumb')) : ?>
    <div class="container hidden-desktop" id="breadcrumb">
      <?php echo $page->breadcrumb(); ?>
    </div>
    <?php endif; ?>
    
    <!-- content -->
    <?php
      echo !$page->option('hide-container') ? '<div class="container">' : null;
      include dirname($controller) . '/view.php';
      echo !$page->option('hide-container') ? '</div>' : null;
    ?>
    <!-- /content -->
    
    <!-- footer -->
    <footer>
      <hr />
      <div class="container">
        <div class="clearfix">
          <ul class="nav nav-pills pull-right">
            <li><a href="#"><i class="icon-arrow-up"></i> Remonter</a></li>
          </ul>
          <ul class="nav nav-pills pull-left">
            <?php echo $footerMenu->display(); ?>
          </ul>
        </div>
        
        <div class="colophon">
          <address><i class="icon-map-marker"></i> Espace de Bezannes, 3 rue Source de Muire, 51430 Bezannes</address>
          <p>&copy; 2012-<?php echo date('Y'); ?> &mdash; Foyer Social et Culturel de Bezannes</p>
        </div>
      </div>
    </footer>
    <!-- /footer -->
    
    <script src="<?php echo _JQUERY_; ?>"></script>
    <script src="/js/bootstrap.min.js"></script>
    <?php
      echo (!$page->option('hide-anchor-menu') ? '<script>$(document).ready(function() { document.location.href = "#menu"; }); </script>' : null);
      echo isset($jquery) ? $jquery : null;
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
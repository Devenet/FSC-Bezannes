<?php

namespace lib;
use lib\content\Page;
use lib\content\Menu;

spl_autoload_extensions('.php');
spl_autoload_register();

session_start();

// Menu navigation
$mainMenu = new Menu();
  $mainMenu->addLink('Accueil', '/', 'home');
  $mainMenu->addLink('À propos', '/a-propos.html', 'info-sign');
  $mainMenu->addLink('Agenda', '#', 'calendar');
  $mainMenu->addLink('Activités', '#', 'globe');
  $mainMenu->addLink('Contact', '#', 'envelope');
// Menu secondaire droite
$rightMenu = new Menu();
  $rightMenu->addLink('Feedback', '#', 'bullhorn');

// Contenu de la page
if (empty($_GET['page'])) $_GET['page'] = 'home';
str_replace("\0", '', $_GET['page']);
str_replace(DIRECTORY_SEPARATOR, '', $_GET['page']);

$infosPage = 'pages/'.$_GET['page'].'/infos.php';
$infosPage = file_exists($infosPage) ? $infosPage : 'pages/errors/404/infos.php';
include $infosPage;

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
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen" />
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
    <link href="/css/bootstrap-responsive.css" rel="stylesheet" />
  </head>

	<body>
    
    <!-- menu -->
    <div class="navbar navbar-static-top">
      <div class="navbar-inner">
        <div class="container-fluid">
        <!--<a class="brand" href="/">FSC Bezannes</a>-->
        <?php echo $mainMenu->display($page->url(), false); ?>
        <?php echo $rightMenu->display($page->url(), true); ?>
        </div>
      </div>
    </div>
    <!-- /menu -->

    <header class="container">
      <h1><a href="/">Foyer Social et Culturel de Bezannes</a></h1>
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
        <ul class="pull-right inline">
          <li><a href="//admin.fsc.localhost.local/">Administration</a></li>
          <li><a href="/mentions-legales.html">Mentions légales</a></li>
        </ul>
      </div>
    </footer>
    <!-- /footer -->
    
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="/js/bootstrap.min.js"></script>  
  </body>
</html>
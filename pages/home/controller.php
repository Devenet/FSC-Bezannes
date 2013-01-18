<?php

use lib\content\Page;

$pageInfos = array(
  'name' => 'Accueil',
  'url' => '/'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array());
$page->addOption('hide-container');
$page->addOption('hide-breadcrumb');
$page->addOption('hide-anchor-menu');

$displayMainMenu = $mainMenu->display($page->url());
$displayRightMenu = $rightMenu->display($page->url());

?>
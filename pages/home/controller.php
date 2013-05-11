<?php

use lib\content\Page;

$pageInfos = array(
  'name' => 'Accueil',
  'url' => _FSC_.'/'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array());
$page->addOption('no-container');

$displayMainMenu = $mainMenu->display($page->url());
$displayRightMenu = $rightMenu->display($page->url());

?>
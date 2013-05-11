<?php

use lib\content\Page;

$pageInfos = array(
  'name' => 'Préinscriptions',
  'url' => _INSCRIPTION_.'/'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array());

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
  header('Location: '. _INSCRIPTION_ .'/account');
  exit();
}

$page->addOption('no-breadcrumb');
$page->addOption('no-container');

?>
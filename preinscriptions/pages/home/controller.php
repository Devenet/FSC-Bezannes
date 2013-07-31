<?php

use lib\content\Page;

$pageInfos = array(
  'name' => 'Préinscriptions',
  'url' => _PREINSCRIPTION_.'/'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array());

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
  header('Location: '. _PREINSCRIPTION_ .'/list');
  exit();
}

$page->addOption('no-breadcrumb');
$page->addOption('no-container');
$page->addOption('no-title');

?>
<?php

use lib\content\Page;

if (!_PREINSCRIPTION_ENABLED_) {
	header('Location: '. _PREINSCRIPTION_.'/disabled');
	exit();
}

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
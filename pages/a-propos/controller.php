<?php

use lib\content\Page;
use lib\content\PageChild;
use lib\content\Menu;

$pageInfos = array(
  'name' => 'À propos',
  'url' => '/a-propos.html'
);
$page = new Page('À propos', $pageInfos['url'], array($pageInfos));

$pageMenu = new Menu();
  $pageMenu->addLink('À propos', '/a-propos.html');
  $pageMenu->addLink('La vie associative', '/a-propos/vie-associative.html');
  $pageMenu->addLink('Documents', '/a-propos/documents.html');

$rel = null;
if (isset($_GET['rel'])) {
  switch (htmlspecialchars($_GET['rel'])) {
    case 'vie-associative':
      $page = new PageChild($page, 'La vie associative', '/a-propos/vie-associative.html');
      $rel = 'asso';
      break;
    
    case 'documents':
      $page = new PageChild($page, 'Documents', '/a-propos/documents.html');
      $rel = 'doc';
      break;
    
    default:
      header ('Location: /a-propos.html');
      exit();    
  }
}

$page->addOption('has-children');
//$page->addOption('hide-breadcrumb');

?>
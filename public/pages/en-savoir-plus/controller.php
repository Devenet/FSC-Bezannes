<?php

use lib\content\Page;
use lib\content\PageChild;
use lib\content\Menu;

$pageInfos = array(
  'name' => 'En savoir plus',
  'url' => _FSC_.'/en-savoir-plus'
);
$page = new Page('En savoir plus', $pageInfos['url'], array($pageInfos));

$pageMenu = new Menu();
  $pageMenu->addLink('En savoir plus', $pageInfos['url']);
  $pageMenu->addLink('Conseil d’administration', $pageInfos['url'].'/conseil-d-aministration');
  $pageMenu->addLink('Bureau', $pageInfos['url'].'/bureau');
  $pageMenu->addLink('Assemblée générale', $pageInfos['url'].'/assemblee-generale');

$rel = null;
$display_parent = true;

if (isset($_GET['rel'])) {
  switch (htmlspecialchars($_GET['rel'])) {
    case 'conseil-d-aministration':
      $page = new PageChild($page, 'Conseil d’administration', $pageInfos['url'].'/conseil-d-aministration', $display_parent);
      $rel = 'ca';
      break;
    
    case 'bureau':
      $page = new PageChild($page, 'Bureau',$pageInfos['url'].'/bureau', $display_parent);
      $rel = 'bureau';
      break;

    case 'assemblee-generale':
      $page = new PageChild($page, 'Assemblée générale',$pageInfos['url'].'/assemblee-generale', $display_parent);
      $rel = 'ag';
      break;

    
    default:
      header ('Location: '. $pageInfos['url']);
      exit();    
  }
}

?>
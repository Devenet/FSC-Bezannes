<?php

use lib\content\Page;
use lib\content\PageChild;
use lib\content\Menu;

$pageInfos = array(
  'name' => 'À propos',
  'url' => _FSC_.'/a-propos'
);
$page = new Page('À propos', $pageInfos['url'], array($pageInfos));

$pageMenu = new Menu();
  $pageMenu->addLink('À propos', _FSC_.'/a-propos');
  $pageMenu->addLink('La vie associative', _FSC_.'/a-propos/vie-associative');
  $pageMenu->addLink('Documents', _FSC_.'/a-propos/documents');

$rel = null;
$display_parent = false;

if (isset($_GET['rel'])) {
  switch (htmlspecialchars($_GET['rel'])) {
    case 'vie-associative':
      $page = new PageChild($page, 'La vie associative', _FSC_.'/a-propos/vie-associative', $display_parent);
      $rel = 'asso';
      break;
    
    case 'documents':
      $page = new PageChild($page, 'Documents', _FSC_.'/a-propos/documents', $display_parent);
      $rel = 'doc';
      break;
    
    default:
      header ('Location: /a-propos');
      exit();    
  }
}

$_SCRIPT[] = '
  <script>
    $(function(){
      alert("Ces pages sont vouées à disparaître ! \n(remplacées par celles fournies par JCL) \n\n voir la rubrique « En savoir plus »");
    });
  </script>
';

?>
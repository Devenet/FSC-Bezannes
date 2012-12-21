<?php

use lib\content\Page;

$pageInfos = array(
  'name' => 'Erreur 404',
  'url' => ''
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

?>
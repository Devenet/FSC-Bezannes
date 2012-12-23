<?php

use lib\content\Page;

$pageInfos = array(
  'name' => 'À propos',
  'url' => '/a-propos.html'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

?>
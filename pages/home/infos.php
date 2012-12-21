<?php

use lib\content\Page;

$pageInfos = array(
  'name' => 'Accueil',
  'url' => '/'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array());


?>
<?php

use lib\content\Page;

$pageInfos = array(
  'name' => 'Activités',
  'url' => '/?page=activites'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));


?>
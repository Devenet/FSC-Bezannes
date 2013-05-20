<?php

use lib\content\Page;

$pageInfos = array(
  'name' => 'Erreur 403',
  'url' => ''
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

// URL not found : $_SERVER['REQUEST_URI'];

header('HTTP/1.1 403 Forbidden', true, 403);

?>
<?php

use lib\content\Page;

$pageInfos = array(
  'name' => 'Erreur 404',
  'url' => ''
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

// URL not found : $_SERVER['REQUEST_URI'];

header('HTTP/1.0 404 Not Found', true, 404);

?>
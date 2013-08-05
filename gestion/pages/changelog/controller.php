<?php

use lib\content\Page;
use lib\users\UserAdmin;
use lib\content\Display;
use lib\content\Pagination;

$pageInfos = array(
  'name' => 'Historique',
  'url' => _GESTION_.'/?page=changelog'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));


?>
<?php

use lib\activities\Activity;
use lib\content\Page;

$pageInfos = array(
  'name' => 'Activités',
  'url' => '/?page=activities'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

$activities = Activity::Activities();

?>
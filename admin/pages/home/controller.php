<?php

use lib\content\Page;
use lib\activities\Activity;

$pageInfos = array(
  'name' => 'Administration',
  'url' => '/'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array());

$activities = Activity::countActivities();


?>
<?php

use lib\activities\Activity;
use lib\content\Page;

$pageInfos = array(
  'name' => 'Activités',
  'url' => '/activites.html'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));


  $activities = Activity::ActiveActivities();

?>
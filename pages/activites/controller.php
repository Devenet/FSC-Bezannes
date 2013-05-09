<?php

use lib\activities\Activity;
use lib\content\Page;

$pageInfos = array(
  'name' => 'Activités',
  'url' => _FSC_.'/activites'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));


  $activities = Activity::ActiveActivities();

?>
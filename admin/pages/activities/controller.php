<?php

use lib\activities\Activity;
use lib\content\Page;

$pageInfos = array(
  'name' => 'Activités',
  'url' => '/?page=activities'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

if (isset($_GET['sort'])) {
  $data = explode('-', htmlspecialchars($_GET['sort']));
  $sens = isset($data[1]) && $data[1] == 'desc' ? false : true;
  switch($data[0]) {
    case 'name':
      $activities = Activity::ActivitiesByName($sens);
      break;
    case 'active':
      $activities = Activity::ActivitiesByActive($sens);
      break;
    case 'price':
      $activities = Activity::ActivitiesByPrice($sens);
      break;
    default:
      $activities = Activity::Activities();
  }
}
else {
  $activities = Activity::Activities();
}

?>
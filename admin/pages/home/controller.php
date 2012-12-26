<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\members\Member;

$pageInfos = array(
  'name' => 'Administration',
  'url' => '/'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array());

$activities = Activity::countActivities();
$plural_activities = ($activities > 1 ? 's' : null);

$members = Member::countMembers();
$plural_members = ($members > 1 ? 's' : null);

?>
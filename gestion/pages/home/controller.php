<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\members\Member;
use lib\users\UserAdmin;
use lib\content\Display;

$pageInfos = array(
  'name' => 'Administration',
  'url' => '/'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array());

$activities = Activity::countActivities();
$plural_activities = ($activities > 1 ? 's' : null);

$active_activities = Activity::countActiveActivities();
$plural_active_activities = ($active_activities > 1 ? 's' : null);

$members = Member::countMembers();
$plural_members = ($members > 1 ? 's' : null);

$adherents = Member::countAdherents();
$plural_adherents = ($adherents > 1 ? 's' : null);

?>
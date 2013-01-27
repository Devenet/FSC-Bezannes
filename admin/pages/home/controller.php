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

$configs = array ('_FSC_', '_ADMIN_', '_INSCRIPTION_', '_ANALYTICS_FSC_', '_ANALYTICS_ADMIN_', '_ANALYTICS_INSCRIPTION_', '_JQUERY_', '_YEAR_', '_SEARCH_ENGINE_', '_PHONE_SEC_');
$display_constants = '';
foreach ($configs as $c)
    $display_constants .= '<tr style="font-family: monospace;"><td><code>'. $c .'</code></td><td>'. (is_bool(constant($c)) ? (constant($c) ? '<span style="color:rgb(70, 136, 71);">true</span>' : '<span style="color:rgb(185, 74, 72);">false</span>') : constant($c)) .'</td></tr>';

$history = UserAdmin::getHistory();
$display_history = '<tbody>';
foreach ($history as $data) 
  $display_history .= '<tr><td>' . Display::FullTimestampDate($data['date']) . '</td><td>'. Display::FullTimestampHour($data['date']) .'</td><td>'. $data['name'] . ' <span class="pull-right"><a href="mailto:'. $data['email'] .'" title="Envoyer un courriel"><i class="icon-envelope"></i></a></span></td><td><code>'. Display::Privilege($data['privilege']) .'</code></td><td>'. $data['ip'] . '</td></tr>';
$display_history .= '</tbody>';

?>
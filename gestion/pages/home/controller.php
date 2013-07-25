<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\members\Member;
use lib\users\UserAdmin;
use lib\content\Display;
use lib\preinscriptions\Preinscription;

$pageInfos = array(
  'name' => 'Dashboard',
  'url' => _GESTION_
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

$activities = Activity::countActivities();
$plural_activities = ($activities > 1 ? 's' : NULL);

$active_activities = Activity::countActiveActivities();
$plural_active_activities = ($active_activities > 1 ? 's' : NULL);

$members = Member::countMembers();
$plural_members = ($members > 1 ? 's' : NULL);

$adherents = Member::countAdherents();
$plural_adherents = ($adherents > 1 ? 's' : NULL);

$inscription_accounts = Preinscription::countAccounts();
$plural_PREINSCRIPTION_accounts = ($inscription_accounts > 1 ? 's' : NULL);

$inscriptions = Preinscription::countPreinscriptions();
$plural_inscriptions = ($inscriptions > 1 ? 's' : NULL);

$inscription_adherents = Preinscription::countAdherents();
$plural_PREINSCRIPTION_adherents = ($inscription_adherents > 1 ? 's' : NULL);

?>
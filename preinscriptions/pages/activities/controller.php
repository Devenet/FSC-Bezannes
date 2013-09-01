<?php

use lib\activities\Activity;
use lib\content\Page;
use lib\payments\Price;

$pageInfos = array(
	'name' => 'Activités',
	'url' => _PREINSCRIPTION_.'/activities'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));


$activities = Activity::ActiveActivities();
$prices = new Price();


?>
<?php

use lib\content\Page;
use lib\content\Display;
use lib\db\SQL;

$pageInfos = array(
	'name' => 'Configuration',
	'url' => '/?page=configuration'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

$configs = array (
	'_SEARCH_ENGINE_',
	'_YEAR_',
	'_PHONE_SEC_',
	'_EMAIL_',
	'_FSC_',
	'_GESTION_',
	'_PREINSCRIPTION_',
	'_PREINSCRIPTION_ENABLED_',
	'_ANALYTICS_FSC_',
	'_ANALYTICS_GESTION_',
	'_ANALYTICS_PREINSCRIPTION_',
	'_PATH_PUBLIC_',
	'_PATH_GESTION_',
	'_PATH_PREINSCRIPTION_',
	'_PATH_UPLOADS_',
	'_PATH_UPLOADS_FULL_',
	'_PATH_API_',
	'_STATIC_',
	'_UPLOADS_',
	'_PUBLIC_API_',
	'_PRIVATE_API_',
);
$display_constants = '';
foreach ($configs as $c)
		$display_constants .= '<tr style="font-family: monospace;"><td><code>'. $c .'</code></td><td>'. (is_bool(constant($c)) ? (constant($c) ? '<span style="color:rgb(70, 136, 71);">true</span>' : '<span style="color:rgb(185, 74, 72);">false</span>') : constant($c)) .'</td></tr>';

$bases = array(
	'activities',
	'history_admin', 
	'members',
	'members_inscription',
	'participants', 
	'participants_inscription', 
	'payments_advantages', 
	'payments_transactions', 
	'referents',
	'schedules', 
	'users_admin', 
	'users_inscription', 
	'users_recover_passwords'
);
$display_db = '';
foreach ($bases as $db) {
	$display_db .= '<tr><td>fsc_<strong>'. $db .'</strong></td><td class="center">';
	$query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_'.$db);
	$data = $query->fetch();
	$display_db .= $data['total']. '</td></tr>';
}

?>
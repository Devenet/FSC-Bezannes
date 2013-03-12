<?php

use lib\content\Page;
use lib\users\UserAdmin;
use lib\content\Display;

$pageInfos = array(
  'name' => 'Historique',
  'url' => '/?page=history'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

$history = UserAdmin::getHistory();
$display_history = '<tbody>';
foreach ($history as $data) 
  $display_history .= '<tr><td>' . Display::FullTimestampDate($data['date']) . '</td><td>'. Display::FullTimestampHour($data['date']) .'</td><td>'. $data['name'] . ' <span class="pull-right"><a href="mailto:'. $data['login'] .'" title="Envoyer un courriel"><i class="icon-envelope"></i></a></span></td><td><code>'. Display::Privilege($data['privilege']) .'</code></td><td>'. $data['ip'] . '</td></tr>';
$display_history .= '</tbody>';


?>
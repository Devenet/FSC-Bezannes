<?php

use lib\content\Page;
use lib\users\UserAdmin;
use lib\content\Display;
use lib\content\Pagination;

$pageInfos = array(
  'name' => 'Historique',
  'url' => _GESTION_.'/?page=history'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

// set actual page
$pages = ceil(UserAdmin::countHistory() / Pagination::step());
$browse = 1;
if (isset($_GET['browse']) && $_GET['browse'] != NULL)
  $browse = min($pages, max(1, $_GET['browse']+0));

$history = UserAdmin::getHistory(($browse-1) * Pagination::step());
$display_history = '<tbody>';
foreach ($history as $data) 
  $display_history .= '<tr><td>' . Display::FullTimestampDate($data['date']) . '</td><td>'. Display::FullTimestampHour($data['date']) .'</td><td>'. $data['name'] . ' <span class="pull-right"><a href="mailto:'. $data['login'] .'" title="Envoyer un courriel" class="normal"><i class="icon-envelope-alt"></i></a></span></td><td><code>'. Display::Privilege($data['privilege']) .'</code></td><td>'. $data['ip'] . '</td></tr>';
$display_history .= '</tbody>';

// pagination
$display_pagination = '<li '. ($browse == 1 ? ' class="disabled"><span>' : '><a href="./?page=history">') .'<i class="icon-double-angle-left"></i>'. ($browse == 1 ? '</span>' : '</a>') .'</li>' ;
for ($i = 1; $i <= $pages; $i++) {
  $display_pagination .= '
  <li '. ($i != $browse ?: ' class="active"') .'><a href="./?page=history'. ($i != 1 ? '&amp;browse='. $i : '') .'">'. $i .'</a></li>
  ';
}
$display_pagination .= '<li '. ($browse == $pages ? ' class="disabled"><span>' : '><a href="./?page=history&browse='. $pages .'">') .'<i class="icon-double-angle-right"></i>'. ($browse == $pages ? '</span>' : '</a>') .'</li>' ;


?>
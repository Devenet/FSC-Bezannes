<?php

use lib\content\Page;
use lib\users\UserAdmin;
use lib\content\Display;

$pageInfos = array(
  'name' => 'Configuration',
  'url' => '/?page=configuration'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

$configs = array (
  '_PATH_GESTION_',
  '_PATH_ADMIN_',
  '_PATH_INSCRIPTION_',
  '_PATH_UPLOADS_',
  '_PATH_API_',
  '_SEARCH_ENGINE_',
  '_YEAR_',
  '_PHONE_SEC_',
  '_EMAIL_',
  '_FSC_',
  '_GESTION_',
  '_ADMIN_',
  '_INSCRIPTION_',
  '_ANALYTICS_FSC_',
  '_ANALYTICS_GESTION_',
  '_ANALYTICS_INSCRIPTION_',
  '_JQUERY_',
  '_ASSETS_',
  '_PUBLIC_API_',
  '_PRIVATE_API_',
);
$display_constants = '';
foreach ($configs as $c)
    $display_constants .= '<tr style="font-family: monospace;"><td><code>'. $c .'</code></td><td>'. (is_bool(constant($c)) ? (constant($c) ? '<span style="color:rgb(70, 136, 71);">true</span>' : '<span style="color:rgb(185, 74, 72);">false</span>') : constant($c)) .'</td></tr>';

?>
<?php

use lib\content\Page;
use lib\content\Message;

$pageInfos = array(
  'name' => 'Préinscriptions désactivées',
  'url' => ''
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

$page->addOption('no-title');
$page->addOption('no-breadcrumb');

// we get informations file if exists
$file = dirname(__FILE__).'/'.'data.disabled';
$content = file_get_contents($file);

if ($content !== FALSE && !empty($content)) {
  $display_more = nl2br($content, TRUE);
}

?>
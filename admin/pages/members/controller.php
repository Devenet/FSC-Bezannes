<?php

use lib\members\Member;
use lib\content\Page;

$pageInfos = array(
  'name' => 'Membres',
  'url' => '/?page=members'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

$members = Member::Members();

?>
<?php

use lib\members\Member;
use lib\content\Page;

$pageInfos = array(
  'name' => 'Membres',
  'url' => '/?page=members'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

if (isset($_GET['sort'])) {
  $data = explode('-', htmlspecialchars($_GET['sort']));
  $sens = isset($data[1]) && $data[1] == 'desc' ? false : true;
  switch($data[0]) {
    case 'name':
      $members = Member::MembersByName($sens);
      break;
    case 'adherent':
      $members = Member::MembersByAdherent($sens);
      break;
    case 'bezannais':
      $members = Member::MembersByBezannais($sens);
      break;
    case 'adult':
      $members = Member::MembersByAdult($sens);
      break;
    default:
      $members = Member::Members();
  }
}
else {
  $members = Member::Members();
}

?>
<?php

use lib\content\Page;
use lib\users\UserInscription;
use lib\preinscriptions\Preinscription;
use lib\preinscriptions\Member;
use lib\content\Message;
use lib\content\Display;

function quit() {
  header('Location: '. _GESTION_ .'/?page=preinscriptions');
  exit();
}

if (isset($_GET['id']) && Member::isMember($_GET['id']+0)) {
  
  $pre = new Member($_GET['id']+0);
  $account = new UserInscription($pre->id_user_inscription());
    
  $pageInfos = array(
   'name' => $pre->name(),
   'url' => _GESTION_.'/?page=preinscriptions'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], 
    array(
      array('name' => 'Préinscriptions', 'url' => '?page=preinscriptions'),
      array('name' => $account->login(), 'url' => '?page=preinscriptions&amp;detail='.$account->id()),
      $pageInfos)
  );

  
}
else {
  quit();
}

?>
<?php

use lib\content\Page;
use lib\users\UserInscription;
use lib\preinscriptions\Preinscription;
use lib\preinscriptions\Member;
use lib\preinscriptions\Participant;
use lib\content\Message;
use lib\content\Display;
use lib\activities\Activity;
use lib\activities\Schedule;

function quit() {
  header('Location: '. _GESTION_ .'/?page=preinscriptions');
  exit();
}

if (isset($_GET['id']) && Member::isMember($_GET['id']+0)) {
  
  $pre = new Member($_GET['id']+0);
  $account = new UserInscription($pre->id_user_inscription());
  if ($pre->minor())
    $respo = new Member($pre->responsible());

  // if minor, chech that the responsible's preinscription is already validated
  if ($pre->minor() && $respo->status() != Preinscription::VALIDATED) {
    // responsible already in database but have no preinscription done, so accept this minor
    if (!isset($_GET['forced'])) {
      $_SESSION['msg'] = new Message('La préinscription du responsable légal n’a pas encore été validée !<br /><a href="?page=validate-preinscription&amp;id='.$pre->id().'&forced">Forcer la préinscription</a>', -1, 'Validation impossible', FALSE);
      header('Location: '. _GESTION_ .'/?page=preinscription&id='.$pre->id());
      exit();
    }
  }
    
  $pageInfos = array(
   'name' => 'Validation d’une préinscription',
   'url' => _GESTION_.'/?page=preinscriptions'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], 
    array(
      array('name' => 'Préinscriptions', 'url' => '?page=preinscriptions'),
      array('name' => $account->login(), 'url' => '?page=preinscriptions&amp;account='.$account->id()),
      array('name' => $pre->name(), 'url' => '?page=Preinscription&amp;id='.$pre->id()),
      $pageInfos)
  );


  
}
else {
  quit();
}

?>
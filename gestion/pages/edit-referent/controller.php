<?php

use lib\members\Referent;
use lib\activities\Activity;
use lib\content\Message;

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && Referent::isReferent($_GET['id']+0)) {
  $r = new Referent($_GET['id']+0);
  $act = new Activity($r->activity());
  
  if (!$act->active()) {
    $r->delete(true);
    $_SESSION['msg'] = new Message('Le référent a bien été supprimé !', 1, 'Suppression réussie');
    header ('Location: '. _GESTION_ .'/?page=activity&id='.$act->id().'#referents');
    exit();
  }
  elseif (Referent::countReferents($act->id()) > 1) {
    $r->delete(true);
    $_SESSION['msg'] = new Message('Le référent a bien été supprimé !', 1, 'Suppression réussie');
    header ('Location: '. _GESTION_ .'/?page=activity&id='.$act->id().'#referents');
    exit();
  }
  else {
    $_SESSION['msg'] = new Message('Le référent ne peut pas être supprimé car l’activité est activée !', -1, 'Suppression impossible');
    header ('Location: '. _GESTION_ .'/?page=activity&id='.$act->id().'#referents');
    exit();
  }
  
}
else {
  header ('Location: '. _GESTION_ .'/?page=members');
  exit();
}

?>
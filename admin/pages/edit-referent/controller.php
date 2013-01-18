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
    header ('Location: /?page=activity&id='.$act->id());
    exit();
  }
  elseif (Referent::countReferents($act->id()) > 1) {
    $r->delete(true);
    $_SESSION['msg'] = new Message('Le référent a bien été supprimé !', 1, 'Suppression réussie');
    header ('Location: /?page=activity&id='.$act->id());
    exit();
  }
  else {
    $_SESSION['msg'] = new Message('Le référent ne peut pas être supprimé car l’activité est activée !', -1, 'Suppression impossible');
    header ('Location: /?page=activity&id='.$act->id());
    exit();
  }
  
}
else {
  header ('Location: /?page=members');
  exit();
}

?>
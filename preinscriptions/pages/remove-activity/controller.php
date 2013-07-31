<?php

use lib\preinscriptions\FutureParticipant;
use lib\preinscriptions\Preinscription;
use lib\content\Message;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  if (isset($_GET['rel']) && FutureParticipant::isParticipant($_GET['rel']+0)) {
    $p = new FutureParticipant($_GET['rel']+0);
    $member = new Preinscription($p->adherent());
    
    if ($member->status() == Preinscription::AWAITING) {
      $p->delete(true);
      $_SESSION['msg'] = new Message('Le membre a bien été désinscrit de l’activité', 1, 'Suppression réussie');
      header ('Location: '. _PREINSCRIPTION_ .'/preinscription/'.$member->id());
      exit();
    }
    else {
      $_SESSION['msg'] = new Message('La préinscription du membre ayant été validée, il n’est plus possible de supprimer une préinscription à une activité.', -1, 'Suppression impossible');
      header ('Location: '. _PREINSCRIPTION_ .'/preinscription/'.$member->id());
      exit(); 
    }
  }
  else {
    header ('Location: '. _PREINSCRIPTION_ .'/list');
    exit();
  }

}
else {
  header ('Location: '. _PREINSCRIPTION_ .'/login');
  exit();
}
?>
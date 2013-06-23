<?php

use lib\members\Participant;
use lib\content\Message;

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && Participant::isParticipant($_GET['id']+0)) {
  $p = new Participant($_GET['id']+0);
  $member = $p->adherent();
  $p->delete(true);
  $_SESSION['msg'] = new Message('Le membre a bien été désinscrit de l’activité', 1, 'Suppression réussie');
  header ('Location: '. _GESTION_ .'/?page=member&id='.$member.'#activities');
  exit();
}
else {
  header ('Location: '. _GESTION_ .'/?page=members');
  exit();
}

?>
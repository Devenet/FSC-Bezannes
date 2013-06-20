<?php

use lib\inscription\Participant;
use lib\content\Message;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  if (isset($_GET['rel']) && Participant::isParticipant($_GET['rel']+0)) {
    $p = new Participant($_GET['rel']+0);
    $member = $p->adherent();
    $p->delete(true);
    $_SESSION['msg'] = new Message('Le membre a bien été désinscrit de l’activité', 1, 'Suppression réussie');
    header ('Location: /preinscription/'.$member);
    exit();
  }
  else {
    header ('Location: /account');
    exit();
  }

}
else {
  header ('Location: /login');
  exit();
}
?>
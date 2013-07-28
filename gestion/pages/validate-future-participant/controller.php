<?php

use lib\content\Message;
use lib\preinscriptions\Preinscription;
use lib\preinscriptions\FutureParticipant;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\members\Participant;

if (isset($_GET['id']) && FutureParticipant::isParticipant($_GET['id']+0)) {
  
  $fp = new FutureParticipant($_GET['id']+0);
  $pre = new Preinscription($fp->adherent());

  function quit() {
    global $pre;
    header('Location: '. _GESTION_ .'/?page=preinscription&id='.$pre->id());
    exit();
  }

  // check if participant is validated
  if ($pre->id_member() == NULL) {
    $_SESSION['msg'] = new Message('La validation du membre doit d’abord être effectuée !', -1, 'Validation impossible');
    quit();
  }
  
  // check that the participant was not yet validated
  if ($fp->status() != Preinscription::AWAITING) {
    $_SESSION['msg'] = new Message('L’activité a déjà été validée pour le membre', -1, 'Validation impossible');
    quit();
  }

  // delete a future participant
  if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $fp->delete(true);
    $pre->checkStatus();
    $_SESSION['msg'] = new Message('La préinscription pour l’activité a bien été supprimée', 1, 'Suppression réussie');
    quit();
  }

  // validate a activity preinscription
  try {

    $p = new Participant();
    $p->setAdherent($pre->id_member());
                
    if (!Activity::isActiveActivity($fp->activity()))
      throw new \Exception('Cette activité n’est pas activée');
    if (!$p->setActivity($fp->activity()))
    throw new \Exception('Impossible d’ajouter l’activité choisie');

    // activite libre
    if ($fp->schedule() != NULL) {
      if (!$p->setSchedule($fp->schedule()))
        throw new \Exception('L’horaire choisi n’est pas valide');
    }

    if (!$p->couldCreated())
      throw new \Exception('Le membre participe déjà à cette activité');
    if(!$p->create())
      throw new \Exception('Impossible d’ajouter le participant');

    // update status
    $fp->setStatus(Preinscription::VALIDATED);
    $pre->checkStatus();

    // activity well added
    $_SESSION['msg'] = new Message('La préinscription de l’activité bien été validée <i class="icon-smile"></i>', 1, 'Validation réussie !');
    quit();
        
  }
  catch (\Exception $e) {
    $_SESSION['msg'] = new Message($e->getMessage(), -1, 'Validation impossible !', FALSE);
    quit();
  }

  
}
else {
  quit();
}

?>
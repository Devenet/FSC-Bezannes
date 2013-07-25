<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\preinscriptions\Preinscription;
use lib\preinscriptions\Member;
use lib\preinscriptions\Participant;
use lib\content\Message;
use lib\content\Form;
use lib\content\Display;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  if (isset($_GET['rel']) && Member::isAdherent($_GET['rel']+0, $_SESSION['user']->id())) {
    
    $a = new Member($_GET['rel']+0);

    // check status of the preinscription
    if ($a->status() != Preinscription::AWAITING) {
      $_SESSION['msg'] = new Message('Une préinscription validée ne permet plus d’y ajouter de nouvelles activités', -1, 'Opération impossible');
      header('Location: '. _PREINSCRIPTION_ .'/list');
      exit();
    }


    $pageInfos = array(
     'name' => 'Ajout d’une activité',
     'url' => _PREINSCRIPTION_.'/add-activity/'. $a->id()
    );
    $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => $a->name(), 'url' => _PREINSCRIPTION_.'/preinscription/'.$a->id()), $pageInfos));
    
    $form = new Form('add-activity', _PREINSCRIPTION_ .'/add-activity/'.$a->id(), 'Ajouter', 'Sélection d’une activité pour '.$a->name());
    
    if (isset($_GET['activity']) && Activity::isActivity($_GET['activity']+0)) {
      $act = new Activity($_GET['activity']+0);
      foreach (Schedule::Schedules($act->id()) as $schedule) {
        if ($schedule->description() != NULL)
          $form->addRadio('activity', '<strong>'.$act->name().'</strong><br /> '.$schedule->description(), $act->id().'-'.$schedule->id());
        else
          $form->addRadio('activity', '<strong>'.$act->name().'</strong><br /> '.Display::Day($schedule->day()).' <i class="icon-caret-right"></i> '. $schedule->time_begin() .' à '. $schedule->time_end() . ($schedule->more() != NULL ? '&nbsp; &nbsp;('.$schedule->more().')' : ''), $act->id().'-'.$schedule->id());
      }
    }
    else {
      foreach (Activity::ActiveActivities() as $act) {
        if ($act->aggregate())
          $form->addRadio('activity', '<strong>'.$act->name().'</strong>', $act->id());
        else {
          foreach (Schedule::Schedules($act->id()) as $schedule) {
            if ($schedule->description() != NULL)
              $form->addRadio('activity', '<strong>'.$act->name().'</strong><br /> '.$schedule->description(), $act->id().'-'.$schedule->id());
            else
              $form->addRadio('activity', '<strong>'.$act->name().'</strong><br /> '.Display::Day($schedule->day()).' <i class="icon-caret-right"></i> '. $schedule->time_begin() .' à '. $schedule->time_end() . ($schedule->more() != NULL ? '&nbsp; &nbsp;('.$schedule->more().')' : ''), $act->id().'-'.$schedule->id());
          }
        }
      }
    }
      
    // controle formulaire
    if (isset($_POST) and $_POST != NULL) {
      $form->add('activity', (isset($_POST['activity']) ? htmlspecialchars($_POST['activity']) : NULL));
      
      $p = new Participant();
      $p->setAdherent($a->id());
      
      $data = explode('-', htmlspecialchars($_POST['activity']));
      
      try {
        
        if (!Activity::isActiveActivity($data[0]))
          throw new \Exception('Cette activité n’est pas activée');
        if (!$p->setActivity($data[0]))
        throw new \Exception('Impossible d’ajouter l’activité choisie');
        
        // activite libre
        if (isset($data[1])) {
          if (!$p->setSchedule($data[1]))
            throw new \Exception('L’horaire choisi n’est pas valide');
        }
        
        if (!$p->couldCreated())
          throw new \Exception('Le membre participe déjà à cette activité');
        if(!$p->create())
          throw new \Exception('Impossible d’ajouter le participant');
        
        $_SESSION['msg'] = new Message('<em>'. $a->name() .'</em> est maintenant inscrit à l’activité :)', 1, 'Ajout réussi !');
        header ('Location: '. _PREINSCRIPTION_ .'/preinscription/'. $a->id());
        exit();
        
      }
      catch (\Exception $e) {
        $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Erreur !', false);
      }
      
    }
  }
  else {
    header('Location: '. _PREINSCRIPTION_ .'/list');
    exit();
  }

}
else {
  header ('Location: '. _PREINSCRIPTION_ .'/login');
  exit();
}

?>
<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\inscription\Member;
use lib\inscription\Participant;
use lib\content\Message;
use lib\content\Form;
use lib\content\Display;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  if (isset($_GET['rel']) && Member::isAdherent($_GET['rel']+0, $_SESSION['user']->id())) {
    
    $a = new Member($_GET['rel']+0);

    $pageInfos = array(
     'name' => 'Ajout d’une activité',
     'url' => _INSCRIPTION_.'/add-activity/'. $a->id()
    );
    $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => $a->name(), 'url' => _INSCRIPTION_.'/preinscription/'.$a->id()), $pageInfos));
    
    $form = new Form('add-activity', _INSCRIPTION_ .'/add-activity/'.$a->id(), 'Ajouter', 'Sélection d’une activité pour '.$a->name());
    
    if (isset($_GET['activity']) && Activity::isActivity($_GET['activity']+0)) {
      $act = new Activity($_GET['activity']+0);
      foreach (Schedule::Schedules($act->id()) as $schedule) {
        if ($schedule->description() != null)
          $form->addRadio('activity', $act->name().'&nbsp; &nbsp;<i class="icon-time"></i> '.$schedule->description(), $act->id().'-'.$schedule->id());
        else
          $form->addRadio('activity', $act->name().'&nbsp; &nbsp;<i class="icon-time"></i> '.Display::Day($schedule->day()).' &rsaquo; '. $schedule->time_begin() .' à '. $schedule->time_end() . ($schedule->more() != null ? '&nbsp; &nbsp;('.$schedule->more().')' : ''), $act->id().'-'.$schedule->id());
      }
    }
    else {
      foreach (Activity::ActiveActivities() as $act) {
        if ($act->aggregate())
          $form->addRadio('activity', $act->name(), $act->id());
        else {
          foreach (Schedule::Schedules($act->id()) as $schedule) {
            if ($schedule->description() != null)
              $form->addRadio('activity', $act->name().'&nbsp; &nbsp;<i class="icon-time"></i> '.$schedule->description(), $act->id().'-'.$schedule->id());
            else
              $form->addRadio('activity', $act->name().'&nbsp; &nbsp;<i class="icon-time"></i> '.Display::Day($schedule->day()).' &rsaquo; '. $schedule->time_begin() .' à '. $schedule->time_end() . ($schedule->more() != null ? '&nbsp; &nbsp;('.$schedule->more().')' : ''), $act->id().'-'.$schedule->id());
          }
        }
      }
    }
      
    // controle formulaire
    if (isset($_POST) and $_POST != null) {
      $form->add('activity', (isset($_POST['activity']) ? htmlspecialchars($_POST['activity']) : null));
      
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
        
        $_SESSION['msg'] = new Message('Le membre <em>'. $a->name() .'</em> est maintenant inscrit à l’activité :)', 1, 'Ajout réussi !');
        header ('Location: '. _INSCRIPTION_ .'/preinscription/'. $a->id());
        exit();
        
      }
      catch (\Exception $e) {
        $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Erreur !');
      }
      
    }
  }
  else {
    header('Location: '. _INSCRIPTION_ .'/list');
    exit();
  }

}
else {
  header ('Location: '. _INSCRIPTION_ .'/login');
  exit();
}

?>
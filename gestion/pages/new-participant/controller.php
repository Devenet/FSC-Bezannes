<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\members\Member;
use lib\members\Participant;
use lib\content\Message;
use lib\content\Form;
use lib\content\Display;

// choix d'une activité pour un membre
if (isset($_GET['adherent']) && Member::isAdherent($_GET['adherent']+0)) {
  
  $a = new Member($_GET['adherent']+0);

  $pageInfos = array(
   'name' => 'Ajout d’une activité',
   'url' => _GESTION_.'/?page=members'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Membres', 'url' => '?page=members'), array('name' => $a->name(), 'url' => '/?page=member&amp;id='.$a->id()), $pageInfos));
  
  $form = new Form('add-activity', './?page=new-participant&amp;adherent='.$a->id(), 'Ajouter', 'Sélection d’une activité pour '.$a->name());
  
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
      header ('Location: '. _GESTION_ .'/?page=member&id='. $a->id() .'#activities');
      exit();
      
    }
    catch (\Exception $e) {
      $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Erreur !');
    }
    
  }
}
// choix d'un participant pour une activité
elseif (isset($_GET['activity']) && Activity::isActivity($_GET['activity']+0)) {
  $a = new Activity($_GET['activity']+0);

  $pageInfos = array(
   'name' => 'Ajout d’un participant',
   'url' => _GESTION_.'/?page=activities'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Activités', 'url' => '?page=activities'), array('name' => $a->name(), 'url' => '/?page=activity&amp;id='.$a->id()), $pageInfos));
  
  $form = new Form('add-adherent', './?page=new-participant&amp;activity='.$a->id(), 'Ajouter', 'Sélection d’un participant pour '.$a->name());
  foreach (Member::Adherents() as $m)
    $form->addOption('adherent', $m->name(), $m->id());
    
  // controle formulaire
  if (isset($_POST) and $_POST != null) {
    $form->add('adherent', (isset($_POST['adherent']) ? htmlspecialchars($_POST['adherent']) : null));
    
    $p = new Participant();
    $p->setActivity($a->id());
    
    try {
      
      if (!Member::isAdherent(htmlspecialchars($_POST['adherent'])))
        throw new \Exception('Ce membre n’est pas adhérent');
      if (!$p->setAdherent(htmlspecialchars($_POST['adherent'])))
      throw new \Exception('Impossible d’ajouter l’adhérent choisi');
            
      if (!$p->couldCreated())
        throw new \Exception('Le membre participe déjà à cette activité');
      
      if ($a->aggregate()) {
        
        $p->create();
        
        $m = new Member($p->adherent());
        $_SESSION['msg'] = new Message('Le membre <em>'. $m->name() .'</em> est maintenant inscrit à l’activité :)', 1, 'Ajout réussi !');
        header ('Location: '. _GESTION_ .'/?page=activity&id='. $a->id().'#participants');
        exit();
      }
      
      header ('Location: '. _GESTION_ .'/?page=new-participant&adherent='. $p->adherent().'&activity='.$a->id());
      exit();
      
    }
    catch (\Exception $e) {
      $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Erreur !');
    }
    
  }
}
else {
  header('Location: '. _GESTION_ .'./?page=members');
  exit();
}
?>
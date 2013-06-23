<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\content\Message;
use lib\content\Form;

if (isset($_GET['id']) && Schedule::isSchedule($_GET['id']+0)) {
  
  $s = new Schedule($_GET['id']+0);
  $act = new Activity($s->activity());
  
  // suppression
  if (isset($_GET['action']) && $_GET['action'] == 'delete') {    
    if (!$act->active()) {
      $s->delete(true);
      $_SESSION['msg'] = new Message('L’horaire a bien été supprimé !', 1, 'Suppression réussie');
      header ('Location: '. _GESTION_ .'/?page=activity&id='.$act->id().'#schedules');
      exit();
    }
    elseif (Schedule::countSchedules($act->id()) > 1) {
      $s->delete(true);
      $_SESSION['msg'] = new Message('L’horaire a bien été supprimé !', 1, 'Suppression réussie');
      header ('Location: '. _GESTION_ .'/?page=activity&id='.$act->id().'#schedules');
      exit();
    }
    else {
      $_SESSION['msg'] = new Message('L’horaire ne peut pas être supprimé car l’activité est activée !', -1, 'Suppression impossible');
      header ('Location: '. _GESTION_ .'/?page=activity&id='.$act->id());
      exit();
    }
  }
  
  $pageInfos = array(
   'name' => 'Modifier un horaire',
   'url' => '/?page=activities'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Activités', 'url' => '?page=activities'), array('name' => $act->name(), 'url' => '?page=activity&id='. $act->id()), $pageInfos));
  
  $form = new Form('edit-schedule', './?page=edit-schedule&amp;id='. $s->id(), 'Modifier', 'Modifier l’horaire');
  
  $inputs = array(
    'day',
    'time_begin_hour',
    'time_begin_minute',
    'time_end_hour',
    'time_end_minute',
    'more',
    'description',
    'type'
  );
  foreach ($inputs as $input)
    $form->add($input, $s->$input());
  
  // controle formulaire
  if (isset($_POST) and $_POST != null) {
    foreach ($inputs as $input)
      $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));
    
    $s->setActivity($act->id());
    
    try {
      
      // horaire journalier
      if ($_POST['description'] == null) {
        $s->setType();
        
        if (!$s->setDay($_POST['day']))
          throw new \Exception('Merci de sélectionner un jour');
        if (!$s->setTimeBegin($_POST['time_begin_hour'], $_POST['time_begin_minute']))
          throw new \Exception('Merci de préciser l’heure de début');
        if (!$s->setTimeEnd($_POST['time_end_hour'], $_POST['time_end_minute']))
          throw new \Exception('Merci de préciser l’heure de fin');
        if (!$s->setMore(stripslashes($_POST['more'])))
          throw new \Exception('Merci d’indiquer des informations complémentaires valides');
        
      }
      // horaire libre
      else {
        $s->setType(1);
        
        if (!$s->setDescription(stripslashes($_POST['description'])))
          throw new \Exception('Merci d’indiquer une description valide');
        
      }
      
      $s->update();
      
      $_SESSION['msg'] = new Message('L’horaire a bien été modifié :)', 1, 'Modification réussie !');
      header ('Location: '. _GESTION_ .'/?page=activity&id='. $act->id().'#schedules');
      exit();
      
    }
    catch (\Exception $e) {
      $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Formulaire incomplet !');
    }
    
  }
  
}
else {
  header ('Location: '. _GESTION_ .'/?page=activities');
  exit();
}

?>
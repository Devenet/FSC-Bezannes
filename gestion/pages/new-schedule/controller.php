<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\content\Message;
use lib\content\Form;

if (isset($_GET['activity']) && Activity::isActivity($_GET['activity']+0)) {
  
  $act = new Activity($_GET['activity']+0);
  
  $pageInfos = array(
   'name' => 'Nouvel horaire',
   'url' => _GESTION_.'/?page=activities'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Activités', 'url' => '?page=activities'), array('name' => $act->name(), 'url' => '?page=activity&id='. $act->id()), $pageInfos));
  
  $form = new Form('new-schedule', './?page=new-schedule&amp;activity='. $act->id(), 'Ajouter', 'Nouvel horaire');
  
  // controle formulaire
  if (isset($_POST) and $_POST != null) {
    $inputs = array(
      'day',
      'time_begin_hour',
      'time_begin_minute',
      'time_end_hour',
      'time_end_minute',
      'more',
      'description'
    );
    foreach ($inputs as $input)
      $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));
    
    $s = new Schedule();
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
      
      $s->create();
      
      $_SESSION['msg'] = new Message('L’horaire a bien été créé :)', 1, 'Ajout réussi !');
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
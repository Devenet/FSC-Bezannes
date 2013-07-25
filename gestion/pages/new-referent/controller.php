<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\members\Member;
use lib\members\Referent;
use lib\content\Message;
use lib\content\Form;

// choix referent pour activity
if (isset($_GET['activity']) && Activity::isActivity($_GET['activity']+0)) {
  
  $act = new Activity($_GET['activity']+0);

  $pageInfos = array(
   'name' => 'Ajout d’un référent',
   'url' => _GESTION_.'/?page=activities'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Activités', 'url' => '?page=activities'), array('name' => $act->name(), 'url' => '?page=activity&amp;id='. $act->id()), $pageInfos));
  
  $form = new Form('add-referent', './?page=new-referent&amp;activity='. $act->id(), 'Choisir', 'Référent pour <em>'. $act->name() .'</em>');
  foreach (Member::Adults() as $adherent)
    $form->addOption('member', $adherent->name(), $adherent->id());
    
  // controle formulaire
  if (isset($_POST) and $_POST != NULL) {
    $inputs = array(
      'member',
      'type',
      'display_phone'
    );
    foreach ($inputs as $input)
      $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : NULL));
  
    $r = new Referent();
    $r->setActivity($act->id());
    
    
    try {
      
      if (!$r->setMember(isset($_POST['member']) ? $_POST['member']+0 : NULL))
        throw new \Exception('Impossible d’ajouter l’adhérent sélectionné');
      if (!$r->setType($form->input('type')))
        throw new \Exception('Merci de sélectionner le type de référent');
      if (!$r->setDisplayPhone((isset($_POST['display_phone']) ? 1 : 0)))
        throw new \Exception('Impossible d’afficher le téléphone du référent');
      
      $r->create();
      $m = new Member($r->member());
      
      $_SESSION['msg'] = new Message('Le référent <em>'. $m->name() .'</em> a bien été ajouté :)', 1, 'Ajout réussi !');
      header ('Location: '. _GESTION_ .'/?page=activity&id='. $act->id().'#referents');
      exit();
      
    }
    catch (\Exception $e) {
      $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Formulaire incomplet !');
    }
    
  }

}
else {
  header('Location: '. _GESTION_ .'/?page=activities');
  exit();
}
?>
<?php

use lib\content\Page;
use lib\members\Member;
use lib\content\Message;
use lib\content\Form;

// choix respo pour new membre
if (isset($_SESSION['member']) && $_SESSION['member']->minor()) {

  $pageInfos = array(
   'name' => 'Choix du responsable',
   'url' => '/?page=new-members'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Membres', 'url' => '?page=members'), $pageInfos));
  
  $form = new Form('choose-responsible', '/?page=choose-responsible', 'Choisir', 'Représentant légal pour <strong>'. $_SESSION['member']->name() .'</strong>');
  foreach (Member::Adults() as $adult)
    $form->addOption('adulte', $adult->name(), $adult->id());
    
  // controle formulaire
  if (isset($_POST) and $_POST != null) {
    $form->add('adulte', (isset($_POST['adulte']) ? htmlspecialchars($_POST['adulte']) : null));
    
    $m = $_SESSION['member'];
    
    try {
      
      if (!$m->setResponsible($_POST['adulte']))
        throw new \Exception('Impossible d’ajouter le responsable choisi');
      
      $m->setBezannais();
      $m->create();
      unset ($_SESSION['member']);
      
      $_SESSION['msg'] = new Message('Le membre <em>'. $m->name() .'</em> a bien été créé :)', 1, 'Ajout réussi !');
      header ('Location: /?page=member&id='. $m->id());
      exit();
      
    }
    catch (\Exception $e) {
      $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Formulaire incomplet !');
    }
    
  }

}
// changement respo
elseif(isset($_GET['member']) && !Member::isAdult($_GET['member']+0)) {
  $m = new Member($_GET['member']+0);
  
  $pageInfos = array(
   'name' => 'Modification du responsable',
   'url' => '/?page=members'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Membres', 'url' => '?page=members'), array('name' => $m->name(), 'url' => '?page=member&amp;id='.$m->id()), $pageInfos));
  
  $form = new Form('choose-responsible', '/?page=choose-responsible&amp;member='.$m->id(), 'Modifier le représant légal', 'Représentant légal pour <strong>'. $m->name() .'</strong>');
  foreach (Member::Adults() as $adult)
    $form->addOption('adulte', $adult->name(), $adult->id());
  $form->add('adulte', $m->responsible());
    
  // controle formulaire
  if (isset($_POST) and $_POST != null) {
    
    $form->add('adulte', (isset($_POST['adulte']) ? htmlspecialchars($_POST['adulte']) : null));
    
    try {
      
      if (!$m->setResponsible($_POST['adulte']))
        throw new \Exception('Impossible d’ajouter le responsable choisi');
      
      $m->update();
      
      $_SESSION['msg'] = new Message('Le responsable de <em>'. $m->name() .'</em> a bien été modifié :)', 1, 'Modification réussie !');
      header ('Location: /?page=member&id='. $m->id());
      exit();
      
    }
    catch (\Exception $e) {
      $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Formulaire incomplet !');
    }
    
  }
  
}
else {
  header('Location: /?page=new-member');
  exit();
}
?>
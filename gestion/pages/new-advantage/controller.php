<?php

use lib\content\Page;
use lib\members\Member;
use lib\payments\Advantage;
use lib\content\Message;
use lib\content\Form;
use lib\content\Display;

// choix d'une activité pour un membre
if (isset($_GET['adherent']) && Member::isAdherent($_GET['adherent']+0)) {
  
  $a = new Member($_GET['adherent']+0);

  $pageInfos = array(
   'name' => 'Ajout d’un avantage',
   'url' => _GESTION_.'/?page=members'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Membres', 'url' => '?page=members'), array('name' => $a->name(), 'url' => '/?page=member&amp;id='.$a->id()), $pageInfos));
  
  $form = new Form('add-advantage', './?page=new-advantage&amp;adherent='.$a->id(), 'Ajouter', 'Ajouter un avantage pour <em>'. $a->name() .'</em>');
  
  
    
  // controle formulaire
  if (isset($_POST) and $_POST != null) {
    $inputs = array(
      'amount',
      'date_year',
      'date_month',
      'date_day',
      'description'
    );
    foreach ($inputs as $input)
      $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));
    
    $t = new Advantage();
    $t->setAdherent($a->id());
    
    try {
      
      if (!$t->setAmount($form->input('amount')))
        throw new \Exception('Merci d’indiquer un montant correct');
      
      if (!$t->setDate($form->input('date_year'), $form->input('date_month'), $form->input('date_day')))
        throw new \Exception('Merci d’indiquer une date correcte');
      
      if (!$t->setDescription($form->input('description')))
        throw new \Exception('Merci de mettre une description correcte');
      
      $t->create();
      
      $_SESSION['msg'] = new Message('L’avantage pour <em>'. $a->name() .'</em> a bien été ajouté :)', 1, 'Ajout réussi !');
      header ('Location: /?page=member&id='. $a->id().'#payments');
      exit();
      
    }
    catch (\Exception $e) {
      $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Erreur !');
    }
    
  }
}
else {
  header('Location: '. _GESTION_ .'/?page=members');
  exit();
}
?>
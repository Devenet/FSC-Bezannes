<?php

use lib\content\Page;
use lib\members\Member;
use lib\payments\Transaction;
use lib\content\Message;
use lib\content\Form;
use lib\content\Display;

// choix d'une activité pour un membre
if (isset($_GET['adherent']) && Member::isAdherent($_GET['adherent']+0)) {
  
  $a = new Member($_GET['adherent']+0);

  $pageInfos = array(
   'name' => 'Ajout d’une transaction',
   'url' => '/?page=members'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Membres', 'url' => '?page=members'), array('name' => $a->name(), 'url' => '/?page=member&amp;id='.$a->id()), $pageInfos));
  
  $form = new Form('add-transaction', './?page=new-transaction&amp;adherent='.$a->id(), 'Ajouter', 'Ajouter une transaction pour <em>'. $a->name() .'</em>');
  
  
    
  // controle formulaire
  if (isset($_POST) and $_POST != null) {
    $inputs = array(
      'amount',
      'date_year',
      'date_month',
      'date_day',
      'type',
      'note'
    );
    foreach ($inputs as $input)
      $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));
    
    $t = new Transaction();
    $t->setAdherent($a->id());
    
    try {
      
      if (!$t->setAmount($form->input('amount')))
        throw new \Exception('Merci d’indiquer un montant correct');
      
      if (!$t->setDate($form->input('date_year'), $form->input('date_month'), $form->input('date_day')))
        throw new \Exception('Merci d’indiquer une date correcte');
      
      if (!$t->setType($form->input('type')))
        throw new \Exception('Merci d’indiquer un moyen de paiement correct');
      
      if (!$t->setNote($form->input('note')))
        throw new \Exception('Merci de mettre une note correcte');
      
      $t->create();
      
      $_SESSION['msg'] = new Message('La transaction pour <em>'. $a->name() .'</em> a bien été ajoutée :)', 1, 'Ajout réussi !');
      header ('Location: '. _GESTION_ .'/?page=member&id='. $a->id().'#payments');
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
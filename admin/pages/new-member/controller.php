<?php

use lib\content\Page;
use lib\members\Member;
use lib\content\Message;
use lib\content\Form;

$pageInfos = array(
 'name' => 'Nouveau membre',
 'url' => '/?page=members'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Membres', 'url' => '?page=members'), $pageInfos));

$form = new Form('new-member', '/?page=new-member', 'Ajouter', 'Nouveau membre');

// controle formulaire
if (isset($_POST) and $_POST != null) {
  $inputs = array(
    'last_name',
    'first_name',
    'gender',
    'date_birthday_day',
    'date_birthday_month',
    'date_birthday_year'
  );
  foreach ($inputs as $input)
    $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));
  
  $m = new Member();
  
  try {
    
    if(!$m->setGender($form->input('gender')))
      throw new \Exception('Merci de présicer la civilité du nouveau membre');
    if(!$m->setLastName($form->input('last_name')))
      throw new \Exception('Merci d’indiquer le nom du nouveau membre');
    if(!$m->setFirstName($form->input('first_name')))
      throw new \Exception('Merci d’indiquer le prénom du nouveau membre');
    if(!$m->setDateBirthday($form->input('date_birthday_year'), $form->input('date_birthday_month'),  $form->input('date_birthday_day')))
      throw new \Exception('Merci de compléter la date de naissance du nouveau membre');
    
    $_SESSION['msg'] = new Message ('Ça a l’air d’avoir marché !');
    /*
    $_SESSION['msg'] = new Message('L’horaire a bien été créé :)', 1, 'Ajout réussi !');
    header ('Location: /?page=activity&id='. $act->id());
    exit();
    */
    
  }
  catch (\Exception $e) {
    $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Formulaire incomplet !');
  }
  
}
  
?>
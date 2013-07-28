<?php

use lib\content\Page;
use lib\members\Member;
use lib\content\Message;
use lib\content\Form;

$pageInfos = array(
 'name' => 'Nouveau membre',
 'url' => _GESTION_.'/?page=members'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Membres', 'url' => '?page=members'), $pageInfos));

$form = new Form('new-member', './?page=new-member', 'Ajouter', 'Nouveau membre');

// controle formulaire
if (isset($_POST) and $_POST != NULL) {
  $inputs = array(
    'last_name',
    'first_name',
    'gender',
    'date_birthday_day',
    'date_birthday_month',
    'date_birthday_year',
    'minor',
    'address_different',
    'address_number',
    'address_street',
    'address_further',
    'address_zip_code',
    'address_town',
    'phone',
    'email',
    'mobile',
    'adherent',
    'date_registration_day',
    'date_registration_month',
    'date_registration_year'
  );
  foreach ($inputs as $input)
    $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : NULL));
  
  $m = new Member();
  
  try {
    
    if (!$m->setGender($form->input('gender')))
      throw new \Exception('Merci de présicer la civilité du nouveau membre');
    if (!$m->setLastName(stripslashes($form->input('last_name'))))
      throw new \Exception('Merci d’indiquer le nom du nouveau membre');
    if (!$m->setFirstName(stripslashes($form->input('first_name'))))
      throw new \Exception('Merci d’indiquer le prénom du nouveau membre');
    if (!$m->setDateBirthday($form->input('date_birthday_year'), $form->input('date_birthday_month'),  $form->input('date_birthday_day')))
      throw new \Exception('Merci de compléter la date de naissance du nouveau membre');
    
    $m->setMinor();
    if ($m->minor() != (isset($_POST['minor']) ? 1 : 0))
      throw new \Exception('La date de naissance et l’option jeune ne correspondent pas !');
    
    if (!$m->setAddressDifferent(($form->input('address_different') == 'on' ? 1 : 0)))
      throw new \Exception('Impossible de définir si l’adresse du mineur est différente');
    
    // majeur ou mineur avec adresse differente
    if (!$m->minor() || $m->minor() && $m->address_different()) {
      if (!$m->setAddressNumber(stripslashes($form->input('address_number'))))
        throw new \Exception('Merci d’indiquer le numéro de voie');
      if (!$m->setAddressStreet(stripslashes($form->input('address_street'))))
        throw new \Exception('Merci d’indiquer la voie du nouveau membre');
      if (!$m->setAddressFurther(stripslashes($form->input('address_further'))))
        throw new \Exception('Impossible d’ajouter un complément d’adresse');
      if (!$m->setAddressZipCode($form->input('address_zip_code')))
        throw new \Exception('Merci d’indiquer un code postal valide');
      if (!$m->setAddressTown(stripslashes($form->input('address_town'))))
        throw new \Exception('Merci d’indiquer une commune pour le nouveau membre');
    }
    
    if (!$m->setEmail($form->input('email')))
      throw new \Exception('Merci d’indiquer un courriel valide');
    if (!$m->setPhone($form->input('phone')))
      throw new \Exception('Merci d’indiquer un numéro de téléphone valide');
    if (!$m->setMobile($form->input('mobile')))
      throw new \Exception('Merci d’indiquer un numéro de mobile valide');
    
    $m->setAdherent(isset($_POST['adherent']) ? 1 : 0);
    // si adherent, on vérifie la date d'adhésion
    if ($m->adherent()) {
      if (!$m->setDateRegistration($form->input('date_registration_year'), $form->input('date_registration_month'),  $form->input('date_registration_day')))
      throw new \Exception('Merci d’indiquer une date d’inscription valide');
    }
    
    // si majeur, on peut créer
    if (!$m->minor()) {
      $m->setBezannais();      
      $m->create();
      $_SESSION['msg'] = new Message('Le membre <em>'. $m->name() .'</em> a bien été créé :)', 1, 'Ajout réussi !');
      header ('Location: '. _GESTION_ .'/?page=member&id='. $m->id());
      exit();
    }
    else {
      $_SESSION['member'] = $m;
      header ('Location: '. _GESTION_ .'/?page=choose-responsible');
      exit();
    }
    
  }
  catch (\Exception $e) {
    $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Formulaire incomplet !', FALSE);
  }
  
}
  
?>
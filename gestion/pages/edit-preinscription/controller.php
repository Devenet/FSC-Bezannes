<?php

use lib\content\Page;
use lib\preinscriptions\Preinscription;
use lib\users\UserInscription;
use lib\content\Message;
use lib\content\Form;

if (isset($_GET['id']) && Preinscription::isMember($_GET['id']+0)) {
  
  $m = new Preinscription($_GET['id']+0);
  $account = new UserInscription($m->id_user_inscription());

  // to delete a preinscription
  if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    function quit() {
      global $account;
      header('Location: ?page=preinscriptions&account='.$account->id());
      exit();
    }

    $name = $m->name();
    if ($m->countResponsabilities() <= 0) {
      if ($m->delete(true)) {
        $_SESSION['msg'] = new Message('La préinscription de <em>'. $name .'</em> a bien été supprimée :/', 1, 'Suppression réussie !');
        quit();
      }
      else {
        $_SESSION['msg'] = new Message('Impossible de supprimer la préinscription de <em>'. $name .'</em>', -1, 'Suppression impossible <i class="icon-meh"></i>');
        quit();
      }
    }
    else {
      $_SESSION['msg'] = new Message($m->name(). ' est responsable de mineurs.<br />Supprimez leur préinscription d’abord.', -1, 'Suppression impossible <i class="icon-meh"></i>');
      quit();
    }
  }
  
  $pageInfos = array(
   'name' => 'Modifier la préinscription',
   'url' => _GESTION_.'/?page=preinscriptions'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Membres', 'url' => '?page=members'), array('name' => $m->name(), 'url' => '?page=member&amp;id='.$m->id()), $pageInfos));

  $page = new Page($pageInfos['name'], $pageInfos['url'], 
    array(
      array('name' => 'Préinscriptions', 'url' => '?page=preinscriptions'),
      array('name' => $account->login(), 'url' => '?page=preinscriptions&amp;detail='.$account->id()),
      array('name' => $m->name(), 'url' => '?page=preinscription&amp;id='.$m->id()),
      $pageInfos)
  );
  
  $form = new Form('edit-preinscription', './?page=edit-preinscription&amp;id='.$m->id(), 'Modifier', 'Modifier la préinscription');
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
    'adherent'
  );
  foreach($inputs as $input)
    $form->add($input, $m->$input());
  
  
  // controle formulaire
  if (isset($_POST) and $_POST != NULL) {
    
    foreach ($inputs as $input)
      $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : NULL));
    
    try {

      $minor = $m->minor();
      
      if (!$m->setGender($form->input('gender')))
        throw new \Exception('Merci de présicer la civilité du futur membre');
      if (!$m->setLastName(stripslashes($form->input('last_name'))))
        throw new \Exception('Merci d’indiquer le nom du futur membre');
      if (!$m->setFirstName(stripslashes($form->input('first_name'))))
        throw new \Exception('Merci d’indiquer le prénom du futur membre');
      if (!$m->setDateBirthday($form->input('date_birthday_year'), $form->input('date_birthday_month'),  $form->input('date_birthday_day')))
        throw new \Exception('Merci de compléter la date de naissance du futur membre');
      
      $m->setMinor();
              // vérifie que l'on a pas changé de catégorie
        if ($minor != $m->minor())
          throw new \Exception('Mince, la personne est passée '. ($m->minor() ? 'mineure' : 'majeure') .'. Merci de supprimer le membre et de le créer de nouveau avec la bonne date de naissance.');
      if ($m->minor() != (isset($_POST['minor']) ? 1 : 0))
        throw new \Exception('La date de naissance et l’option jeune ne correspondent pas !');
      
      if (!$m->setAddressDifferent(($form->input('address_different') == 'on' ? 1 : 0)))
        throw new \Exception('Impossible de définir si l’adresse du mineur est différente');
      
      // majeur ou mineur avec adresse differente
      if (!$m->minor() || $m->minor() && $m->address_different()) {
        if (!$m->setAddressNumber(stripslashes($form->input('address_number'))))
          throw new \Exception('Merci d’indiquer le numéro de voie');
        if (!$m->setAddressStreet(stripslashes($form->input('address_street'))))
          throw new \Exception('Merci d’indiquer la voie du futur membre');
        if (!$m->setAddressFurther(stripslashes($form->input('address_further'))))
          throw new \Exception('Impossible d’ajouter un complément d’adresse');
        if (!$m->setAddressZipCode($form->input('address_zip_code')))
          throw new \Exception('Merci d’indiquer un code postal valide');
        if (!$m->setAddressTown(stripslashes($form->input('address_town'))))
          throw new \Exception('Merci d’indiquer une commune pour le futur membre');
      }
      
      if (!$m->setEmail($form->input('email')))
        throw new \Exception('Merci d’indiquer un courriel valide');
      if (!$m->setPhone($form->input('phone')))
        throw new \Exception('Merci d’indiquer un numéro de téléphone valide');
      if (!$m->setMobile($form->input('mobile')))
        throw new \Exception('Merci d’indiquer un numéro de mobile valide');
      
      $m->setAdherent(isset($_POST['adherent']) ? 1 : 0);
      
      $m->setBezannais();
      $m->update();
      $_SESSION['msg'] = new Message('La préinscription de <em>'. $m->name() .'</em> a bien été modifiée <i class="icon-smile"></i>', 1, 'Modification réussie !');
      header ('Location: '. _GESTION_ .'/?page=preinscription&id='. $m->id());
      exit();
      
    }
    catch (\Exception $e) {
      $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Formulaire incomplet !', FALSE);
    }
    
  }
}
else {
  header('Location: '. _GESTION_ .'/?page=members');
  exit();
}
?>
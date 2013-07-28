<?php

use lib\content\Page;
use lib\preinscriptions\Preinscription;
use lib\content\Message;
use lib\content\Form;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  if (isset($_GET['rel']) && Preinscription::isMember($_GET['rel']+0, $_SESSION['user']->id())) {
    
    $m = new Preinscription($_GET['rel']+0);

        // check status of the preinscription
    if ($m->status() != Preinscription::AWAITING) {
      $_SESSION['msg'] = new Message('Une préinscription validée ne permet plus d’être modifée', -1, 'Opération impossible');
      header('Location: '. _PREINSCRIPTION_ .'/list');
      exit();
    }
    
    $pageInfos = array(
     'name' => 'Modifier la préinscription',
     'url' => _PREINSCRIPTION_.'/edit-preinscription/'.$m->id()
    );
    $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => $m->name(), 'url' => _PREINSCRIPTION_.'/preinscription/'.$m->id()), $pageInfos));
    
    $form = new Form('edit-member', _PREINSCRIPTION_.'/edit-preinscription/'.$m->id(), 'Modifier', 'Modifier un membre');
    $form->reset('Annuler les modifications');
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
    foreach ($inputs as $input)
      $form->add($input, $m->$input());
    
    
    // controle formulaire
    if (isset($_POST) and $_POST != NULL) {
      
      foreach ($inputs as $input)
        $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : NULL));
      
      try {
        
        $minor = $m->minor();
      
        if (!$m->setGender($form->input('gender')))
          throw new \Exception('Merci de présicer la civilité du membre à préinscrire');
        if (!$m->setLastName(stripslashes($form->input('last_name'))))
          throw new \Exception('Merci d’indiquer le nom du membre à préinscrire');
        if (!$m->setFirstName(stripslashes($form->input('first_name'))))
          throw new \Exception('Merci d’indiquer le prénom du membre à préinscrire');
        if (!$m->setDateBirthday($form->input('date_birthday_year'), $form->input('date_birthday_month'),  $form->input('date_birthday_day')))
          throw new \Exception('Merci de compléter la date de naissance du membre à préinscrire');
        
        $m->setMinor();
        // vérifie que l'on a pas changé de catégorie
        if ($minor != $m->minor())
          throw new \Exception('Mince, la personne est passée '. ($m->minor() ? 'jeune' : 'adulte') .'. Merci de supprimer sa préinscription et d’en créer une nouvelle avec la bonne date de naissance.');
        if ($m->minor() != (isset($_POST['minor']) ? 1 : 0))
          throw new \Exception('La date de naissance et l’option jeune ne correspondent pas !');
        
        if (!$m->setAddressDifferent(($form->input('address_different') == 'on' ? 1 : 0)))
          throw new \Exception('Impossible de définir si l’adresse du mineur est différente');          
        
        // majeur ou mineur avec adresse differente
        if (!$m->minor() || $m->minor() && $m->address_different()) {
          if (!$m->setAddressNumber(stripslashes($form->input('address_number'))))
            throw new \Exception('Merci d’indiquer le numéro de voie');
          if (!$m->setAddressStreet(stripslashes($form->input('address_street'))))
            throw new \Exception('Merci d’indiquer la voie du membre à préinscrire');
          if (!$m->setAddressFurther(stripslashes($form->input('address_further'))))
            throw new \Exception('Impossible d’ajouter un complément d’adresse');
          if (!$m->setAddressZipCode($form->input('address_zip_code')))
            throw new \Exception('Merci d’indiquer un code postal valide');
          if (!$m->setAddressTown(stripslashes($form->input('address_town'))))
            throw new \Exception('Merci d’indiquer une commune pour le membre à préinscrire');
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
        header ('Location: '. _PREINSCRIPTION_ .'/preinscription/'.$m->id());
        exit();
        
      }
      catch (\Exception $e) {
        $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Formulaire incomplet !', FALSE);
      }
      
    }
  }
  else {
    header('Location: '. _PREINSCRIPTION_ .'/list');
    exit();
  }

}
else {
  header ('Location: '. _PREINSCRIPTION_ .'/login');
  exit();
}

?>
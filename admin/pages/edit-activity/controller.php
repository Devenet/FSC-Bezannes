<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\content\Message;
use lib\content\Form;

if (isset($_GET['id']) && Activity::isActivity($_GET['id']+0)) {

  $act = new Activity($_GET['id']+0);

  $pageInfos = array(
   'name' => 'Modifier l’activité',
   'url' => '/?page=activities'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Activités', 'url' => '?page=activities'), array('name' => $act->name(), 'url' => '?page=activity&id='. $act->id()), $pageInfos));
  
  $form = new Form('edit-activity', '/?page=edit-activity&id='.$act->id(), 'Modifier', $act->name());
  $inputs = array(
    'name',
    'description',
    'place',
    'price',
    'price_young',
    'email',
    'website'
  );
  foreach ($inputs as $input)
    $form->add($input, ($act->$input()==-1 ? '' : $act->$input()));
  
  // controle formulaire
  if (isset($_POST) and $_POST != null) {

    foreach ($inputs as $input)
      $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));
    
    function error($msg, $data) {
      $_SESSION['form_msg'] = new Message($msg, -1, 'Formulaire incomplet !');
      $_SESSION['form_data']  = $data;
    }
    
    try {
      
      if (!$act->setName($_POST['name']))
        throw new \Exception('Merci de compléter le nom de l’activité');
      if (!$act->setDescription($_POST['description']))
        throw new \Exception('Merci de compléter la description de l’activité');
      if (!$act->setPlace($_POST['place']))
        throw new \Exception('Merci de compléter le lieu de l’activité');
      if (!$act->setPrice($_POST['price']))
        throw new \Exception('Merci de compléter le tarif de l’activité');
      if (!$act->setPriceYoung($_POST['price_young']))
        throw new \Exception('Le tarif jeune indiqué est incorrect');
      if (!$act->setEmail($_POST['email']))
        throw new \Exception('Le courriel indiqué est incorrect');
      if (!$act->setWebsite($_POST['website']))
        throw new \Exception('Le website indiqué est incorrect');
      
      $act->update();
      
      $_SESSION['msg'] = new Message('L’activité <em>'. $act->name() .'</em> a bien été modifiée :)', 1, 'Modification réussie !');
      header ('Location: /?page=activity&id='. $act->id());
      exit();
      
    }
    catch (\Exception $e) {
      error($e->getMessage(), $act);
    }
    
  }

}
else {
  header('Location: /?page=activities');
  exit();
}

?>
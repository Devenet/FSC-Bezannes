<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\content\Message;
use lib\content\Form;

$pageInfos = array(
 'name' => 'Nouvelle activité',
 'url' => '/?page=activities'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Activités', 'url' => '?page=activities'), $pageInfos));

$form = new Form('new-activity', '/?page=new-activity', 'Ajouter', 'Nouvelle activité');

// controle formulaire
if (isset($_POST) and $_POST != null) {
  $inputs = array(
    'name',
    'description',
    'place',
    'aggregate',
    'price',
    'price_young',
    'email',
    'website'
  );
  foreach ($inputs as $input)
    $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));
  
  function error($msg, $data) {
    $_SESSION['form_msg'] = new Message($msg, -1);
    $_SESSION['form_data']  = $data;
  }
  
  $act = new Activity();
  
  try {
    
    if (!$act->setName($_POST['name']))
      throw new \Exception('Merci de compléter le nom de l’activité');
    if (!$act->setDescription(htmlspecialchars_decode($_POST['description'])))
      throw new \Exception('Merci de compléter la description de l’activité');
    if (!$act->setPlace($_POST['place']))
      throw new \Exception('Merci de compléter le lieu de l’activité');
    if (!$act->setAggregate(isset($_POST['aggregate']) ? $_POST['aggregate'] : null))
      throw new \Exception('Merci de préciser s’il s’agit d’une activité à créneaux libres');
    if (!$act->setPrice($_POST['price']))
      throw new \Exception('Merci de compléter le tarif de l’activité');
    if (!$act->setPriceYoung($_POST['price_young']))
      throw new \Exception('Le tarif jeune indiqué est incorrect');
    if (!$act->setEmail($_POST['email']))
      throw new \Exception('Le courriel indiqué est incorrect');
    if (!$act->setWebsite($_POST['website']))
      throw new \Exception('Le website indiqué est incorrect');
    
    $act->create();
    
    $_SESSION['msg'] = new Message('L’activité <em>'. $act->name() .'</em> a bien été créée \o/', 1, 'Ajout réussi !');
    header ('Location: /?page=activity&id='. $act->id());
    exit();
    
  }
  catch (\Exception $e) {
    error($e->getMessage(), $act);
  }
  
}

?>
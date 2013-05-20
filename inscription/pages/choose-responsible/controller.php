<?php

use lib\content\Page;
use lib\inscription\Member;
use lib\content\Message;
use lib\content\Form;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  // choix respo pour new membre
  if (isset($_SESSION['member']) && $_SESSION['member']->minor()) {

    $pageInfos = array(
     'name' => 'Choix du responsable',
     'url' => '/new-preinscription'
    );
    $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Nouvelle préinscription', 'url' => 'new-preinscription'), $pageInfos));
    
    $form = new Form('choose-responsible', '/choose-responsible', 'Choisir', 'Représentant légal pour <strong>'. $_SESSION['member']->name() .'</strong>');
    foreach (Member::Adults($_SESSION['user']->id()) as $adult)
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
        
        $_SESSION['msg'] = new Message('Le membre <em>'. $m->name() .'</em> a bien été préinscrit :)', 1, 'Ajout réussi !');
        header ('Location: /account');
        exit();
        
      }
      catch (\Exception $e) {
        $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Formulaire incomplet !');
      }
      
    }

  }
  
  else {
    header('Location: /new-preinscription');
    exit();
  }


}
else {
  header ('Location: /signin');
  exit();
}
?>
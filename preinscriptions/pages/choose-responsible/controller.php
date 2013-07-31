<?php

use lib\content\Page;
use lib\preinscriptions\Preinscription;
use lib\content\Message;
use lib\content\Form;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  // choix respo pour new membre
  if (isset($_SESSION['member']) && $_SESSION['member']->minor()) {

    $pageInfos = array(
     'name' => 'Choix du responsable',
     'url' => _PREINSCRIPTION_.'/new-preinscription'
    );
    $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Nouvelle préinscription', 'url' => _PREINSCRIPTION_.'new-preinscription'), $pageInfos));

    $_SESSION['form_msg'] = Preinscription::countAdults($_SESSION['user']->id()) == 0 ? '<div class="alert alert-error">
      <strong>Oups !</strong> Vous tentez de choisir un responsable pour un mineur alors qu’aucune personne majeure n’a précédement été préinscrite.
      <br />Si le responsable ne souhaite pas devenir adhérent, il suffit de ne pas cocher la case pré-adhérer dans le <a href="/new-preinscription">formulaire de préinscription</a>.
    </div>' : '';
    
    $form = new Form('choose-responsible', _PREINSCRIPTION_ .'/choose-responsible', 'Choisir', 'Représentant légal pour <strong>'. $_SESSION['member']->name() .'</strong>');
    foreach (Preinscription::Adults($_SESSION['user']->id()) as $adult)
      $form->addOption('adulte', $adult->name(), $adult->id());
      
    // controle formulaire
    if (isset($_POST) and $_POST != NULL) {
      $form->add('adulte', (isset($_POST['adulte']) ? htmlspecialchars($_POST['adulte']) : NULL));
      
      $m = $_SESSION['member'];
      
      try {
        
        if (!$m->setResponsible($_POST['adulte']))
          throw new \Exception('Impossible d’ajouter le responsable choisi');
        
        $m->setBezannais();
        $m->create();
        unset ($_SESSION['member']);

        $_SESSION['user']->checkStatus();
        
        $_SESSION['msg'] = new Message('Le membre <em>'. $m->name() .'</em> a bien été préinscrit :)', 1, 'Ajout réussi !');
        header ('Location: '. _PREINSCRIPTION_ .'/list');
        exit();
        
      }
      catch (\Exception $e) {
        $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Formulaire incomplet !');
      }
      
    }

  }

  else {
    header('Location: '. _PREINSCRIPTION_ .'/new-preinscription');
    exit();
  }


}
else {
  header ('Location: '. _PREINSCRIPTION_ .'/login');
  exit();
}
?>
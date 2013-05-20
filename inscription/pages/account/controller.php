<?php

use lib\content\Page;
use lib\content\Form;
use lib\content\Message;
use lib\users\UserInscription;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  $pageInfos = array(
    'name' => 'Mon compte',
    'url' => '/account'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));
  
  $u = $_SESSION['user'];

  // change password
  if (isset($_POST) && isset($_POST['password']) && $_POST['password'] != null) { 
    try {
      if (!UserInscription::isAuthorizedUser($u->login(), htmlspecialchars($_POST['password'])))
        throw new \Exception('Mot de passe actuel incorrect');
      
      if ($_POST['new-password'] != $_POST['confirm-new-password'])
        throw new \Exception('Les deux mots de passes ne correspondent pas !');
      
      if (!$u->setPassword(stripslashes($_POST['new-password'])))
        throw new \Exception('Votre mot de passe n’est pas valide. Il doit comporter au minimum 7 caractères.');

      $u->update();
      
      $_SESSION['msg'] = new Message('Vous voilà avec un nouveau mot de passe :)', 1, 'Mot de passe changé !');
    }
    catch (\Exception $e) {
      $_SESSION['msg'] = new Message($e->getMessage(), -1, 'Impossible de changer le mot de passe !');
    }
  }


  
}
else {
  header ('Location: /signin');
  exit();
}


?>
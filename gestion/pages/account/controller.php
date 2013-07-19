<?php

use lib\content\Page;
use lib\users\UserAdmin;
use lib\content\Display;
use lib\content\Message;

$pageInfos = array(
  'name' => 'Mon compte',
  'url' => '/?page=user'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

$u = $_SESSION['user'];

// change password
if (isset($_POST) && isset($_POST['password']) && $_POST['password'] != null) { 
  try {
    if (!UserAdmin::isAuthorizedUser($u->login(), htmlspecialchars($_POST['password'])))
      throw new \Exception('Mot de passe actuel incorrect !');
    
    if ($_POST['new-password'] != $_POST['confirm-new-password'])
      throw new \Exception('Les deux mots de passes ne correspondent pas !');
    
    if (!$u->setPassword(stripslashes($_POST['new-password']), 8))
      throw new \Exception('Votre mot de passe n’est pas valide. Il doit comporter au minimum 8 caractères.');

    $u->update();
    
    $_SESSION['msg'] = new Message('Vous voilà avec un nouveau mot de passe <i class="icon-smile"></i>', 1, 'Mot de passe changé !');
  }
  catch (\Exception $e) {
    $_SESSION['msg'] = new Message($e->getMessage(), -1, 'Impossible de changer le mot de passe');
  }
}



// affichage privilege
$display_privilege = ucfirst(Display::Privilege($u->privilege()));

// affichage dernière connexion
$data = $u->lastHistory();
$display_last_history = ($data != null) ? Display::FullTimestamp($data['date']) .'<br /> depuis l’IP '. $data['ip'] : 'Aucune, c’est votre première connexion';


?>
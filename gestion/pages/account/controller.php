<?php

use lib\content\Page;
use lib\users\UserAdmin;
use lib\content\Display;
use lib\content\Message;

$pageInfos = array(
  'name' => 'Mon compte',
  'url' => '/?page=account'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

$u = $_SESSION['user'];

// change password
if (isset($_POST) && isset($_POST['password']) && $_POST['password'] != null) { 
  try {
    if (!UserAdmin::isAuthorizedUser($u->login(), htmlspecialchars($_POST['password'])))
      throw new \Exception('Mot de passe actuel incorrect');
    
    if ($_POST['new-password'] != $_POST['confirm-new-password'])
      throw new \Exception('Les deux mots de passes ne correspondent pas !');
    
    if (!$u->setPassword(stripslashes($_POST['new-password']), 8))
      throw new \Exception('Votre mot de passe n’est pas valide. Il doit comporter au minimum 8 caractères.');
    
    // $_SESSION['msg'] = new Message('Vous voilà avec un nouveau mot de passe :)', 1, 'Mot de passe changé !');
    $_SESSION['msg'] = new Message('Passons à la suite !', 1, 'OK');
  }
  catch (\Exception $e) {
    $_SESSION['msg'] = new Message($e->getMessage(), -1, 'Impossible de changer le mot de passe !');
  }
}



// affichage privilege
$display_privilege = ucfirst(Display::Privilege($u->privilege()));

// affichage dernière connexion
$data = $u->lastHistory();
$display_last_history = Display::FullTimestamp($data['date']) .' depuis l’IP '. $data['ip'];

// affichage users admin
$display_users = '';
foreach(UserAdmin::getUsers() as $data) {
  $display_users .= '
        <tr>
          <td>'. $data['id'] .'</td>
          <td>'. $data['name'] .'</td>
          <td>'. ucfirst(Display::Privilege($data['privilege'])) .'</td>
          <td class="center"><span class="btn-group"><a href="mailto:'. $data['login'] .'" target="_blank" class="btn btn-small"><i class="icon-envelope"></i></a> <a href="/?page=account&amp;action=del&amp;id='. $data['id'] .'" class="btn btn-small"><i class="icon-trash"></i></a></span></td>
        </tr>
  ';
}

?>
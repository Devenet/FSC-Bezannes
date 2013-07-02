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

    $u->update();
    
    $_SESSION['msg'] = new Message('Vous voilà avec un nouveau mot de passe :)', 1, 'Mot de passe changé !');
  }
  catch (\Exception $e) {
    $_SESSION['msg'] = new Message($e->getMessage(), -1, 'Impossible de changer le mot de passe !');
  }
}



// affichage privilege
$display_privilege = ucfirst(Display::Privilege($u->privilege()));

// affichage dernière connexion
$data = $u->lastHistory();
$display_last_history = ($data != null) ? Display::FullTimestamp($data['date']) .'<br /> depuis l’IP '. $data['ip'] : 'Première connexion';

// affichage users admin
$display_users = '';
foreach(UserAdmin::getUsers() as $data) {
  $display_users .= '
        <tr>
          <td>'. $data['id'] .'</td>
          <td>'. $data['name'] .'</td>
          <td>'. ucfirst(Display::FrenchPrivilege($data['privilege'])) .'</td>
          <td class="center"><span class="btn-group"><a href="mailto:'. $data['login'] .'" rel="external" class="btn btn-small"><i class="icon-envelope-alt"></i></a> <!--<a href="/?page=users&amp;action=block&amp;login='. $data['login'] .'" class="btn btn-small"><i class="icon-ban-circle"></i></a>--> <a href="#confirmBox'. $data['id'] .'" class="btn btn-small" role="button" data-toggle="modal"><i class="icon-trash"></i></a></span></td>
        </tr>
  ';
}

// affichage confirmation suppression
$display_users_confirm = '';
foreach (UserAdmin::getUsers() as $data) {
  $display_users_confirm .= '
    <div id="confirmBox'. $data['id'] .'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="confirmSuppression" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>'. $data['name'] .'</h3>
      </div>
      <div class="modal-body">
        <p class="text-error">Êtes-vous bien sûr de vouloir supprimer cet utilisateur ?</p>
      </div>
      <div class="modal-footer">
        <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
        <a class="btn btn-danger" href="/?page=users&amp;action=delete&amp;login='. urlencode($data['login']) .'">Supprimer</a>
      </div>
    </div>
  ';
}



?>
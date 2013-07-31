<?php

use lib\content\Page;
use lib\users\UserAdmin;
use lib\users\Privilege;
use lib\content\Message;

$pageInfos = array(
  'name' => 'Utilisateurs',
  'url' => '/?page=users'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

//$u = $_SESSION['user'];

// affichage users admin
$display_users = '';
foreach(UserAdmin::getUsers() as $u) {
  $display_users .= '
        <tr>
          <td>'. $u->id() .'</td>
          <td>'. $u->name() .'</td>
          <td>'. ucfirst(Privilege::FrenchTranslation($u->privilege())) .'</td>
          <td><img src="'. $u->gravatar(20) .'" alt="gravatar" class="gravatar" />'. $u->login() .'</td>
          <td class="center"><a href="mailto:'. $u->login() .'" rel="external" class="btn btn-small"><i class="icon-envelope-alt"></i></a> <!--<a href="/?page=users&amp;action=block&amp;login='. $u->login() .'" class="btn btn-small"><i class="icon-ban-circle"></i></a>--> <a href="#confirmBox'. $u->id() .'" class="btn btn-small" role="button" data-toggle="modal"><i class="icon-trash"></i></a></td>
        </tr>
  ';
}

// affichage confirmation suppression
$display_users_confirm = '';
foreach (UserAdmin::getUsers() as $u) {
  $display_users_confirm .= '
    <div id="confirmBox'. $u->id() .'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="confirmSuppression" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>'. $u->name() .'</h3>
      </div>
      <div class="modal-body">
        <p class="text-error">Êtes-vous bien sûr de vouloir supprimer cet utilisateur ?</p>
      </div>
      <div class="modal-footer">
        <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
        <a class="btn btn-danger" href="'. _GESTION_ .'/?page=edit-users&amp;action=delete&amp;login='. urlencode($u->login()) .'">Supprimer</a>
      </div>
    </div>
  ';
}



?>
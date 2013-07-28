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
foreach(UserAdmin::getUsers() as $data) {
  $display_users .= '
        <tr>
          <td>'. $data['id'] .'</td>
          <td>'. $data['name'] .'</td>
          <td>'. ucfirst(Privilege::FrenchTranslation($data['privilege'])) .'</td>
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
        <a class="btn btn-danger" href="'. _GESTION_ .'/?page=edit-users&amp;action=delete&amp;login='. urlencode($data['login']) .'">Supprimer</a>
      </div>
    </div>
  ';
}



?>
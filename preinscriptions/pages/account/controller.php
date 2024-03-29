<?php

use lib\content\Page;
use lib\content\Form;
use lib\content\Message;
use lib\content\Display;
use lib\users\UserInscription;
use lib\preinscriptions\Preinscription;
use lib\preinscriptions\Participant;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  $pageInfos = array(
    'name' => 'Mon compte',
    'url' => _PREINSCRIPTION_.'/settings'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));
  
  $u = $_SESSION['user'];

  // change password
  if (isset($_POST) && isset($_POST['password']) && $_POST['password'] != NULL) { 
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

  $count_members = Preinscription::countMembers($u->id());
  $display_count_members = 'Il y a actuellement <span class="label label-info">'. $count_members . '</span> personne'. Display::Plural($count_members) .' préinscrite'. Display::Plural($count_members) .' sur votre compte.';
  
  $lastConnection = $u->lastConnection();
  $security = '';
  if ($lastConnection['ip'] != '0.0.0.0')
    $security = '<p>Votre dernière connexion a eu lieu :</p><ul class="unstyled"><li><i class="icon-calendar"></i> le '. Display::FullTimestamp($lastConnection['date']) .'</li><li><i class="icon-laptop"></i> depuis lʼadresse <abbr title="Internet Protocol">IP</abbr> '. $lastConnection['ip'] .'</li></ul>';
  else
    $security = 'Il s’agit de votre première connexion <i class="icon-smile"></i> ';
  
}
else {
  header ('Location: '. _PREINSCRIPTION_ .'/login');
  exit();
}

?>
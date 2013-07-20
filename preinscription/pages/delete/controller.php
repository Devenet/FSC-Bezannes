<?php

use lib\content\Page;
use lib\content\Form;
use lib\content\Message;
use lib\content\Display;
use lib\users\UserInscription;
use lib\preinscriptions\Member;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  $pageInfos = array(
    'name' => 'Suppression du compte',
    'url' => _PREINSCRIPTION_.'/settings'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));
  
  $u = $_SESSION['user'];

  // if valide token
  if ($u->acceptToken(htmlspecialchars($_GET['rel']))) {

    // if post data confirmed, delete account (and preinscriptions) user
    if (isset($_POST['password']) && $_POST['password'] != null) {

      try {
        // check if password is correct
        if (! UserInscription::isAuthorizedUser($u->login(), $_POST['password']))
          throw new \Exception('Le mot de passe donné n’est pas correct !', 1);
        
        if (! $u->delete(true))
          throw new \Exception('Une erreure applicative est survenue...');

        $_SESSION['msg'] = new Message('Votre compte ainsi que les préinscriptions associées ont bien été supprimées.', 1, 'Suppression réussie');
        header ('Location: '. _PREINSCRIPTION_ .'/logout/deleted');
        exit();
      }
      catch (\Exception $e) {
        $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Suppression du compte impossible', false);
      }

    }
    // else, ask confirmation to delete user
    else {

      $count_members = Member::countMembers($u->id());
      if ($count_members == 1)
        $display_count_members = 'votre préinscription sera aussi supprimée !' ;
      else if ($count_members > 1) {
        $display_count_members = 'vos <span class="label label-important">'. $count_members .'</span> préinscriptions seront aussi supprimées !' ; 
      }
    }
  
  }
  else {
    // invalid token
    $_SESSION['msg'] = new Message('Le jeton permettant d’accéder à la page souhaitée a expiré ou est invalide. <br />Merci de réessayer.', -1);
    header ('Location: '. _PREINSCRIPTION_ .'/account');
    exit();
  }

  
}
else {
  header ('Location: '. _PREINSCRIPTION_ .'/login');
  exit();
}

?>
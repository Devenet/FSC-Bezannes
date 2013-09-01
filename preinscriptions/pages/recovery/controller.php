<?php

use lib\content\Page;
use lib\content\Message;
use lib\users\UserInscription;
use lib\users\RecoverPassword;

error_reporting(E_ERROR);


if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
  header('Location: '. _PREINSCRIPTION_ .'/account');
  exit;
}
elseif (isset($_SESSION['to_ban']) && $_SESSION['to_ban'] > 3) {
  $_SESSION['msg'] = new Message('Trop de tentatives de récupération de mot de passe ont été tentées sans succès. Merci de réessayer plus tard.', -1, 'Oups... !');
  header ('Location: '. _PREINSCRIPTION_ .'/login');
  exit();
}
// demande envoie
elseif (isset($_POST['user']) && $_POST['user'] != NULL) {
  // si user est bien dans la BDD, on lui envoie le mail
  if (UserInscription::isUser(htmlspecialchars($_POST['user']))) {
    unset($_SESSION['to_ban']);
    $u = new UserInscription(UserInscription::getID(htmlspecialchars($_POST['user'])));
    try {
      RecoverPassword::insert($u->id(), $u->login());
      $content = '
        <h2 class="form-signin-heading">Envoyé</h2>
        <p>Un email contenant un lien pour réinitialiser votre mot de passe a bien été envoyé à <code>'. $u->login() .'</code>.</p>
        <p>Vérifiez vos emails <i class="icon-smile"></i></p>
      ';
    }
    // s'il a déja fait une demande, il doit attendre pour en faire une autre
    catch (\Exception $e) {
      $content = '
        <h2 class="text-error">Oups... !</h2>
        <p>'. $e->getMessage() .'</p>
      ';
    }
  }
  // sinon c'est peut être un hack
  else {
    $_SESSION['msg'] = new Message('Cet utilisateur est inconnu.', -1, 'Oups... !', false);
    $_SESSION['to_ban'] = (isset($_SESSION['to_ban']) ? $_SESSION['to_ban']+1 : 1);
    header ('Location: '. _PREINSCRIPTION_ .'/recovery');
    exit();
  }
}
// accept token
elseif (isset($_GET['user']) && $_GET['user'] != NULL && isset($_GET['token']) && $_GET['token'] != NULL) {

  if (RecoverPassword::accept(htmlspecialchars($_GET['token']), UserInscription::getID(htmlspecialchars($_GET['user'])))) {
    if (isset($_POST['new-password']) && $_POST['new-password'] != NULL && isset($_POST['confirm-new-password']) && $_POST['confirm-new-password'] != NULL) {
      $u = new UserInscription(UserInscription::getID(htmlspecialchars($_GET['user'])));
      try {
        if ($_POST['new-password'] != $_POST['confirm-new-password'])
          throw new \Exception('Les mots de passes ne correspondent pas.');
        if (! $u->setPassword($_POST['new-password']))
          throw new \Exception('Votre mot de passe n’est pas valide. Il doit comporter au minimum 7 caractères.');

        $u->update();
        RecoverPassword::remove(UserInscription::getID(htmlspecialchars($_GET['user'])));


        $_SESSION['msg'] = new Message('Votre mot de passe a bien été réinitialisé. Vous pouvez maintenant vous connecter :)', 1, 'Réinitialisation réussie !');
        header ('Location: '. _PREINSCRIPTION_ .'/login');
        exit(); 
      }
      catch (\Exception $e) {
        $_SESSION['msg'] = new Message($e->getMessage(), -1, 'Oups... !', false);
        header ('Location: '. _PREINSCRIPTION_ .'/?page=precovery&user='. urlencode(htmlspecialchars($_GET['user'])) .'&token='. htmlspecialchars($_GET['token']));
        exit(); 
      }
    }
    else {
      $content = '
      <h2>Réinitialisation</h2>
      <div class="alert alert-info">
        <strong>Note :</strong> votre nouveau mot de passe doit comporter au moins 7 caractères !
      </div>
      <form class="form-horizontal espace-top" action="'. _PREINSCRIPTION_ .'/?page=recovery&user='. urlencode(htmlspecialchars($_GET['user'])) .'&amp;token='. htmlspecialchars($_GET['token']) .'" method="post">
          <div class="control-group">
            <label class="control-label">Compte concerné</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on"><i class="icon-envelope"></i></span>
                <input type="text" disabled="disabled" value="'. htmlspecialchars($_GET['user']) .'" />
              </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="new-password">Nouveau mot de passe</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on"><i class="icon-lock"></i></span>
                <input type="password" id="new-password" name="new-password" />
              </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="confirm-new-password">Confirmation</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on"><i class="icon-repeat"></i></span>
                <input type="password" id="confirm-new-password" name="confirm-new-password" />
              </div>
            </div>
          </div>
        <div class="form-actions">
          <input type="submit" class="btn btn-primary" value="Réinitialiser" /> 
        </div>

      </form> 
      ';
    }
  }
  else {
    $_SESSION['msg'] = new Message('Autorisation de réinitialisation de votre mot de passe invalide ou expirée.', -1, 'Oups... !');
    $_SESSION['to_ban'] = (isset($_SESSION['to_ban']) ? $_SESSION['to_ban']+1 : 1);
    header ('Location: '. _PREINSCRIPTION_ .'/login');
    exit(); 
  }
}

$pageInfos = array(
  'name' => 'Récupération de mot de passe',
  'url' => _PREINSCRIPTION_.'/recovery'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

?>
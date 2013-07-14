<?php

use lib\content\Page;
use lib\content\Form;
use lib\content\Message;
use lib\users\UserInscription;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
  header ('Location: '. _INSCRIPTION_);
  exit();
}
else if (isset($_GET['rel'])) {
  header ('Location: '. _INSCRIPTION_.'/login');
  exit(); 
}

$pageInfos = array(
  'name' => 'Connexion',
  'url' => _INSCRIPTION_.'/login'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

if (isset($_SESSION['login-next-step'])) {
  $page->addOption('steps');
  $page->addParameter('step', 2);
  $page->addParameter('step-width', 8);
  $page->addParameter('step-info', 'Accéder à son compte');
  $page->addOption('bar');
  $page->addParameter('bar', 'danger');
  unset($_SESSION['login-next-step']);
}

$form = new Form('login', _INSCRIPTION_.'/login', 'Connexion');
$inputs = array(
    'login',
    'password'
  );
  foreach ($inputs as $input)
    $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));

if (isset($_POST['login']) && isset($_POST['password']) && $_POST['login'] != null && $_POST['password'] != null) {
  
  if (UserInscription::isAuthorizedUser($_POST['login'], $_POST['password'])) {
    $_SESSION['user'] = new UserInscription(UserInscription::getID(htmlspecialchars($_POST['login'])));
    $_SESSION['user']->historize($_SERVER['REMOTE_ADDR']);
    $_SESSION['authentificated'] = true;
    header('Location: '. _INSCRIPTION_ .'/list');
    exit;
  }
  else {
   	$_SESSION['msg'] = new Message('Mot de passe oublié ? <a href="'. _INSCRIPTION_ .'/recovery">Réinitialisez-le</a> !', -1, 'Oups... Identifiants incorrects');
  }
}

?>
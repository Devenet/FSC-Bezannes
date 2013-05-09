<?php

use lib\content\Page;
use lib\content\Form;
use lib\content\Message;
use lib\users\UserInscription;

// login
if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
 	header('Location: /');
 	exit;
}

$pageInfos = array(
  'name' => 'Connexion',
  'url' => '/login.html'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));
if (isset($_GET['rel']) && $_GET['rel'] == 'first') {
  $page->addOption('steps');
  $page->addParameter('step', 2);
  $page->addParameter('step-width', 8);
  $page->addParameter('step-info', 'Accéder à son compte');
  $page->addOption('bar');
  $page->addParameter('bar', 'danger');
}
elseif (isset($_GET['rel'])) {
  header ('Location: /login.html');
  exit;
}

$form = new Form('login', '/login'. (isset($_GET['rel']) && $_GET['rel'] == 'first' ? '-first' : null) .'.html', 'Connexion');
$inputs = array(
    'login',
    'password'
  );
  foreach ($inputs as $input)
    $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));

if (isset($_POST['login']) && isset($_POST['password'])) {
  
  if (UserInscription::isAuthorizedUser($_POST['login'], $_POST['password'])) {
    $_SESSION['user'] = new UserInscription(UserInscription::getID(htmlspecialchars($_POST['login'])));
    $_SESSION['user']->historize($_SERVER['REMOTE_ADDR']);
    $_SESSION['authentificated'] = true;
    header('Location: /account.html');
    exit;
  }
  else {
   	$_SESSION['msg'] = new Message('Mot de passe oublié ? <a href="/recover-password.html">Réinitialisez-le</a> !', -1, 'Oups... Identifiants incorrects');
  }
}

?>
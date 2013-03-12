<?php

use lib\content\Page;
use lib\content\Form;
use lib\content\Message;
use lib\users\UserInscription;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
  header ('Location: /');
  exit();
}

$pageInfos = array(
  'name' => 'Création du compte',
  'url' => '/signup.html'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));
$page->addOption('steps');
$page->addParameter('step', 1);
$page->addParameter('step-width', 2);
$page->addOption('bar');
$page->addParameter('bar', 'danger');

$form = new Form('signup', '/signup.html', 'Créer mon compte');

// controle formulaire
if (isset($_POST) and $_POST != null) {
  $inputs = array(
    'login',
    'password',
    'confirm-password'
  );
  foreach ($inputs as $input)
    $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));

  
  $u = new UserInscription();
  
  try {
    
    if(!$u->acceptLogin(stripslashes($_POST['login'])))
      throw new \Exception('Mince, cette adresse e-mail est déjà utilisée !<br />Voulez-vous <a href="/login.html">vous connecter</a> ou avez-vous <a href="/recover-password.html">oublié votre mot de passe</a> ?');
    if (!$u->setLogin(stripslashes($_POST['login'])))
      throw new \Exception('Merci d’indiquer un courriel valide !');
    
    if ($_POST['password'] != $_POST['confirm-password'])
      throw new \Exception('Les deux mots de passes ne correspondent pas !');
    
    if (!$u->setPassword(stripslashes($_POST['password'])))
      throw new \Exception('Votre mot de passe n’est pas valide. Il doit comporter au minimum 7 caractères.');
    
    if ($_POST['captcha'] != $_SESSION['captcha'][1] + $_SESSION['captcha'][0])
      throw new \Exception('Seriez-vous un robot ?! Merci de compléter correctement l’anti-robots.');
    
    unset($_SESSION['captcha']);
    $u->create();
    
    $_SESSION['msg'] = new Message('Vous pouvez maintenant vous connecter avec vos identifiants.', 1, 'Votre compte a bien été créé !');
    header ('Location: /login-first.html');
    exit();
    
  }
  catch (\Exception $e) {
    $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Oups... !');
  }
}

?>
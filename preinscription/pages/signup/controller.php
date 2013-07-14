<?php

use lib\content\Page;
use lib\content\Form;
use lib\content\Message;
use lib\users\UserInscription;
use lib\mail\Mail;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
  header ('Location: '. _PREINSCRIPTION_);
  exit();
}
else if (isset($_GET['rel'])) {
  header ('Location: '. _PREINSCRIPTION_.'/signup');
  exit(); 
}

$pageInfos = array(
  'name' => 'Création du compte',
  'url' => _PREINSCRIPTION_.'/signup'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));
$page->addOption('steps');
$page->addParameter('step', 1);
$page->addParameter('step-width', 2);
$page->addOption('bar');
$page->addParameter('bar', 'danger');

$form = new Form('signup', _PREINSCRIPTION_.'/signup', 'Créer mon compte');

// controle formulaire
if (isset($_POST) and $_POST != null) {
  $inputs = array(
    'login',
    'password',
    'confirm-password',
    'cnil'
  );
  foreach ($inputs as $input)
    $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));

  
  $u = new UserInscription();
  
  try {
    
    if(!$u->acceptLogin(stripslashes($_POST['login'])))
      throw new \Exception('Mince, cette adresse e-mail est déjà utilisée !<br />Voulez-vous <a href="./login">vous connecter</a> ou avez-vous <a href="/recovery">oublié votre mot de passe</a> ?');
    if (!$u->setLogin(stripslashes($_POST['login'])))
      throw new \Exception('Merci d’indiquer un courriel valide !');
    
    if ($_POST['password'] != $_POST['confirm-password'])
      throw new \Exception('Les deux mots de passes ne correspondent pas !');
    
    if (!$u->setPassword(stripslashes($_POST['password'])))
      throw new \Exception('Votre mot de passe n’est pas valide. Il doit comporter au minimum 7 caractères.');

    if (!isset($_POST['cnil']) || $_POST['cnil'] != 'on')
      throw new \Exception('Merci de confirmer que vous avez pris connaissance de vos droits.');
    
    if ($_POST['captcha'] != $_SESSION['captcha'][1] + $_SESSION['captcha'][0])
      throw new \Exception('Seriez-vous un robot ?! Merci de compléter correctement l’anti-robots.');
    
    unset($_SESSION['captcha']);
    $u->create();

    $body = 'Bonjour, 

Ceci est un email automatique pour vous confirmer la création de votre compte sur le site des préinscriptions du Foyer Social et Culturel de Bezannes. 

Voici un petit rappel des informations utiles : 
    • Votre identifiant : '. $u->login() .'
    • Votre mot de passe : celui défini lors de l’inscription 
    • Page de connexion : http:'. _PREINSCRIPTION_ .'/login';
    Mail::text($u->email(), 'Préinscriptions', $body);
    
    $_SESSION['msg'] = new Message('Vous pouvez maintenant vous connecter avec vos identifiants.', 1, 'Votre compte a bien été créé !');
    $_SESSION['login-next-step'] = true;
    header ('Location: '. _PREINSCRIPTION_ .'/login');
    exit();
    
  }
  catch (\Exception $e) {
    $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Oups... !');
  }
}

?>
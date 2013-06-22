<?php

use lib\content\Page;
use lib\content\Form;
use lib\content\Message;
use lib\content\Display;
use lib\users\UserInscription;
use lib\inscription\Member;
use lib\inscription\Participant;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  $pageInfos = array(
    'name' => 'Mon compte',
    'url' => '/account'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));
  
  $u = $_SESSION['user'];

  // change password
  if (isset($_POST) && isset($_POST['password']) && $_POST['password'] != null) { 
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

  $count_members = Member::countMembers($u->id());
  $display_count_members = 'Il y a actuellement <span class="label">'. $count_members . '</span> personne'. Display::Plural($count_members) .' préinscrite'. Display::Plural($count_members) .' sur votre compte.';
  $count_activities = 99999;
  $count_adherents = 0;
  // affichage des préinscriptions du compte
  if ($count_members == 0) {
    $display_members = '<div class="row espace-top"><div class="span8 offset2"><div class="alert">Aucune préinscription n’a encore été enregistrée :/<br />Faire ma <a href="/new-preinscription">première préinscription</a> !</div></div></div>';
  }
  else {
    $display_members = '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th style="text-align:right;"><i class="icon-user"></i></th>
          <th> Identité</th>
          <th style="width:120px; text-align:center;"><i class="icon-map-marker"></i> Bezannais</th>
          <th style="width:120px; text-align:center;">Pré-adhérent</th>
          <th style="text-align:center;"><i class="icon-globe"></i> Activités</th>
          <th style="text-align:center;"></th>
        </tr>
      </thead>
      <tbody>';
    foreach (Member::Members($_SESSION['user']->id()) as $m) {
      $act = Participant::countActivities($m->id());
      if ($m->adherent()) {
        $count_adherents++;
        $count_activities = min($act, $count_activities);
      }
      $display_members .= '
        <tr>
          <td style="text-align:center;">'. Display::HtmlGender($m->gender()) .'</td>
          <td><a href="/preinscription/'. $m->id() .'" style="text-decoration:none; color:#333;">'. $m->name() .'</a><a href="/preinscription/'. $m->id() .'" style="text-decoration:none; padding-left:8px;"><i class="icon-share-alt"></i></a></td>
          <td style="width:120px; text-align:center;">'. ($m->bezannais() ? '<i class="icon-ok" style="color:#444;"></i>' : '') .'</td>
          <td style="width:120px; text-align:center;">'. ($m->adherent() ? '<i class="icon-ok" style="color:#444;"></i>' : '') .'</td>
          <td style="text-align:center;">'. ($m->adherent() ? '<span class="label '. ($act == 0 ? ' label-warning' : '') .'">'. $act .'</span> <a href="/add-activity/'. $m->id() .'" style="color: black; text-decoration: none; margin-left: 5px;"><i class="icon-plus-sign"></i></a>' : '') .'</td>
          <td style="text-align:center;"><a href="/preinscription/'. $m->id() .'" class="btn btn-small">Voir</a></td>
        </tr>
      ';
    }
    $display_members .= '
      </tbody>
    </table>';
  }

  // aucune préinscription
  if ($count_members == 0) {
    $page->addOption('steps');
    $page->addParameter('step', 3);
    $page->addParameter('step-width', 25);
    $page->addParameter('step-info', 'Ajouter une préinscription');
    $page->addOption('bar');
    $page->addParameter('bar', 'warning');
  }
  // préinscription faite avec au moins un adhérent
  else if ($count_adherents > 0) {
    // au moins un adhérent sans aucune activité choisie
    if ($count_activities == 0) {
      $page->addOption('steps');
      $page->addParameter('step', 4);
      $page->addParameter('step-width', 75);
      $page->addParameter('step-info', 'Se préinscrire à des activités');
      $page->addOption('bar');
      $page->addParameter('bar', 'warning');
    }
    // au moins une activité choisie
    else {
      $page->addOption('steps');
      $page->addParameter('step', 5);
      $page->addParameter('step-width', 100);
      $page->addParameter('step-info', 'Vérifier vos informations');
      $page->addOption('bar');
      $page->addParameter('bar', 'success');
    }
  }
  // préinscription faite, mais aucun adhérent
  else {
    $page->addOption('steps');
      $page->addParameter('step', 3);
      $page->addParameter('step-width', 50);
      $page->addParameter('step-info', 'Préinscrire un nouvel adhérent');
      $page->addOption('bar');
      $page->addParameter('bar', 'warning');
  }
  
}
else {
  header ('Location: /login');
  exit();
}

?>
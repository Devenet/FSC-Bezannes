<?php

use lib\content\Page;
use lib\content\Form;
use lib\content\Message;
use lib\content\Display;
use lib\users\UserInscription;
use lib\preinscriptions\Preinscription;
use lib\preinscriptions\FutureParticipant;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\members\Member;
use lib\members\Participant;

function quit() {
  header('Location: '. _GESTION_ .'/?page=preinscriptions');
  exit();
}

if (isset($_GET['id']) && Preinscription::isMember($_GET['id']+0)) {
  
  $pre = new Preinscription($_GET['id']+0);
  $account = new UserInscription($pre->id_user_inscription());
  
  // check that the preinscription was not yet validated
  if ($pre->status() != Preinscription::AWAITING) {
    $_SESSION['msg'] = new Message('La préinscription du membre a déjà été effectuée', -1, 'Validation impossible');
    header('Location: '. _GESTION_ .'/?page=preinscriptions&account='.$account->id());
    exit();
  }

  if ($pre->minor())
    $respo = new Preinscription($pre->responsible());

  // if minor, check that the responsible's preinscription is already validated
  if ($pre->minor() && $respo->status() != Preinscription::VALIDATED) {
    // responsible already in database but have no preinscription done, so accept this minor
    if (!isset($_GET['forced'])) {
      $_SESSION['msg'] = new Message('La préinscription du responsable légal n’a pas encore été validée !<br /><i class="icon-unlock-alt"></i> <a href="?page=validate-preinscription&amp;id='.$pre->id().'&forced">Forcer la préinscription</a>', 0, 'Validation impossible');
      header('Location: '. _GESTION_ .'/?page=preinscription&id='.$pre->id());
      exit();
    }
  }
    
  $pageInfos = array(
   'name' => 'Validation de préinscription',
   'url' => _GESTION_.'/?page=preinscriptions'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], 
    array(
      array('name' => 'Préinscriptions', 'url' => '?page=preinscriptions'),
      array('name' => $account->login(), 'url' => '?page=preinscriptions&amp;account='.$account->id()),
      array('name' => $pre->name(), 'url' => '?page=Preinscription&amp;id='.$pre->id()),
      $pageInfos)
  );

  $url_forced = isset($_GET['forced']) ? '&amp;forced' : NULL;
  $form = new Form('validate-preinscription', _GESTION_.'/?page=validate-preinscription&amp;id='.$pre->id().$url_forced, 'Valider', 'Valider la préinscription');

  $future_participant = FutureParticipant::Activities($pre->id());

  // add activity preinscription for the member to validate
  $form_checkbox_content = array();
  if ($pre->adherent()) {
    foreach ($future_participant as $p) {
      $a = new Activity($p->activity());
      if (!$a->aggregate())
        $s = new Schedule($p->schedule());
      $horaire = isset($s) && $a->aggregate() == 0 ? '<br />'. Display::Day($s->day()).' &rsaquo; '. $s->time_begin() .' à '. $s->time_end() . ($s->more() != NULL ? '&nbsp; &nbsp;('.$s->more().')' : '') : NULL;
      $horaire = isset($s) && $s->description() != NULL ? $s->description() : $horaire;
      $form->add('participant-'.$p->id());
      $form_checkbox_content['participant-'.$p->id()] = $a->name() . $horaire;
    }
  }

  // responsible choice for minor member
  if ($pre->minor()) {
    foreach (Member::Adults() as $adult)
      $form->addOption('adulte', $adult->name(), $adult->id());
  }

  // check if a member with same name already exists
  $search_result = Member::SearchName(htmlspecialchars($pre->last_name()), htmlspecialchars($pre->first_name()));
  if (!empty($search_result)) {
    $same_member = '<ul>';
    foreach ($search_result as $m)
      $same_member .= '<li>'. $m->name() .' [<a rel="external" href="'. _GESTION_ .'/?page=member&amp;id='. $m->id() .'">#'. $m->id() .'</a>]</li>';
    $same_member .= '</ul>';
  }

  // controle formulaire
  if (isset($_POST) and $_POST != NULL) {
    $inputs = array(
      'inscription',
      'date_registration_day',
      'date_registration_month',
      'date_registration_year'
    );
    foreach ($inputs as $input)
      $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : NULL));
    
    $m = new Member();

    // membre à valider
    if ($pre->id_member() == NULL) {
      try {

        // check validation for member is ok
        if ($form->raw('inscription') != 'on')
          throw new \Exception('Impossible d’aller plus loin si vous ne validez pas la préinscription du membre.');

        if (!$m->setGender($pre->gender()))
          throw new \Exception('La civilité du nouveau membre pose problème.');
        if (!$m->setLastName($pre->last_name()))
          throw new \Exception('Le nom du nouveau membre pose problème.');
        if (!$m->setFirstName($pre->first_name()))
          throw new \Exception('Le prénom du nouveau membre pose problème.');
        if (!$m->setDateBirthday($pre->date_birthday_year(), $pre->date_birthday_month(), $pre->date_birthday_day()))
          throw new \Exception('La date de naissance du nouveau membre pose problème.');
        
        $m->setMinor();
        if ($m->minor() != $pre->minor())
          throw new \Exception('La date de naissance et l’option jeune posent problème.');
        
        if (!$m->setAddressDifferent($pre->address_different()))
          throw new \Exception('Impossible de définir si l’adresse du mineur est différente.');
        
        // majeur ou mineur avec adresse differente
        if (!$m->minor() || $m->minor() && $m->address_different()) {
          if (!$m->setAddressNumber($pre->address_number()))
            throw new \Exception('Le numéro de voie du nouveau membre pose problème.');
          if (!$m->setAddressStreet($pre->address_street()))
            throw new \Exception('La voie du nouveau membre pose problème.');
          if (!$m->setAddressFurther($pre->address_further()))
            throw new \Exception('Le complément d’adresse du nouveau membre pose problème.');
          if (!$m->setAddressZipCode($pre->address_zip_code()))
            throw new \Exception('Le code postal du nouveau membre pose problème.');
          if (!$m->setAddressTown($pre->address_town()))
            throw new \Exception('La commune pour le nouveau membre pose problème.');
        }

        if ($m->minor()) {
          if (!$m->setResponsible($_POST['adulte']+0))
            throw new \Exception('Le reponsable du nouveau membre pose problème.');
        }
        
        if (!$m->setEmail($pre->email()))
          throw new \Exception('Le courriel du nouveau membre pose problème.');
        if (!$m->setPhone($pre->phone()))
          throw new \Exception('Le numéro de téléphone du nouveau membre pose problème.');
        if (!$m->setMobile($pre->mobile()))
          throw new \Exception('Le numéro de mobile du nouveau membre pose problème.');
        
        $m->setAdherent($pre->adherent());
        // si adherent, on vérifie la date d'adhésion
        if ($m->adherent()) {
          if (!$m->setDateRegistration($form->input('date_registration_year'), $form->input('date_registration_month'),  $form->input('date_registration_day')))
          throw new \Exception('Merci d’indiquer une date d’adhésion valide.');
        }
        
        // on peut créer
        $m->setBezannais();      
        $m->create();

        // update status
        $pre->setStatus(Preinscription::VALIDATED);
        $pre->setIDMember($m->id());

        // s'il y a des activités à valider
        if ($m->adherent() && isset($_POST['activities'])) {
          $counter_participations_added = 0;
          foreach ($future_participant as $fp) {
            if (isset($_POST['participant-'.$fp->id()]) && $_POST['participant-'.$fp->id()] == 'on') {
              $form->add('participant-'.$fp->id(), 'on');

              $p = new Participant();
              $p->setAdherent($m->id());
                          
              if (!Activity::isActiveActivity($fp->activity()))
                throw new \Exception('Cette activité n’est pas activée');
              if (!$p->setActivity($fp->activity()))
              throw new \Exception('Impossible d’ajouter l’activité choisie');
              
              // activite libre
              if ($fp->schedule() != NULL) {
                if (!$p->setSchedule($fp->schedule()))
                  throw new \Exception('L’horaire choisi n’est pas valide');
              }
              
              if (!$p->couldCreated())
                throw new \Exception('Le membre participe déjà à cette activité');
              if(!$p->create())
                throw new \Exception('Impossible d’ajouter le participant');

              // update status
              $fp->setStatus(Preinscription::VALIDATED);
              $counter_participations_added++;
            }
          }
        }
        else {
          // only member added, no activity to participate
          $_SESSION['msg'] = new Message('La préinscription de <em>'. $m->name() .'</em> a bien été validée <i class="icon-smile"></i>', 1, 'Validation réussie !');
          header ('Location: '. _GESTION_ .'/?page=preinscriptions&account='. $account->id());
          exit();
        }

        if (sizeof($future_participant) != $counter_participations_added)
          $pre->setStatus(Preinscription::INCOMPLETE);

        // member and activities well added
        $_SESSION['msg'] = new Message('La préinscription de <em>'. $m->name() .'</em>  bien été validée <i class="icon-smile"></i><br />Les activités sélectionnées ont bien été ajoutées !', 1, 'Validation réussie !');
        header ('Location: '. _GESTION_ .'/?page=preinscriptions&account='. $account->id());
        exit();
        
      }
      catch (\Exception $e) {
        $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Validation impossible !', FALSE);
      }
    }
  }


  
}
else {
  quit();
}

?>
<?php

use lib\content\Page;
use lib\users\UserInscription;
use lib\preinscriptions\Preinscription;
use lib\preinscriptions\Member;
use lib\preinscriptions\Participant;
use lib\content\Message;
use lib\content\Display;
use lib\activities\Activity;
use lib\activities\Schedule;

function quit() {
  header('Location: '. _GESTION_ .'/?page=preinscriptions');
  exit();
}

if (isset($_GET['id']) && Member::isMember($_GET['id']+0)) {
  
  $pre = new Member($_GET['id']+0);
  $account = new UserInscription($pre->id_user_inscription());
  if ($pre->minor())
    $respo = new Member($pre->responsible());
    
  $pageInfos = array(
   'name' => $pre->name(),
   'url' => _GESTION_.'/?page=preinscriptions'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], 
    array(
      array('name' => 'Préinscriptions', 'url' => '?page=preinscriptions'),
      array('name' => $account->login(), 'url' => '?page=preinscriptions&amp;account='.$account->id()),
      $pageInfos)
  );

  // generation des buttons du membre en fonction de son status
  function getButtonsMember() {
    global $pre;
    $result = '<a ';
    if ($pre->status() ==  Preinscription::AWAITING)
      $result .= 'href="'. _GESTION_ .'/?page=validate-preinscription&amp;id='. $pre->id() .'" title="Valider la préinscription"';
    $result .= ' class="btn btn-small';
    if ($pre->status() !=  Preinscription::AWAITING)
      $result .= ' disabled';
    $result .= '"><i class="icon-plus"></i></a>'. PHP_EOL;
    $result .= '<div class="btn-group">';
    $result .= '<a ';
    if ($pre->status() ==  Preinscription::AWAITING)
      $result .= 'href="'. _GESTION_ .'/?page=edit-preinscription&amp;id='. $pre->id() .'" title="Modifier la préinscription"';
    $result .= ' class="btn btn-small';
    if ($pre->status() !=  Preinscription::AWAITING)
      $result .= ' disabled';
    $result .= '"><i class="icon-pencil"></i></a>';
    $result .= '<a href="#confirmRemoveInscription'. $pre->id() .'" role="button" data-toggle="modal" title="Supprimer la préinscription" class="btn btn-small"><i class="icon-trash"></i></a>';
    $result .= '</div>';
    return $result;

  }
  // geneation des boutons en fonction du status (préinscription & participation)
  function getButtonsParticipant($p) {
    global $pre;
    switch ($pre->status()) {
      case Preinscription::AWAITING:
        return 'préinscription non validée';
        break;

      case Preinscription::INCOMPLETE:
      case Preinscription::VALIDATED:
        if ($p->status() == Preinscription::AWAITING)
          return '<a href="#confirmBoxP'. $p->id() .'"  role="button" data-toggle="modal" class="normal"><i class="icon-trash"></i></a>';
        return 'nop';
        break;

      case Preinscription::REJECTED:
      default:
        return 'not allowed';
        break;
    }
  }


  // Activités
  $count_activites = Participant::countActivities($pre->id());
  $plural_count_activities = $count_activites > 1 ? 's' : '';
  
  $display_participatitions = '';
  if ($count_activites >= 1) {
    $display_participatitions = '<table class="table table-striped table-go"><thead>
      <tr>
        <th>Activité</th>
        <th>Horaire</th>
        <th class="center">Statut</th>
      </tr>
      </thead><tbody>
    ';
    foreach (Participant::Activities($pre->id()) as $p) {
      $a = new Activity($p->activity());
      if (!$a->aggregate())
        $s = new Schedule($p->schedule());
      $horaire = isset($s) && $a->aggregate() == 0 ? Display::Day($s->day()).' &rsaquo; '. $s->time_begin() .' à '. $s->time_end() . ($s->more() != NULL ? '&nbsp; &nbsp;('.$s->more().')' : '') : '<em>Pratique libre</em>';
      $horaire = isset($s) && $s->description() != NULL ? $s->description() : $horaire;
      $display_participatitions .= '
        <tr>
          <td class="go"><a href="'. _FSC_ .'/activite/'. $a->url() .'" rel="external">'. $a->name() .'</a> <span class="external-link"><i class="icon-external-link"></i></span></td>
          <td>'. $horaire .'</td>
          <td class="center status">'. Preinscription::StatusTooltip($p->status()) .'</td>
          <td class="center">'. getButtonsParticipant($p) .'</td>
        </tr>
      ';
    }
    $display_participatitions .= '</tbody></table>';
    $_SCRIPT[] = '<script>$(function(){ $(\'table td.status span\').tooltip(); });</script>';

    foreach (Participant::Activities($pre->id()) as $p)
      $display_participatitions .= '
      <div id="confirmBoxP'. $p->id() .'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelParticipant'. $p->id() .'" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 id="ConfirmDelParticipant'. $p->id() .'">'. $pre->name() .'</h3>
        </div>
        <div class="modal-body">
          <p class="text-error">Êtes-vous sûr de vouloir désinscrire ce membre de l’activité ?</p>
        </div>
        <div class="modal-footer">
          <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
          <a href="'. _PREINSCRIPTION_ .'/remove-activity/'. $p->id() .'" class="btn btn-danger">Confirmer</a>
        </div>
      </div>
      ';
  }


  $_SCRIPT[] = '<script>$(function(){ $(\'.status-tooltip span\').tooltip({"placement": "right"}); });</script>';

  
}
else {
  quit();
}

?>
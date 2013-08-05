<?php

use lib\content\Page;
use lib\preinscriptions\FutureParticipant;
use lib\preinscriptions\Preinscription;
use lib\payments\Price;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\content\Message;
use lib\content\Display;

function quit() {
  header('Location: '. _PREINSCRIPTION_ .'/list');
  exit();
}

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  if (isset($_GET['rel']) && Preinscription::isMember($_GET['rel']+0, $_SESSION['user']->id())) {
    
    $m = new Preinscription($_GET['rel']+0);
    if ($m->minor())
      $r = new Preinscription($m->responsible());
    
    // suppression membre
    if (isset($_GET['data']) && $_GET['data'] == 'delete') {

      $name = $m->name();
      if ($m->countResponsabilities() <= 0) {
        if ($m->delete(true)) {
          $_SESSION['user']->checkStatus();
          $_SESSION['msg'] = new Message('La préinscription de <em>'. $name .'</em> a bien été supprimée :/', 1, 'Suppression réussie !');
          quit();
        }
        else {
          $_SESSION['msg'] = new Message('Impossible de supprimer la préinscription de <em>'. $name .'</em>', -1, 'Suppression impossible :/');
          quit();
        }
      }
      else {
        $_SESSION['msg'] = new Message($m->name(). ' est responsable d’au moins un jeune.<br />Supprimez leurs préinscriptions d’abord.', -1, 'Suppression impossible :/');
          quit();
      }
    }
    
    $pageInfos = array(
     'name' => $m->name(),
     'url' => _PREINSCRIPTION_.'/preinscription'
    );
    $page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));
    
    
    // Activités
    $count_activites = FutureParticipant::countActivities($m->id());
    $plural_count_activities = $count_activites > 1 ? 's' : '';
    
    $activities_participant = '';
    if ($count_activites >= 1) {
      $activities_participant = '<table class="table table-striped table-go"><thead>
        <tr>
          <th>Activité</th>
          <th>Horaire</th>
          <th class="center">Statut</th>
        </tr>
        </thead><tbody>
      ';
      foreach (FutureParticipant::Activities($m->id()) as $p) {
        $a = new Activity($p->activity());
        if (!$a->aggregate())
          $s = new Schedule($p->schedule());
        $horaire = isset($s) && $a->aggregate() == 0 ? Display::Day($s->day()).' &rsaquo; '. $s->time_begin() .' à '. $s->time_end() . ($s->more() != NULL ? '&nbsp; &nbsp;('.$s->more().')' : '') : '<em>Pratique libre</em>';
        $horaire = isset($s) && $s->description() != NULL ? $s->description() : $horaire;
        $activities_participant .= '
          <tr>
            <td class="go"><a href="'. _PREINSCRIPTION_ .'/activite/'. $a->url() .'">'. $a->name() .'</a></span></td>
            <td>'. $horaire .'</td>
            <td class="center status">'. Preinscription::StatusTooltipActivity($p->status()) .'</td>
            <td class="center">'. ($m->status() == Preinscription::AWAITING  ? '<a href="#confirmBoxP'. $p->id() .'"  role="button" data-toggle="modal" class="btn btn-small"><i class="icon-trash"></i></a>' : '<a class="btn btn-small disabled"><i class="icon-trash"></i></a>') .'</td>
          </tr>
        ';
      }
      $activities_participant .= '</tbody></table>';
      $_SCRIPT[] = '<script>$(function(){ $(\'table td.status span\').tooltip(); });</script>';

      foreach (FutureParticipant::Activities($m->id()) as $p)
        $activities_participant .= '
        <div id="confirmBoxP'. $p->id() .'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelParticipant'. $p->id() .'" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 id="ConfirmDelParticipant'. $p->id() .'">'. $m->name() .'</h3>
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


    
  }
  else {
    quit();
  }

}
else {
  quit();
}

?>
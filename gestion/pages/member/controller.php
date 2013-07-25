<?php

use lib\content\Page;
use lib\members\Member;
use lib\members\Participant;
use lib\members\Referent;
use lib\payments\Transaction;
use lib\payments\Advantage;
use lib\payments\Price;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\content\Message;
use lib\content\Display;

function quit() {
  header('Location: '. _GESTION_ .'/?page=members');
  exit();
}

if (isset($_GET['id']) && Member::isMember($_GET['id']+0)) {
  
  $m = new Member($_GET['id']+0);
  if ($m->minor())
    $r = new Member($m->responsible());
  
  // suppression membre
  if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $name = $m->name();
    if ($m->countResponsabilities() <= 0 && Referent::countResponsabilities($m->id()) <= 0) {
      if ($m->delete(true)) {
        $_SESSION['msg'] = new Message('Le membre <em>'. $name .'</em> a bien été supprimé :/', 1, 'Suppression réussie !');
        quit();
      }
      else {
        $_SESSION['msg'] = new Message('Impossible de supprimer le membre <em>'. $name .'</em>', -1, 'Suppression impossible :/');
        quit();
      }
    }
    else {
      $_SESSION['msg'] = new Message($m->name(). ' est référent d’activités ou responsable de mineurs.<br />Supprimez-les d’abord.', -1, 'Suppression impossible :/');
        quit();
    }
  }
  // forcer bezannais
  /* à écrire */
  
  $pageInfos = array(
   'name' => $m->name(),
   'url' => _GESTION_.'/?page=members'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Membres', 'url' => '?page=members'), $pageInfos));
  
  if (Referent::countResponsabilities($m->id()) > 0) {
    $display_referent = '';
    foreach (Referent::Responsabilities($m->id()) as $r) {
      $act = new Activity($r->activity());
      $display_referent .= '<li>'. ucfirst(Display::Referent($r->type(), $m->gender())) .' pour '. $act->name() .' [<a href="./?page=activity&amp;id='. $r->activity() .'">#'. $act->id() .'</a>]</li>';
    }
  }
  
  // Paiements
  $cost_payments = Price::Cost($m->id());
  $total_payments = $cost_payments;
  $display_payments = '';
  // Advantages
  if (Advantage::countAdvantages($m->id()) > 0) {
    $total_payments = Price::Total($m->id());
    $display_payments .= '<h4>Avantages</h4><table class="table table-striped"><thead>
      <tr>
        <!--<th>#</th>-->
        <th>Date</th>
        <th>Montant</th>
        <th>Decsription</th>
        <th></th>
      </tr>
      </thead><tbody>
    ';
    $amount_a = 0.0;
    foreach (Advantage::Advantages($m->id()) as $t) {
      $amount_a += preg_replace('#,#', '.', $t->amount());
      $display_payments .= '
        <tr>
          <!--<td>'. $t->id() .'</td>-->
          <td>'. Display::Date($t->date()) .'</td>
          <td>'. $t->amount() .' &euro;</td>
          <td>'. $t->description() .'</td>
          <td><a href="#confirmBoxA'. $t->id() .'"  role="button" data-toggle="modal" class="normal"><i class="icon-trash"></i></a></td>
        </tr>
      ';
    }
    $display_payments .= '</tbody><tfoot>
      <tr>
        <!--<td></td>-->
        <td style="text-align:right; font-weight:bold;">Total</td>
        <td><span class="label label-info">'. preg_replace('#\.#', ',', $amount_a) .'</span> &euro;</td>
        <td></td>
        <td></td>
      </tr>
    </tfoot></table>';
    foreach (Advantage::Advantages($m->id()) as $t) {
      $display_payments .= '
      <div id="confirmBoxA'. $t->id() .'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelTransaction'. $t->id() .'" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 id="ConfirmDelTransactiont'. $t->id() .'">'. $m->name() .'</h3>
        </div>
        <div class="modal-body">
          <p class="text-error">Êtes-vous sûr de vouloir supprimer cet avantage ?</p>
        </div>
        <div class="modal-footer">
          <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
          <a href="./?page=edit-payment&amp;advantage='. $t->id() .'&amp;action=delete" class="btn btn-danger">Confirmer</a>
        </div>
      </div>
      ';
    }
    $display_payments .= '<h4>Paiements</h4>';
  }
  // Transactions
  if (Transaction::countTransactions($m->id()) > 0) {
    $display_payments .= '<table class="table table-striped"><thead>
      <tr>
        <!--<th>#</th>-->
        <th>Date</th>
        <th>Montant</th>
        <th>Type</th>
        <th>Notes</th>
        <th></th>
      </tr>
      </thead><tbody>
    ';
    $amount_t = 0.0;
    foreach (Transaction::Transactions($m->id()) as $t) {
      $amount_t += preg_replace('#,#', '.', $t->amount());
      $display_payments .= '
        <tr>
          <!--<td>'. $t->id() .'</td>-->
          <td>'. Display::Date($t->date()) .'</td>
          <td>'. $t->amount() .' &euro;</td>
          <td>'. Display::Transaction($t->type()) .'</td>
          <td>'. $t->note() .'</td>
          <td><a href="#confirmBoxT'. $t->id() .'"  role="button" data-toggle="modal" class="normal"><i class="icon-trash"></i></a></td>
        </tr>
      ';
    }
    $display_payments .= '</tbody><tfoot>
      <tr>
        <!--<td></td>-->
        <td style="text-align:right; font-weight:bold;">Total</td>
        <td><span class="label label-'. ($amount_t >= $total_payments ? ($amount_t > $total_payments ? 'warning' : 'success' ) : 'important') .'">'. preg_replace('#\.#', ',', $amount_t) .'</span> &euro;</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tfoot></table>';
    foreach (Transaction::Transactions($m->id()) as $t) {
      $display_payments .= '
      <div id="confirmBoxT'. $t->id() .'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelTransaction'. $t->id() .'" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 id="ConfirmDelTransactiont'. $t->id() .'">'. $m->name() .'</h3>
        </div>
        <div class="modal-body">
          <p class="text-error">Êtes-vous sûr de vouloir supprimer cette transaction ?</p>
        </div>
        <div class="modal-footer">
          <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
          <a href="./?page=edit-payment&amp;transaction='. $t->id() .'&amp;action=delete" class="btn btn-danger">Confirmer</a>
        </div>
      </div>
      ';
    }
  }
  else
    $display_payments .= Price::Total($m->id()) == 0 ? '<div class="alert alert-success">Ce membre est à jour de ses paiements</div>' : '<div class="alert">Aucun paiement n’a encore été effectué !</div>';
  
  // Activités
  $count_activites = Participant::countActivities($m->id());
  $plural_count_activities = $count_activites > 1 ? 's' : '';
  
  $activities_participant = '';
  if ($count_activites >= 1) {
    $activities_participant = '<table class="table table-striped"><thead>
      <tr>
        <th>#</th>
        <th>Activité</th>
        <th>Horaire</th>
      </tr>
      </thead><tbody>
    ';
    foreach (Participant::Activities($m->id()) as $p) {
      $a = new Activity($p->activity());
      if (!$a->aggregate())
        $s = new Schedule($p->schedule());
      $horaire = isset($s) ? Display::Day($s->day()).' &rsaquo; '. $s->time_begin() .' à '. $s->time_end() . ($s->more() != NULL ? '&nbsp; &nbsp;('.$s->more().')' : '') : '<em>Pratique libre</em>';
      $horaire = isset($s) && $s->description() != NULL ? $s->description() : $horaire;
      $activities_participant .= '
        <tr>
          <td>'. $p->id() .'</td>
          <td><a href="./?page=activity&amp;id='. $a->id() .'">'. $a->name() .'</a></td>
          <td>'. $horaire .'</td>
          <td><a href="#confirmBoxP'. $p->id() .'"  role="button" data-toggle="modal" class="normal"><i class="icon-trash"></i></a></td>
        </tr>
      ';
    }
    $activities_participant .= '</tbody></table>';
    foreach (Participant::Activities($m->id()) as $p)
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
          <a href="./?page=edit-participant&amp;id='. $p->id() .'&amp;action=delete" class="btn btn-danger">Confirmer</a>
        </div>
      </div>
      ';
  }

  
}
else {
  quit();
}

?>
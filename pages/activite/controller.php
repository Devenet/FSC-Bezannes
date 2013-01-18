<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\members\Member;
use lib\members\Participant;
use lib\members\Referent;
use lib\content\Message;
use lib\content\Display;

if (isset($_GET['url']) && Activity::isActivityURL($_GET['url'])) {
  
  $act = new Activity(Activity::IDfromURL($_GET['url']));
  
  $pageInfos = array(
   'name' => $act->name(),
   'url' => '/activites.html'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Activités', 'url' => '../activites.html'), $pageInfos));
  
  /* preparation affichage schedules */
  $display_schedules = '';
  if (Schedule::countSchedules($act->id()) > 0) {
    if (Schedule::countSchedulesDays($act->id()) > 0) {
      $display_schedules .= '
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Jour</th>
              <th>Horaire</th>
              <th>Complément</th>
            </tr>
          </thead>
          <tbody>
      ';
      foreach (Schedule::SchedulesDays($act->id()) as $s) {
        $display_schedules .= '
          <tr>
            <td>'. Display::Day($s->day()) .'</td>
            <td>'. $s->time_begin() .' à '. $s->time_end() .'</td>
            <td>'. $s->more() .'</td>
          </tr>
        ';
      }
      $display_schedules .= '</tbody></table>';
    }
    if (Schedule::countSchedulesFree($act->id())>0) {
      $display_schedules .= '
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
      ';
      foreach (Schedule::SchedulesFree($act->id()) as $s) {
        $display_schedules .= '
          <tr>
            <td>'. $s->description() .'</td>
          </tr>
        ';
      }
      $display_schedules .= '</tbody></table>';
    }
  }
  else
    $display_schedules = '<div class="alert">Aucun horaire pour l’instant !</div>';
  
  
  // preparation affichage referents
  $count_referents = Referent::countReferents($act->id());
  //$plural_count_referents = $count_referents > 1 ? 's' : '';
  
  $display_referents = '';
  if ($count_referents >= 1) {
    $display_referents = '<table class="table table-striped"><thead>
      <tr>
        <th>Membre</th>
        <th>Référent</th>
        <th class="center">Téléphone</th>
      </tr>
      </thead><tbody>
    ';
    foreach (Referent::Referents($act->id()) as $r) {
      $m = new Member($r->member());
      $display_referents .= '
        <tr>
          <td>'. $m->name() .'</td>
          <td>'. ucfirst(Display::Referent($r->type())) .'</td>
          <td class="center">'. ($r->display_phone() ? Display::Phone($m->phone()) : Display::Phone(_PHONE_SEC_).' (secrétariat)') .'</td>
        </tr>
      ';
    }
    $display_referents .= '</tbody></table>';
  }
  
  
  
}
else {
  header('Location: /activites.html');
  exit();
}

?>
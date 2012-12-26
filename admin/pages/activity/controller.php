<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\content\Message;

function quit() {
  header('Location: /?page=activities');
  exit();
}

if (isset($_GET['id']) && Activity::isActivity($_GET['id']+0)) {
  
  $act = new Activity($_GET['id']+0);
  
  // suppression activité
  if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $name = $act->name();
    if ($act->delete(true)) {
      $_SESSION['msg'] = new Message('L’activité <em>'. $name .'</em> a bien été supprimée :/', 1, 'Suppression réussie !');
      quit();
    }
    else {
      $_SESSION['msg'] = new Message('Impossible de supprimer l’activité <em>'. $name .'</em>', -1, 'Suppression impossible :/');
      quit();
    }
  }
  // changement activé <-> pas activé
  if (isset($_GET['action']) && $_GET['action'] == 'status') {
    if ($act->active()) {
      $act->changeActive();
      $_SESSION['msg'] = new Message('L’activité a bien été désactivée !', 1, 'Changement effectué');
      header ('Location: /?page=activity&id='.$act->id());
      exit();
    }
    else {
      if (Schedule::countSchedules($act->id())>0) {
        $act->changeActive();
        $_SESSION['msg'] = new Message('L’activité a bien été activée !', 1, 'Changement effectué');
        header ('Location: /?page=activity&id='.$act->id());
        exit();
      }
      else {
        $_SESSION['msg'] = new Message('L’activité ne possède aucun horaire !', -1, 'Impossible d’effectuer le changement');
        header ('Location: /?page=activity&id='.$act->id());
        exit();
      }
    }
  }
  
  
  $pageInfos = array(
   'name' => $act->name(),
   'url' => '/?page=activities'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Activités', 'url' => '?page=activities'), $pageInfos));
  
  /* preparation affihage schedules */
  $display_schedules = '';
  if (Schedule::countSchedules($act->id()) > 0) {
    if (Schedule::countSchedulesDays($act->id()) > 0) {
      $display_schedules .= '
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Jour</th>
              <th>Horaire</th>
              <th>Complément</th>
              <th> </th>
            </tr>
          </thead>
          <tbody>
      ';
      foreach (Schedule::SchedulesDays($act->id()) as $s) {
        $display_schedules .= '
          <tr>
            <td>'. $s->id() .'</td>
            <td>'. $s->day_word() .'</td>
            <td>'. $s->time_begin() .' à '. $s->time_end() .'</td>
            <td>'. $s->more() .'</td>
            <td style="width:45px; text-align:center;">
              <a href="/?page=edit-schedule&id='. $s->id() .'"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
              <a href="#confirmBox'. $s->id() .'" role="button" data-toggle="modal"><i class="icon-trash"></i></a>
            </td>
        ';
      }
      $display_schedules .= '</tbody></table>';
    }
    if (Schedule::countSchedulesFree($act->id())>0) {
      $display_schedules .= '
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Description</th>
              <th> </th>
            </tr>
          </thead>
          <tbody>
      ';
      foreach (Schedule::SchedulesFree($act->id()) as $s) {
        $display_schedules .= '
          <tr>
            <td>'. $s->id() .'</td>
            <td>'. $s->description() .'</td>
            <td style="width:45px; text-align:center;">
              <a href="/?page=edit-schedule&id='. $s->id() .'"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
              <a href="#confirmBox'. $s->id() .'" role="button" data-toggle="modal"><i class="icon-trash"></i></a>
            </td>
        ';
      }
      $display_schedules .= '</tbody></table>';
    }
    foreach (Schedule::Schedules($act->id()) as $s) {
      $display_schedules .= '
        <div id="confirmBox'. $s->id() .'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelSchedule'. $s->id() .'" aria-hidden="true">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="ConfirmDelSchedule'. $s->id() .'">'. $act->name() .'</h3>
        </div>
        <div class="modal-body">
        <p class="text-error">Êtes-vous sûr de vouloir supprimer cet horaire ?</p>
        </div>
        <div class="modal-footer">
        <a class="btn" data-dismiss="modal" aria-hidden="true"/>Annuler</a>
        <a href="/?page=edit-schedule&id='. $s->id() .'&action=delete" class="btn btn-danger">Confirmer</a>
        </div>
        </div>
      ';
    }
  }
  else
    $display_schedules = '<div class="alert">Aucun horaire pour l’instant !</div>';
  
}
else {
  quit();
}

?>
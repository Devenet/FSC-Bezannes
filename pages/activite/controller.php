<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\members\Member;
use lib\members\Participant;
use lib\members\Referent;
use lib\content\Message;
use lib\content\Display;

if (isset($_GET['url']) && Activity::isActiveActivityURL($_GET['url'])) {
  
  $act = new Activity(Activity::IDfromURL($_GET['url']));
  
  $pageInfos = array(
   'name' => $act->name(),
   'url' => '/activites.html'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Activités', 'url' => '../activites.html'), $pageInfos));
  
  /* preparation affichage schedules */
  $display_schedules = '<ul class="unstyled">';
  if (Schedule::countSchedulesDays($act->id()) > 0) {
    foreach (Schedule::SchedulesDays($act->id()) as $s)
      $display_schedules .= '<li><i class="icon-time"></i> '. ucfirst(Display::Day($s->day())) .' &rsaquo; '. $s->time_begin() .' à '. $s->time_end() . ($s->more() != '' ? ' <br /><span style="margin-left:18px; font-style:italic;">'. $s->more() .'</span>' : '') . '</li>' ;
  }
  if (Schedule::countSchedulesFree($act->id())>0) {
    foreach (Schedule::SchedulesFree($act->id()) as $s)
      $display_schedules .= '<li><i class="icon-time"></i> '. $s->description() .'</li>';
  }  
  $display_schedules .= '</ul>';
  
  
  // preparation affichage referents 
  $display_referents = '<ul class="unstyled">';
  $count_referents_respo = Referent::countReferentsByType($act->id());
  $count_referents_anim = Referent::countReferentsByType($act->id(), 1);
  if ($count_referents_respo >= 1) {
    $display_referents .= '<li>Responsable' . ($count_referents_respo > 1 ? 's' : '') . ' <ul>'; 
    foreach (Referent::ReferentsByType($act->id()) as $r) {
      $m = new Member($r->member());
      $display_referents .= '<li>'. $m->name() . ($r->display_phone() ? ' <br />('. Display::Phone($m->phone()) .')' : '') .'</li>';
    }
    $display_referents .= '</ul></li>';
  }
  if ($count_referents_anim >= 1) {
    $display_referents .= '<li>Animateur' . ($count_referents_anim > 1 ? 's' : '') . ' <ul>'; 
    foreach (Referent::ReferentsByType($act->id(), 1) as $r) {
      $m = new Member($r->member());
      $display_referents .= '<li>'. $m->name() . ($r->display_phone() ? ' <br />('. Display::Phone($m->phone()) .')' : '') .'</li>';
    }
    $display_referents .= '</ul></li>';
  }
  $display_referents .= '</ul>';
  
  
  
}
else {
  header('Location: /activites.html');
  exit();
}

?>
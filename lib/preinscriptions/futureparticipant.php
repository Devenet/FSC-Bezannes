<?php

namespace lib\preinscriptions;
use lib\preinscriptions\Preinscription;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\db\SQL;

class FutureParticipant {
  protected $id;
  protected $activity;
  protected $adherent;
  protected $schedule;
  protected $status; 
  private $created;
  
  public function __construct($id = NULL) {
    if (is_int($id+0) && $this->isParticipant($id+0)) {
      $query = SQL::sql()->query('SELECT id, activity, adherent, schedule, status FROM fsc_participants_inscription WHERE id = '. $id);
      $participant = $query->fetch();
      $this->id = $id+0;
      $this->activity = $participant['activity'];
      $this->adherent = $participant['adherent'];
      $this->schedule = $participant['schedule'];
      $this->status = $participant['status'];
      $this->created = true;
      $query->closeCursor();
    }
    else
      $created = false;
  }
  
  public function id() {
    return $this->id;
  }

  public function status() {
    return $this->status;
  }
  public function setStatus($status) {
    $this->status = $status;
    $this->updateStatus();
  }
  private function updateStatus() {
    $query = SQL::sql()->prepare('UPDATE fsc_participants_inscription SET status = :status WHERE id = :id');
    $query->execute(array(
      'status' => $this->status,
      'id' => $this->id
    ));
    $query->closeCursor();
  }
  
  public function activity() {
    return $this->activity;
  }
  public function setActivity($id) {
    if (Activity::isActivity($id+0)) {
      $this->activity = $id+0;
      return true;
    }
    return false;
  }
  
  public function adherent() {
    return $this->adherent;
  }
  public function setAdherent($id) {
    if (Preinscription::isAdherent($id+0)) {
      $this->adherent = $id+0;
      return true;
    }
    return false;
  }
  
  public function schedule() {
    return $this->schedule;
  }
  public function setSchedule($s) {
    if (Schedule::isSchedule($s+0)) {
      $this->schedule = $s+0;
      return true;
    }
    return false;
  }
  
  public function couldCreated() {
    if ($this->schedule != NULL) {
      $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_participants_inscription WHERE activity = :activity AND adherent = :adherent AND schedule = :schedule');
      $prepare = array(
        'activity' => $this->activity,
        'adherent' => $this->adherent,
        'schedule' => $this->schedule
      );
    }
    else {
      $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_participants_inscription WHERE activity = :activity AND adherent = :adherent');
      $prepare = array(
        'activity' => $this->activity,
        'adherent' => $this->adherent
      );
    }
    $query->execute($prepare);
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'] == 0 ? true : false;
  }
  public function create() {
    if (!$this->created && $this->couldCreated()) {
      $query = SQL::sql()->prepare('INSERT INTO fsc_participants_inscription(activity, adherent, schedule) VALUES(:activity, :adherent, :schedule)');
      $prepare = array(
        'activity' => $this->activity,
        'adherent' => $this->adherent,
        'schedule' => $this->schedule
        );
      $query->execute($prepare);
      $query->closeCursor();
      $query = SQL::sql()->prepare('SELECT id FROM fsc_participants_inscription WHERE activity = :activity AND adherent = :adherent AND schedule = :schedule');
      $query->execute($prepare);
      $data = $query->fetch();
      $this->id = $data['id'];
      $query->closeCursor();
      $this->created = true;
      return true;
    }
    else
      return false;
  }
  
  public function delete($bool = false) {
    if ($bool && $this->created) {
      $query = SQL::sql()->prepare('DELETE FROM fsc_participants_inscription WHERE id = :id');
      $query->execute(array('id' => $this->id));
      $query->closeCursor();
      return true;
    }
    return false;
  }
  
  static public function isParticipant($id) {
    $query = SQL::sql()->query('SELECT id FROM fsc_participants_inscription');
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    return in_array($id, $ids);
  }
  
  static public function Activities($adherent) {
    $return = array();
    $query = SQL::sql()->prepare('SELECT id FROM fsc_participants_inscription WHERE adherent = :adherent');
    $query->execute(array('adherent' => $adherent));
    while ($data = $query->fetch())
      $return[] = new FutureParticipant($data['id']);
    return $return;
  }
  
  static public function Adherents($activity, $schedule = NULL) {
    $return = array();
    if ($schedule != NULL) {
      $query = SQL::sql()->prepare('SELECT id FROM fsc_participants_inscription WHERE activity = :activity AND schedule = :schedule');
      $query->execute(array('activity' => $activity, 'schedule' => $schedule));
    }
    else {
      $query = SQL::sql()->prepare('SELECT id FROM fsc_participants_inscription WHERE activity = :activity');
      $query->execute(array('activity' => $activity));
    }
    while ($data = $query->fetch())
      $return[] = new FutureParticipant($data['id']);
    return $return;
  }
  
  static public function countParticipants() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_participants_inscription');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
  static public function countActivities($adherent) {
    $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_participants_inscription WHERE adherent = :adherent');
    $query->execute(array('adherent' => $adherent+0));
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
  static public function countAdherents($activity, $schedule = NULL) {
    if ($schedule != NULL) {
      $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_participants_inscription WHERE activity = :activity AND schedule = :schedule');
      $query->execute(array('activity' => $activity+0, 'schedule' => $schedule+0));
    }
    else {
      $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_participants_inscription WHERE activity = :activity');
      $query->execute(array('activity' => $activity+0));
    }
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
}


?>
<?php

namespace lib\activities;
use lib\db\SQL;
 
class Schedule {
  
  private $id;
  private $activity;
  private $more;
  private $type; // 1: horaire journalier; 0: horaire "libre"
  private $time_begin;
  private $time_end;
  private $description;
  private $created;
  
  public function __construct($id = null) {
    if (is_int($id+0) && $this->isSchedule($id+0)) {
      $query = SQL::sql()->query('SELECT activity, more, type, time_begin, time_end, description FROM fsc_schedules WHERE id = '. $id);
      $schedule = $query->fetch();
      $this->id = $id+0;
      $this->activity = $schedule['activity'];
      $this->more = stripslashes($schedule['more']);
      $this->type = $schedule['type'];
      $this->time_begin = $schedule['time_begin'];
      $this->time_end = $schedule['time_end'];
      $this->description = stripslashes($schedule['description']);
      $this->created = true;
      $query->closeCursor();
    }
    else
      $created = false;
  }
  
  public function id() {
    return $this->id;
  }
  
  public function activity() {
    return $this->activity;
  }
  
  public function more() {
    return $this->more;
  }
  
  public function type() {
    return $this->type;
  }
  
  public function time_begin() {
    return $this->time_begin;
  }
  
  public function time_end() {
    return $this->time_end;
  }
  
  public function description() {
    return $this->description;
  }
  

  private function update_sql($field, $data) {
    $demande = 'UPDATE fsc_schedules SET '. $field .' = \''. $data .'\' WHERE id = '. $this->id .'';
    $query = SQL::sql()->query($demande);
    $query->closeCursor();
  }
  
  public function update() {
    if ($this->created) {
      $this->update_sql('activity', $this->activity);
      $this->update_sql('more', addslashes($this->more));
      $this->update_sql('type', $this->type);
      $this->update_sql('time_begin', $this->time_begin);
      $this->update_sql('time_end', $this->time_end);
      $this->update_sql('description', addslashes($this->description));
    }
  }
  
  public function create() {
    if (!$this->created) {
      $query = SQL::sql()->prepare('INSERT INTO fsc_schedules(activity, more, type, time_begin, time_end, description) VALUES(:activity, :more, :type, :time_begin, :time_end, :description)');
      $prepare = array(
        'activity' => $this->activity,
        'more' => addslashes($this->more),
        'type' => $this->type,
        'time_begin' => $this->time_begin,
        'time_end' => $this->time_end,
        'description' => addslashes($this->description)
        );
      $rep = $query->execute($prepare);
      $query->closeCursor();
      /*
       * On ne récupère pas l'id de l'horaire...
       */
      $this->created = true;
    }
  }
  
  public function delete($bool = false) {
    if ($bool && $this->created) {
      $query = SQL::sql()->prepare('DELETE FROM fsc_schedules WHERE id = :id');
      $query->execute(array('id' => $this->id));
      $query->closeCursor();
      return true;
    }
    return false;
  }
  
  static public function isSchedule($id) {
    $query = SQL::sql()->query('SELECT id FROM fsc_schedules');
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    return in_array($id, $ids);
  }
  
  static public function Schedules($activity) {
    $return = array();
    $query = SQL::sql()->prepare('SELECT id FROM fsc_schedules WHERE activity = :activity');
    $query->execute(array('activity' => $activity));
    while ($data = $query->fetch())
      $return[] = new Schedule($data['id']); 
    $query->closeCursor();
    return $return;
  }
  
  static public function countSchedules($activity) {
    $query = SQL::sql()->prepare('SELECT count(id) AS total FROM fsc_schedules WHERE activity = :activity');
    $query->execute(array('activity' => $activity));
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
  
}
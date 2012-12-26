<?php

namespace lib\activities;
use lib\activities\Activity;
use lib\db\SQL;

 
class Schedule {
  
  private $id;
  private $activity;
  private $more;
  private $type; // 0: horaire journalier; 1: horaire "libre"
  private $day;
  private $days = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
  private $time_begin;
  private $time_end;
  private $description;
  private $created;
  
  public function __construct($id = null) {
    if (is_int($id+0) && $this->isSchedule($id+0)) {
      $query = SQL::sql()->query('SELECT activity, more, type, day, time_begin, time_end, description FROM fsc_schedules WHERE id = '. $id);
      $schedule = $query->fetch();
      $this->id = $id+0;
      $this->activity = $schedule['activity'];
      $this->more = stripslashes($schedule['more']);
      $this->type = $schedule['type'];
      $this->day = $schedule['day'];
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
  public function setActivity($id) {
    if (is_int($id) && Activity::isActivity($id+0)) {
      $this->activity = $id+0;
      return true;
    }
    return false;
  }
  
  public function more() {
    return $this->more;
  }
  public function setMore($string = null) {
    if ($string == null) {
      $this->more = null;
      return true;
    }
    elseif (is_string($string)) {
      $this->more = htmlspecialchars($string);
      return true;
    }
    return false;
  }
  
  public function type() {
    return $this->type;
  }
  public function setType($int = 0) {
    if ($int == 0) {
      $this->type = 0;
      $this->description = null;
    }
    else {
      $this->type = 1;
      $this->day = 1;
      $this->time_begin = '';
      $this->time_end = '';
      $this->more = '';
    }
    return true;
  }
  
  public function day() {
    return $this->day;
  }
  public function day_word() {
    return $this->days[$this->day];
  }
  public function setDay($day = null) {
    if ($this->type == 0) {
      if ($day >= 0 && $day <= 6) {
        $this->day = $day;
        return true;
      }
      return false;
    }
    $this->day = null;
    return true;
  }
  
  public function time_begin() {
    return substr($this->time_begin, 0, -3);
  }
  public function setTimeBegin($hour = null, $minute = null) {
    if ($this->type == 0) {
      if ($hour != null && $minute != null && $hour <= 24 && $hour >= 0 && $minute <= 60 && $minute >= 0) {
        $this->time_begin = $hour .':'. $minute;
        return true;
      }
      return false;
    }
    $this->time_begin = null;
    return true;
  }
  public function time_begin_hour() {
    return substr($this->time_begin, 0, 2);
  }
  public function time_begin_minute() {
    return substr($this->time_begin, 3, 2);
  }
  
  public function time_end() {
    return substr($this->time_end, 0, -3);
  }
  public function setTimeEnd($hour = null, $minute = null) {
    if ($this->type == 0) {
      if ($hour != null && $minute != null &&  $hour <= 24 && $hour >= 0 && $minute <= 60 && $minute >= 0) {
        $this->time_end = $hour .':'. $minute;
        return true;
      }
      return false;
    }
    $this->time_end = null;
    return true;
  }
  public function time_end_hour() {
    return substr($this->time_end, 0, 2);
  }
  public function time_end_minute() {
    return substr($this->time_end, 3, 2);
  }
  
  public function description() {
    return $this->description;
  }
  public function setDescription($string = null) {
    if ($this->type == 1) {
      if ($string != null && is_string($string)) {
        $this->description = htmlspecialchars($string);
        return true;
      }
      return false;
    }
    $this->description = null;
    return true;
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
      $this->update_sql('day', $this->day);
      $this->update_sql('time_begin', $this->time_begin);
      $this->update_sql('time_end', $this->time_end);
      $this->update_sql('description', addslashes($this->description));
    }
  }
  
  public function create() {
    if (!$this->created) {
      $query = SQL::sql()->prepare('INSERT INTO fsc_schedules(activity, more, type, day, time_begin, time_end, description) VALUES(:activity, :more, :type, :day, :time_begin, :time_end, :description)');
      $prepare = array(
        'activity' => $this->activity,
        'more' => addslashes($this->more),
        'type' => $this->type,
        'day' => $this->day,
        'time_begin' => $this->time_begin,
        'time_end' => $this->time_end,
        'description' => addslashes($this->description)
        );
      $rep = $query->execute($prepare);
      $query->closeCursor();
      /* On ne récupère pas l'id de l'horaire... */
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
  
  static public function SchedulesDays($activity) {
    $return = array();
    $query = SQL::sql()->prepare('SELECT id FROM fsc_schedules WHERE activity = :activity AND type = 0');
    $query->execute(array('activity' => $activity));
    while ($data = $query->fetch())
      $return[] = new Schedule($data['id']); 
    $query->closeCursor();
    return $return;
  }
  
  static public function SchedulesFree($activity) {
    $return = array();
    $query = SQL::sql()->prepare('SELECT id FROM fsc_schedules WHERE activity = :activity AND type = 1');
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
  
  static public function countSchedulesDays($activity) {
    $query = SQL::sql()->prepare('SELECT count(id) AS total FROM fsc_schedules WHERE activity = :activity AND type = 0');
    $query->execute(array('activity' => $activity));
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
  static public function countSchedulesFree($activity) {
    $query = SQL::sql()->prepare('SELECT count(id) AS total FROM fsc_schedules WHERE activity = :activity AND type = 1');
    $query->execute(array('activity' => $activity));
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
}
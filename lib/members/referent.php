<?php

namespace lib\members;
use lib\members\Member;
use lib\activities\Activity;
use lib\db\SQL;

class Referent {
  private $id;
  private $activity;
  private $member;
  private $type; // 0: responsable; 1: animateur
  private $display_phone;
  private $created;
  
  public function __construct($id = null) {
    if (is_int($id+0) && $this->isReferent($id+0)) {
      $query = SQL::sql()->query('SELECT id, activity, member, type, display_phone FROM fsc_referents WHERE id = '. $id);
      $member = $query->fetch();
      $this->id = $id+0;
      $this->activity = $member['activity'];
      $this->member = $member['member'];
      $this->type = $member['type'];
      $this->display_phone = $member['display_phone'];
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
    if (Activity::isActivity($id+0)) {
      $this->activity = $id;
      return true;
    }
    return false;
  }
  
  public function member() {
    return $this->member;
  }
  public function setMember($id) {
    if (Member::isMember($id+0)) {
      $this->member = $id+0;
      return true;
    }
    return false;
  }
  
  public function type() {
    return $this->type;
  }
  public function setType($type) {
    if ($type != null) {
      $this->type = ($type == 1) ? 1 : 0;
      return true;
    }
    return false;
  }
  
  public function display_phone() {
    return $this->display_phone;
  }
  public function setDisplayPhone($bool = false) {
    $this->display_phone = ($bool == 1) ? 1 : 0;
    return true;
  }
  
  public function create() {
    if (!$this->created) {
      $query = SQL::sql()->prepare('INSERT INTO fsc_referents(activity, member, type, display_phone) VALUES(:activity, :member, :type, :display_phone)');
      $prepare = array(
        'activity' => $this->activity,
        'member' => $this->member,
        'type' => $this->type,
        'display_phone' => $this->display_phone
        );
      $query->execute($prepare);
      $query->closeCursor();
      $this->created = true;
      return true;
    }
    else
      return false;
  }
  
  public function delete($bool = false) {
    if ($bool && $this->created) {
      $query = SQL::sql()->prepare('DELETE FROM fsc_referents WHERE id = :id');
      $query->execute(array('id' => $this->id));
      $query->closeCursor();
      return true;
    }
    return false;
  }
  
  static public function isReferent($id) {
    $query = SQL::sql()->query('SELECT id FROM fsc_referents');
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    return in_array($id, $ids);
  }
  
  static public function Referents($activity) {
    $return = array();
    $query = SQL::sql()->prepare('SELECT id FROM fsc_referents WHERE activity = ?');
    $query->execute(array($activity));
    while ($data = $query->fetch())
      $return[] = new Referent($data['id']);
    return $return;
  }
  static public function Responsabilities($member) {
    $return = array();
    $query = SQL::sql()->prepare('SELECT id FROM fsc_referents WHERE member = ?');
    $query->execute(array($member));
    while ($data = $query->fetch())
      $return[] = new Referent($data['id']);
    return $return;
  }
  
  static public function countReferents($activity) {
    $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_referents WHERE activity = ?');
    $query->execute(array($activity));
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
  static public function countResponsabilities($member) {
    $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_referents WHERE member = ?');
    $query->execute(array($member));
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
}


?>
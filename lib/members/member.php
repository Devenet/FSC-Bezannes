<?php

namespace lib\members;
use lib\db\SQL;

class Member {
  protected $id;
  protected $gender; // 0: M.; 1: Mme; 2: Mlle
  protected $last_name;
  protected $first_name;
  protected $date_birthday;
  protected $address_number;
  protected $address_street;
  protected $address_further;
  protected $address_zip_code;
  protected $address_town;
  protected $bezannais;
  protected $minor;
  protected $responsible;
  protected $address_different;
  protected $adherent;
  protected $date_registration;
  protected $date_creation;
  private $created;
  
  public function __construct($id = null) {
    if (is_int($id+0) && $this->isMember($id+0)) {
      $query = SQL::sql()->query('SELECT gender, last_name, first_name, date_birthday, address_number, address_street, address_further, address_zip_code, address_town, bezannais, minor, responsible, address_different, adherent, date_registration, date_creation FROM fsc_members WHERE id = '. $id);
      $member = $query->fetch();
      $this->id = $id+0;
      $this->gender = $member['gender'];
      $this->last_name = stripslashes($member['last_name']);
      $this->first_name = stripslashes($member['first_name']);
      $this->date_birthday = $member['date_birthday'];
      $this->address_number = $member['address_number'];
      $this->address_street = stripslashes($member['address_street']);
      $this->address_further = stripslashes($member['address_further']);
      $this->address_zip_code = $member['address_zip_code'];
      $this->address_town = stripslashes($member['address_town']);
      $this->bezannais = $member['bezannais'];
      $this->minor = $member['minor'];
      $this->responsible = $member['responsible'];
      $this->address_different = $member['address_different'];
      $this->adherent = $member['adherent'];
      $this->date_registration = $member['date_registration'];
      $this->date_creation = $member['date_creation'];
      $this->created = true;
      $query->closeCursor();
    }
    else
      $created = false;
  }
  
  public function id() {
    return $this->id;
  }
  
  public function gender() {
    return $this->gender;
  }
  public function setGender($gender) {
    if ($gender != null && $gender >= 0 && $gender <= 2) {
      $this->gender = $gender+0;
      return true;
    }
    return false;
  }
  
  public function last_name() {
    return $this->last_name;
  }
  public function setLastName($name) {
    if ($name != null) {
      $this->last_name = htmlspecialchars($name);
      return true;
    }
    return false;
  }
  
  public function first_name() {
    return $this->first_name;
  }
  public function setFirstName($name) {
    if ($name != null) {
      $this->first_name = htmlspecialchars($name);
      return true;
    }
    return false;
  }
  
  public function name() {
    return $this->last_name .' '. $this->first_name;
  }
  
  public function date_birthday() {
    return $this->date_birthday;
  }
  public function setDateBirthday($year, $month, $day) {
    if ($year != null && $year != null && $day != null && $year >= 1920 && $year <= date('Y')-1 && $month >= 1 && $month <= 12 && $day >= 1 && $day <= 31) {
      $this->date_birthday = $year.'-'.$month.'-'.$day;
      return true;
    }
    return false;
  }
  
  public function bezannais() {
    return $this->bezannais;
  }
  
  public function adherent() {
    return $this->adherent;
  }
  
  static public function isMember($id) {
    $query = SQL::sql()->query('SELECT id FROM fsc_members');
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    return in_array($id, $ids);
  }
  
  static public function Members() {
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_members');
    while ($data = $query->fetch())
      $return[] = new Member($data['id']); 
    $query->closeCursor();
    return $return;
  }
  
  static public function Adults() {
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_members WHERE minor = 0');
    while ($data = $query->fetch())
      $return[] = new Member($data['id']); 
    $query->closeCursor();
    return $return;
  }
  
  static public function Teenagers() {
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_members WHERE minor = 1');
    while ($data = $query->fetch())
      $return[] = new Member($data['id']); 
    $query->closeCursor();
    return $return;
  }
  
  static public function Adherents() {
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_members WHERE adherent = 1');
    while ($data = $query->fetch())
      $return[] = new Member($data['id']); 
    $query->closeCursor();
    return $return;
  }
  
  static public function countMembers() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_members');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
  static public function countAdults() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_members WHERE minor = 0');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
  static public function countTeenagers() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_members WHERE minor = 1');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
  static public function countAdherents() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_members WHERE adherent = 1');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
}


?>
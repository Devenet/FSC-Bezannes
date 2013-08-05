<?php

/**
 * (c) 2012-2013  Nicolas Devenet <nicolas@devenet.info>
 * Code source hosted on https://github.com/nicolabricot/FSC-Bezannes
 */

namespace lib\payments;
use lib\members\Member;
use lib\DB\SQL;

class Advantage {
  
  private $id;
  private $adherent;
  private $amount;
  private $date;
  private $description;
  private $created;
  
  public function __construct($id = NULL) {
    if ($id != NULL && Advantage::isAdvantage($id+0)) {
      $query = SQL::sql()->prepare('SELECT id, adherent, amount, date, description FROM fsc_payments_advantages WHERE id = ?');
      $query->execute(array($id+0));
      $data = $query->fetch();
      $this->id = $data['id'];
      $this->adherent = $data['adherent'];
      $this->amount = $data['amount'];
      $this->date = $data['date'];
      $this->description = stripslashes($data['description']);
      $query->closeCursor();
      $this->created = true;
    }
    else
      $this->created = false;
  }
  
  public function id() {
    return $this->id;
  }
  
  public function adherent() {
    return $this->adherent;
  }
  public function setAdherent($id) {
    if ($id != NULL && Member::isAdherent($id+0)) {
      $this->adherent = $id+0;
      return true;
    }
    return false;
  }
  
  public function amount() {
    return preg_replace('#\.#', ',', $this->amount);
  }
  public function setAmount($amount) {
    $amount = preg_replace('#,#', '.', $amount) + 0;
    if ($amount != NULL && (is_int($amount) || is_double($amount) || is_float($amount))) {
      $this->amount = $amount;
      return true;
    }
    return false;
  }
  
  public function date() {
    return $this->date;
  }
  public function setDate($year, $month, $day) {
    if ($year != NULL && $month != NULL && $day != NULL && $year >= _YEAR_ && $year <= _YEAR_+1 && $month >= 1 && $month <= 12 && $day >= 1 && $day <= 31) {
      $this->date = $year.'-'.$month.'-'.$day;
      return true;
    }
    return false;
  }
  public function date_year() {
    $date = explode('-', $this->date);
    return $date[0];
  }
  public function date_month() {
    $date = explode('-', $this->date);
    return $date[1];
  }
  public function date_day() {
    $date = explode('-', $this->date);
    return $date[2];
  }
  
  public function description() {
    return htmlspecialchars_decode($this->description);
  }
  public function setDescription($string) {
    if ($string != NULL) {
      $this->description = htmlspecialchars($string);
      return true;
    }
    return false;
  }
  
  public function create() {
    if (!$this->created) {
      $query = SQL::sql()->prepare('INSERT INTO fsc_payments_advantages(adherent, amount, date, description) VALUES(:adherent, :amount, :date, :description)');
      $query->execute(
        array(
          'adherent' => $this->adherent,
          'amount' => $this->amount,
          'date' => $this->date,
          'description' => addslashes($this->description)
        )
      );
      $query->closeCursor();
      $this->created = true;
    }
  }
  
  public function delete($bool = false) {
    if ($bool && $this->created) {
      $query = SQL::sql()->prepare('DELETE FROM fsc_payments_advantages WHERE id = ?');
      $query->execute(array($this->id));
      $query->closeCursor();
      return true;
    }
    return false;
  }
  
  public static function Advantages($adherent) {
    $query = SQL::sql()->prepare('SELECT id FROM fsc_payments_advantages WHERE adherent = ?');
    $query->execute(array($adherent+0));
    $return = array();
    while ($data = $query->fetch())
      $return[] = new Advantage($data['id']);
    $query->closeCursor();
    return $return;
  }
  
  public static function isAdvantage($id) {
    $query = SQL::sql()->query('SELECT id FROM fsc_payments_advantages');
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    $query->closeCursor();
    return in_array($id, $ids);
  }
  
  public static function countAdvantages($adherent) {
    $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_payments_advantages WHERE adherent = ?');
    $query->execute(array($adherent+0));
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

}

?>
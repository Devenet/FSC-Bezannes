<?php

namespace lib\payments;
use lib\members\Member;
use lib\DB\SQL;

class Transaction {
  
  private $id;
  private $adherent;
  private $amount;
  private $date;
  private $type; // 0: cheque; 1: espece; 2: cheque vacances; 3: autre
  private $note;
  private $created;
  
  public function __construct($id = null) {
    if ($id != null && Transaction::isTransaction($id+0)) {
      $query = SQL::sql()->prepare('SELECT id, adherent, amount, date, type, note FROM fsc_payments_transactions WHERE id = ?');
      $query->execute(array($id+0));
      $data = $query->fetch();
      $this->id = $data['id'];
      $this->adherent = $data['adherent'];
      $this->amount = $data['amount'];
      $this->date = $data['date'];
      $this->type = $data['type'];
      $this->note = stripslashes($data['note']);
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
    if ($id != null && Member::isAdherent($id+0)) {
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
    if ($amount != null && $amount >= 0) {
      $this->amount = $amount;
      return true;
    }
    return false;
  }
  
  public function date() {
    return $this->date;
  }
  public function setDate($year, $month, $day) {
    if ($year != null && $month != null && $day != null && $year >= _YEAR_ && $year <= _YEAR_+1 && $month >= 1 && $month <= 12 && $day >= 1 && $day <= 31) {
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
  
  public function type() {
    return $this->type;
  }
  public function setType($type) {
    if ($type != null && $type+0 >= 0 && $type <= 3) {
      $this->type = $type+0;
      return true;
    }
    return false;
  }
  
  public function note() {
    return htmlspecialchars_decode($this->note);
  }
  public function setNote($string) {
    if ($string != null) {
      $this->note = htmlspecialchars($string);
      return true;
    }
    $this->note = '';
    return true;
  }
  
  public function create() {
    if (!$this->created) {
      $query = SQL::sql()->prepare('INSERT INTO fsc_payments_transactions(adherent, amount, date, type, note) VALUES(:adherent, :amount, :date, :type, :note)');
      $query->execute(
        array(
          'adherent' => $this->adherent,
          'amount' => $this->amount,
          'date' => $this->date,
          'type' => $this->type,
          'note' => addslashes($this->note)
        )
      );
      $query->closeCursor();
      $this->created = true;
    }
  }
  
  public function delete($bool = false) {
    if ($bool && $this->created) {
      $query = SQL::sql()->prepare('DELETE FROM fsc_payments_transactions WHERE id = ?');
      $query->execute(array($this->id));
      $query->closeCursor();
      return true;
    }
    return false;
  }
  
  public static function Transactions($adherent) {
    $query = SQL::sql()->prepare('SELECT id FROM fsc_payments_transactions WHERE adherent = ?');
    $query->execute(array($adherent+0));
    $return = array();
    while ($data = $query->fetch())
      $return[] = new Transaction($data['id']);
    $query->closeCursor();
    return $return;
  }
  
  public static function isTransaction($id) {
    $query = SQL::sql()->query('SELECT id FROM fsc_payments_transactions');
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    $query->closeCursor();
    return in_array($id, $ids);
  }
  
  public static function countTransactions($adherent) {
    $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_payments_transactions WHERE adherent = ?');
    $query->execute(array($adherent+0));
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

}

?>
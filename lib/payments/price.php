<?php

namespace lib\payments;
use lib\members\Member;
use lib\DB\SQL;

class Price {
  
  public static $adult = array(20, 16);
  public static $teen = array(14, 10);
  
  public static function Cost($adherent) {
    $return = 0.0;
    $a = new Member($adherent);
    
    // cotisation adhérent
    if ($a->minor())
      $return += Price::$teen[$a->bezannais()];
    else
      $return += Price::$adult[$a->bezannais()];
      
    // activites
    $query = SQL::sql()->prepare('SELECT price, price_young FROM fsc_activities INNER JOIN fsc_participants ON fsc_participants.activity = fsc_activities.id WHERE fsc_participants.adherent = ?');
    $query->execute(array($a->id()));
    while ($data = $query->fetch()) {
      if ($data['price_young'] != -1 && $a->minor())
        $return += $data['price_young'];
      else
        $return += $data['price'];
    }
    $query->closeCursor();
    
    return $return;
  }
  
  public static function Total($adherent) {
    $a = new Member($adherent);
    $return = Price::Cost($a->id());
    
    $query = SQL::sql()->prepare('SELECT amount FROM fsc_payments_advantages WHERE adherent = ?');
    $query->execute(array($a->id()));
    while ($data = $query->fetch())
      $return -= $data['amount'];
    $query->closeCursor();
    
    return $return;
  }
  
  
}

?>
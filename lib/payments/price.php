<?php

namespace lib\payments;
use lib\members\Member;
use lib\DB\SQL;

class Price {
  
  public static function price($age, $bezannais) {
    $file = dirname(__FILE__).'/../../config/price.json';
    if (file_exists($file)) {
      $price = json_decode(file_get_contents($file));
      
      if ($age == 1)
        return $price->teen[$bezannais];
      return $price->adult[$bezannais];
    }
    else {
      echo 'Price file not found';
      exit();
    }
  }
  
  public static function Cost($adherent) {
    $return = 0.0;
    $a = new Member($adherent);
    
    // cotisation adhérent
    $return += self::price($a->minor(), $a->bezannais());
      
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
<?php

namespace lib\users;
use lib\db\SQL;

abstract class Privilege {
  
  const GOD = 9;
  const ADMINISTRATOR = 8;
  const MANAGER = 7;
  const VISITOR = 2;
  const REFERENT = 1;
  const DISABLED = 0;

  static function Translation($int) {
    $tr = array(
      'disabled',
      'referent', 
      'visitor', 
      '', 
      '', 
      '', 
      '', 
      'manager', 
      'administrator', 
      'god'
    );
    return $tr[$int];
  }

  static function FrenchTranslation($int) {
    $tr = array(
      'désactivé', 
      'référant', 
      'visiteur', 
      '', 
      '', 
      '', 
      '', 
      'gestionnaire', 
      'administrateur', 
      'dieu'
    );
    return $tr[$int];
  }
  
}

?>
<?php

namespace lib\content;

class Display {
  
  static public function Phone($phone) {
    return preg_replace('#([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})#', '$1 $2 $3 $4 $5', $phone);
  }
  
  static public function Email($email) {
    return '<a href="mailto:'. $email .'" title="'. $email .'">'. $email .'</a>';
  }
  
  static public function FullGender($gender) {
    $genders = array ('Monsieur', 'Madame', 'Mademoiselle');
    return $genders[$gender];
  }
  
  static public function Gender($gender) {
    $genders = array ('M.', 'Mme', 'Mlle');
    return $genders[$gender];
  }
  
  static public function Date($date) {
    $date = explode('-', $date);
    return $date[2] .'.'. $date[1] .'.'. $date[0];
  }
  
  static public function FullTimestamp($time) {
    $time = preg_split('/[-\s]/', $time);
    return $time[2] .' '. Display::Month($time[1]) .' '. $time[0] .' à '. $time[3];
  }
  static public function FullTimestampDate($time) {
    $time = preg_split('/[-\s]/', $time);
    return $time[2] .' '. Display::Month($time[1]) .' '. $time[0];
  }
  static public function FullTimestampHour($time) {
    $time = preg_split('/[-\s]/', $time);
    return $time[3];
  }
  
  static public function Day($day) {
    $days = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
    return $days[$day];
  }
  
  static public function Month($month) {
    $months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    return $months[$month-1];
  }
  
  static public function Referent($type, $gender = 0) {
    $types = array('responsable', 'animateur', 'animatrice');
    return $types[($type == 1 && $gender != 0 ? $type+1 : $type )];
  }
  
  static public function Transaction($type) {
    $types = array('chèque', 'espèces', 'chèques vacances', 'autre');
    return $types[$type];
  }
  
  static public function Privilege($int) {
    $privileges = array('disabled', 'referent', '', '', '', '', '', 'manager', 'administrator', 'god');
    return $privileges[$int];
  }
  static public function FrenchPrivilege($int) {
    $privileges = array('désactivé', 'référant', '', '', '', '', '', 'gestionnaire', 'administrateur', 'dieu');
    return $privileges[$int];
  }
  
  static public function Double($double) {
    return $double;
  }
  
}
?>

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
  
  static public function Day($day) {
    $days = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
    return $days[$day];
  }
  
  static public function Referent($type) {
    $types = array('responsable', 'animateur');
    return $types[$type];
  }
  
  static public function Transaction($type) {
    $types = array('chèque', 'espèces', 'chèques vacances', 'autre');
    return $types[$type];
  }
  
  static public function Double($double) {
    return $double;
  }
  
}
?>

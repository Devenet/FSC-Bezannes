<?php

namespace lib\preinscriptions;
use lib\db\SQL;
use lib\users\UserInscription;
use lib\content\Pagination;

class Preinscription {

  const AWAITING = 0;
  const VALIDATED = 1;
  const INCOMPLETE = 2;
  const REJECTED = 3;

  static public function Status($status) {
    $display = array('awaiting', 'validated', 'incomplete', 'rejected');
    return $display[$status];
  }
  static public function FrenchStatus($status) {
    $display = array('en attente', 'validée', 'incomplète', 'rejetée');
    return $display[$status];
  }
  static public function StatusDescription($status) {
    $display = array('En attente de validation', 'Préinscription validée', 'Préinscription partiellement validée', 'Préinscription rejetée');
    return $display[$status];
  }
  static public function StatusIcon($status) {
    $display = array('time', 'ok-sign', 'warning-sign', 'ban-circle');
    return '<i class="icon-'. $display[$status] .'"></i>';
  }
  static public function StatusColor($status) {
    $display = array('muted', 'success', 'warning','error');
    return $display[$status];
  }
  static public function StatusTooltip($status, $placement = 'bottom') {
    return '<span data-toggle="tooltip" data-placement="bottom" data-title="'. self::StatusDescription($status) .'" 
      class="normal cursor-default text-'. self::StatusColor($status) .'">'. self::StatusIcon($status) .'</span>';
  }

  static public function Preinscriptions($start = 0, $step = NULL) {
    $step = is_null($step) ? Pagination::step() : $step;
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_users_inscription LIMIT '. $start .','. $step);
    while ($data = $query->fetch())
      $return[] = new UserInscription($data['id']); 
    $query->closeCursor();
    return $return;
  }

  static public function PreinscriptionsByStatus($start = 0, $sens = true, $step = NULL) {
    $step = is_null($step) ? Pagination::step() : $step;
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_users_inscription ORDER BY status '. ($sens ? 'DESC' :  '') .', login LIMIT '. $start .','. $step);
    while ($data = $query->fetch())
      $return[] = new UserInscription($data['id']); 
    $query->closeCursor();
    return $return;
  }

  static public function PreinscriptionsByLogin($start = 0, $sens = true, $step = NULL) {
    $step = is_null($step) ? Pagination::step() : $step;
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_users_inscription ORDER BY login '. ($sens ? '' :  'DESC') .' LIMIT '. $start .','. $step);
    while ($data = $query->fetch())
      $return[] = new UserInscription($data['id']); 
    $query->closeCursor();
    return $return;
  }

  static public function countAccounts() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_users_inscription');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

  static public function countPreinscriptions() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_members_inscription');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

  static public function countAdherents() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_members_inscription WHERE adherent = 1');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

}

?>
<?php

/**
 * (c) 2012-2013  Nicolas Devenet <nicolas@devenet.info>
 * Code source hosted on https://github.com/nicolabricot/FSC-Bezannes
 */

namespace lib\preinscriptions;
use lib\db\SQL;
use lib\users\UserInscription;
use lib\content\Pagination;
use lib\laravel\Str;

class Preinscription {

  const AWAITING = 0;
  const VALIDATED = 1;
  const INCOMPLETE = 2;
  const REJECTED = 3;

  /* BEGIN OF PRE-MEMBER */

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
  protected $email;
  protected $phone;
  protected $mobile;
  protected $bezannais;
  protected $minor;
  protected $responsible;
  protected $address_different;
  protected $adherent;
  protected $date_creation;
  protected $id_user_inscription;
  protected $status;
  protected $id_member = 0;
  private $created;
  
  public function __construct($id = NULL) {
    if (is_int($id+0) && $this->isMember($id+0)) {
      $query = SQL::sql()->query('SELECT gender, last_name, first_name, date_birthday, address_number, address_street, address_further, address_zip_code, address_town, phone, email, mobile, bezannais, minor, responsible, address_different, adherent, date_creation, id_user_inscription, status, id_member FROM fsc_members_inscription WHERE id = '. $id);
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
      $this->phone = $member['phone'];
      $this->email = $member['email'];
      $this->mobile = $member['mobile'];
      $this->bezannais = $member['bezannais'];
      $this->minor = $member['minor'];
      $this->responsible = $member['responsible'];
      $this->address_different = $member['address_different'];
      $this->adherent = $member['adherent'];
      $this->date_creation = $member['date_creation'];
      $this->id_user_inscription = $member['id_user_inscription'];
      $this->status = $member['status'];
      $this->id_member = $member['id_member'];
      $this->created = true;
      $query->closeCursor();
    }
    else
      $created = false;
  }
  
  public function id() {
    return $this->id;
  }

  public function id_user_inscription() {
    return $this->id_user_inscription;
  }
  public function setIDUserInscription($id) {
    $this->id_user_inscription = $id;
  }
  
  public function status() {
    return $this->status;
  }
  public function setStatus($status) {
    $this->status = $status;
    $this->update_sql('status', $this->status);
  }
  public function checkStatus() {
    switch($this->status) {
      case self::INCOMPLETE:
        $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM `fsc_participants_inscription` WHERE adherent = :id');
        $query->execute(array('id' => $this->id));
        $data = $query->fetch();
        $total = $data['total'];
        $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM `fsc_participants_inscription` WHERE adherent = :id AND STATUS = :status');
        $query->execute(array('id' => $this->id, 'status' => self::VALIDATED));
        $data = $query->fetch();
        $validated = $data['total'];
        $query->closeCursor();
        if ($validated == $total) {
          $this->setStatus(self::VALIDATED);
          return TRUE;
        }
        return FALSE;
        break;

      case self::VALIDATED:
      case self::REJECTED:
      default:
        return FALSE;
        break;
    }
  }

  public function gender() {
    return $this->gender;
  }
  public function setGender($gender) {
    if ($gender != NULL && $gender >= 0 && $gender <= 2) {
      $this->gender = $gender+0;
      return true;
    }
    return false;
  }
  
  public function last_name() {
    return $this->last_name;
  }
  public function setLastName($name) {
    if ($name != NULL) {
      $this->last_name = Str::title(htmlspecialchars($name));
      return true;
    }
    return false;
  }
  
  public function first_name() {
    return $this->first_name;
  }
  public function setFirstName($name) {
    if ($name != NULL) {
      $this->first_name = Str::title(htmlspecialchars($name));
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
    if ($year != NULL && $month != NULL && $day != NULL && $year >= date('Y')-100 && $year <= date('Y')-1 && $month >= 1 && $month <= 12 && $day >= 1 && $day <= 31) {
      if ($month == 2) {
        // bissextile (et 29 days max) ou 28 days max
        if ((date("L", mktime(0, 0, 0, 1, 1, $year)) == 1 && $day <= 29) || $day <= 28) {
          $this->date_birthday = $year.'-'.$month.'-'.$day;
          return true;
        }
        else
          return false;
      }
      else {
        $this->date_birthday = $year.'-'.$month.'-'.$day;
        return true;
      }
    }
    return false;
  }
  public function age() {
    $date = explode('-', $this->date_birthday);
    return (date('m') >= $date[1] ? date('Y') - $date[0] : date('Y') - $date[0] - 1);
  }
  public function date_birthday_year() {
    $date = explode('-', $this->date_birthday);
    return $date[0];
  }
  public function date_birthday_month() {
    $date = explode('-', $this->date_birthday);
    return $date[1];
  }
  public function date_birthday_day() {
    $date = explode('-', $this->date_birthday);
    return $date[2];
  }
  
  public function minor() {
    return $this->minor;
  }
  public function setMinor() {
    // Jeune après le 1er septembre inclus
    $date = explode('-', $this->date_birthday);
    if ($date[0] < (_YEAR_ - 18)) {
      $this->minor = 0;
      $this->address_different = 0;
    }
    else if ($date[0] > (_YEAR_ - 18))
      $this->minor = 1;
    else if ($date[1] < 9) {
      $this->minor = 0;
      $this->address_different = 0;
    }
    else
      $this->minor = 1;
  }
  
  public function address_different() {
    return $this->address_different;
  }
  public function setAddressDifferent($bool = NULL) {
    if (!$this->minor()) {
      $this->address_different = 0;
      return true;
    }
    else {
      $this->address_different = ($bool == 1 ? 1 : 0);
      return true;
    }
    return false;
  }
  
  public function address_number() {
    return $this->address_number;
  }
  public function setAddressNumber($number) {
    // peut etre 1bis
    if ($number != NULL) {
      $this->address_number = htmlspecialchars($number);
      return true;
    }
    return false;
  }
  
  public function address_street() {
    return $this->address_street;
  }
  public function setAddressStreet($street) {
    if ($street != NULL) {
      $this->address_street = ucwords(mb_strtolower(htmlspecialchars($street), 'UTF-8'));
      return true;
    }
    return false;
  }
  
  public function address_further() {
    return $this->address_further;
  }
  public function setAddressFurther($further = NULL) {
    $this->address_further = ucwords(mb_strtolower(htmlspecialchars($further), 'UTF-8'));;
    return true;
  }
  
  public function address_zip_code() {
    return $this->address_zip_code;
  }
  public function setAddressZipCode($zip) {
    if ($zip != NULL && $zip > 0 && $zip <= 99000) {
      $this->address_zip_code = $zip;
      return true;
    }
    return false;
  }
  
  public function address_town() {
    return $this->address_town;
  }
  public function setAddressTown($town) {
    if ($town != NULL) {
      $this->address_town = preg_replace('#((\s)+$)|(^(\s)+)#', '', ucwords(mb_strtolower(htmlspecialchars($town), 'UTF-8')));
      return true;
    }
    return false;
  }
  
  public function address() {
    return $this->address_number .' '. $this->address_street .'<br />'. ($this->address_further != NULL ? $this->address_further.'<br />' : NULL) . $this->address_zip_code .' '. $this->address_town;
  }
  
  public function bezannais() {
    return $this->bezannais;
  }
  public function setBezannais() {
    // mineur
    if ($this->minor) {
      $respo = new Preinscription($this->responsible);
      if ($respo->bezannais())
        $this->bezannais = 1;
      elseif ($this->address_different && $this->address_zip_code == 51430 && $this->address_town == 'Bezannes')
        $this->bezannais = 1;
      else
        $this->bezannais = 0;
    }
    // majeur
    else {
      if ($this->address_zip_code == 51430 && $this->address_town == 'Bezannes')
        $this->bezannais = 1;
      else
        $this->bezannais = 0;
    }
  }
  public function email() {
    return $this->email;
  }
  public function setEmail($email) {
    if ($email != NULL && preg_match('#^[a-z0-9._\+-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', strtolower(htmlspecialchars($email)))) {
      $this->email = strtolower(htmlspecialchars($email));
      return true;
    }
    return false;
  }
  
  public function phone() {
    return $this->phone;
  }
  public function setPhone($phone) {
    if ($phone != NULL && preg_match('#^0[1-9]([0-9]{2}){4}$#', $phone)) {
      $this->phone = htmlspecialchars($phone);
      return true;
    }
    return false;
  }
  
  public function mobile() {
    return $this->mobile;
  }
  public function setMobile($phone = NULL) {
    if ($phone != NULL) {
      if (preg_match('#^0[1-9]([0-9]{2}){4}$#', $phone)) {
        $this->mobile = htmlspecialchars($phone);
        return true;
      }
      else
        return false;
    }
    else {
      $this->mobile = '';
      return true;
    }
  }
  
  public function responsible() {
    return $this->responsible;
  }
  public function setResponsible($id) {
    if ($id != NULL && $this->isAdult($id+0)) {
      $this->responsible = $id+0;
      return true;
    }
    return false;
  }
  
  public function adherent() {
    return $this->adherent;
  }
  public function setAdherent($bool) {
    $this->adherent = ($bool == 1) ? 1 : 0;
    if (!$this->adherent) {
      $query = SQL::sql()->prepare('DELETE FROM fsc_participants_inscription WHERE adherent = :adherent');
      $query->execute(array('adherent' => $this->id));
      $query->closeCursor();
    }
  }

  public function id_member() {
    return $this->id_member;
  }
  public function setIDMember($id) {
    $this->id_member = $id+0;
    $this->update_sql('id_member', $this->id_member);
  }
  
  public function date_creation() {
    return $this->date_creation;
  }

  private function update_sql($field, $data) {
    $demande = 'UPDATE fsc_members_inscription SET '. $field .' = \''. $data .'\' WHERE id = '. $this->id .'';
    $query = SQL::sql()->query($demande);
    $query->closeCursor();
  }
  
  public function update() {
    if ($this->created) {
      $this->update_sql('gender', $this->gender);
      $this->update_sql('last_name', addslashes($this->last_name));
      $this->update_sql('first_name', addslashes($this->first_name));
      $this->update_sql('date_birthday', $this->date_birthday);
      $this->update_sql('address_number', addslashes($this->address_number));
      $this->update_sql('address_street', addslashes($this->address_street));
      $this->update_sql('address_further', addslashes($this->address_further));
      $this->update_sql('address_zip_code', $this->address_zip_code);
      $this->update_sql('phone', $this->phone);
      $this->update_sql('email', $this->email);
      $this->update_sql('mobile', $this->mobile);
      $this->update_sql('address_town', addslashes($this->address_town));
      $this->update_sql('bezannais', $this->bezannais);
      $this->update_sql('minor', $this->minor);
      $this->update_sql('responsible', $this->responsible);
      $this->update_sql('address_different', $this->address_different);
      $this->update_sql('adherent', $this->adherent);
    }
  }
  
  public function create() {
    if (!$this->created) {
      $fake_id = time()-rand(1000, 100000);      
      $query = SQL::sql()->prepare('INSERT INTO fsc_members_inscription(gender, last_name, first_name, date_birthday, address_number, address_street, address_further, address_zip_code, address_town, phone, email, mobile, bezannais, minor, responsible, address_different, adherent, date_creation, id_user_inscription) VALUES(:gender, :last_name, :first_name, :date_birthday, :address_number, :address_street, :address_further, :address_zip_code, :address_town, :phone, :email, :mobile, :bezannais, :minor, :responsible, :address_different, :adherent, :date_creation, :id_user_inscription)');
      $prepare = array(
        'gender' => $this->gender,
        'last_name' => addslashes($this->last_name),
        'first_name' => addslashes($this->first_name),
        'date_birthday' => $this->date_birthday,
        'address_number' => addslashes($this->address_number),
        'address_street' => addslashes($this->address_street),
        'address_further' => addslashes($this->address_further),
        'address_zip_code' => $this->address_zip_code == NULL ? '' : $this->address_zip_code,
        'address_town' => addslashes($this->address_town),
        'phone' => $this->phone,
        'email' => $this->email,
        'mobile' => $this->mobile,
        'bezannais' => $this->bezannais,
        'minor' => $this->minor,
        'responsible' => $this->responsible,
        'address_different' => $this->address_different,
        'adherent' => $this->adherent,
        'date_creation' => date('Y').':'.date('m').':'.date('d'),
        'id_user_inscription' => $this->id_user_inscription
        );
      $query->execute($prepare);
      $this->id = SQL::sql()->lastInsertId();
      $query->closeCursor();
      $this->created = true;
    }
  }
  
  public function delete($bool = false) {
    if ($bool && $this->created) {
      // suppression membre
      $query = SQL::sql()->prepare('DELETE FROM fsc_members_inscription WHERE id = :id');
      $query->execute(array('id' => $this->id));
      // suppression participant
      $query = SQL::sql()->prepare('DELETE FROM fsc_participants_inscription WHERE adherent = :id');
      $query->execute(array('id' => $this->id));
      $query->closeCursor();
      return true;
    }
    return false;
  }
  
  static public function isMember($id, $id_user_inscription = 0) {
    if ($id_user_inscription == 0)
      $query = SQL::sql()->query('SELECT id FROM fsc_members_inscription');
    else {
      $query = SQL::sql()->prepare('SELECT id FROM fsc_members_inscription WHERE id_user_inscription = :id_user_inscription');
      $query->execute(array('id_user_inscription' => $id_user_inscription));
    }
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    return in_array($id, $ids);
  }
  
  static public function isAdherent($id,  $id_user_inscription = 0) {
    if ($id_user_inscription == 0)
      $query = SQL::sql()->query('SELECT id FROM fsc_members_inscription WHERE adherent = 1');
    else {
      $query = SQL::sql()->prepare('SELECT id FROM fsc_members_inscription WHERE adherent = 1 AND id_user_inscription = :id_user_inscription');
      $query->execute(array('id_user_inscription' => $id_user_inscription));
    }
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    return in_array($id, $ids);
  }
  
  static public function isAdult($id) {
    $query = SQL::sql()->query('SELECT id FROM fsc_members_inscription WHERE minor = 0');
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    return in_array($id, $ids);
  }
  
  static public function Members($id = 0) {
    $return = array();
    if ($id == 0)
      $query = SQL::sql()->query('SELECT id FROM fsc_members_inscription ORDER BY id ');
    else {
      $query = SQL::sql()->prepare('SELECT id FROM fsc_members_inscription WHERE id_user_inscription = :id ORDER BY id');
      $query->execute(array('id' => $id));
    }
    while ($data = $query->fetch())
      $return[] = new Preinscription($data['id']); 
    $query->closeCursor();
    return $return;
  }
  
  
  static public function Adults($id = 0) {
    $return = array();
    if ($id == 0)
      $query = SQL::sql()->query('SELECT id FROM fsc_members_inscription WHERE minor = 0 ORDER BY last_name, first_name');
    else {
      $query = SQL::sql()->prepare('SELECT id FROM fsc_members_inscription WHERE minor = 0 AND id_user_inscription = :id ORDER BY last_name, first_name');
      $query->execute(array('id' => $id));
    }
    while ($data = $query->fetch())
      $return[] = new Preinscription($data['id']); 
    $query->closeCursor();
    return $return;
  }
   
  public function Responsabilities() {
    $return = array();
    $query = SQL::sql()->prepare('SELECT id FROM fsc_members_inscription WHERE responsible = :id');
    $query->execute(array('id' => $this->id));
    while ($data = $query->fetch())
      $return[] = new Preinscription($data['id']); 
    $query->closeCursor();
    return $return;
  }
  
  static public function countMembers($id = 0) {
    if ($id == 0)
      $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_members_inscription');
    else {
      $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_members_inscription WHERE id_user_inscription = :id');
      $query->execute(array('id' => $id));
    }
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
  static public function countAdults($id = 0) {
    if ($id == 0)
      $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_members_inscription WHERE minor = 0');
    else {
      $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_members_inscription WHERE minor = 0 AND id_user_inscription = :id');
      $query->execute(array('id' => $id));
    }
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
  
  public function countResponsabilities() {
    $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_members_inscription WHERE responsible = :id');
    $query->execute(array('id' => $this->id));
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }


  /* END OF PRE-MEMBER */

  static public function StatusText($status) {
    $display = array('en attente', 'validée', 'incomplète', 'rejetée');
    return $display[$status];
  }
  static public function StatusDescription($status) {
    $display = array('En attente de validation', 'Préinscription validée', 'Préinscription partiellement validée', 'Préinscription rejetée');
    return $display[$status];
  }
  static public function StatusDescriptionActivity($status) {
    $display = array('En attente de validation', 'Activitée validée', 'Activité partiellement validée', 'Activitée rejetée');
    return $display[$status];
  }
  static public function StatusDescriptionAccount($status) {
    $display = array('En attente de validation', 'Compte validé', 'Compte partiellement validé', 'Compte rejeté');
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
  static public function StatusTooltipActivity($status, $placement = 'bottom') {
    return '<span data-toggle="tooltip" data-placement="bottom" data-title="'. self::StatusDescriptionActivity($status) .'" 
      class="normal cursor-default text-'. self::StatusColor($status) .'">'. self::StatusIcon($status) .'</span>';
  }
  static public function StatusTooltipAccount($status, $placement = 'bottom') {
    return '<span data-toggle="tooltip" data-placement="bottom" data-title="'. self::StatusDescriptionAccount($status) .'" 
      class="normal cursor-default text-'. self::StatusColor($status) .'">'. self::StatusIcon($status) .'</span>';
  }
  static public function Accounts($start = 0, $step = NULL) {
    $return = array();
    if ($start === 'all') { $query = SQL::sql()->query('SELECT id FROM fsc_users_inscription'); }
    else {
      $step = is_null($step) ? Pagination::step() : $step;
      $query = SQL::sql()->query('SELECT id FROM fsc_users_inscription LIMIT '. $start .','. $step);
    }
    while ($data = $query->fetch())
      $return[] = new UserInscription($data['id']); 
    $query->closeCursor();
    return $return;
  }

  static public function AccountsByStatus($start = 0, $sens = true, $step = NULL) {
    $step = is_null($step) ? Pagination::step() : $step;
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_users_inscription ORDER BY status '. ($sens ? 'DESC' :  '') .', login LIMIT '. $start .','. $step);
    while ($data = $query->fetch())
      $return[] = new UserInscription($data['id']); 
    $query->closeCursor();
    return $return;
  }

  static public function AccountsByLogin($start = 0, $sens = true, $step = NULL) {
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

}

?>
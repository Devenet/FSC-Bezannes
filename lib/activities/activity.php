<?php

namespace lib\activities;
use lib\db\SQL;
use lib\laravel\Str;
use lib\upload\UploadImage;
use lib\content\Pagination;
 
class Activity {
  
  private $id;
  private $name;
  private $active;
  private $url;
  private $description;
  private $place;
  private $website;
  private $email;
  private $aggregate; // 1: creneaux libres; 0: horaires indépendants
  private $price;
  private $price_young;
  
  private $image = 0;
  static protected $path_image = 'activities';
  private $image_temp;
  
  private $created;
  
  public function __construct($id = null) {
    if (is_int($id+0) && $this->isActivity($id+0)) {
      $query = SQL::sql()->query('SELECT name, active, url, description, place, email, website, price, price_young, aggregate FROM fsc_activities WHERE id = '. $id);
      $activity = $query->fetch();
      $this->id = $id+0;
      $this->name = stripslashes($activity['name']);
      $this->active = $activity['active'];
      $this->url = $activity['url'];
      $this->description = stripslashes($activity['description']);
      $this->place = stripslashes($activity['place']);
      $this->email = $activity['email'];
      $this->website = $activity['website'];
      $this->aggregate = $activity['aggregate'];
      $this->price = $activity['price'];
      $this->price_young = $activity['price_young'];
      $this->created = true;
      $query->closeCursor();

      if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . _PATH_UPLOADS_FULL_ . DIRECTORY_SEPARATOR . Activity::$path_image .DIRECTORY_SEPARATOR. $this->id . '.jpg'))
        $this->image = 1;
    }
    else
      $created = false;
  }
  
  private function boolToInt($bool) {
    if ($bool) return 1;
    return 0;
  }
  
  public function id() {
    return $this->id;
  }
  
  public function setName($name) {
    if (!is_string($name) OR $name == null)
      return false;
    else {
      $this->name = htmlspecialchars($name);
      return true;
    }
  }
  public function name() {
    return $this->name;
  }

  public function setActive($bool = false) {
    $this->active = $this->boolToInt($bool);
    if (!$this->active) {
      $query = SQL::sql()->prepare('DELETE FROM fsc_participants WHERE activity = :activity');
      $query->execute(array('activity' => $this->id));
      $query->closeCursor();
    }
  }
  public function active() {
    return $this->active;
  }
  public function changeActive() {
    $this->active = ($this->active == 0 ? 1 : 0);
    $this->update_sql('active', $this->active);
    if (!$this->active) {
      $query = SQL::sql()->prepare('DELETE FROM fsc_participants WHERE activity = :activity');
      $query->execute(array('activity' => $this->id));
      $query->closeCursor();
    }
  }
  
  private function accept_url($url) {
    // avoid to rewrite default image...
    if ($url == 'default')
      return false;
    $query = SQL::sql()->query('SELECT url FROM fsc_activities'); 
    $urls = array();
    while ($data = $query->fetch())
      $urls[] = $data['url'];
    $query->closeCursor();
    if (!in_array($url, $urls) || ($this->created && ($this->id == Activity::IDfromURL($url))))
      return true;
    return false;
  }
  protected function setUrl($url) {    
    if ($url != NULL) {
      /*
      $url = mb_strtolower($url, 'UTF-8');
      $url = preg_replace('#à|â|ä#', 'a', $url);
      $url = preg_replace('#é|ê|è|ë#', 'e', $url);
      $url = preg_replace('#î|ï#', 'i', $url);
      $url = preg_replace('#ô|ö#', 'o', $url);
      $url = preg_replace('#ù|û|ü#', 'u', $url);
      $url = preg_replace('#ç#', 'c', $url);
      $url = preg_replace('#([^a-z])+#', '-', $url);
      $url = preg_replace('#\-$#', '', $url);
      */
      $url = Str::slug($url);
      if ($this->accept_url($url)) {
        $this->url = $url;
        return true;
      }
      else {
        $url = $url . '-' . rand(1,10);
        if ($this->accept_url($url)) {
          $this->url = $url;
          return true;
        }
        else
        $this->setUrl($url);
      }
    }
    return $this->setUrl($this->name);
  }
  public function url() {
    return $this->url;
  }
  
  public function setDescription($description) {
    if ($description != null) {
      /*
      $description = preg_replace('#^[^(<p>)](.*)#', '<p>$0', htmlspecialchars_decode($description));
      $description = preg_replace('#(.*)[^(</p>)]$#', '$0</p>', $description);
      $description = preg_replace('#<br />([\t\n\r\s]*)<br />([\t\n\r\s]*)#', '</p><p>', nl2br($description));
      */
      $description = preg_replace('#<br>#', '<br />', htmlspecialchars_decode($description));
      $description = preg_replace('#<b>#', '<strong>', $description);
      $description = preg_replace('#</b>#', '</strong>', $description);
      $description = preg_replace('#<i>#', '<em>', $description);
      $description = preg_replace('#</i>#', '</em>', $description);
      $this->description = htmlspecialchars($description);
      return true;
    }
    return false;
  }
  public function description() {
    //return '<p>'. htmlspecialchars_decode($this->description) .'</p>';
    return htmlspecialchars_decode($this->description);
  }
  public function wysihtmlDescription() {
    /*
    $description = preg_replace('#</p><p>#', "\n\r", htmlspecialchars_decode(nl2br($this->description)));
    $description = preg_replace('#<br /><br />#', '', $description);
    $description = preg_replace('#<p>#', '', $description);
    $description = preg_replace('#</p>#', '', $description);
    return $description;
    */
    $description = preg_replace('#<br />#', "<br>", htmlspecialchars_decode($this->description));
    $description = preg_replace('#<strong>#', '<b>', $description);
    $description = preg_replace('#</strong>#', '</b>', $description);
    $description = preg_replace('#<em>#', '<i>', $description);
    $description = preg_replace('#</em>#', '</i>', $description);
    return htmlspecialchars_decode($description);
  }
  
  public function setPlace($place) {
    if($place != null) {
      $this->place = htmlspecialchars($place);
      return true;
    }
    return false;
  }
  public function place() {
    return $this->place;
  }
  
  public function setImage($image) {
    $img = new UploadImage($image);
    $img->save(($this->created ? $this->id : 'temp') . '.jpg', Activity::$path_image);
    $img->resize(210, 135);
    $this->image = 1;
    if (! $this->created)
      $this->image_temp = $img->file();
  }
  public function image()  {
    return _UPLOADS_ . '/' . Activity::$path_image .'/'. ($this->image ? $this->id : 'default') . '.jpg';;
  }
  public function hasImage() {
    return $this->image;
  }
  
  public function setEmail($email) {
    if ($email != null) {
      if (!preg_match('#^[a-z0-9._\+-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', strtolower(htmlspecialchars($email))))
        return false;
      else {
        $this->email = strtolower(htmlspecialchars($email));
        return true;
      }
    }
    else {
      $this->email = '';
      return true;
    }
  }
  public function email() {
    return $this->email;
  }
  
  public function setWebsite($website) {
    if ($website != null) {
      // oui je ne prends pas en compte les nouveaux NDD avec accents, mais hein bon quoi keur.
      if (!preg_match('#^(http://)?[a-z0-9._-]{2,}\.[a-z]{2,4}$#', strtolower(htmlspecialchars($website))))
        return false;
      else {
        $this->website = preg_replace('#^http://(.+)#', '$1', strtolower(htmlspecialchars($website)));
        return true;
      }
    }
    else {
      $this->website = '';
      return true;
    }
  }
  public function website() {
    return $this->website;
  }
  
  public function setAggregate($bool) {
    if ($bool == 'on') $this->aggregate = 1;
    else $this->aggregate = 0;
    return true;
  }
  public function aggregate() {
    return $this->aggregate;
  }
  
  public function setPrice($float = null) {
    $float = preg_replace('#,#', '.', $float) + 0;
    if ($float == null) {
      $this->price = 0;
      return true;
    }
    elseif ((is_float($float) or is_int($float)) and $float >= 0) {
      $this->price = $float;
      return true;
    }
    return false;
  }
  public function price() {
    return preg_replace('#\.#', ',', $this->price);
  }
  
  public function setPriceYoung($float = null) {
    $float = preg_replace('#,#', '.', $float) + 0;
    // if not specified, same price as the "normal" price
    if ($float == null) {
      $this->price_young = -1;
      return true;
    }
    // if specified, must be > 0 and < than the "normal" price
    elseif ((is_float($float) or is_int($float)) and $float >= 0 and $float < $this->price) {
      $this->price_young = $float;
      return true;
    }
    return false;
  }
  public function price_young() {
    return preg_replace('#\.#', ',', $this->price_young);
  }
  
  private function update_sql($field, $data) {
    $demande = 'UPDATE fsc_activities SET '. $field .' = \''. $data .'\' WHERE id = '. $this->id .'';
    $query = SQL::sql()->query($demande);
    $query->closeCursor();
  }
  
  public function update() {
    if ($this->created) {
      $this->update_sql('name', addslashes($this->name));
      $this->update_sql('active', $this->active);
      $this->setUrl($this->name);
      $this->update_sql('url', $this->url);
      $this->update_sql('description', addslashes($this->description));
      $this->update_sql('place', addslashes($this->place));
      $this->update_sql('email', $this->email);
      $this->update_sql('website', $this->website);
      $this->update_sql('aggregate', $this->aggregate);
      $this->update_sql('price', $this->price);
      $this->update_sql('price_young', $this->price_young);
    }
  }
  
  public function create() {
    if (!$this->created) {
      if ($this->url == null) $this->setUrl($this->name);
      $query = SQL::sql()->prepare('INSERT INTO fsc_activities(name, active, url, description, place, aggregate, email, website, price, price_young) VALUES(:name, :active, :url, :description, :place, :aggregate, :email, :website, :price, :price_young)');
      $prepare = array(
        'name' => addslashes($this->name),
        'active' => ($this->active == null) ? 0 : $this->active,
        'url' => $this->url,
        'description' => addslashes($this->description),
        'place' => addslashes($this->place),
        'aggregate' => $this->aggregate,
        'email' => ($this->email == null) ? '' : $this->email,
        'website' => ($this->website == null) ? '' : $this->website,
        'price' => ($this->price == null) ? 0 : $this->price,
        'price_young' => ($this->price_young == null) ? -1 : $this->price_young
        );
      $rep = $query->execute($prepare);
      $this->id = SQL::sql()->lastInsertId();
      $query->closeCursor();
      if ($this->image) {
        $src = imagecreatefromjpeg($this->image_temp);
        imagejpeg($src, dirname($this->image_temp). DIRECTORY_SEPARATOR .$this->id.'.jpg');
        unlink(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . _PATH_UPLOADS_FULL_ . DIRECTORY_SEPARATOR . Activity::$path_image .DIRECTORY_SEPARATOR. 'temp.jpg');
        unset($this->image_temp);
      }
      $this->created = true;
    }
  }
  
  public function delete($bool = false) {
    if ($bool && $this->created) {
      // suppression horaires liés
      $query = SQL::sql()->prepare('DELETE FROM fsc_schedules WHERE activity = :activity');
      $query->execute(array('activity' => $this->id));
      $query->closeCursor();
      // suppression participants
      $query = SQL::sql()->prepare('DELETE FROM fsc_participants WHERE activity = :activity');
      $query->execute(array('activity' => $this->id));
      $query->closeCursor();
      // suppression referents
      $query = SQL::sql()->prepare('DELETE FROM fsc_referents WHERE activity = :activity');
      $query->execute(array('activity' => $this->id));
      $query->closeCursor();
      // supression image
      if ($this->image)
        unlink(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . _PATH_UPLOADS_FULL_ . DIRECTORY_SEPARATOR . Activity::$path_image .DIRECTORY_SEPARATOR. $this->id . '.jpg');
      // suppression activité
      $query = SQL::sql()->prepare('DELETE FROM fsc_activities WHERE id = :id');
      $query->execute(array('id' => $this->id));
      $query->closeCursor();
      return true;
    }
    return false;
  }
  
  static public function isActivity($id) {
    $query = SQL::sql()->query('SELECT id FROM fsc_activities');
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    return in_array($id, $ids);
  }
  static public function isActivityURL($url) {
    $query = SQL::sql()->query('SELECT url FROM fsc_activities');
    $urls = array();
    while ($data = $query->fetch())
      $urls[] = $data['url'];
    return in_array($url, $urls);
  }
  
  static public function isActiveActivity($id) {
    $query = SQL::sql()->query('SELECT id FROM fsc_activities WHERE active = 1');
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    return in_array($id, $ids);
  }
  static public function isActiveActivityURL($url) {
    $query = SQL::sql()->query('SELECT url FROM fsc_activities WHERE active = 1');
    $urls = array();
    while ($data = $query->fetch())
      $urls[] = $data['url'];
    return in_array($url, $urls);
  }
  
  static public function Activities($start = 0, $step = null) {
    $step = is_null($step) ? Pagination::step() : $step;
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_activities ORDER BY id LIMIT '. $start .','. $step);
    while ($data = $query->fetch())
      $return[] = new Activity($data['id']); 
    $query->closeCursor();
    return $return;
  }
  static public function ActiveActivities() {
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_activities WHERE active = 1 ORDER BY name');
    while ($data = $query->fetch())
      $return[] = new Activity($data['id']); 
    $query->closeCursor();
    return $return;
  }
  
  static public function ActivitiesByName($start = 0, $sens = true, $step = null) {
    $step = is_null($step) ? Pagination::step() : $step;
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_activities ORDER BY name '. ($sens ? '' :  'DESC'). ' LIMIT '. $start .','. $step);
    while ($data = $query->fetch())
      $return[] = new Activity($data['id']); 
    $query->closeCursor();
    return $return;
  }
  static public function ActivitiesByActive($start = 0, $sens = true, $step = null) {
    $step = is_null($step) ? Pagination::step() : $step;
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_activities ORDER BY active '. ($sens ? 'DESC' :  '') .', name LIMIT '. $start .','. $step);
    while ($data = $query->fetch())
      $return[] = new Activity($data['id']); 
    $query->closeCursor();
    return $return;
  }
  static public function ActivitiesByPrice($start = 0, $sens = true, $step = null) {
    $step = is_null($step) ? Pagination::step() : $step;
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_activities ORDER BY price '. ($sens ? '' :  'DESC') .', name LIMIT '. $start .','. $step);
    while ($data = $query->fetch())
      $return[] = new Activity($data['id']); 
    $query->closeCursor();
    return $return;
  }
  
  static public function countActivities() {
    $query = SQL::sql()->query('SELECT count(id) AS total FROM fsc_activities');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  static public function countActiveActivities() {
    $query = SQL::sql()->query('SELECT count(id) AS total FROM fsc_activities WHERE active = 1');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }
  
  static public function IDfromURL($url) {
    if (Activity::isActivityURL($url)) {
      $query = SQL::sql()->prepare('SELECT id FROM fsc_activities WHERE url = ?');
      $query->execute(array(htmlspecialchars($url)));
      $data = $query->fetch();
      $query->closeCursor();
      return $data['id'];
    }
    return NULL;
  }
  
}
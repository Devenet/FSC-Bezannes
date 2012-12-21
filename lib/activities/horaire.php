<?php

  //require_once('../inc/connexion.inc.php');
  
  class Horaire {
  
    private $id;
    private $jour;
    private $debut;
    private $fin;
    private $id_activite;
    private $horaire_libre;
    private $horaire_libre_desc;
    private $infos;
    private $created;
    
    public function __construct($id) {
      // si l'id est nul, on est en train de créer le créneau
      if ($id == null)
        $this->created = false;
      else {
        $this->created = true;
        $query = $GLOBALS['sql']->query('SELECT id, jour, debut, fin, id_activite, horaire_libre, horaire_libre_desc, infos FROM horaires WHERE id = '. $id .'');
        //$data = $query->execute(array($id));
        $horaire = $query->fetch();
        $this->id = $id;
        $this->jour = $horaire['jour'];
        $temp = explode(':', $horaire['debut']);
        $this->debut = $temp[0]. ':' .$temp[1];
        $temp = explode(':', $horaire['fin']);
        $this->fin = $temp[0]. ':' .$temp[1];
        $this->id_activite = $horaire['id_activite'];
        $this->horaire_libre = $horaire['horaire_libre'];
        $this->horaire_libre_desc = stripslashes($horaire['horaire_libre_desc']);
        $this->infos = $horaire['infos'];
      }
    }
    
    public function getID() {
      return $this->id;
    }
    
    public function getJour() {
      if($this->jour == 1)
        return 'lundi';
      elseif($this->jour == 2)
        return 'mardi';
      elseif($this->jour == 3)
        return 'mercredi';
      elseif($this->jour == 4)
        return 'jeudi';
      elseif($this->jour == 5)
        return 'vendredi';
      elseif($this->jour == 6)
        return 'samedi';
      elseif ($this->jour == 7)
        return 'dimanche';
      else
        return '';
    }
    public function getJourInt() {
      return $this->jour;
    }
    public function setJour($jour) {
      if ($jour == null) {
        $this->jour = '';
        return true;
      }
      elseif ($jour > 0 AND $jour < 8) {
        /*
        if($jour == 1)
          $this->jour = 'lundi';
        elseif($jour == 2)
          $this->jour = 'mardi';
        elseif($jour == 3)
          $this->jour = 'mercredi';
        elseif($jour == 4)
          $this->jour = 'jeudi';
        elseif($jour == 5)
          $this->jour = 'vendredi';
        elseif($jour == 6)
          $this->jour = 'samedi';
        else
          $this->jour = 'dimanche';
        */
        $this->jour = $jour;
        return true;
      }
      else
        return false;
    }
    
    public function getDebut() {
      return $this->debut;
    }
    public function getDebutH() {
      $temp = explode(':', $this->debut);
      return $temp[0];
    }
    public function getDebutM() {
      $temp = explode(':', $this->debut);
      return $temp[1];
    }
    public function setDebut($debut) {
      if ($this->horaire_libre) {
        $this->debut = '00:00';
        return true;
      }
      else {
        $debut = explode(':', $debut);
        if ($debut[0] != null AND $debut[1] != null) {
          if ($debut[0]<24 AND $debut[1]<60) {
            $this->debut = $debut[0] . ':' . $debut[1];
            return true;
          }
          else
            return false;
        }
        else
          return false;
      }
    }
    
    public function getFin() {
      return $this->fin;
    }
    public function getFinH() {
      $temp = explode(':', $this->fin);
      return $temp[0];
    }
    public function getFinM() {
      $temp = explode(':', $this->fin);
      return $temp[1];
    }
    public function setFin($fin) {
      if ($this->horaire_libre) {
        $this->fin = '00:00';
        return true;
      }
      else {
        $fin = explode(':', $fin);
        if ($fin[0] != null AND $fin[1] != null) {
          if ($fin[0]<24 AND $fin[1]<60) {
            $this->fin = $fin[0] . ':' . $fin[1];
            return true;
          }
          else
            return false;
        }
        else
          return false;
      }
    }
    
    public function getIDActivite() {
      return $this->id_activite;
    }
    public function setIDActivite($id) {
      //if (is_int($id))
        $this->id_activite = $id;
    }
    
    public function getHoraireLibre() {
      return $this->horaire_libre;
    }
    public function setHoraireLibre($horaire_libre) {
      if ($horaire_libre == 'on') {
        $this->horaire_libre = 1;
        return true;
      }
      elseif ($horaire_libre == null) {
        $this->horaire_libre = 0;
        return true;
      }
      else
        return false;
    }
  
    public function getHoraireLibreDesc() {
      return $this->horaire_libre_desc;
    }
    public function setHoraireLibreDesc($desc) {
      if ($this->horaire_libre) {
        if ($desc != null) {
          $this->horaire_libre_desc = $desc;
          return true;
        }
        else
          return false;
      }
      $this->horaire_libre_desc = '';
      return true;
    }
  
    public function getInfos() {
      return stripcslashes($this->infos);
    }
    public function setInfos($infos) {
      if ($infos != null) {
        $this->infos = $infos;
        return true;
      }
      else {
        $this->infos = '';
        return true;
      }
    }
  
    // met à jour des les donnees sql
    protected function update_sql($field, $data) {
      $demande = 'UPDATE horaires SET '. $field .' = \''. $data .'\' WHERE id = '. $this->id .'';
      $query = $GLOBALS['sql']->query($demande);
      $query->closeCursor();
    }
    
    // on met à jour la BDD
    public function update() {
      $this->update_sql('jour', $this->jour);
      $this->update_sql('debut', $this->debut);
      $this->update_sql('fin', $this->fin);
      $this->update_sql('horaire_libre', $this->horaire_libre);
      $this->update_sql('horaire_libre_desc', $this->horaire_libre_desc);
      $this->update_sql('infos', $this->infos);
    }
    
    // on créé le nouvel horaire en l'inserant dans la BDD
    public function create() {
      if (!$this->created) {
        if ($this->id_activite == null) return false;
        $query = $GLOBALS['sql']->prepare('INSERT INTO horaires(jour, debut, fin, id_activite, horaire_libre, horaire_libre_desc, infos, fake_id) VALUES(:jour, :debut, :fin, :id_activite,  :horaire_libre, :horaire_libre_desc, :infos, :fake_id)');
        $fake_id = time()-rand(10,1000);
        $rep = $query->execute(array(
          'jour' => $this->jour,
          'debut' => $this->debut,
          'fin' => $this->fin,
          'id_activite' => $this->id_activite,
          'horaire_libre' => $this->horaire_libre,
          'horaire_libre_desc' => $this->horaire_libre_desc,
          'infos' => $this->infos,
          'fake_id' => $fake_id
          )) ; //or die(print_r($query->errorInfo()));
        $query = $GLOBALS['sql']->prepare('SELECT id FROM horaires WHERE fake_id = ?');
        $query->execute(array($fake_id));
        $data = $query->fetch();
        $this->id = $data['id'];
        $this->created = true;
      }
    }
  }
<?php

/**
 * (c) 2012-2013  Nicolas Devenet <nicolas@devenet.info>
 * Code source hosted on https://github.com/nicolabricot/FSC-Bezannes
 */

namespace lib\upload;
use lib\laravel\Str;
require_once '../config/config.php';

abstract class Upload {
  
  protected $uploaded = false;
  protected $saved = false;
  protected $size_limit = 1500000;
  protected $files = 'files';
  protected $path;
  protected $file;
  protected $types;
  
  protected $file_name;
  protected $file_type;
  protected $file_size;
  protected $file_tmp;
  protected $file_error;
  
  public function __construct ($file) {
    $this->file_name = $file['name'];
    $this->file_type = $file['type'];
    $this->file_size = $file['size'];
    $this->file_tmp = $file['tmp_name'];
    $this->file_error = $file['error'];
    
    if ($this->file_error == 0 && $this->file_size > 0) {
      if ($this->file_size <= $this->size_limit)
        $this->uploaded = true;
      else
        throw new \Exception('Fichier trop volumineux');
    }
    else
      throw new \Exception('Erreur lors du téléchargement du fichier');
    
    if (! in_array($this->file_type, $this->types)) {
      $this->uploaded = false;
      throw new \Exception('Type de fichier invalide');
    }
  }
 
  public function file() {
    return $this->file;
  }
 
  public function save($name = NULL, $path = NULL) {
    $this->path = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . _PATH_UPLOADS_FULL_ . DIRECTORY_SEPARATOR . (is_null($path) ? $this->files : preg_replace('#(.*)/$#', '$1', $path)) . DIRECTORY_SEPARATOR;
    $this->file =  $this->path . (is_null($name) ? Str::lower(basename($this->file_name)) : $name);
    
    if ($this->uploaded) {
      move_uploaded_file($this->file_tmp, $this->file);
      $this->saved = true;
    }
    else
      throw new \Exception('Impossible de sauvegarder le fichier');
  }

}

?>
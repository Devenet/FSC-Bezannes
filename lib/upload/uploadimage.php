<?php

namespace lib\upload;
use lib\upload\Upload;

class UploadImage extends Upload {
  
  public function __construct($file) {
    $this->size_limit = 2000000;
    $this->types = array('image/png', 'image/jpeg', 'image/gif');
    
    parent::__construct($file);
  }
  
  public function resize($width, $height) {    
    if ($this->saved) {
      if ($this->file_type == 'image/png')
        $src = imagecreatefrompng($this->file);
      else
        $src = imagecreatefromjpeg($this->file);
      $thumb = imagecreatetruecolor($width, $height);
      imagecopyresampled($thumb, $src, 0, 0, 0, 0, $width, $height, imagesx($src), imagesy($src));
      imagejpeg($thumb, $this->file);
    }
  }
  
  public function thumb($width = 150, $height = 150) {
    if ($this->saved) {
      $src = imagecreatefromjpeg($this->file);
      $thumb = imagecreatetruecolor($width, $height);
      imagecopyresampled($thumb, $src, 0, 0, 0, 0, $width, $height, imagesx($src), imagesy($src));
      imagejpeg($thumb, $this->path());
    }
  }
  
}

?>
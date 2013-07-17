<?php

namespace lib\content;

class Sort {

  private $sens;

  public function __construct() {
  }

  public function sens($sens) {
    $this->sens = $sens;
  }

  public function icon() {
    switch ($this->sens) {
      case 'desc':
        return '<i class="icon-long-arrow-up"></i>';
        break;

      case 'asc':
        return '<i class="icon-long-arrow-down"></i>';
        break;        
      
      default:
        return '<i class="icon-sort"></i>';
    }
  }


}

?>
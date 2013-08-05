<?php

/**
 * (c) 2012-2013  Nicolas Devenet <nicolas@devenet.info>
 * Code source hosted on https://github.com/nicolabricot/FSC-Bezannes
 */

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
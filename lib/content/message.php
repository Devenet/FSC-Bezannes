<?php

/**
 * (c) 2012-2013  Nicolas Devenet <nicolas@devenet.info>
 * Code source hosted on https://github.com/nicolabricot/FSC-Bezannes
 */

namespace lib\content;

class Message {
  
  // 0: alert; -1: error; 1: success; other: info
  private $type;
  private $header;
  private $message;
  private $close;
  
  public function __construct($message, $type = 0, $header = NULL, $close = true) {
    $this->type = $type;
    $this->header = $header;
    $this->message = $message;
    $this->close = $close;
  }
  
  private function addClose() {
      return ($this->close ? '<a href="#" class="close" data-dismiss="alert">&times;</a>' . "\n" : NULL);
    }
  
  public function __toString() {
    $return = '<div class="alert ';
    switch ($this->type) {
      case 0:
        $return .= '">'. $this->addClose() . ($this->header != NULL ? '<h4>' : NULL);
        break;
      case -1:
        $return .= 'alert-error">'. $this->addClose() . ($this->header != NULL ? '<h4>' : NULL);
        break;
      case 1:
        $return .= 'alert-success">'. $this->addClose() . ($this->header != NULL ? '<h4>' : NULL);
        break;
      default:
        $return .= 'alert-info">'. $this->addClose() . ($this->header != NULL ? '<h4>' : NULL);
        break;
    }
    $return .= ($this->header != NULL ? $this->header .'</h4>' : NULL). $this->message .'</div>';
    return $return;
  }
  
}

?>
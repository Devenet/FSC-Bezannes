<?php

namespace lib\content;

class Message {
  
  // 0: alert; -1: error; 1: success; other: info
  private $type;
  private $header;
  private $message;
  private $close;
  
  public function __construct($message, $type = 0, $header = null, $close = true) {
    $this->type = $type;
    $this->header = $header;
    $this->message = $message;
    $this->close = $close;
  }
  
  private function addClose() {
      return ($this->close ? '<a href="#" class="close" data-dismiss="alert">&times;</a>' . "\n" : null);
    }
  
  public function __toString() {
    $return = '<div class="alert ';
    switch ($this->type) {
      case 0:
        $return .= '">'. $this->addClose() . ($this->header != null ? '<h4>' : null);
        break;
      case -1:
        $return .= 'alert-error">'. $this->addClose() . ($this->header != null ? '<h4>' : null);
        break;
      case 1:
        $return .= 'alert-success">'. $this->addClose() . ($this->header != null ? '<h4>' : null);
        break;
      default:
        $return .= 'alert-info">'. $this->addClose() . ($this->header != null ? '<h4>' : null);
        break;
    }
    $return .= ($this->header != null ? $this->header .'</h4>' : null). $this->message .'</div>';
    return $return;
  }
  
}

?>
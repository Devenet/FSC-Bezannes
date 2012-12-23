<?php

namespace lib\content;

class Form {
  
  private $action;
  private $method;
  private $submit;
  private $legend;
  private $inputs;
  
  public function __construct($name = 'default', $action = '?', $submit = 'Envoyer', $legend = null, $method = 'post') {
    $this->name = $name;
    $this->action = $action;
    $this->submit = $submit;
    $this->legend = $legend;
    $this->method = $method;
  }
  
  public function name() {
    return $this->name;
  }
  public function action() {
    return $this->action;
  }
  public function submit() {
    return $this->submit;
  }
  public function legend() {
    return $this->legend;
  }
  public function method() {
    return $this->method;
  }
  
  public function add($input, $value = null) {
    $this->inputs[$input] = $value;
  }
  
  public function value($input) {
    return (isset($this->inputs[$input]) ? ' value="'. stripslashes($this->inputs[$input]) .'" ' : null); 
  }
  
  public function input($input) {
    return (isset($this->inputs[$input]) ? stripslashes($this->inputs[$input]) : null);
  }
  
  public function checkbox($input) {
    return ((isset($this->inputs[$input]) && ($this->inputs[$input] == 'on' || $this->inputs[$input] == 1)) ? 'checked="checked"' : null);
  }
  
  
}
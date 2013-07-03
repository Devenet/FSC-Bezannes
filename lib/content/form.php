<?php

namespace lib\content;

class Form {
  
  private $action;
  private $method;
  private $submit;
  private $reset = 'Effacer';
  private $legend;
  private $inputs;
  private $selects;
  private $radios;
  
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
  public function reset($value = null) {
    if ($value != null)
      $this->reset = $value;
    return $this->reset;
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
  
  public function addOption($select, $name, $value) {
    $this->selects[$select][] = array('name' => $name, 'value' => $value);
  }
  public function addRadio($radio, $name, $value) {
    $this->radios[$radio][] = array('name' => $name, 'value' => $value);
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
  
  public function select($select, $active = 'absolutly null') {
    $return = '';
    foreach ($this->selects[$select] as $option)
      $return .= '<option value="'. $option['value'] .'" '. ($active == $option['value'] ? 'selected="selected"' : null) .'>'. $option['name'] .'</option>'."\n";
    return $return;
  }
  
  public function radio($radio, $active = 'absolutly null') {
    $return = '';
    if ($this->radios != null) {
      foreach ($this->radios[$radio] as $input)
        $return .= '<label class="radio" for="'. $radio .'-'. $input['value'] .'"><input type="radio" name="'. $radio .'"  id="'. $radio .'-'. $input['value'] .'" value="'. $input['value'] .'" '. ($active == $input['value'] ? 'checked="checked"' : null) .' />'. $input['name'] .'</label>'."\n";
    }
    return $return;
  }
  
}
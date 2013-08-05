<?php

/**
 * (c) 2012-2013  Nicolas Devenet <nicolas@devenet.info>
 * Code source hosted on https://github.com/nicolabricot/FSC-Bezannes
 */

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
  
  public function __construct($name = 'default', $action = '?', $submit = 'Envoyer', $legend = NULL, $method = 'post') {
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
  public function reset($value = NULL) {
    if ($value != NULL)
      $this->reset = $value;
    return $this->reset;
  }
  public function legend() {
    return $this->legend;
  }
  public function method() {
    return $this->method;
  }

  public function add($input, $value = NULL) {
    $this->inputs[$input] = $value;
  }
  
  public function addOption($select, $name, $value) {
    $this->selects[$select][] = array('name' => $name, 'value' => $value);
  }
  public function addRadio($radio, $name, $value) {
    $this->radios[$radio][] = array('name' => $name, 'value' => $value);
  }
  
  public function raw($input) {
    return (isset($this->inputs[$input]) ? stripslashes($this->inputs[$input]) : NULL);
  }

  public function value($input) {
    return (isset($this->inputs[$input]) ? ' value="'. stripslashes($this->inputs[$input]) .'" ' : NULL); 
  }
  
  public function input($input) {
    return (isset($this->inputs[$input]) ? stripslashes($this->inputs[$input]) : NULL);
  }
  
  public function checkbox($input) {
    return ((isset($this->inputs[$input]) && ($this->inputs[$input] == 'on' || $this->inputs[$input] == 1)) ? 'checked="checked"' : NULL);
  }
  
  public function select($select, $active = 'absolutly NULL') {
    $return = '';
    foreach ($this->selects[$select] as $option)
      $return .= '<option value="'. $option['value'] .'" '. ($active == $option['value'] ? 'selected="selected"' : NULL) .'>'. $option['name'] .'</option>'."\n";
    return $return;
  }
  
  public function radio($radio, $active = 'absolutly NULL') {
    $return = '';
    if ($this->radios != NULL) {
      foreach ($this->radios[$radio] as $input)
        $return .= '<label class="radio" for="'. $radio .'-'. $input['value'] .'"><input type="radio" name="'. $radio .'"  id="'. $radio .'-'. $input['value'] .'" value="'. $input['value'] .'" '. ($active == $input['value'] ? 'checked="checked"' : NULL) .' />'. $input['name'] .'</label>'."\n";
    }
    return $return;
  }
  
}
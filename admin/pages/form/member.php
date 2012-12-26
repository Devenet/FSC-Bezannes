<?php

$form->addOption('date_birthday_day', '', NULL);
for ($i = 1; $i <= 31; $i++)
  $form->addOption('date_birthday_day', $i, $i);

$form->addOption('date_birthday_year', '', NULL);
for ($i = date('Y')-1; $i >= 1920; $i--)
  $form->addOption('date_birthday_year', $i, $i);

$form->addOption('date_birthday_month', '', NULL);
$form->addOption('date_birthday_month', 'janvier', '1');
$form->addOption('date_birthday_month', 'février', '2');
$form->addOption('date_birthday_month', 'mars', '3');
$form->addOption('date_birthday_month', 'avril', '4');
$form->addOption('date_birthday_month', 'mai', '5');
$form->addOption('date_birthday_month', 'juin', '6');
$form->addOption('date_birthday_month', 'juillet', '7');
$form->addOption('date_birthday_month', 'août', '8');
$form->addOption('date_birthday_month', 'septembre', '9');
$form->addOption('date_birthday_month', 'octobre', '10');
$form->addOption('date_birthday_month', 'novembre', '11');
$form->addOption('date_birthday_month', 'décembre', '12');

?>

<form action="<?php echo $form->action(); ?>" method="<?php echo $form->method();?>" class="form-horizontal" >
  <?php echo ($form->legend() != null ? '<legend>'. $form->legend() .'</legend>' : null); ?>
  
  <!-- form messages -->
  <?php
    if (isset($_SESSION['form_msg'])) {
      echo '<div class="control-group"><div class="controls input-xxlarge">', $_SESSION['form_msg'], '</div></div>';
      unset($_SESSION['form_msg']);
    }
  ?>
  <!-- /form messages -->
  
  <div class="control-group">
    <label class="control-label" for="gender">Civilité</label>
    <div class="controls">
      <label class="radio inline">
        <input type="radio" id="gender" value="0" name="gender" <?php echo ($form->input('gender') == '0' ? 'checked="checked"' : null); ?> /> Monsieur
      </label>
      <label class="radio inline">
        <input type="radio" value="1" name="gender" <?php echo ($form->input('gender') == '1' ? 'checked="checked"' : null); ?> /> Madame
      </label>
      <label class="radio inline">
        <input type="radio" value="2" name="gender" <?php echo ($form->input('gender') == '2' ? 'checked="checked"' : null); ?> /> Mademoiselle
      </label>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="last_name">Nom</label>
    <div class="controls">
      <input type="text" name="last_name" id="last_name" placeholder="Smith" <?php echo $form->value('last_name'); ?> class="input-xxlarge" />
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="first_name">Prénom</label>
    <div class="controls">
      <input type="text" name="first_name" id="first_name" placeholder="John" <?php echo $form->value('first_name'); ?> class="input-xxlarge" />
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="date_birthday_day">Date de naissance</label>
    <div class="controls">
      <select class="span1" name="date_birthday_day" id="date_birthday_day">
        <?php echo $form->select('date_birthday_day', $form->input('date_birthday_day')); ?>
      </select>
      <select class="input-medium" name="date_birthday_month" id="date_birthday_month">
        <?php echo $form->select('date_birthday_month', $form->input('date_birthday_month')); ?>
      </select>
      <select class="input-small" name="date_birthday_year" id="date_birthday_year">
        <?php echo $form->select('date_birthday_year', $form->input('date_birthday_year')); ?>
      </select>
    </div>
  </div>
  
  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary" value="<?php echo $form->submit(); ?>" /> 
    <input type="reset" class="btn" value="Annuler" />
  </div>
  
</form>
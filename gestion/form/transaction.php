<?php

for ($i = 1; $i <= 31; $i++)
  $form->addOption('date_day', $i, $i);

$form->addOption('date_year', _YEAR_+1, _YEAR_+1);
$form->addOption('date_year', _YEAR_, _YEAR_);

$months = array (
  1 => 'janvier',
  2 => 'février',
  3 => 'mars',
  4 => 'avril',
  5 => 'mai',
  6 => 'juin',
  7 => 'juillet',
  8 => 'août',
  9 => 'septembre',
  10 => 'octobre',
  11 => 'novembre',
  12 => 'décembre'
);
foreach ($months as $value => $month)
  $form->addOption('date_month', $month, $value);
  
$types = array('Chèque', 'Espèces', 'Chèques vacances', 'Autre');
foreach ($types as $key => $value) {
  $form->addOption('type', $value, $key);
}

?>

<form action="<?php echo $form->action(); ?>" method="<?php echo $form->method();?>" class="form-horizontal" >
  <?php echo ($form->legend() != NULL ? '<legend>'. $form->legend() .'</legend>' : NULL); ?>
  
  <!-- form messages -->
  <?php
    if (isset($_SESSION['form_msg'])) {
      echo '<div class="control-group"><div class="controls input-xxlarge">', $_SESSION['form_msg'], '</div></div>';
      unset($_SESSION['form_msg']);
    }
  ?>
  <!-- /form messages -->
  
  
  <div class="control-group">
    <label class="control-label" for="amount"><i class="icon-shopping-cart"></i> Montant</label>
    <div class="controls">
      <div class=" input-append">
        <input type="text" name="amount" id="amount" placeholder="10,00" <?php echo $form->value('amount'); ?> class="input-mini"/>
        <span class="add-on">&euro;</span>
      </div>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="type"><i class="icon-info-sign"></i> Paiement par</label>
    <div class="controls">
      <select class="span3" name="type" id="type">
        <?php echo $form->select('type', $form->input('type')); ?>
      </select>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="date_day"><i class="icon-time"></i> Date</label>
    <div class="controls">
      <select class="input-mini" name="date_day" id="date_day">
        <?php echo $form->select('date_day', ($form->input('date_day') != NULL ? $form->input('date_day') : date('d'))); ?>
      </select>
      <select class="input-medium" name="date_month" id="date_month">
        <?php echo $form->select('date_month', ($form->input('date_month') != NULL ? $form->input('date_month') : date('m'))); ?>
      </select>
      <select class="input-small" name="date_year" id="date_year">
        <?php echo $form->select('date_year', ($form->input('date_year') != NULL ? $form->input('date_year') : date('Y'))); ?>
      </select>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="note"><i class="icon-pencil"></i> Note</label>
    <div class="controls">
      <input type="text" name="note" id="note" placeholder="Notes complémentaires" <?php echo $form->value('note'); ?> class="input-xxlarge" />
    </div>
  </div>
  
  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary" value="<?php echo $form->submit(); ?>" id="submit_btn" />
    <input type="reset" class="btn" value="Effacer" />
  </div>
  
</form>
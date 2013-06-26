<?php

$form->addOption('day', 'Lundi', '1');
$form->addOption('day', 'Mardi', '2');
$form->addOption('day', 'Mercredi', '3');
$form->addOption('day', 'Jeudi', '4');
$form->addOption('day', 'Vendredi', '5');
$form->addOption('day', 'Samedi', '6');
$form->addOption('day', 'Dimanche', '0');

?>

<form action="<?php echo $form->action(); ?>" method="<?php echo $form->method();?>" class="form-horizontal" >
  <!--<?php echo ($form->legend() != null ? '<legend>'. $form->legend() .'</legend>' : null); ?>-->
  
  <!-- form messages -->
  <?php
    if (isset($_SESSION['form_msg'])) {
      echo '<div class="control-group"><div class="controls input-xxlarge">', $_SESSION['form_msg'], '</div></div>';
      unset($_SESSION['form_msg']);
    }
  ?>
  <!-- /form messages -->
  
  
  <div class="tabbable">
    <ul class="nav nav-tabs">
      <li <?php echo ($form->name() == 'edit-schedule' ? ($form->input('type') != 1 ? 'class="active"' : null) : 'class="active"'); ?>><a href="#tab1" data-toggle="tab">Horaire journalier</a></li>
      <li <?php echo ($form->name() == 'edit-schedule' && $form->input('type') == 1 ? 'class="active"' : null); ?>><a href="#tab2" data-toggle="tab">Horaire libre</a></li>
    </ul>
      
    <div class="tab-content">
      <div class="tab-pane <?php echo ($form->name() == 'edit-schedule' ? ($form->input('type') != 1 ? 'active' : null) : 'active'); ?>" id="tab1">
                <div class="control-group">
          <label class="control-label" for="day">Jour</label>
          <div class="controls">
            <select class="input-medium" name="day" id="day">
              <?php echo $form->select('day', $form->input('day')); ?>
            </select>
          </div>
        </div>
  
        <div class="control-group">
          <label class="control-label" for="time_begin_hour">Heure de début</label>
          <div class="controls">
            <input type="text" name="time_begin_hour" id="time_begin_hour" placeholder="10" <?php echo $form->value('time_begin_hour'); ?> class="span1" maxlength="2" /> :
            <input type="text" name="time_begin_minute" id="time_begin_minute" placeholder="00" <?php echo $form->value('time_begin_minute'); ?> class="span1" maxlength="2" />
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="time_end_hour">Heure de fin</label>
          <div class="controls">
            <input type="text" name="time_end_hour" id="time_end_hour" placeholder="11" <?php echo $form->value('time_end_hour'); ?> class="span1" maxlength="2" /> :
            <input type="text" name="time_end_minute" id="time_end_minute" placeholder="30" <?php echo $form->value('time_end_minute'); ?> class="span1" maxlength="2" />
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="more">Complément</label>
          <div class="controls">
            <input type="text" name="more" id="more" placeholder="Informations complémentaires" <?php echo $form->value('more'); ?> class="input-xxlarge" />
          </div>
        </div>
      </div>
      
      <div class="tab-pane <?php echo ($form->name() == 'edit-schedule' && $form->input('type') == 1 ? 'active' : null); ?>" id="tab2">
        <div class="control-group">
          <label class="control-label" for="description">Decsription</label>
          <div class="controls">
            <textarea name="description" id="description" rows="5" placeholder="Decsription de l’horaire libre" class="input-xxlarge"><?php echo $form->input('description'); ?></textarea>
          </div>
        </div>
      </div>
    </div>    
  </div>
  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary" value="<?php echo $form->submit(); ?>" /> 
    <input type="reset" class="btn" value="Effacer" />
  </div>
  
</form>
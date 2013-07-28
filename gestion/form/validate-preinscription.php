<?php

for ($i = 1; $i <= 31; $i++)
  $form->addOption('date_registration_day', $i, $i);

$form->addOption('date_registration_year', _YEAR_+1, _YEAR_+1);
$form->addOption('date_registration_year', _YEAR_, _YEAR_);

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
  $form->addOption('date_registration_month', $month, $value);
?>

<form action="<?php echo $form->action(); ?>" method="<?php echo $form->method();?>" class="form-horizontal" >
  
  <!-- form messages -->
  <?php
    if (isset($_SESSION['form_msg'])) {
      echo '<div class="control-group"><div class="controls input-xxlarge">', $_SESSION['form_msg'], '</div></div>';
      unset($_SESSION['form_msg']);
    }
  ?>
  <!-- /form messages -->

  <h3 class="controls">Inscription</h3>

  <div class="control-group">
    <label class="control-label" for="inscription"><span <?php echo $pre->adherent() ? 'class="text-success">Adhérent' : 'class="text-warning">Membre'; ?></span></label>
    <div class="controls">
      <label class="checkbox" for="inscription">
        <input type="checkbox" name="inscription" id="inscription" <?php echo $pre->id_member() != NULL ? $form->checkbox('inscription') : 'checked="checked"'; ?>/>
        <?php echo $pre->name(); ?>
      </label>
    </div>
  </div>

  <?php if ($pre->minor()) : ?>
  <div class="control-group">
    <label class="control-label" for="adulte">Reponsable</label>
    <div class="controls">
      <select class="input-xlarge" name="adulte" id="adulte">
        <?php echo $form->select('adulte', $form->input('adulte') == NULL ? $respo->id_member() : $form->input('adulte')); ?>
      </select>
    </div>
  </div>
  <?php
  $_SCRIPT[] = '
    <script src="'. _FSC_ .'/js/select2.min.js"></script>
    <script src="'. _FSC_ .'/js/select2_locale_fr.js"></script>
    <script>
      $(function() {
        $("#adulte").select2();
      });
    </script>
  ';
  endif;
  ?>

  <?php if ($pre->adherent()) : ?>

  <div class="control-group" id="box_date_registration">
    <label class="control-label" for="date_registration_day">Date d’adhésion</label>
    <div class="controls">
      <select class="input-mini" name="date_registration_day" id="date_registration_day" <?php echo $pre->adherent() ?: 'disabled="disabled"'; ?>>
        <?php echo $form->select('date_registration_day', ($form->input('date_registration_day') != NULL ? $form->input('date_registration_day') : date('d'))); ?>
      </select>
      <select class="input-medium" name="date_registration_month" id="date_registration_month" <?php echo $pre->adherent() ?: 'disabled="disabled"'; ?>>
        <?php echo $form->select('date_registration_month', ($form->input('date_registration_month') != NULL ? $form->input('date_registration_month') : date('m'))); ?>
      </select>
      <select class="input-small" name="date_registration_year" id="date_registration_year" <?php echo $pre->adherent() ?: 'disabled="disabled"'; ?>>
        <?php echo $form->select('date_registration_year', ($form->input('date_registration_year') != NULL ? $form->input('date_registration_year') : date('Y'))); ?>
      </select>
    </div>
  </div>

  <div class="clearfix"></div>
  
  <h3 class="controls espace-small-top">Activités</h3>

  <div class="control-group">
    <label class="control-label" id="toggle-activities"></label>
    <div class="controls" id="participant_boxes">
      <?php
        foreach($form_checkbox_content as $key => $text) {
          echo '<label class="checkbox" for="', $key, '">', 
            '<input type="checkbox" name="', $key, '" id="', $key, '" ', $form->checkbox($key), ' />',
            $text,
            '</label>'; 
        }
        if (empty($form_checkbox_content)) 
          echo '<span style="line-height:40px;">Aucune activité</span>';
      ?>
    </div>
  </div>

  <input type="hidden" name="activities" value="<?php echo time(); ?>" />

  <?php
    $_SCRIPT[] = "
    <script>
    $(function() {
      var inscription = $('#inscription').attr('checked') == 'checked';
      if (!inscription)
        $('#box_date_registration').hide();

      $('#inscription').click(function() {
        inscription = !inscription;
        if (inscription)
          $('#box_date_registration').fadeIn();
        else
          $('#box_date_registration').hide();
      });

      var checked_all = false;
      function toggleActivities() {
        checked_all = !checked_all;
        checkboxes = $('#participant_boxes label input');
        for(var i=0, n=checkboxes.length;i<n;i++) {
          checkboxes[i].checked = checked_all;
        }
      }
      $('#toggle-activities').click(function() {
        toggleActivities();
        if (checked_all)
          $('#toggle-activities').html('<span class=\"btn btn-small\">Tout désélectionner</span>');
        else
          $('#toggle-activities').html('<span class=\"btn btn-small\">Tout sélectionner</span>');
      });
      $('#toggle-activities').html('<span class=\"btn btn-small\">Tout sélectionner</span>');

    });
    </script>
    ";

  endif;
  ?>
 
  <div class="form-actions">
    <input type="submit" class="btn btn-primary" value="<?php echo $form->submit(); ?>" id="submit_btn" />
    <input type="reset" class="btn" value="Effacer" />
  </div>
  
</form>
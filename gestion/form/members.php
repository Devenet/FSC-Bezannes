
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
    <label class="control-label" for="member">Membre</label>
    <div class="controls">
      <select class="input-xlarge" name="member" id="member">
        <?php echo $form->select('member', $form->input('member')); ?>
      </select>
    </div>
  </div>
  
  <?php if ($form->name() == 'add-referent'): ?>
  <div class="control-group">
    <label class="control-label" for="type">Référent</label>
    <div class="controls">
      <label class="radio inline">
        <input type="radio" id="type" value="0" name="type" <?php echo ($form->input('type') == '0' ? 'checked="checked"' : null); ?> /> Responsable
      </label>
      <label class="radio inline">
        <input type="radio" value="1" name="type" <?php echo ($form->input('type') == '1' ? 'checked="checked"' : null); ?> /> Animateur
      </label>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="display_phone">Téléphone</label>
    <div class="controls">
      <label class="checkbox" for="display_phone">
        <input type="checkbox" name="display_phone" id="display_phone" <?php echo $form->checkbox('display_phone'); ?> />
        Afficher le téléphone du référent
      </label>
    </div>
  </div>
  <?php endif; ?>
  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary" value="<?php echo $form->submit(); ?>" /> 
    <input type="reset" class="btn" value="Effacer" />
  </div>
  
</form>


<?php
$_SCRIPT[] = '
  <script src="'. _FSC_ .'/js/select2.min.js"></script>
  <script src="'. _FSC_ .'/js/select2_locale_fr.js"></script>
  <script>
    $(document).ready(function() {
      $("#member").select2({
        placeholder: "Sélectionnez un membre",
        allowClear: true
      });
    });
  </script>
';
?>
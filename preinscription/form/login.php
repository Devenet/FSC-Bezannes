<form action="<?php echo $form->action(); ?>" method="<?php echo $form->method();?>" class="form-horizontal">
  <?php echo ($form->legend() != NULL ? '<legend>'. $form->legend() .'</legend>' : NULL); ?>
  
  <!-- form messages -->
  <?php
    if (isset($_SESSION['form_msg'])) {
      echo '<div class="row"><div class="span8">', $_SESSION['form_msg'], '</div></div><div class="clearfix"></div>';
      unset($_SESSION['form_msg']);
    }
  ?>
  
  <h3 class="controls">Identifiants</h3>
  
  <div class="control-group" id="parent-login">
    <label class="control-label" for="login">Courriel</label>
    <div class="controls">
      <div class="input-prepend">
        <span class="add-on"><i class="icon-envelope" id="icon-login"></i></span>
        <input type="text" name="login" id="login" class="input-large" <?php echo $form->value('login'); ?> autofocus />
      </div>
    </div>
  </div>

  <div class="control-group" id="parent-password">
    <label class="control-label" for="login">Mot de passe</label>
    <div class="controls">
      <div class="input-prepend">
        <span class="add-on"><i class="icon-lock" id="icon-password"></i></span>
        <input type="password" name="password" id="password" class="input-large" <?php echo $form->value('password'); ?>/>
      </div>
    </div>
  </div>
  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary" value="<?php echo $form->submit(); ?>" /> 
    <input type="reset" class="btn" value="Effacer" />
  </div>
  
</form>

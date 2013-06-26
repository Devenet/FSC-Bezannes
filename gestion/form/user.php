<?php

use lib\content\Display;

for ($i = 8; $i > 2 ; $i--) {
  if (Display::Privilege($i) != '')
    $form->addOption('privilege', ucfirst(Display::FrenchPrivilege($i)), $i);
}
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

  <h3 class="controls">Identifiant</h3>
  
  <div class="control-group">
    <label class="control-label" for="name">Nom affiché</label>
    <div class="controls">
      <input type="text" name="name" id="name" placeholder="J. Smith" <?php echo $form->value('name'); ?> class="input-xlarge" />
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="login">Courriel</label>
    <div class="controls">
      <input type="email" name="login" id="login" placeholder="john@smith.com" <?php echo $form->value('login'); ?> class="input-xlarge"/>
      <span class="help-inline">Le courriel sera l’identifiant de l’utilisateur</span>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="password">Mot de passe</label>
    <div class="controls controls-row">
      <input type="password" name="password" id="password" placeholder="Mot de passe" <?php echo $form->value('password'); ?> class="input-xlarge" />
      <span class="help-inline">Le mot de passe doit comporter au moins 8 caractères</span>
    </div>
  </div>

  
  <div class="control-group">
    <label class="control-label" for="privilege">Privilège</label>
    <div class="controls">
      <select name="privilege" id="privilege">
        <?php echo $form->select('privilege', $form->input('privilege')); ?>
      </select>
    </div>
  </div>

  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary" value="<?php echo $form->submit(); ?>" id="submit_btn" />
    <input type="reset" class="btn" value="Effacer" />
  </div>
  
</form>

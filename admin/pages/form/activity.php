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
    <label class="control-label" for="name">Nom</label>
    <div class="controls">
      <input type="text" name="name" id="name" placeholder="Nom de l’activité" class="input-xxlarge" <?php echo $form->value('name'); ?>/>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="description"><i class="icon-book"></i> Decsription</label>
    <div class="controls">
      <textarea name="description" id="description" rows="5" placeholder="Decsription de l’activité" class="input-xxlarge"><?php echo $form->input('description'); ?></textarea>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="place"><i class="icon-map-marker"></i> Lieu</label>
    <div class="controls">
      <input type="text" name="place" id="place" placeholder="Lieu de l’activité" <?php echo $form->value('place'); ?> class="input-xxlarge"/>
    </div>
  </div>
  
  <div class="control-group">
    <!--<div class="control-label"><i class="icon-time"></i></div>-->
    <div class="controls">
      <label class="checkbox" for="aggregate">
        <input type="checkbox" name="aggregate" id="aggregate" <?php echo $form->checkbox('aggregate'); ?>/>
        Pratique libre
      </label>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="price">Tarif</label>
    <div class="controls">
      <div class=" input-append">
        <input type="text" name="price" id="price" placeholder="10,00" <?php echo $form->value('price'); ?> class="input-mini"/>
        <span class="add-on">&euro;</span>
      </div>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="price_young">Tarif jeune</label>
    <div class="controls">
      <div class=" input-append">
        <input type="text" name="price_young" id="price_young" placeholder="" <?php echo $form->value('price_young'); ?> class="input-mini"/>
        <span class="add-on">&euro;</span>
      </div>
      <!--<span class="help-inline">Dans le cas où les deux tarifs sont les mêmes, laisser <strong>Tarif jeune</strong> vide.</span>-->
    </div>
  </div>

  
  <div class="control-group">
    <label class="control-label" for="email"><i class="icon-envelope"></i> Courriel</label>
    <div class="controls">
        <input type="email" name="email" id="email" placeholder="monactivite@hebergeur.fr" <?php echo $form->value('email'); ?> class="input-xlarge"/>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="website"><i class="icon-globe"></i> Site web</label>
    <div class="controls">
      <div class=" input-prepend">
        <span class="add-on">http://</span>
        <input type="text" name="website" id="website" placeholder="monsiteweb.fr" <?php echo $form->value('website'); ?> class="input-xlarge"/>
      </div>
    </div>
  </div>
  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary" value="<?php echo $form->submit(); ?>" /> 
    <input type="reset" class="btn" value="Annuler" />
  </div>
  
</form>
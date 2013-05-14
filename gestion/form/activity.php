<form action="<?php echo $form->action(); ?>" method="<?php echo $form->method();?>" class="form-horizontal" enctype="multipart/form-data">
  <!--<?php echo ($form->legend() != null ? '<legend>'. $form->legend() .'</legend>' : null); ?>-->
  
  <!-- form messages -->
  <?php
    if (isset($_SESSION['form_msg'])) {
      echo '<div class="control-group"><div class="controls input-xxlarge">', $_SESSION['form_msg'], '</div></div>';
      unset($_SESSION['form_msg']);
    }
  ?>
  <!-- /form messages -->
  
  <h3 class="controls">Informations</h3>
  
  <div class="control-group">
    <label class="control-label" for="name">Nom</label>
    <div class="controls">
      <input type="text" name="name" id="name" placeholder="Nom de l’activité" class="input-xxlarge" <?php echo $form->value('name'); ?>/>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="description"><i class="icon-book"></i> Description</label>
    <div class="controls">
      <textarea name="description" id="description" rows="10" placeholder="Description de l’activité" class="input-xxlarge"><?php echo $form->input('description'); ?></textarea>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="place"><i class="icon-map-marker"></i> Lieu</label>
    <div class="controls">
      <input type="text" name="place" id="place" placeholder="Lieu de l’activité" <?php echo $form->value('place'); ?> class="input-xxlarge"/>
    </div>
  </div>
  
  <!--
  <div class="control-group">
    <label class="control-label" for="image"><i class="icon-picture"></i> Image</label>
    <div class="controls">
      <input type="file" name="image" id="image" class="input-xxlarge"/>
      <span class="help-block">L’image sera automatiquement redimensionnée<br />L’image ne doit pas excéder 2Mo</span>
    </div>
  </div>
  -->
  <!--
  <div class="control-group">
    <label class="control-label" for="image"><i class="icon-picture"></i> Image</label>
    <div class="controls">
      <div class="fileupload fileupload-new" data-provides="fileupload">
        <span class="btn btn-file"><span class="fileupload-new">Choisir</span><span class="fileupload-exists">Modifier</span>
          <input type="file" name="image" id="image"/></span>
        <span class="fileupload-preview"></span>
        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
      </div>
      <span class="help-block">L’image sera automatiquement redimensionnée<br />L’image ne doit pas excéder 2Mo</span>
    </div>
  </div>
  -->
  <div class="control-group">
    <label class="control-label" for="image"><i class="icon-picture"></i> Image</label>
    <div class="controls">
      <div class="fileupload fileupload-new pull-left" data-provides="fileupload">
        <div class="fileupload-new thumbnail" style="width: 175px; height: 115px;"><img src="<?php if (isset($act) && $act->hasImage()) echo _ASSETS_.'/activities/'.$act->id().'.jpg'; else echo _FSC_.'/img/no-image.jpg'; ?>" /></div>
        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 175px; max-height: 115px; line-height: 20px;"></div>
        <div>
          <span class="btn btn-file"><span class="fileupload-new">Choisir</span><span class="fileupload-exists">Modifier</span><input type="file" name="image" id="image" /></span>
          <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Supprimer</a>
        </div>
      </div>
      <span class="help-inline" style="margin-left:10px; margin-top:20px;">L’image sera automatiquement redimensionnée<br />L’image ne doit pas excéder 2Mo</span>
    </div>
  </div>
  
  <h3 class="controls">Tarif</h3>
  
  <?php if (! $page->option('hide-aggregate')) { ?>
  <div class="control-group">
    <label class="control-label" for="aggregate">Pratique libre</label>
    <div class="controls">
      <label class="checkbox" for="aggregate">
        <input type="checkbox" name="aggregate" id="aggregate" <?php echo $form->checkbox('aggregate'); ?>/>
        <span class="help-inline">L’activité est en <abbr title="L’inscription à l’activité permet aux participants de venir à tous les créneaux">pratique libre</abbr></span>
      </label>
    </div>
  </div>
  <?php } ?>
  
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
      <span class="help-inline">Laisser vide si les tarifs sont identiques</span>
    </div>
  </div>
  
  <h3 class="controls">Contact</h3>
  
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

<link rel="stylesheet" type="text/css" href="<?php echo _FSC_; ?>/css/bootstrap-wysihtml5.css" />
<?php
  $_SCRIPT[] = '
<script src="'. _FSC_ .'/js/bootstrap-fileupload.min.js"></script>
<script src="'. _FSC_ .'/js/wysihtml5.min.js"></script>
<script src="'. _FSC_ .'/js/bootstrap-wysihtml5.js"></script>
<script type="text/javascript">
	$("#description").wysihtml5();
</script>
'; ?>
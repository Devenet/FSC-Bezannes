<form action="<?php echo $form->action(); ?>" method="<?php echo $form->method();?>" class="form-horizontal" enctype="multipart/form-data">
	<!--<?php echo ($form->legend() != NULL ? '<legend>'. $form->legend() .'</legend>' : NULL); ?>-->
	
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
			<textarea name="description" id="description" rows="15" placeholder="Description de l’activité" class="input-xxlarge"><?php echo $form->input('description'); ?></textarea>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="place"><i class="icon-map-marker"></i> Lieu</label>
		<div class="controls">
			<input type="text" name="place" id="place" placeholder="Lieu de l’activité" <?php echo $form->value('place'); ?> class="input-xxlarge"/>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="image"><i class="icon-picture"></i> Image</label>
		<div class="controls">
			<div class="fileupload fileupload-new pull-left" data-provides="fileupload">
				<div class="fileupload-new thumbnail" style="width: 175px; height: 115px;"><img src="<?php if (isset($act) && $act->hasImage()) echo _UPLOADS_.'/activities/'.$act->id().'.jpg'; else echo _STATIC_.'/img/no-image.jpg'; ?>" /></div>
				<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 175px; max-height: 115px; line-height: 20px;"></div>
				<div>
					<span class="btn btn-file"><span class="fileupload-new">Choisir</span><span class="fileupload-exists">Remplacer</span><input type="file" name="image" id="image" /></span>
					<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Supprimer</a>
				</div>
			</div>
			<span class="help-inline" style="margin-left:10px; margin-top:20px;">L’image sera automatiquement redimensionnée en 210px par 135px<br />L’image ne doit pas excéder 1,5Mo
				<br /><small>Si une erreur survient, merci de réessayer avec une image plus petite</small></span>
		</div>
	</div>
	
	<h3 class="controls">Tarif</h3>
	
	<?php if (! $page->option('hide-aggregate')) { ?>
	<div class="control-group">
		<label class="control-label" for="aggregate">Pratique libre</label>
		<div class="controls">
			<label class="checkbox" for="aggregate">
				<input type="checkbox" name="aggregate" id="aggregate" <?php echo $form->checkbox('aggregate'); ?>/>
				<span class="help-inline">L’inscription à l’activité permet aux participants de venir à tous les créneaux (bibliothèque, badminton, &hellip;).
					<br /><small>Une fois l’activité créée, il ne sera plus possible de modifier ce paramètre.</small></span>
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
		<label class="control-label" for="email"><i class="icon-envelope-alt"></i> Courriel</label>
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
		<input type="reset" class="btn" value="Effacer" />
	</div>
	
</form>

<?php
$_SCRIPT[] = '<script src="'. _STATIC_ .'/js/bootstrap-fileupload-'. _VERSION_JS_ .'.min.js"></script>';
$_SCRIPT[] = '<script src="'. _STATIC_ .'/js/wysihtml5-'. _VERSION_JS_ .'.min.js"></script>';
$_SCRIPT[] = '<script src="'. _STATIC_ .'/js/bootstrap-wysihtml5-'. _VERSION_JS_ .'.js"></script>';
$_SCRIPT[] = '<script src="'. _STATIC_ .'/js/hogan-'. _VERSION_JS_ .'.min.js"></script>';
$_SCRIPT[] = '<script src="'. _STATIC_ .'/js/typeahead-'. _VERSION_JS_ .'.min.js"></script>';
$_SCRIPT[] = "
<script>
$(document).ready(function() {
$('#description').wysihtml5();
$('input#place').typeahead({
	name: 'places',
	valueKey: 'place',
	prefetch: {
		'url': 'http:". _PRIVATE_API_ ."/activities_places.php',
		'ttl': 30000
		},
	template: '{{place}}',
	limit: 8,
	engine: Hogan
});
$('abbr.tip').tooltip({'placement': 'right'});
});
</script>
"; 
?>

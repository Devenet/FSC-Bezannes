<div class="row">
	<div class="span12">
		<div class="page-header">
			<h2 style="margin-bottom: 0;">Configuration</h2>
		</div>
	</div>
</div>

<div class="row">
	<div class="span8 offset2">
		<div class="alert">
			<i class="icon-warning-sign icon-3x pull-left"></i>
			La modification des paramètres suivants peut être dommageable pour la stabilité de l’application. Ne continuez que si vous savez ce que vous faites.
		</div>
	</div>
</div>

<ul class="nav nav-tabs">
	<li class="active"><a href="?page=settings">Paramètres</a></li>
	<li><a href="?page=settings-prices">Cotisations</a></li>
	<li class="pull-right"><a href="?page=settings-debug">Déboguage</a/></li>
</ul>

<form action="?page=settings" method="post" class="form-horizontal">

	<!-- form messages -->
	<?php
		if (isset($_SESSION['form_msg'])) {
			echo '<div class="control-group"><div class="controls input-xxlarge">', $_SESSION['form_msg'], '</div></div>';
			unset($_SESSION['form_msg']);
		}
	?>
	<!-- /form messages -->

	<h3 class="controls">Paramètres généraux</h3>
	
	<div class="control-group">
		<label class="control-label" for="year">Saison</label>
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on"><i class="icon-calendar"></i></span>
				<input type="number" name="year" id="year" placeholder="<?php echo date('Y'); ?>"  class="input-mini" step="1" min="2000" value="<?php echo _YEAR_; ?>" />
			</div>
			<span class="help-block">Il s’agit de l’année de la saison en cours au 1<sup>er</sup> septembre.</span>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="preinscriptions">Préinscriptions</label>
		<div class="controls">
			<label class="radio inline" for="preinscriptions">
				<input type="radio" name="preinscriptions" id="preinscriptions" value="enabled" <?php if(_PREINSCRIPTION_ENABLED_) {echo 'checked="checked"';} ?>/> activées <i class="icon-ok"></i>
			</label>
			<label class="radio inline" for="preinscriptions2">
				<input type="radio" name="preinscriptions" id="preinscriptions2" value="disabled" <?php if(!_PREINSCRIPTION_ENABLED_) {echo 'checked="checked"';} ?>/> désactivées <i class="icon-remove"></i>
			</label>
			<span class="help-block espace-small-top">La désactivation des préinscriptions ne supprime pas les préinscriptions.</span>
		</div>
	</div>

	<h3 class="controls">Coordonnées</h3>

	<div class="control-group">
		<label class="control-label" for="phone">Téléphone</label>
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on"><i class="icon-phone"></i></span>
				<input type="text" name="phone" id="phone" placeholder="Téléphone secrétariat"  class="input-medium" value="<?php echo _PHONE_SEC_; ?>"/>
			</div>
			<span class="help-block">Le format attendu est 0102030405.</span>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="email">Courriel</label>
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on"><i class="icon-envelope-alt"></i></span>
				<input type="text" name="email" id="email" placeholder="contact@fsc-bezannes.fr"  class="input-xlarge" value="<?php echo _EMAIL_; ?>"/>
			</div>
			<span class="help-block">L’adresse e-mail est utilitée dans les courriels automatiques envoyés par le site.
				<br /><small>Le courriel par défaut est <strong>contact@fsc-bezannes.fr</strong>. Tous les messages reçus à cette adresse sont automatiquement renvoyés vers <em>fscbezannes.isabelle@orange.fr</em>, <em>fscbezannes.monique@orange.fr</em> et <em>fscbezannes@orange.fr</em>.</small></span>
		</div>
	</div>

	
	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="Mettre à jour" id="submit_btn" />
		<input type="reset" class="btn" value="Effacer" />
	</div>
	
</form>
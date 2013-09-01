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
				<input type="radio" name="preinscriptions" id="preinscriptions" value="enabled" <?php if(_PREINSCRIPTION_ENABLED_) {echo 'checked="checked"';} ?>/> activées 
			</label>
			<label class="radio inline" for="preinscriptions2">
				<input type="radio" name="preinscriptions" id="preinscriptions2" value="disabled" <?php if(!_PREINSCRIPTION_ENABLED_) {echo 'checked="checked"';} ?>/> désactivées 
			</label>
			<span class="help-block espace-small-top">La désactivation des préinscriptions ne supprime pas les préinscriptions.
				<br /><small>Vous pouvez <a href="#change-disabled-more" role="button" data-toggle="modal">modifier le texte d’information</a>.</small></span>
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
			<span class="help-block">L’adresse e-mail est utilitée dans les courriels automatiques envoyés par le site.</span>
			<span class="help-block" style="margin-top:5px;line-height:16px;"><small>Le courriel par défaut est <a href="mailto:contact@fsc-bezannes.fr">contact@fsc-bezannes.fr</a>. Tous les messages reçus à cette adresse sont automatiquement renvoyés vers <em>fscbezannes.isabelle@orange.fr</em>, <em>fscbezannes.monique@orange.fr</em> et <em>fscbezannes@orange.fr</em>.</small></span>
		</div>
	</div>

	
	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="Mettre à jour" id="submit_btn" />
		<input type="reset" class="btn" value="Effacer" />
	</div>
	
</form>

<!-- Modal -->
<div id="change-disabled-more" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalChangeInfos" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="modalChangeInfos">Modifier le texte d’information</h3>
  </div>
  <form method="post" action="<?php echo _GESTION_; ?>/?page=settings&amp;update=disabled-infos" class="form" style="margin-bottom:0;">
    <div class="modal-body">
    	<div class="alert alert-info"><strong>Note :</strong> ce texte apparaît lorsque les préinscriptions sont désactivées. Un aperçu est disponible sur <a href="<?php echo _PREINSCRIPTION_; ?>/disabled" rel="external">cette page <span class="external-link normal"><i class="icon-external-link"></i></span></a>.</div>

			<textarea id="infos" name="infos" rows="8" style="width:510px;"><?php echo $display_infos_disabled; ?></textarea>
			<input type="hidden" name="token" value="42" />
      
    </div>
    <div class="modal-footer">
    	<span class="btn pull-left" id="write-default-text">Texte par défaut</span>
      <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
      <input type="submit" class="btn btn-primary" value="Modifier" />
    </div>
  </form>
</div>
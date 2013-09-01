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
	<li><a href="?page=settings">Paramètres</a></li>
	<li class="active"><a href="?page=settings-prices">Cotisations</a></li>
	<li class="pull-right"><a href="?page=settings-debug">Déboguage</a/></li>
</ul>

<form action="?page=settings-prices" method="post" class="form-horizontal">

	<!-- form messages -->
	<?php
		if (isset($_SESSION['form_msg'])) {
			echo '<div class="control-group"><div class="controls input-xxlarge">', $_SESSION['form_msg'], '</div></div>';
			unset($_SESSION['form_msg']);
		}
	?>
	<!-- /form messages -->

	<h3 class="controls">Adultes</h3>
	
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<label class="control-label" for="adult">Bezannais</label>
				<div class="controls">
					<div class=" input-append">
						<input name="adult" id="adult" placeholder="16" value="<?php echo $prices->price(0,1); ?>" class="input-mini" type="number" min="0">
						<span class="add-on">€</span>
					</div>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<label class="control-label" for="adult_ext">Extérieur</label>
				<div class="controls">
					<div class=" input-append">
						<input name="adult_ext" id="adult_ext" placeholder="21" value="<?php echo $prices->price(0,0); ?>" class="input-mini" type="number" min="0">
						<span class="add-on">€</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<h3 class="controls">Jeunes</h3>

		<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<label class="control-label" for="young">Bezannais</label>
				<div class="controls">
					<div class=" input-append">
						<input name="young" id="young" placeholder="16" value="<?php echo $prices->price(1,1); ?>" class="input-mini" type="number" min="0">
						<span class="add-on">€</span>
					</div>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<label class="control-label" for="young_ext">Extérieur</label>
				<div class="controls">
					<div class=" input-append">
						<input name="young_ext" id="young_ext" placeholder="21" value="<?php echo $prices->price(1,0); ?>" class="input-mini" type="number" min="0">
						<span class="add-on">€</span>
					</div>
				</div>
			</div>
		</div>
	</div>


	
	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="Mettre à jour" id="submit_btn" />
		<input type="reset" class="btn" value="Effacer" />
	</div>
	
</form>
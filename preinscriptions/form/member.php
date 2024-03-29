<?php

$form->addOption('date_birthday_day', '', NULL);
for ($i = 1; $i <= 31; $i++) {
	$form->addOption('date_birthday_day', $i, $i);
	$form->addOption('date_registration_day', $i, $i);
}

$form->addOption('date_birthday_year', '', NULL);
for ($i = date('Y')-1; $i >= date('Y')-100 ; $i--) {
	$form->addOption('date_birthday_year', $i, $i);
}

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
$form->addOption('date_birthday_month', '', NULL);
foreach ($months as $value => $month) {
	$form->addOption('date_birthday_month', $month, $value);
	$form->addOption('date_registration_month', $month, $value);
}
?>

<form action="<?php echo $form->action(); ?>" method="<?php echo $form->method();?>" class="form-horizontal" >
	<!--<?php echo ($form->legend() != NULL ? '<legend>'. $form->legend() .'</legend>' : NULL); ?>-->
	
	<!-- form messages -->
	<?php
		if (isset($_SESSION['form_msg'])) {
			echo '<div class="control-group"><div class="controls input-xxlarge">', $_SESSION['form_msg'], '</div></div>';
			unset($_SESSION['form_msg']);
		}
	?>
	
	<h3 class="controls">Identité</h3>
	
	<div class="control-group">
		<label class="control-label" for="gender">Civilité</label>
		<div class="controls">
			<label class="radio inline">
				<input type="radio" id="gender" value="0" name="gender" <?php echo ($form->input('gender') == '0' ? 'checked="checked"' : NULL); ?> /> Monsieur
			</label>
			<label class="radio inline">
				<input type="radio" value="1" name="gender" <?php echo ($form->input('gender') == '1' ? 'checked="checked"' : NULL); ?> /> Madame
			</label>
			<label class="radio inline">
				<input type="radio" value="2" name="gender" <?php echo ($form->input('gender') == '2' ? 'checked="checked"' : NULL); ?> /> Mademoiselle
			</label>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="last_name">Nom</label>
		<div class="controls">
			<input type="text" name="last_name" id="last_name" placeholder="Smith" <?php echo $form->value('last_name'); ?> class="input-xxlarge" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="first_name">Prénom</label>
		<div class="controls">
			<input type="text" name="first_name" id="first_name" placeholder="John" <?php echo $form->value('first_name'); ?> class="input-xxlarge" />
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="date_birthday_day">Date de naissance</label>
		<div class="controls">
			<select class="input-mini" name="date_birthday_day" id="date_birthday_day">
				<?php echo $form->select('date_birthday_day', $form->input('date_birthday_day')); ?>
			</select>
			<select class="input-medium" name="date_birthday_month" id="date_birthday_month">
				<?php echo $form->select('date_birthday_month', $form->input('date_birthday_month')); ?>
			</select>
			<select class="input-small" name="date_birthday_year" id="date_birthday_year">
				<?php echo $form->select('date_birthday_year', $form->input('date_birthday_year')); ?>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="minor">Jeune</label>
		<div class="controls">
			<label class="checkbox" for="minor">
				<input type="checkbox" name="minor" id="minor" <?php echo $form->checkbox('minor'); ?> />
				moins de 18 ans au 1<sup>er</sup> septembre <?php echo _YEAR_; ?>
			</label>
		</div>
	</div>
	
	<h3 class="controls">Adresse</h3>
	
	<div class="control-group" id="box_address_different">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" name="address_different" id="address_different" <?php echo $form->checkbox('address_different'); ?> />
				Adresse du jeune différente du représentant légal
			</label>
		</div>
	</div>
	
	<div id="address">
		<div class="control-group">
			<label class="control-label" for="address_number">N°</label>
			<div class="controls">
				<input type="text" name="address_number" id="address_number" placeholder="42" <?php echo $form->value('address_number'); ?> class="span1" />
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="address_street">Voie</label>
			<div class="controls">
				<input type="text" name="address_street" id="address_street" placeholder="Grande Rue" <?php echo $form->value('address_street'); ?> class="input-xxlarge" />
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="address_further">Complément</label>
			<div class="controls">
				<input type="text" name="address_further" id="address_further" placeholder="Résidence Jolie" <?php echo $form->value('address_further'); ?> class="input-xxlarge" />
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="address_zip_code">Commune</label>
			<div class="controls controls-row">
				<input type="text" name="address_zip_code" id="address_zip_code" placeholder="51430" <?php echo $form->value('address_zip_code'); ?> class="span2" maxlength="5" />
				<input type="text" name="address_town" id="address_town" placeholder="Bezannes" <?php echo $form->value('address_town'); ?> class="span5"/>
			</div>
		</div>
	</div>
	
	<h3 class="controls">Contact</h3>
	
	<div class="control-group">
		<label class="control-label" for="email">Courriel</label>
		<div class="controls">
			<input type="email" name="email" id="email" placeholder="john@smith.com" <?php echo $form->value('email'); ?> class="input-xxlarge"/>
			<span class="help-block">Pour un mineur ne possédant pas d’adresse email, vous pouvez mettre le courriel du responsable.</span>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="phone">Téléphone</label>
		<div class="controls controls-row">
			<input type="text" name="phone" id="phone" placeholder="Téléphone (0102030405)" <?php echo $form->value('phone'); ?> class="span3" maxlength="10"/>
			<input type="text" name="mobile" id="mobile" placeholder="Téléphone (0602030405)" <?php echo $form->value('mobile'); ?> class="span3 offset2" maxlength="10"/>
		</div>
	</div>
	
	<h3 class="controls">Inscription</h3>
	
	<div class="control-group info">
		<label class="control-label" for="adherent">Pré-adhérer</label>
		<div class="controls">
			<label class="checkbox" for="adherent">
				<input type="checkbox" name="adherent" id="adherent" <?php echo $form->checkbox('adherent'); ?>/>
				<span class="help-inline">Je souhaite devenir adhérent pour me préinscrire aux activités
					<br />Si vous remplissez le formulaire en tant que responsable non-adhérent, vous n'avez pas à cocher cette case.</span>
			</label>
		</div>
	</div>
	
	
	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="<?php echo $form->submit(); ?>" id="submit_btn" />
		<input type="reset" class="btn" value="<?php echo $form->reset(); ?>" />
	</div>
	
</form>

<?php
	$_SCRIPT[] = '
<script>
$(document).ready(function() {

var minor, address_different, adherent;
minor = ($("#minor").attr("checked") == "checked");
address_different = ($("#address_different").attr("checked") == "checked");
adherent = ($("#adherent").attr("checked") == "checked");

if (!minor) $("#box_address_different").hide();
else if (!address_different) $("#address").hide();'.
($form->name() == 'new-member' ? 'if (minor) $("#submit_btn").attr("value", "Choisir le responsable");' : '')
.'
$("#minor").click(function() {
	minor = !minor;
	if(minor) {
		$("#box_address_different").fadeIn();'.
		($form->name() == 'new-member' ? '$("#submit_btn").attr("value", "Choisir le responsable");' : '')
		.'
		if (!address_different)
			$("#address").hide();
		else
			$("#address").fadeIn();
	}
	else {
		$("#address").fadeIn();
		$("#box_address_different").hide();'.
		($form->name() == 'new-member' ? '$("#submit_btn").attr("value", "'. $form->submit() .'");' : '')
		.'
	}
});

$("#address_different").click(function() {
	address_different = !address_different;
	if(address_different)
		$("#address").fadeIn();
	else
		$("#address").hide();
});

});
</script>
';
?>
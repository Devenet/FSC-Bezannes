<div class="row">
	<div class="span12">
		<div class="page-header">
			<h2 style="margin-bottom: 0;">Configuration</h2>
		</div>
	</div>
</div>

<ul class="nav nav-tabs">
	<li><a href="?page=settings">Paramètres</a></li>
	<li><a href="?page=settings-prices">Cotisations</a></li>
	<li class="pull-right active"><a href="?page=settings-debug">Déboguage</a/></li>
</ul>

<div class="tabbable tabs-left">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-constants" data-toggle="tab">Constantes</a></li>
		<li><a href="#tab-db" data-toggle="tab">État de la BDD</a></li>
		<li><a href="#tab-ovh" data-toggle="tab">OVH</a></li>
	</ul>
	<div class="tab-content espace-small-top" style="padding-left:20px;">
		<div class="tab-pane active" id="tab-constants">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Constante</th>
						<th>Valeur</th>
					</tr>
				</thead>
				<?php echo $display_constants; ?>
			</table>
		</div>
		
		<div class="tab-pane" id="tab-db">
			<table class="table table-striped table-hover" style="max-width: 300px;">
				<thead>
					<tr>
						<th>Nom de la table</th>
						<th class="center">Entrées</th>
					</tr>
				</thead>
				<?php echo $display_db; ?>
			</table>
		</div>

		<div class="tab-pane" id="tab-ovh">
			<ul>
				<li><a href="https://www.ovh.com/managerv3/" rel="external">Manager <i class="icon-external-link"></i></a></li>
				<li><a href="https://phpmyadmin.ovh.net/" rel="external">phpMyAdmin <i class="icon-external-link"></i></a></li>
			</ul>
		</div>
	</div>
</div>


<div class="clearfix"></div>
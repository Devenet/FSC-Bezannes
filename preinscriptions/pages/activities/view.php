<div class="page-activites">
<div class="row-fluid">
	<div class="span10 offset1">
		<p class="lead">Retrouvez toutes les activités éducatives, récréatives et sportives proposées par le Foyer Social et Culturel !</p>
	</div>
</div>

<div class="row-fluid">
	<div class="span10 offset1">
		<div class="prices">
			<p><strong>Note :</strong> Ces activités sont réservées aux adhérents du FSC.</p>
			<div class="row-fluid">
				<div class="span4">
					<p><strong>Tarifs de l’adhésion :</strong></p>
					<small>* moins de 18 ans au 1<sup>er</sup> septembre <?php echo _YEAR_; ?></small>
				</div>
				<div class="span8">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th></th>
								<th>Bezannais</th>
								<th>Extérieur</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><strong>Jeune</strong> *</td>
								<td><?php echo $price->price(1,1); ?> €</td>
								<td><?php echo $price->price(1,0); ?> €</td>
							</tr>
							<tr>
								<td><strong>Adulte</strong></td>
								<td><?php echo $price->price(0,1); ?> €</td>
								<td><?php echo $price->price(0,0); ?> €</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="all">
	<ul class="inline">
		<?php foreach ($activities as $act): ?>
		<li>
			<a href="<?php echo _PREINSCRIPTION_; ?>/activity/<?php echo $act->url(); ?>" title="<?php echo $act->name(); ?>">
				<img src="<?php echo ($act->hasImage() ? substr($act->image(), 0, -4).'-'.$act->url().'.jpg' : $act->image()); ?>" alt="<?php echo $act->name(); ?>" class="img-polaroid" />
				<h4><?php echo $act->name(); ?></h4>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
</div>
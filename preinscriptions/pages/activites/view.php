<div class="page-activites">
<div class="row-fluid">
  <div class="span8 offset2">
    <p class="lead">Retrouvez toutes les activités éducatives, récréatives et sportives proposées par le Foyer Social et Culturel !</p>
  </div>
</div>

<div class="all">
  <ul class="inline">
    <?php foreach ($activities as $act): ?>
    <li>
      <a href="<?php echo _PREINSCRIPTION_; ?>/activite/<?php echo $act->url(); ?>" title="<?php echo $act->name(); ?>">
        <img src="<?php echo $act->image(); ?>" alt="<?php echo $act->name(); ?>" class="img-polaroid" />
        <h4><?php echo $act->name(); ?></h4>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
</div>
</div>
<div class="page-header">
  <h2>Activités</h2>
</div>

<div class="row-fluid">
  <div class="span8">
    <p class="lead">Retrouvez toutes les activités éducatives, récréatives et sportives proposées par le Foyer Social et Culturel !</p>
  </div>
  <div class="span4">
    <form class="form-search" style="text-align: center;">
      <p>Accès rapide</p>
      <input type="text" class="search-activities" placeholder="Bibliothèque"/>
    </form>
  </div>
</div>

<div class="all">
  <h3>Toutes les activités</h3>
  <ul class="inline">
    <?php foreach ($activities as $act): ?>
    <li>
      <a href="<?php echo _FSC_; ?>/activite/<?php echo $act->url(); ?>" title="<?php echo $act->name(); ?>">
        <img src="<?php echo $act->image(); ?>" alt="<?php echo $act->name(); ?>" class="img-polaroid" />
        <h4><?php echo $act->name(); ?></h4>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="page-header">
  <h2>Activités</h2>
</div>

<ul>
<?php foreach ($activities as $act): ?>
<li><a href="/activite/<?php echo $act->url(); ?>.html"><?php echo $act->name(); ?></a></li>
<?php endforeach; ?>
</ul>
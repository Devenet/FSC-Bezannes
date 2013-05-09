<div class="page-header">
  <h2>Activités</h2>
</div>

<ul>
<?php foreach ($activities as $act): ?>
<li><a href="<?php echo _FSC_; ?>/activite/<?php echo $act->url(); ?>"><?php echo $act->name(); ?></a></li>
<?php endforeach; ?>
</ul>
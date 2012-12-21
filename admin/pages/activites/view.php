<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Activité</th>
      <th>Visible</th>
      <th>Tarif</th>
      <th>Tarif jeune</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($activities as $act): ?>
    <tr>
      <td><?php echo $act->id(); ?></td>
      <td><a href="/?page=activite&id=<?php echo $act->id(); ?>"><?php echo $act->name(); ?></a></td>
      <td><?php echo ($act->active() == 1) ? '<i class="icon-ok"></i>' : '<i class="icon-ban-circle"></i>' ; ?></td>
      <td><?php echo $act->price(); ?> €</td>
      <td><?php echo ($act->price_young() == -1) ? '&ndash;' : $act->price_young() .' €'; ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
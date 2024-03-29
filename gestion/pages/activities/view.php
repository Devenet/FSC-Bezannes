<form class="form-search pull-left">
  <input type="text" class="search-activities span4" placeholder="Accès rapide" autofocus/>
</form>
<div class="pull-right">
  <a href="./?page=new-activity" class="btn btn-primary btn-small pull-right"><i class="icon-plus icon-white"></i> Ajouter</a>
</div>

<div class="clearfix">&nbsp;</div>

<table class="table table-striped espace-top">
  <thead>
    <tr>
      <th>#</th>
      <th><a href="./?page=activities&amp;sort=name-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'name-asc' ? 'desc' : 'asc'; ?>"><?php echo $sort['name']->icon(); ?></a> Activité </th>
      <th><a href="./?page=activities&amp;sort=active-<?php echo isset($_GET['sort']) && $_GET['sort'] ==  'active-asc' ? 'desc' : 'asc'; ?>"><?php echo $sort['active']->icon(); ?></a> Activée</th>
      <th><a href="./?page=activities&amp;sort=price-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'price-asc' ? 'desc' : 'asc'; ?>"><?php echo $sort['price']->icon(); ?></a> Tarif</th>
      <th>Tarif jeune</th>
      <th> </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($activities as $act): ?>
    <tr <?php echo $act->active() == 0 ? 'class="muted"' : NULL; ?>>
      <td><?php echo $act->id(); ?></td>
      <td><a href="./?page=activity&amp;id=<?php echo $act->id(); ?>"><?php echo $act->name(); ?></a></td>
      <td><?php echo ($act->active() == 1) ? '<i class="icon-ok"></i>' : '' ; ?></td>
      <td><?php echo $act->price(); ?> €</td>
      <td><?php echo ($act->price_young() == -1) ? '&ndash;' : $act->price_young() .' €'; ?></td>
      <td style="padding-right:0; padding-left:0;" class="center">
        <div class="btn-group">
          <a href="./?page=activity&amp;id=<?php echo $act->id(); ?>" class="btn btn-small" title="Voir"><i class="icon-eye-open"></i></a>
          <a href="./?page=edit-activity&amp;id=<?php echo $act->id(); ?>" class="btn btn-small" title="Modifier"><i class="icon-pencil"></i></a>
        </div>
          <a href="#confirmBox<?php echo $act->id(); ?>" role="button" data-toggle="modal" class="btn btn-small" title="Supprimer"><i class="icon-trash"></i></a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="pagination pagination-centered">
  <ul>
    <?php echo $display_pagination; ?>
  </ul>
</div>

<?php foreach ($activities as $act): ?>
<div id="confirmBox<?php echo $act->id(); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelActivity<?php echo $act->id(); ?>" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="ConfirmDelActivity<?php echo $act->id(); ?>"><?php echo $act->name(); ?></h3>
  </div>
  <div class="modal-body">
    <p class="text-error">Êtes-vous sûr de vouloir supprimer cette activité ?</p>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
    <a href="./?page=activity&amp;id=<?php echo $act->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
  </div>
</div>
<?php endforeach; ?>


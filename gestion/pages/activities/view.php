<form class="form-search pull-left">
  <input type="text" class="search-activities" placeholder="Accès rapide"/>
</form>
<div class="pull-right">
  <a href="/?page=new-activity" class="btn btn-primary pull-right"><i class="icon-plus icon-white"></i> Ajouter</a>
</div>

<div class="clearfix">&nbsp;</div>

<table class="table table-striped espace-top">
  <thead>
    <tr>
      <th>#</th>
      <th><a href="/?page=activities&amp;sort=name-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'name-asc' ? 'desc' : 'asc'; ?>"><i class="icon-sort"></i></a> Activité</th>
      <th><a href="/?page=activities&amp;sort=active-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'active-asc' ? 'desc' : 'asc'; ?>"><i class="icon-sort"></i></a> Activée</th>
      <th><a href="/?page=activities&amp;sort=price-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'price-asc' ? 'desc' : 'asc'; ?>"><i class="icon-sort"></i></a> Tarif</th>
      <th>Tarif jeune</th>
      <th> </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($activities as $act): ?>
    <tr <?php echo $act->active() == 0 ? 'class="muted"' : null; ?>>
      <td><?php echo $act->id(); ?></td>
      <td><a href="/?page=activity&amp;id=<?php echo $act->id(); ?>"><?php echo $act->name(); ?></a></td>
      <td><?php echo ($act->active() == 1) ? '<i class="icon-ok"></i>' : '' ; ?></td>
      <td><?php echo $act->price(); ?> €</td>
      <td><?php echo ($act->price_young() == -1) ? '&ndash;' : $act->price_young() .' €'; ?></td>
      <td style="width: 80px;">
        <div class="btn-group">
          <a class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="#"><i class="icon-edit"></i> 
          <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="/?page=activity&amp;id=<?php echo $act->id(); ?>"><i class="icon-eye-open"></i> Voir</a></li>
            <li><a href="/?page=edit-activity&amp;id=<?php echo $act->id(); ?>"><i class="icon-pencil"></i> Modifier</a></li>
            <li class="divider"></li>
            <li><a href="#confirmBox<?php echo $act->id(); ?>" role="button" data-toggle="modal"><i class="icon-trash"></i> Supprimer</a></li>
          </ul>
        </div>
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
    <a href="/?page=activity&amp;id=<?php echo $act->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
  </div>
</div>
<?php endforeach; ?>

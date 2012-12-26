<div class="pull-right" style="margin-bottom:10px;">
  <a href="/?page=new-member" class="btn btn-primary"><i class="icon-plus icon-white"></i> Ajouter</a>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Adhérent</th>
      <th>Bezannais</th>
      <th></th>
      <th> </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($members as $m): ?>
    <tr <?php echo $m->adherent() == 0 ? 'class="muted"' : null; ?>>
      <td><?php echo $m->id(); ?></td>
      <td><?php echo $m->last_name(); ?></td>
      <td><?php echo $m->first_name(); ?></td>
      <td><i class="<?php echo ($m->adherent() ? 'icon-ok-circle' : 'icon-ban-circle'); ?>"></i></td>
      <th><?php echo ($m->bezannais() ? '<i class="icon-home"></i>' : '&ndash;' ); ?></th>
      <td style="width: 80px;">
        <div class="btn-group">
          <a class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="#"><i class="icon-edit"></i> 
          <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="/?page=member&id=<?php echo $m->id(); ?>"><i class="icon-eye-open"></i> Voir</a></li>
            <li><a href="/?page=edit-member&id=<?php echo $m->id(); ?>"><i class="icon-pencil"></i> Modifier</a></li>
            <li class="divider"></li>
            <li><a href="#confirmBox<?php echo $m->id(); ?>" role="button" data-toggle="modal"><i class="icon-trash"></i> Supprimer</a></li>
          </ul>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php foreach ($members as $m): ?>
<div id="confirmBox<?php echo $m->id(); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelMember<?php echo $m->id(); ?>" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="ConfirmDelMember<?php echo $m->id(); ?>"><?php echo $m->name(); ?></h3>
  </div>
  <div class="modal-body">
    <p class="text-error">Êtes-vous sûr de vouloir supprimer ce membre ?</p>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal" aria-hidden="true"/>Annuler</a>
    <a href="/?page=member&id=<?php echo $m->id(); ?>&action=delete" class="btn btn-danger">Confirmer</a>
  </div>
</div>
<?php endforeach; ?>

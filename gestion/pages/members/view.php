<form class="form-search pull-left">
  <input type="text" class="search-members span4" placeholder="Accès rapide" autofocus />
</form>
<div class="pull-right">
  <a href="./?page=new-member" class="btn btn-primary btn-small pull-right"><i class="icon-plus icon-white"></i> Ajouter</a>
</div>

<div class="clearfix">&nbsp;</div>

<table class="table table-striped espace-top">
  <thead>
    <tr class="small">
      <th><a href="./?page=members&amp;sort=id-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'id-asc' ? 'desc' : 'asc'; ?>"><?php echo $sort['id']->icon(); ?></a> #</th>
      <th><a href="./?page=members&amp;sort=name-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'name-asc' ? 'desc' : 'asc'; ?>"><?php echo $sort['name']->icon(); ?></a> Nom</th>
      <th>Prénom</th>
      <th style="width:110px; text-align:center;"><a href="./?page=members&amp;sort=adherent-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'adherent-asc' ? 'desc' : 'asc'; ?>"><?php echo $sort['adherent']->icon(); ?></a> Adhérent</th>
      <th style="width:110px; text-align:center;"><a href="./?page=members&amp;sort=bezannais-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'bezannais-asc' ? 'desc' : 'asc'; ?>"><?php echo $sort['bezannais']->icon(); ?></a> Bezannais</th>
      <th style="width:110px; text-align:center;"><a href="./?page=members&amp;sort=adult-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'adult-asc' ? 'desc' : 'asc'; ?>"><?php echo $sort['adult']->icon(); ?></a> Catégorie</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($members as $m): ?>
    <tr>
      <td<?php echo $m->adherent() == 0 ? ' class="muted"' : NULL; ?>><?php echo $m->id(); ?></td>
      <td><a href="./?page=member&amp;id=<?php echo $m->id(); ?>"><?php echo $m->last_name(); ?></a></td>
      <td><a href="./?page=member&amp;id=<?php echo $m->id(); ?>"><?php echo $m->first_name(); ?></a></td>
      <td style="width:110px; text-align:center;"><i class="icon-<?php echo ($m->adherent() ? 'ok' : ''); ?>"></i></td>
      <td style="width:110px; text-align:center;"><i class="icon-<?php echo ($m->bezannais() ? 'ok' : ''); ?>"></i></td>
      <td style="width:110px; text-align:center;"><?php echo ($m->minor() ? 'e' : ($m->countResponsabilities() > 0 ? 'A <span style="position:absolute; padding-left:5px; color:#333;">&bull;</span>' : 'A')); ?></td>
      <td style="padding-left:0; padding-right:0;" class="center">
        <div class="btn-group">
          <a href="./?page=member&amp;id=<?php echo $m->id(); ?>" class="btn btn-small" title="Voir"><i class="icon-eye-open"></i></a>
          <a href="./?page=edit-member&amp;id=<?php echo $m->id(); ?>" class="btn btn-small" title="Modifier"><i class="icon-pencil"></i></a>
        </div>
          <a href="#confirmBox<?php echo $m->id(); ?>" role="button" data-toggle="modal" class="btn btn-small" title="Supprimer"><i class="icon-trash"></i></a>
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
    <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
    <a href="./?page=member&amp;id=<?php echo $m->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
  </div>
</div>
<?php endforeach; ?>

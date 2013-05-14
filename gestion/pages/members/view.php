<form class="form-search pull-left">
  <input type="text" class="search-members" placeholder="Accès rapide" autofocus />
</form>
<div class="pull-right">
  <a href="/?page=new-member" class="btn btn-primary pull-right"><i class="icon-plus icon-white"></i> Ajouter</a>
</div>

<div class="clearfix">&nbsp;</div>

<table class="table table-striped espace-top">
  <thead>
    <tr class="small">
      <th>#</th>
      <th><a href="/?page=members&amp;sort=name-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'name-asc' ? 'desc' : 'asc'; ?>"><i class="icon-sort"></i></a> Nom</th>
      <th>Prénom</th>
      <th style="width:110px; text-align:center;"><a href="/?page=members&amp;sort=adherent-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'adherent-asc' ? 'desc' : 'asc'; ?>"><i class="icon-sort"></i></a> Adhérent</th>
      <th style="width:110px; text-align:center;"><a href="/?page=members&amp;sort=bezannais-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'bezannais-asc' ? 'desc' : 'asc'; ?>"><i class="icon-sort"></i></a> Bezannais</th>
      <th style="width:110px; text-align:center;"><a href="/?page=members&amp;sort=adult-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'adult-asc' ? 'desc' : 'asc'; ?>"><i class="icon-sort"></i></a> Catégorie</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($members as $m): ?>
    <tr>
      <td<?php echo $m->adherent() == 0 ? ' class="muted"' : null; ?>><?php echo $m->id(); ?></td>
      <td><a href="/?page=member&amp;id=<?php echo $m->id(); ?>"><?php echo $m->last_name(); ?></a></td>
      <td><a href="/?page=member&amp;id=<?php echo $m->id(); ?>"><?php echo $m->first_name(); ?></a></td>
      <td style="width:110px; text-align:center;"><i class="icon-<?php echo ($m->adherent() ? 'ok' : ''); ?>"></i></td>
      <td style="width:110px; text-align:center;"><i class="icon-<?php echo ($m->bezannais() ? 'ok' : ''); ?>"></i></td>
      <td style="width:110px; text-align:center;"><?php echo ($m->minor() ? 'e' : 'A'); ?></td>
      <td style="width: 80px;">
        <div class="btn-group">
          <a class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="/?page=member&amp;id=<?php echo $m->id(); ?>"><i class="icon-edit"></i> 
          <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="/?page=member&amp;id=<?php echo $m->id(); ?>"><i class="icon-eye-open"></i> Voir</a></li>
            <li><a href="/?page=edit-member&amp;id=<?php echo $m->id(); ?>"><i class="icon-pencil"></i> Modifier</a></li>
            <li class="divider"></li>
            <li><a href="#confirmBox<?php echo $m->id(); ?>" role="button" data-toggle="modal"><i class="icon-trash"></i> Supprimer</a></li>
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
    <a href="/?page=member&amp;id=<?php echo $m->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
  </div>
</div>
<?php endforeach; ?>

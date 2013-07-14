<form class="form-search pull-left">
  <input type="text" class="search-preinscriptions span4" placeholder="Accès rapide compte" autofocus />
</form>


<div class="clearfix">&nbsp;</div>

<table class="table table-striped espace-top">
  <thead>
    <tr class="small">
      <th><a href="./?page=preinscriptions&amp;sort=id-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'id-asc' ? 'desc' : 'asc'; ?>"><i class="icon-sort"></i></a> #</th>
      <th><a href="./?page=preinscriptions&amp;sort=login-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'login-asc' ? 'desc' : 'asc'; ?>"><i class="icon-sort"></i></a> Compte</th>
      <th>Préinscriptions</th>
      <th>Pré-adhérents</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($preinscriptions as $p): ?>
    <tr>
      <td><?php echo $p->id(); ?></td>
      <td><a href="./?page=preinscription&amp;id=<?php echo $p->id(); ?>"><?php echo $p->login(); ?></a></td>
      <td><span class="label"><?php echo $p->countPreinscriptions(); ?></span></td>
      <td><span class="label label-success"><?php echo $p->countAdherents(); ?></span></td>
      <td style="width: 80px;"><a class="btn btn-small" href="./?page=preinscription&amp;id=<?php echo $p->id(); ?>"><i class="icon-eye-open"></i></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="pagination pagination-centered">
  <ul>
    <?php //echo $display_pagination; ?>
  </ul>
</div>

<?php foreach ($preinscriptions as $p): ?>
<div id="confirmBox<?php echo $p->id(); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelPreinscription<?php echo $p->id(); ?>" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="ConfirmDelPreinscription<?php echo $p->id(); ?>"><?php echo $p->login(); ?></h3>
  </div>
  <div class="modal-body">
    <p class="text-error">Êtes-vous sûr de vouloir supprimer ce compte de préinscription ?</p>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
    <a href="./?page=preinscription&amp;id=<?php echo $p->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
  </div>
</div>
<?php endforeach; ?>

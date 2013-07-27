<?php

use lib\content\Display;

if ($required_view == 'account') {
?>

<div class="row">
  <div class="span8">
    <div class="page-header" style="overflow:hidden; padding-bottom:5px;">
      <h2 style="margin-bottom:0;"><?php echo $u->login(); ?>
      <div class="btn-group pull-right btn-small">
        <a href="#" class="btn btn-small" title="Supprimer ce compte"><i class="icon-trash"></i></a>
      </div>
      </h2>
    </div>
    <p style="margin-top:-20px;" class="muted"><i class="icon-calendar"></i> <span style="font-size:12px;">dernière connexion le <?php echo Display::FullTimestampDate($u->date()); ?></span></p>
  </div>
  <div class="span3 offset1" style="margin-top:20px;">
    <div class="well well-small">
      <strong>Compte :</strong> #<?php echo $u->id(); ?>
    </div>
  </div>
</div>

<div class="row espace-top">
  <?php echo $display_members; ?>
</div>

<?php
} else {
  // accounts list
?>

<form class="form-search pull-left">
  <input type="text" class="search-accounts span4" placeholder="Accès rapide compte" autofocus />
</form>
<form class="form-search pull-right">
  <input type="text" class="search-preinscriptions span4" placeholder="Accès rapide préinscription" />
</form>

<div class="clearfix">&nbsp;</div>

<table class="table table-striped table-go espace-top">
  <thead>
    <tr class="small">
      <th>#</th>
      <th><a href="./?page=preinscriptions&amp;sort=login-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'login-asc' ? 'desc' : 'asc'; ?>"><?php echo $sort['login']->icon(); ?></a> Compte</th>
      <th>Préinscriptions</th>
      <th>Pré-adhérents</th>
      <th><a href="./?page=preinscriptions&amp;sort=status-<?php echo isset($_GET['sort']) && $_GET['sort'] == 'status-asc' ? 'desc' : 'asc'; ?>"><?php echo $sort['status']->icon(); ?></a> Statut</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($preinscriptions as $p): ?>
    <tr>
      <td><?php echo $p->id(); ?></td>
      <td class="go"><a href="./?page=preinscriptions&amp;account=<?php echo $p->id(); ?>"><?php echo $p->login(); ?></a></td>
      <td><span class="label"><?php echo $p->countPreinscriptions(); ?></span></td>
      <td><span class="label label-info"><?php echo $p->countAdherents(); ?></span></td>
      <td>?</td>
      <td style="padding-left:0; padding-right:0;" class="center"><a class="btn btn-small" href="./?page=preinscriptions&amp;account=<?php echo $p->id(); ?>"><i class="icon-eye-open"></i></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="pagination pagination-centered">
  <ul>
    <?php echo $display_pagination; ?>
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


<?php
}
?>
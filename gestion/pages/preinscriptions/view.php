<?php

use lib\content\Display;
use lib\preinscriptions\Preinscription;

if ($required_view == 'account') {
?>

<div class="row">
  <div class="span8">
    <div class="page-header" style="overflow:hidden; padding-bottom:5px;">
      <h2 style="margin-bottom:0;"><?php echo $u->login(); ?>
      <div class="btn-group pull-right btn-small">
        <a href="#confirmBoxAccount<?php echo $u->id(); ?>" data-toggle="modal" role="button" class="btn btn-small <?php echo $u->status() == Preinscription::VALIDATED ? 'btn-danger' : NULL; ?>" title="Supprimer ce compte"><i class="icon-trash"></i></a>
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

<?php if ($u->status() == Preinscription::VALIDATED) : ?>
<div class="row espace-top center">
  <div class="span6 offset3">
    <div class="alert alert-error">
      Toutes les préinscriptions du compte ont été validées.
      <br />Merci de supprimer le compte !
    </div>
  </div>
</div>
<?php endif; ?>

<div class="row espace-top">
  <?php echo $display_members; ?>
</div>

<?php foreach($preinscriptions as $p) :?>
<div id="confirmBox<?php echo $p->id(); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelPreinscription<?php echo $p->id(); ?>" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="ConfirmDelPreinscription<?php echo $p->id(); ?>"><?php echo $p->name(); ?></h3>
  </div>
  <div class="modal-body">
    <p class="text-error">Êtes-vous sûr de vouloir supprimer cette préinscription ?</p>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
    <a href="./?page=edit-preinscription&amp;id=<?php echo $p->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
  </div>
</div>
<?php endforeach; ?>

<div id="confirmBoxAccount<?php echo $u->id(); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelAccount<?php echo $u->id(); ?>" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="ConfirmDelAccount<?php echo $u->id(); ?>"><?php echo $u->login(); ?></h3>
  </div>
  <div class="modal-body">
    <p class="text-error">Êtes-vous sûr de vouloir supprimer ce compte et toutes les préinscriptions associées ?</p>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
    <a href="./?page=preinscriptions&amp;account=<?php echo $u->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
  </div>
</div>

<?php
} else {
  // accounts list
?>

<form class="form-search pull-left">
  <input type="text" class="search-preinscriptions span4" placeholder="Accès rapide" autofocus />
</form>
<div class="pull-right">
  <a href="<?php echo $_SERVER['REQUEST_URI']; ?>&amp;check-status"  class="btn btn-small"><i class="icon-refresh"></i> Mettre à jour les statuts</a>
</div>
<style>
h5 {margin:5px 10px; border-bottom:1px solid #aaa; color:#aaa;}
</style>

<div class="clearfix">&nbsp;</div>
<style>
table img.gravatar {margin-right: 10px;}
</style>

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
      <td class="go"><img src="<?php echo $p->gravatar(20); ?>" alt="\o/" class="gravatar" /><a href="./?page=preinscriptions&amp;account=<?php echo $p->id(); ?>"><?php echo $p->login(); ?></a></td>
      <td><span class="label"><?php echo $p->countPreinscriptions(); ?></span></td>
      <td><span class="label label-info"><?php echo $p->countAdherents(); ?></span></td>
      <td class="tip"><?php echo Preinscription::StatusTooltipAccount($p->status()); ?></td>
      <td style="padding-left:0; padding-right:0;" class="center">
        <a class="btn btn-small" href="./?page=preinscriptions&amp;account=<?php echo $p->id(); ?>"><i class="icon-eye-open"></i></a>
        <a class="btn btn-small <?php echo $p->status() == Preinscription::VALIDATED ? 'btn-danger' : NULL; ?>" href="#confirmBox<?php echo $p->id(); ?>" role="button" data-toggle="modal"><i class="icon-trash"></i>
        </td>
    </tr>
    <?php
    endforeach;
    $_SCRIPT[] = '<script>$(function(){ $(\'table td.tip span\').tooltip(); });</script>';
    ?>
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
    <a href="./?page=preinscriptions&amp;account=<?php echo $p->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
  </div>
</div>
<?php endforeach; ?>


<?php
}
?>
<?php
use lib\content\Display;
use lib\preinscriptions\Preinscription;

$countResponsabilities = $m->countResponsabilities();
?>

<div class="espace-bottom" style="overflow:hidden;">
  <p class="pull-left">Vous trouverez ici toutes les informations concernant la présincription de <?php echo $m->first_name(); ?>.</p>
  <div class="btn-group pull-right">
    <a <?php echo $m->status() == Preinscription::AWAITING ? 'href="'. _PREINSCRIPTION_ .'/edit-preinscription/'. $m->id() .'"' : NULL ; ?> class="btn btn-small<?php echo $m->status() != Preinscription::AWAITING ? ' disabled' : NULL ;?>"><i class="icon-pencil"></i> Modifier</a>
    <a href="#confirmBox<?php echo $m->id(); ?>" class="btn btn-small" role="button" data-toggle="modal"><i class="icon-trash"></i> Supprimer</a>
  </div>
</div>

<?php if ($m->id_member() != NULL) : ?>
  <div class="row">
    <div class="span8 offset2">
      <div class="alert alert-success center">
        La préinscription du membre a été validée !
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
<?php endif; ?>

<div class="row espace-top">
  <div class="span3">
    <div class="well well-small">
      <p><?php echo Display::HtmlGender($m->gender()), ' ', $m->name(); ?>
      <br /><?php echo Display::Date($m->date_birthday()), ' (', $m->age(), ' ans)'; ?></p>
      <?php echo (!$m->minor() ? 'Adulte' : 'Jeune'); ?> &middot; <?php echo ($m->bezannais() ? 'Bezannais' : 'Extérieur'); ?>
    </div>

    <div class="alert <?php echo ($m->adherent() ? 'alert-info' : 'alert-well'); ?>">
      <?php echo ($m->adherent() ? 'Pré-adhérent' : 'Non-adhérent'); ?>
    </div>
  </div>

  <div class="span8 offset1 <?php echo $m->minor() && !$m->address_different() ? 'preinscription-infos' : NULL; ?>">
    <div class="row-fluid">
      <?php if (!$m->minor() || $m->address_different()) : ?>
        <div class="span6">
          <h4>Adresse</h4>
          <address>
            <?php echo $m->address(); ?>
          </address>
        </div>
      <?php endif; ?>

      <div class="span6">
        <h4>Contact</h4>
          <i class="icon-phone"></i> <?php echo Display::Phone($m->phone()); ?>
          <?php echo ($m->mobile() != NULL ? '<br /><i class="icon-phone"></i> '. Display::Phone($m->mobile()) : NULL); ?>
          <br /><i class="icon-envelope-alt"></i> <?php echo Display::Email($m->email()); ?>
      </div>

      <?php echo $m->minor() && $m->address_different() ? '</div><div class="row-fluid">' : NULL; ?>

      <?php if ($m->minor()): ?>
        <div class="span6">
          <h4>Reponsable</h4>
          <p><?php echo Display::HtmlGender($r->gender()), ' ', $r->name(); ?> <a href="<?php echo _PREINSCRIPTION_; ?>/preinscription/<?php echo $r->id(); ?>" style="text-decoration:none; padding-left:2px;"><i class="icon-share-alt"></i></a></p>
        </div>
      <?php
      endif;
      if ($countResponsabilities > 0) {
        echo '</div><div class="row-fluid"><div class="span6">', '<h4>Responsabilité</h4>';
        $minors = $m->Responsabilities();
        echo '<ul>';
        foreach ($minors as $minor)
          echo '<li>', $minor->name(), ' <a href="'. _PREINSCRIPTION_ .'/preinscription/', $minor->id(), '" style="text-decoration:none; padding-left:2px;"><i class="icon-share-alt"></i></a></li>';
        echo '</ul>', '</div>';
      }
      ?>  
    </div>
  </div>
</div>

<hr />
<div class="row espace-top">
  <div class="span10 offset1">
    <?php if ($m->adherent()) : ?>
    <!-- activites -->
      <p class="pull-left espace-bottom"><?php echo $m->first_name(); ?> participe à <span class="label"><?php echo $count_activites; ?></span> activité<?php echo $plural_count_activities; ?>.</p>
      <?php if ($m->status() == Preinscription::AWAITING) : ?>
        <a class="btn btn-small pull-right" href="<?php echo _PREINSCRIPTION_; ?>/add-activity/<?php echo $m->id(); ?>"><i class="icon-plus"></i> Ajouter</a>
      <?php endif; ?>
    <div style="clear:both;">
      <?php echo $activities_participant; ?>
    </div>
    <?php else: ?>
      <p><i class="icon-info-sign pull-left icon-3x muted"></i> Vous avez choisi d’être non-adhérent.
      <br />Vous ne pouvez donc pas vous préinscrire à des activités.</p>
      <p>Pour devenir adhérent, il suffit de modifier votre préinscription : cliquez sur le bouton &laquo; Modifier &raquo; plus haut.</p>
    <?php endif; ?>
  </div>
</div>


<div id="confirmBox<?php echo $m->id(); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelmember<?php echo $m->id(); ?>" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3 id="ConfirmDelmember<?php echo $m->id(); ?>"><?php echo $m->name(); ?></h3>
</div>
<div class="modal-body">
<p class="text-error">Êtes-vous sûr de vouloir supprimer cette préinscription  ?</p>
</div>
<div class="modal-footer">
<a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
<a href="<?php echo _PREINSCRIPTION_; ?>/preinscription/<?php echo $m->id(); ?>/delete" class="btn btn-danger">Confirmer</a>
</div>
</div>
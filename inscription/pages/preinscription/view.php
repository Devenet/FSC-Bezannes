<?php
use lib\content\Display;
?>

<div class="espace-bottom" style="overflow:hidden;">
  <p class="pull-left">Vous trouverez ici toutes les informations concernant la présincription de <?php echo $m->first_name(); ?>.</p>
  <div class="btn-group pull-right">
    <a href="/edit-preinscription/<?php echo $m->id(); ?>" class="btn btn-small"><i class="icon-pencil"></i> Éditer</a>
    <a href="#confirmBox<?php echo $m->id(); ?>" class="btn btn-small" role="button" data-toggle="modal"><i class="icon-trash"></i> Supprimer</a>
  </div>
</div>

<div class="row">
  <div class="span3">
    <div class="well well-small">
      <?php echo Display::HtmlGender($m->gender()), ' ', $m->last_name(), ' ', $m->first_name(); ?>
      <br /><?php echo Display::Date($m->date_birthday()), ' (', $m->age(), ' ans)'; ?>
    </div>

    <div class="alert <?php echo ($m->adherent() ? 'alert-success' : ''); ?>">
      <strong><?php echo ($m->adherent() ? 'Pré-adhérent' : 'Non-adhérent'); ?></strong>
    </div>

    <div class="well well-small">
      <?php echo ($m->bezannais() ? 'Bezannais' : 'Extérieur'); ?>
      <br /><?php echo (!$m->minor() ? 'Adulte' : 'Jeune'); ?>
    </div>
  </div>

  <div class="span8 offset1" style="margin-left:60px;">
    <div class="row-fluid">
      <?php if (!$m->minor() || $m->address_different()) : ?>
        <div class="span4">
          <h4>Coordonnées</h4>
          <address>
            <?php echo $m->address(); ?>
          </address>
        </div>
      <?php endif; ?>

      <div class="span4">
        <h4>Contact</h4>
          <i class="icon-phone"></i> <?php echo Display::Phone($m->phone()); ?>
          <?php echo ($m->mobile() != null ? '<br /><i class="icon-phone"></i> '. Display::Phone($m->mobile()) : null); ?>
          <br /><i class="icon-envelope-alt"></i> <?php echo Display::Email($m->email()); ?>
      </div>

      <?php if ($m->minor()): ?>
        <div class="span4">
          <h4>Reponsable</h4>
          <p><?php echo Display::HtmlGender($r->gender()), ' ', $r->name(); ?> <a href="/preinscription/<?php echo $r->id(); ?>" style="text-decoration:none; padding-left:2px;"><i class="icon-share-alt"></i></a></p>
        </div>
      <?php
      endif;
      if ($m->countResponsabilities() > 0) {
        echo '<div class="span4">', '<h4>Responsabilité</h4>';
        $minors = $m->Responsabilities();
        echo '<ul>';
        foreach ($minors as $minor)
          echo '<li>', $minor->name(), ' <a href="/preinscription/', $minor->id(), '" style="text-decoration:none; padding-left:2px;"><i class="icon-share-alt"></i></a></li>';
        echo '</ul>', '</div>';
      }
      ?>  
    </div>

    <hr />

    <div class="row-fluid">
      <?php if ($m->adherent()) : ?>
      <!-- activites -->
      <div class="tab-pane" id="tab-activities">
        <div style="overflow: hidden;">
          <p class="pull-left"><?php echo $m->first_name(); ?> participe à <span class="label"><?php echo $count_activites; ?></span> activité<?php echo $plural_count_activities; ?>.</p>
          <a class="btn btn-small pull-right" href="/add-activity/<?php echo $m->id(); ?>"><i class="icon-plus"></i> Ajouter</a>
        </div>
        <div style="clear:both; margin-top: 10px;">
          <?php echo $activities_participant; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div><!-- /row -->


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
<a href="/preinscription/<?php echo $m->id(); ?>/delete" class="btn btn-danger">Confirmer</a>
</div>
</div>
<?php
use lib\content\Display;
use lib\preinscriptions\Preinscription;
$countResponsabilities = $pre->countResponsabilities();
?>

<div class="row">
  <div class="span8">
    <div class="page-header" style="overflow:hidden; padding-bottom:5px;">
      <h2 style="margin-bottom:0;"><?php echo $pre->name(); ?> <small class="status-tooltip" style="vertical-align:super;"><?php echo Preinscription::StatusTooltip($pre->status()); ?></small>
      <div class="pull-right btn-small">
        <?php echo getButtonsMember(); ?>
      </div>
      </h2>
    </div>

    <div class="row-fluid" style="margin-top:-20px;">
      <div class="span5 muted">
        <?php echo Display::HtmlGender($pre->gender()), ' ', $pre->name(); ?>
      </div>
      <div class="span3">
        <?php echo Display::Date($pre->date_birthday()), ' (', $pre->age(), ' ans)'; ?>
      </div>
      <div class="span3 offset1 muted">
        <?php echo $pre->minor() ? 'Jeune' : 'Adulte'; ?> &middot; <?php echo $pre->bezannais() ? 'Bezannais' : 'Extérieur'; ?> 
      </div>
    </div>

    <div class="row-fluid espace-top">
      <?php if (!$pre->minor() || $pre->address_different()) : ?>
        <div class="<?php echo ($pre->minor() && $pre->address_different()) || $countResponsabilities > 0 ? 'span4' : 'span6'; ?>">
          <h4>Adresse</h4>
          <address>
            <?php echo $pre->address(); ?>
          </address>
        </div>
      <?php endif; ?>

      <div class="<?php echo ($pre->minor() && $pre->address_different()) || $countResponsabilities > 0 ? 'span4' : 'span6'; ?>">
        <h4>Contact</h4>
          <p><i class="icon-phone"></i> <?php echo Display::Phone($pre->phone()); ?>
          <?php echo ($pre->mobile() != NULL ? '<br /><i class="icon-phone"></i> '. Display::Phone($pre->mobile()) : NULL); ?>
          <br /><i class="icon-envelope-alt"></i> <?php echo Display::Email($pre->email()); ?></p>
      </div>

      <?php if ($pre->minor()): ?>
        <div class="<?php echo ($pre->minor() && $pre->address_different()) || $countResponsabilities > 0 ? 'span4' : 'span6'; ?>">
          <h4>Responsable</h4>
          <p><?php echo Display::HtmlGender($respo->gender()), ' ', $respo->name(); ?> [<a href="<?php echo _GESTION_; ?>/?page=preinscription&amp;id=<?php echo $respo->id(); ?>">#<?php echo $respo->id(); ?></a>]
          <br /><span class="muted"><?php echo $respo->address_zip_code(), ' ', $respo->address_town(); ?></span></p>
        </div>
      <?php
      endif;
      if ($countResponsabilities > 0) {
        echo '<div class="span4">', '<h4>Responsabilité</h4>';
        $minors = $pre->Responsabilities();
        echo '<ul>';
        foreach ($minors as $minor)
          echo '<li>', $minor->name(), ' [<a href="'. _GESTION_ .'/?page=preinscription&amp;id=', $minor->id(), '" >#', $minor->id(), '</a>]</li>';
        echo '</ul>', '</div>';
      }
      ?>  
    </div>
  </div>

  <div class="span3 offset1" style="margin-top:20px;">
    <div class="well well-small">
      <strong>Préinscription :</strong> #<?php echo $pre->id(); ?>
    </div>

    <?php echo getWellMember(); ?>
  </div>
</div>

<?php if ($pre->adherent()) : ?>
<div class="row espace-top">
  <div class="span8 espace-bottom">
    <hr />
  </div>
  <div class="span12">
    <h4>Activité<?php echo $plural_count_activities; ?> en préinscription</h4>
  </div>
  <div class="span12">
    <?php echo $display_participatitions; ?>
  </div>
</div>
<?php endif; ?>


<div id="confirmRemoveInscription<?php echo $pre->id(); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelInscription<?php echo $pre->id(); ?>" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3 id="ConfirmDelInscription<?php echo $pre->id(); ?>"><?php echo $pre->name(); ?></h3>
</div>
<div class="modal-body">
<p class="text-error">Êtes-vous sûr de vouloir supprimer cette préinscription ?</p>
</div>
<div class="modal-footer">
<a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
<a href="./?page=edit-preinscription&amp;id=<?php echo $pre->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
</div>
</div>
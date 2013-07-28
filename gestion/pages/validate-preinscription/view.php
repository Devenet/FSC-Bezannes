<div class="page-header">
  <h2 style="margin-bottom:0;">Validation de préinscription</h2>
</div>

<?php if(isset($same_member)) : ?>
<div class="row">
  <div class="span8 offset2">
    <div class="alert">
      <p>Des personnes portant le même nom ont été trouvées :</p>
      <?php echo $same_member; ?>
      Êtes-vous sûr de vouloir continuer ?
    </div>
  </div>
</div>
<?php endif; ?>

<?php
require _PATH_GESTION_.'/form/validate-preinscription.php';
?>
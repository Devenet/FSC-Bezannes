<?php
use lib\content\Display;
?>

<div class="row">
  <div class="span8">
    <div class="page-header" style="overflow:hidden; padding-bottom:5px;">
      <h2 style="margin-bottom:0;"><?php echo Display::HtmlGender($pre->gender()), ' ', $pre->name(); ?>
      <div class="btn-group pull-right btn-small">
        <a href="./?page=edit-preinscription&amp;id=<?php echo $pre->id(); ?>" class="btn btn-small" title="Modifier la préinscription"><i class="icon-pencil"></i></a>
      </div>
      </h2>
    </div>

    <p><i class="icon-gift"></i> <?php echo Display::Date($pre->date_birthday()), ' (', $pre->age(), ' ans)'; ?></p>

  </div>

  <div class="span3 offset1" style="margin-top:20px;">
    <div class="well well-small">
      <strong>Préinscription :</strong> #<?php echo $pre->id(); ?>
    </div>
  </div>
</div>
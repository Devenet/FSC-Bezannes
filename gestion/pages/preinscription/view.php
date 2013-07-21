<?php
use lib\content\Display;
?>

<div class="row">
  <div class="span8">
    <div class="page-header" style="overflow:hidden; padding-bottom:5px;">
      <h2 style="margin-bottom:0;"><?php echo $pre->name(); ?>
      <div class="btn-group pull-right btn-small">
        <a href="./?page=edit-member&amp;id=<?php echo $pre->id(); ?>" class="btn btn-small" title="Modifier le membre"><i class="icon-pencil"></i></a>
      </div>
      </h2>
    </div>
  </div>
</div>
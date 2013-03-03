<?php
  if ($form->name() == 'add-activity')
    require _PATH_GESTION_.'/form/active-activities.php';
  else
    require _PATH_GESTION_.'/form/adherents.php';
?>
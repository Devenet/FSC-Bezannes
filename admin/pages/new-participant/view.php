<?php
  if ($form->name() == 'add-activity')
    require 'admin/form/active-activities.php';
  else
    require 'admin/form/adherents.php';
?>
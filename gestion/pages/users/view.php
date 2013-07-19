<div class="page-header">
  <h2 style="margin-bottom:0;">Utilisateurs
    <span class="pull-right">
      <a href="<?php echo _GESTION_; ?>/?page=edit-users&amp;action=new" class="btn btn-small btn-primary"><i class="icon-plus icon-white"></i> Ajouter</a>
    </span>
  </h2>
</div>

<div class="clearfix">&nbsp;</div>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>Utilisateur</th>
      <th>Privilège</th>
      <th class="center">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php echo $display_users; ?>
  </tbody>
</table>


<?php
  echo $display_users_confirm;
?>
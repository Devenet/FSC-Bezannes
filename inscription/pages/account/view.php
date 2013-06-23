<div class="row">
  <div class="span8">
    <p><?php echo $display_count_members; ?></p>
  </div>

  <div class="span4">
    <div class="pull-right">
      <a href="./new-preinscription" class="btn btn-primary btn-small">Nouvelle préinscription</a>
    </div>
  </div>
</div>

<div class="clearfix espace-top"></div>


<h3><i class="icon-hand-right"></i> Mes préinscriptions</h3>
<?php echo $display_members; ?>


<!--
<a href="#change-password" role="button" data-toggle="modal">mot de passe</a>
<!-- Modal --
<div id="change-password" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalChangePassword" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="modalChangePassword">Changer mon mot de passe</h3>
  </div>
  <form method="post" action="/account" class="form form-horizontal" style="margin-bottom:0;">
    <div class="modal-body">
      <div class="control-group">
        <label class="control-label" for="password">Mot de passe actuel</label>
        <div class="controls">
          <input type="password" id="password" name="password" autofocus />
        </div>
      </div>
      <p class="alert alert-info"><strong>Note :</strong> votre nouveau mot de passe doit comporter au moins 7 caractères !</p>
      <div class="control-group">
        <label class="control-label" for="new-password">Nouveau mot de passe</label>
        <div class="controls">
          <input type="password" id="new-password" name="new-password" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="confirm-new-password">Confirmation</label>
        <div class="controls">
          <input type="password" id="confirm-new-password" name="confirm-new-password" />
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
      <input type="submit" class="btn btn-primary" value="Modifier" />
    </div>
  </form>
</div>
-->
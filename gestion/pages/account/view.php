<div class="row">
  <div class="span5">
    <h3>Mon compte</h3>
    <dl class="dl-horizontal">
      <dt>Nom</dt>
      <dd><?php echo $u->name() ?></dd>
      <dt>Identifiant</dt>
      <dd><?php echo $u->login() ?></dd>
      <dt>Mot de passe</dt>
      <dd><a href="#change-password" role="button" data-toggle="modal"">modifier</a></dd>
      <dt>Privilège</dt>
      <dd><?php echo $display_privilege; ?></dd>
      <dt>Dernière connexion</dt>
      <dd><?php echo $display_last_history; ?></dd>
    </dl>
  </div>
  
  <div class="span7">
    <h3>Utilisateurs</h3>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Utilisateur</th>
          <th>Privilège</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php echo $display_users; ?>
      </tbody>
    </table>
  </div>
</div>


<!-- Modal -->
<div id="change-password" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalChangePassword" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="modalChangePassword">Changer mon mot de passe</h3>
  </div>
  <form method="post" action="/?page=account" class="form form-horizontal" style="margin-bottom:0;">
  <div class="modal-body">
    <div class="control-group">
      <label class="control-label" for="password">Mot de passe actuel</label>
      <div class="controls">
        <input type="password" id="password" name="password" autofocus />
      </div>
    </div>
    <p class="alert alert-info"><strong>Note :</strong> votre nouveau mot de passe doit comporter au moins 8 caractères !</p>
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
  </form>
  </div>
</div>

<style>
  dl dt, dl dd {
    margin-top: 10px;
  }
</style>
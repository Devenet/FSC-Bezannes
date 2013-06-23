<div class="row">
  <div class="span7 espace-bottom">
    <h3>Mon compte</h3>

    <h4 class="espace-top">Récapitulatif</h4>
    <p><?php echo $display_count_members; ?></p>

    <h4 class="espace-top">Vos données</h4>
    <p>Les informations recueillies sont nécessaires pour votre adhésion.
      Elles font l’objet d’un traitement informatique et sont destinées au secrétariat de l’association. En application des articles 39 et suivants de la loi du 6 janvier 1978 modifiée, vous bénéficiez d’un droit d’accès et de rectification aux informations qui vous concernent.
      Si vous souhaitez exercer ce droit et obtenir communication des informations vous concernant, veuillez vous adresser au secrétariat du Foyer Social et Culturel de Bezannes.</p>
  </div>

  <div class="span4 offset1">
    <div class="well well-small">
      <h3 style="margin-top:0;">Sécurité</h3>
      <?php echo $security; ?>

      <p class="espace-top">Votre identifiant de connexion est :</p>
      <p class="center"><code><?php echo $u->login(); ?></code></p>

      <p class="espace-top" style="margin-bottom:0;"><i class="icon-caret-right"></i> <a href="#change-password" role="button" data-toggle="modal">Modifier mon mot de passe</a></p>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="change-password" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalChangePassword" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="modalChangePassword">Changer mon mot de passe</h3>
  </div>
  <form method="post" action="<?php echo _INSCRIPTION_; ?>/account" class="form form-horizontal" style="margin-bottom:0;">
    <div class="modal-body">
      <div class="control-group">
        <label class="control-label" for="password">Mot de passe actuel</label>
        <div class="controls">
          <input type="password" id="password" name="password" autofocus />
        </div>
      </div>
      <p class="alert alert-info"><strong>Note :</strong> votre mot de passe doit comporter au moins 7 caractères !</p>
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

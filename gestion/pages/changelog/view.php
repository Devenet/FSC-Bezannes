<div class="page-header">
  <h2 style="margin-bottom: 0;">Historique</h2>
</div>

<ul class="nav nav-tabs">
  <li><a href="?page=history">Dernières connexions</a></li>
  <li class="active"><a href="?page=changelog">Changelog</a></li>
</ul>

<div class="clearfix"></div>

<style>
.tabbable p+ul {margin-top:-10px;}
</style>

<div class="tabbable tabs-left">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab-gestion" data-toggle="tab">Gestion <br /><?php echo _VERSION_GESTION_; ?></a></li>
    <li><a href="#tab-preinscriptions" data-toggle="tab">Préinscriptions <br /><?php echo _VERSION_PREINSCRIPTION_; ?></a></li>
    <li><a href="#tab-fsc" data-toggle="tab">FSC <br /><?php echo _VERSION_FSC_; ?></a></li>
  </ul>
  <div class="tab-content espace-small-top" style="padding-left:20px;">
    <div class="tab-pane active" id="tab-gestion">
      <p><strong>Version actuelle : <?php echo _VERSION_GESTION_; ?></strong></p>
      
      <p>v0.1.0</p>
      <ul>
        <li>Augmentation taille image gravatar dans la page compte</li>
      </ul>

      <p>v0.0.9</p>
      <ul>
        <li>Mise en ligne</li>
      </ul>
    </div>
    <div class="tab-pane" id="tab-preinscriptions">
      <p><strong>Version actuelle : <?php echo _VERSION_PREINSCRIPTION_; ?></strong></p>

      <p>v0.1.1</p>
      <ul>
        <li>Harmonisation couleur des boutons “connexion” et “inscription”</li>
      </ul>

      <p>v0.1.0</p>
      <ul>
        <li>Logo FSC centré sur la page d’accueil</li>
        <li>Correction bogue d’affichage de la colonne d’informations dans l’affichage d’une activité (description trop longue faisait descendre les infos...)</li>
        <li>Pas de franglish : url des pages en anglais</li>
        <li>Ajout d’URL Rewriting pour les images pour les activités (passage de <code>id.jpg</code> à <code>id-name.jpg</code>)</li>
      </ul>

      <p>v0.0.9</p>
      <ul>
        <li>Mise en ligne</li>
      </ul>
    </div>
    <div class="tab-pane" id="tab-fsc">
      <p><strong>Version actuelle : <?php echo _VERSION_FSC_; ?></strong></p>
    </div>
  </div>
</div>


<div class="clearfix"></div>

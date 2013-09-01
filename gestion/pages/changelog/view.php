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
      <!--
       ____          _   _  
      / ___| ___ ___| |_(_) ___  _ __  
     | |  _ / _ / __| __| |/ _ \| '_ \ 
     | |_| |  __\__ | |_| | (_) | | | |
      \____|\___|___/\__|_|\___/|_| |_|
      -->

      <p>v0.1.1</p>
      <ul>
        <li>Changement du texte d’aide pour la description des avantages (<del>Remise adhésion famille</del> &rarr; Description de l’avantage) pour les adhérents</li>
        <li>Ajout de la taille des miniatures des activités (redimensionnée en 210px par 135px, que l’image soit trop petite (hauteur ou largeur) ou trop grande), ainsi que la possibilité de supprimer l’image</li>
        <li>Texte d’aide pour la pratique libre dans la création d’une activité inscrit en dur et non plus dans une info-bulle</li>
        <li>Correction orthographique dans message de récupération de mot de passe</li>
        <li>Ajout de nouvelles pages de configuration :
          <ul>
            <li>Modification des paramètres de l’application (année de la saison, courriel, &hellip;)</li>
            <li>Modification du prix des adhésions (adultes/jeunes, bezannais/extérieur)</li>
            <li>Déboguage : affichage des constantes et de l’état de la BDD (correspond à l‘ancienne page de configuration)</li>
          </ul>
        </li>
        <li>Possibilité de désactiver les préinscriptions (ne supprime pas les préinscriptions) : empêche la création de nouveau compte et préinscriptions, et les utilisateurs de se connecter à leur compte</li>
        <li>Modification du texte d’information affiché si les préinscriptions sont désactivées</li>
        <li>Ajout d’une confirmation supplémentaire lors de la désactivation d’une activité</li>
        <li>Dans la liste des participants d’une activité, ajout en petit taille du complement de l’horaire</li>
        <li>Ajout dans une activité de la liste des préinscriptions par horaires</li>
      </ul>
      
      <p>v0.1.0</p>
      <ul>
        <li>Augmentation taille image gravatar dans la page compte</li>
        <li>Correction lien vers activité dans les préinscriptions</li>
      </ul>

      <p>v0.0.9</p>
      <ul>
        <li>Mise en ligne</li>
      </ul>
    </div>
    <div class="tab-pane" id="tab-preinscriptions">
      <p><strong>Version actuelle : <?php echo _VERSION_PREINSCRIPTION_; ?></strong></p>
      <!--
      ____        __ _                     _       _   _                 
     |  _ \ _ __ /_/(_)_ __  ___  ___ _ __(_)_ __ | |_(_) ___  _ __  ___ 
     | |_) | '__/ _ | | '_ \/ __|/ __| '__| | '_ \| __| |/ _ \| '_ \/ __|
     |  __/| | |  __| | | | \__ | (__| |  | | |_) | |_| | (_) | | | \__ \
     |_|   |_|  \___|_|_| |_|___/\___|_|  |_| .__/ \__|_|\___/|_| |_|___/
                                            |_|                          
      -->

      <p>v0.1.3</p>
      <ul>
        <li>Sur la page de la liste des activités :
          <ul>
            <li>changement de la couleur du bandeau des titres des images</li>
            <li>ajout des tarifs de l’adhésion avant la liste</li>
          </ul>
        </li>
        <li>Correction orthographique dans message de récupération de mot de passe</li>
        <li>Prise en compte de la désactivation des préinscriptions (impossibilité de se créer un compte, d’ajouter ou modifier ses préinscriptions)</li>
      </ul>

      <p>v0.1.2</p>
      <ul>
        <li>Titre d’une activité sur tout la longueur de l’en-tête (avec l’ajout de l’option <code>$page->addOption('title-lg')</code>)</li>
        <li>Dans la liste des miniatures des activités, feuille de style conditionnnelle pour fond foncé sur IE inférieur ou égal à 8</li>
      </ul>

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
      <!--
      ____        _     _ _      
     |  _ \ _   _| |__ | (_) ___ 
     | |_) | | | | '_ \| | |/ __|
     |  __/| |_| | |_) | | | (__ 
     |_|    \__,_|_.__/|_|_|\___|
      -->


    </div>
  </div>
</div>


<div class="clearfix"></div>

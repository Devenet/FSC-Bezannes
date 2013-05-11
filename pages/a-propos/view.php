<div class="page-header">
  <h2><?php echo $page->name(); ?></h2>
</div>

<ul class="nav nav-pills nav-a-propos">
  <?php echo $pageMenu->display($page->url()); ?>
</ul>

<?php
switch ($rel) {

case 'doc':
?>

<div class="row">
  <div class="span8">
    <h3>Préinscriptions</h3>
    <p class="lead">Comme les années précédentes, vous pouvez dès à présent remplir les fiches à présenter pour l’inscription pour l’année à venir.</p>
  </div>
  <div class="span4">
    <p class="text-success espace-top">Nouveauté : plus besoin d’imprimer un document, tout se fait en ligne :) !</p>
    <p class="espace-top"><a class="btn btn-success" href="<?php echo _INSCRIPTION_; ?>">Se préinscrire</a></p>
  </div>
</div>

<hr />
<div class="row">
  <div class="span4">
    <h3>Réglement intérieur</h3>
    <p><a class="btn" href="<?php echo _DATA_; ?>/pdf/fsc-reglement-interieur.pdf" rel="external"><i class="icon-file"></i> Télécharger</a></p>
    <p class="espace-top">Le réglement intérieur est là pour rappeler les règles à respecter et les droits et devoirs que chaque adhérent ou membre possède et peut faire valoir.</p>
    <p>Vous le trouverez affiché dans le hall de l'Espace de Bezannes.</p>
  </div>
  <div class="span4">
    <h3>Statuts de l’association</h3>
    <p><a class="btn" href="<?php echo _DATA_; ?>/pdf/fsc-statuts.pdf" rel="external"><i class="icon-file"></i> Télécharger</a></p>
    <p class="espace-top">Les statuts définissent l’association, sa raison et ses objectifs généraux. Il présice les règles exactes du fonctionnement. À chaque modification validée par un vote, il est envoyé à la Préfecture.</p>
  </div>
  <div class="span4">
    <h3>Assemblée générale</h3>
    <p><a class="btn" href="<?php echo _DATA_; ?>/pdf/fsc-assemblee-generale-2011.pdf" rel="external"><i class="icon-file"></i> Télécharger</a></p>
    <p class="espace-top">Tous les ans en décembre, l’AG permet de faire un bilan de l’année écoulée et de voter les prochaines désicions et actions de la vie l’association.</p>
    <p style="margin-bottom:0;">Années précédentes :</p>
    <ul class="unstyled" style="margin-left:15px;">
      <!--<li><i class="icon-file"></i> <a href="<?php echo _DATA_; ?>/pdf/fsc-assemblee-generale-2011.pdf" rel="external">Compte-rendu de 2011</a></li>-->
      <li><i class="icon-file"></i> <a href="<?php echo _DATA_; ?>/pdf/fsc-assemblee-generale-2010.pdf" rel="external">Compte-rendu de 2010</a></li>
    </ul>
  </div>
</div>


<?php
  break;
  
case 'asso':
?>

<div class="row">
  <div class="span7">
    <h3>Être adhérent</h3>
    <p>L’adhésion au Foyer Social et Culturel implique le paiment d’une cotisation annuelle, ainsi que la connaissance et le respect du <a href="<?php echo _FSC_; ?>/a-propos/documents">Règlement intérieur</a>.</p>
    <p>Les activités sont accessibles aux seuls adhérents. La participation à toute activité autre que la Bibliothèque est conditionnée par le réglement d’une cotisation propre à cette activité.</p>
    <p>Les renseignements contenus dans la feuille individuelle d’inscription sont destinés à un usage strictement interne. Animateurs, responsables, secretaires et administrateurs ont consigne de ne pas les communiquer. En particulier si des mailings doivent être effectués les adresses êlectroniques seront en copie cachée. </p>
  </div>
  <div class="span5">
    <h3>Cotisations</h3>
    <table class="table table-striped">
      <thead>
        <th></th>
        <th>Adule</th>
        <th>Jeune</th>
      </thead>
      <tbody>
        <tr>
          <td>Bezannais</td>
          <td>16 €</td>
          <td>10 €</td>
        </tr>
        <tr>
          <td>Non-Bezannais</td>
          <td>20 €</td>
          <td>14 €</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="row espace-top">
  <div class="span4">
    <h3>L’assemblée générale</h3>
    <p>L’assemblée générale est un moment fort dans la vie du FSC. Outre la présentation des bilans et des orientations pour l’année à venir, il est procédé à l’élection des membres du Conseil.
    <p>Cette assemblée est, avec le forum d’ouverture de la saison, un moment privilégié d’échange et de rencontre entre tous les adhérents.</p>
  </div>
  <div class="span4">
    <h3>Le conseil d’administration</h3>
    <p>Le conseil d’administration coordonne l’ensemble des activités. Il se réunit plusieurs fois par an pour s’assurer du bon fonctionnement de l’association et prendre les décisions de gestion en matière administrative et comptable. Il fait le point du travail effectué par des sous-groupes ou commissions (technique, communication, activités ponctuelles, jeunes, ...).</p>
  </div>
  <div class="span4">
    <h3>Le bureau</h3>
    <p>Le bureau est constitué de membres du conseil d’administration, qui représentent l’association au niveau de la loi.</p>
    <p>Constitué au moins d’un président et de son vice-président, d’un trésorier et d'un secrétaire, il donne la dynamique du FSC en accord avec les adhérents et les désicions prises en CA.</p>
  </div>
</div>

<div class="row h3-imprima espace-top">
  <div class="span5">
    <h3>Les membres du bureau</h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Fonction</th>
          <th>Membre</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Président</td>
          <td>Jean-Christophe Mélet</td>
        </tr>
        <tr>
          <td>Vice-président</td>
          <td>Jean-Claude Leguet</td>
        </tr>
        <tr>
          <td>Vice-président</td>
          <td>Jackie Vialle</td>
        </tr>
        <tr>
          <td>Trésorière</td>
          <td>Ghyslaine Raullin</td>
        </tr>
        <tr>
          <td>Secrétaire</td>
          <td>Brigitte Boucault</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="span5 offset1">
    <h3>Les membres du CA</h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Mandat</th>
          <th>Membre</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>2011-2014</td>
          <td>Brigitte Boucault</td>
        </tr>
        <tr>
          <td>2011-2014</td>
          <td>Cyril Cliquenoit</td>
        </tr>
        <tr>
          <td>2011-2014</td>
          <td>Ginette Jory</td>
        </tr>
        <tr>
          <td>2011-2014</td>
          <td>Jacques Marcot</td>
        </tr>
        <tr>
          <td>2011-2014</td>
          <td>Isabelle Tropé</td>
        </tr>
        <tr>
          <td>2011-2012</td>
          <td>Élodie Lecrocq</td>
        </tr>
        <tr>
          <td>2010-2013</td>
          <td>Michel Braux</td>
        </tr>
        <tr>
          <td>2010-2013</td>
          <td>Philippe Labiausse</td>
        </tr>
        <tr>
          <td>2010-2013</td>
          <td>Jean-Claude Leguet</td>
        </tr>
        <tr>
          <td>2010-2013</td>
          <td>Jean-Christophe Mélet</td>
        </tr>
        <tr>
          <td>2010-2013</td>
          <td>André Ramel</td>
        </tr>
        <tr>
          <td>2010-2013</td>
          <td>Ghyslaine Raullin </td>
        </tr>
        <tr>
          <td>2010-2013</td>
          <td>Jackie Vialle</td>
        </tr>
        <tr>
          <td>2009-2012</td>
          <td>Christine Devenet</td>
        </tr>
        <tr>
          <td>2009-2012</td>
          <td>Philippe Lhonoré</td>
        </tr>
        <tr>
          <td>2009-2012</td>
          <td>Nicole Marioni</td>
        </tr>
        <tr>
          <td>2009-2012</td>
          <td>Luce Salaün</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php
  break;
default:
?>
    
<div class="row">
  <div class="span3 center espace-bottom">
    <img src="<?php echo _DATA_; ?>/a-propos/logo-fsc.png" class="img-polaroid"/>
  </div>
  <div class="span8">
    <p class="lead">Le Foyer Social et Culturel de Bezannes est une association loi 1901 qui a pour but le développement et l’épanouissement culturel de ses adhérents en favorisant la mise en oeuvre d’activités éducatives, récréatives et sportives.</p>
  </div>
</div>

<div class="row">
  <div class="span4">
    <h3>Une association</h3>
    <p>Le FSC est administré par un conseil d’administration. Les membres qui le composent sont des adhérents élus parmi ceux-ci, lors de l’assemblée générale qui se tient au mois de novembre.
    <br />Il nomme en son sein un président, un vice-président, un secrétaire et un trésorier.</p>
  </div>
  <div class="span4">
    <h3>Être adhérent</h3>
    <p>En devenant <a href="<?php echo _INSCRIPTION_; ?>">adhérent</a>, vous accédez à l’ensemble des <a href="<?php echo _FSC_; ?>/activites">activités</a> proposées mais vous pouvez aussi faire part de vos idées, suggestions et avis pour permettre au Foyer d’évoluer dans votre intérêt et celui de la collectivité.</p>
  </div>
  <div class="span4">
    <h3>We want you !</h3>
    <p>Ce n’est pas un club fermé. Animé par des bénévoles, l’équipe a toujours besoin d’accueillir de nouvelles forces vives. À beaucoup, c’est peu de travail chacun.
    <br />Aussi, nous serions contents de vous compter parmi tous ceux qui contribuent à la réussite du Foyer.</p>
  </div>
</div>
<div class="row">
  <div class="span8">
    <h3>Où se renseigner et s’inscrire ? </h3>
    <p>Lors du Forum de rentrée, qui se tient chaque année début septembre au sein de l’Espace de Bezannes au cours duquel vous pourrez rencontrer la plupart des animateurs et responsables d’activités.
      Vous pouvez naturellement aussi vous renseigner auprès de l’animateur sur les lieux mêmes de l’activité aux heures indiquées dans la rubrique <a href="<?php echo _FSC_; ?>/activites">Activités</a>.</p>
      <p>Le secrétariat pourra aussi répondre à vos questions. Pour connaître les horaires d’ouverture, consultez la rubrique <a href="<?php echo _FSC_; ?>/contact">Contact</a>. 
  </div>
  <div class="span4">
    <h3>Se préinscrire</h3>
    <p>Pour faciliter votre inscription, vous pouvez dès à présent vous <a href="<?php echo _INSCRIPTION_; ?>">préinscrire en ligne</a>.</p>
    <p>Cette préinscription en ligne nous permet, le jour du Forum, de pouvoir vous inscrire plus rapidement !</p>
  </div>
</div>

<?php
}
?>
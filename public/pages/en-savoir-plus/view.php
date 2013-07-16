<div class="page-header">
  <h2><?php echo $page->name(); ?></h2>
</div>

<ul class="nav nav-pills nav-a-propos">
  <?php echo $pageMenu->display($page->url()); ?>
</ul>

<?php
switch ($rel) {
 
case 'ca':
?>

<div class="row">
  <div class="span4">
    <p>Le FSC est administré par un Conseil d’administration (CA) composé d’adhérents élus lors de l’assemblée générale annuelle.</p>
    <p>Le Conseil d’administration coordonne l’ensemble des activités et contrôle leur bonne marche. Il se réunit plusieurs fois par an pour faire le point et prendre des décisions dans les domaines administratif et comptable et assurer le développement de l’association en définissant la politique générale du FSC dans le cadre des statuts.</p>
  </div>
  <div class="span8">
    <p class="center"><strong>Membres du CA &ndash; Exercice 2012-2013</strong></p>
    <div class="row-fluid">
      <div class="span6">
        <table class="table table-striped">
          <tr>
            <td>aaaa-aaaa</td>
            <td>Brigitte Boucault</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Cyril Cliquenoit</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Ginette Jory</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Jacques Marcot</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Isabelle Tropé</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Élodie Lecrocq</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Michel Braux</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Philippe Labiausse</td>
          </tr>
        </table>
      </div>
      <div class="span6">
        <table class="table table-striped">
          <tr>
            <td>aaaa-aaaa</td>
            <td>Jean-Claude Leguet</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Jean-Christophe Mélet</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>André Ramel</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Ghyslaine Raullin </td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Jackie Vialle</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Christine Devenet</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Philippe Lhonoré</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Nicole Marioni</td>
          </tr>
          <tr>
            <td>aaaa-aaaa</td>
            <td>Luce Salaün</td>
          </tr>
        </table>
  </div>
</div>

<?php
  break;

case 'bureau':
?>

<div class="row">
  <div class="span4">
    <p>Le CA du FSC élit chaque année son bureau comprenant&nbsp;:</p>
    <ul>
      <li>un président ;</li>
      <li>au moins un vice-président ;</li>
      <li>un secrétaire ;</li>
      <li>un trésorier.</li>
    </ul>
    <p>Le CA confie au bureau la mise en œuvre de la politique générale du FSC.</p>
  </div>
  <div class="span6 offset1">
    <p class="center"><strong>Membres du CA &ndash; Exercice 2012-2013</strong></p>
    <table class="table table-striped">
      <tr>
        <td>Président</td>
        <td>Jean-Christophe Mélet</td>
      </tr>
      <tr>
        <td>Vice-présidente &ndash; Secrétariat &amp; événements</td>
        <td>Brigitte Boucault</td>
      </tr>
      <tr>
        <td>Vice-président &ndash; Administration &amp; trésorier</td>
        <td>Jean-Claude Leguet</td>
      </tr>
      <tr>
        <td>Vice-président &ndash; Relations ext. &amp; développement</td>
        <td>Jackie Vialle</td>
      </tr>
      <tr>
        <td>Secrétaire</td>
        <td>Elodie Lecrocq</td>
      </tr>
      <tr>
        <td>Support comptabilité</td>
        <td>Ghyslaine Raullin</td>
      </tr>
    </table>
  </div>
</div>


<?php
  break;
case 'ag':
?>

<div class="row">
  <div class="span4">
    <p>Le CA convoque &mdash; au cours du quatrième trimestre de l’année civile &mdash; l’assemblée générale annuelle qui est un moment fort de la vie du FSC.</p>
    <p>Outre la présentation des bilans de la saison clôturée et des orientations de la saison à venir, il est procédé au renouvellement des membres du CA par tiers.</p>
  </div>
  <div class="span8">
    <p class="center">Téléchargement du rapport de l’AG 2011-2012</p>
  </div>
</div>

<?php
  break;
default:
?>
    
<div class="row">
  <div class="span4">
    <p>Le FSC est administré par un Conseil d’administration (CA) composé d’adhérents élus lors de l’assemblée générale annuelle.</p>
    <p>Le Conseil d’administration coordonne l’ensemble des activités et contrôle leur bonne marche. Il se réunit plusieurs fois par an pour faire le point et prendre des décisions dans les domaines administratif et comptable et assurer le développement de l’association en définissant la politique générale du FSC dans le cadre des statuts.</p>
  </div>
  <div class="span4">
    <p>Le CA du FSC élit chaque année son bureau comprenant&nbsp;:</p>
    <ul>
      <li>un président ;</li>
      <li>au moins un vice-président ;</li>
      <li>un secrétaire ;</li>
      <li>un trésorier.</li>
    </ul>
    <p>Le CA confie au bureau la mise en œuvre de la politique générale du FSC.</p>
  </div>
  <div class="span4">
    <p>Le CA convoque &mdash; au cours du quatrième trimestre de l’année civile &mdash; l’assemblée générale annuelle qui est un moment fort de la vie du FSC.</p>
    <p>Outre la présentation des bilans de la saison clôturée et des orientations de la saison à venir, il est procédé au renouvellement des membres du CA par tiers.</p>
  </div>
</div>

<?php
}
?>
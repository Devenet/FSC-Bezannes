<div class="page-header">
  <h2>Activités</h2>
</div>

<div class="row-fluid">
  <div class="span8">
    <p class="lead">Retrouvez toutes les activités éducatives, récréatives et sportives porposées par le Foyer Social et Culturel !</p>
  </div>
  <div class="span4">
    <form class="form-search" style="text-align: center;">
      <p>Trouver une activité</p>
      <input type="text" class="input-xlarge search-activities" placeholder="Bibliothèque"/>
    </form>
  </div>
</div>

<div>
  <h3>Toutes les activités</h3>
  <ul>
    <?php foreach ($activities as $act): ?>
    <li><a href="<?php echo _FSC_; ?>/activite/<?php echo $act->url(); ?>"><?php echo $act->name(); ?></a></li>
    <?php endforeach; ?>
  </ul>
</div>



<div style="margin-top:200px;">
  <p>&nsbp;</p>
</div>

<style>
.tt-dropdown-menu {
  margin-top: 2px;
  padding: 5px 0;
  text-align: left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.tt-suggestion {
  padding: 3px 20px;
  font-size: 16px;
  line-height: 22px;
}

.tt-suggestion.tt-is-under-cursor {
  color: #fff;
  background-color: #0081c2;
  background-image: -moz-linear-gradient(top, #0088cc, #0077b3);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0077b3));
  background-image: -webkit-linear-gradient(top, #0088cc, #0077b3);
  background-image: -o-linear-gradient(top, #0088cc, #0077b3);
  background-image: linear-gradient(to bottom, #0088cc, #0077b3);
  background-repeat: repeat-x;
}
.tt-suggestion.tt-is-under-cursor a {
  color: #fff;
  text-decoration: none;
}

.tt-suggestion p {
  margin: 0;
}
</style>
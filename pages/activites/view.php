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
      <input type="text" class="search-activities" placeholder="Bibliothèque"/>
    </form>
  </div>
</div>

<div class="all">
  <h3>Toutes les activités</h3>
  <ul class="inline">
    <?php foreach ($activities as $act): ?>
    <li>
      <a href="<?php echo _FSC_; ?>/activite/<?php echo $act->url(); ?>" title="<?php echo $act->name(); ?>">
        <img src="<?php echo $act->image(); ?>" alt="<?php echo $act->name(); ?>" class="img-polaroid" />
        <h4><?php echo $act->name(); ?></h4>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
</div>


<style>
.all {
  margin-top: 30px;
}
.all li {
  position: relative;
  line-height: 135px;
  margin-bottom: 20px;
}
.all img {
  -webkit-transition: all 0.6s ;
  -moz-transition: all 0.6s ;
  -ms-transition: all 0.6s ;
  -o-transition: all 0.6s ;
  transition: all 0.6s ;
  opacity: .8;
}
.all h4 {
  line-height: 1;
  font-size: 14px;
  font-weight: normal;
  color: #fff;
  position: absolute;
  right: 5px;
  bottom: -10px;
  left: 5px;
  padding: 8px;
  background: none repeat scroll 0% 0% rgba(0, 0, 0, .5);
  -webkit-transition: background 0.6s ;
  -moz-transition: background 0.6s ;
  -ms-transition: background 0.6s ;
  -o-transition: background 0.6s ;
  transition: background 0.6s ;
  }
.all a:hover h4 {
  background: none repeat scroll 0% 0% rgba(0, 0, 0, .9);
}
.all a:hover img {
  opacity: 1;
}
</style>
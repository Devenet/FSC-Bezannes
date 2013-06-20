<div class="container">
  <div class="row">
    <div class="span4">
      <h2><?php echo $lorem->getContent(2); ?></h2>
      <p><?php echo $lorem->getContent(30); ?></p>
      <p><a href="<?php echo _FSC_; ?>/#lorem" class="btn"><?php echo $lorem->getContent(2); ?></a></p>
    </div>
    <div class="span4">
      <h2><?php echo $lorem->getContent(2); ?></h2>
      <p><?php echo $lorem->getContent(30); ?></p>
      <p><a href="<?php echo _FSC_; ?>/#lorem" class="btn btn-primary"><?php echo $lorem->getContent(2); ?></a></p>
    </div>
    <div class="span4">
      <h2><?php echo $lorem->getContent(2); ?></h2>
      <p><?php echo $lorem->getContent(30); ?></p>
      <p><a href="<?php echo _FSC_; ?>/#lorem" class="btn btn-success"><?php echo $lorem->getContent(2); ?></a></p>
    </div>
  </div>
</div>

<div class="container">
  <hr style="margin:30px auto 20px;" />

  <div id="homeCarousel" class="carousel slide">
    <ol class="carousel-indicators">
      <?php
        for ($i=0; $i<5; $i++) {
          echo '<li data-target="#homeCarousel" data-slide-to="', $i, '"', ($i==0 ? 'class="active"' : ''), '></li>';
        }
        ?>
    </ol>
    <div class="carousel-inner">
      <?php 
        for ($i=0; $i<5; $i++) {
          echo '<div class="item'. ($i==0 ? ' active' : '') .'">
        <img src="//fakeimg.pl/1000x600?text=fake image ', $i+1, '" alt="Fake image ', $i, '">
          <div class="carousel-caption">
            <h4>', ucfirst($lorem->getContent(5, 'plain', false)), '</h4>
            <p>', ucfirst($lorem->getContent(18, 'plain', false)), '</p>
          </div>
      </div>';
        }
      ?>
    </div>
    <a class="carousel-control left" href="#homeCarousel" data-slide="prev"><i class="icon-chevron-left"></i></a>
    <a class="carousel-control right" href="#homeCarousel" data-slide="next"><i class="icon-chevron-right"></i></a>
  </div>
</div>

<div class="container">
  <hr style="margin:30px auto 20px;" />

  <div class="row">
    <div class="span3 center espace-bottom">
    <img src="//fakeimg.pl/150x100" class="img-polaroid"/>
  </div>
  <div class="span8">
    <p class="lead"><?php echo $lorem->getContent(27); ?></p>
  </div>
  </div>
</div>

<div class="container">
  <hr style="margin:30px auto 20px;" />

<div class="row">
  <?php
    for($i=0; $i<3; $i++) {
    echo '
    <div class="span4">
      <h3>', ucfirst($lorem->getContent(3, 'plain', false)), '</h3>
      <p>', ucfirst($lorem->getContent(60, 'plain', false)), '</p>
    </div>';
  }
  ?>
</div>

<hr />
<div class="row">
  <div class="span8">
    <h3><?php echo ucfirst($lorem->getContent(5)); ?></h3>
    <p><?php echo ucfirst($lorem->getContent(60, 'plain', false)); ?></p> 
    <p><?php echo ucfirst($lorem->getContent(30, 'plain', false)); ?>
      <br /><?php echo ucfirst($lorem->getContent(60, 'plain', false)); ?></p> 
  </div>
  <div class="span4">
    <h3><?php echo ucfirst($lorem->getContent(3)); ?></h3>
    <p><?php echo ucfirst($lorem->getContent(60, 'plain', false)); ?></p> 
  </div>
</div>

<hr />
<div class="row">
  <div class="span6">
    <h3><?php echo ucfirst($lorem->getContent(3)); ?></h3>
    <p><?php echo ucfirst($lorem->getContent(50, 'plain', false)); ?></p> 
  </div>
  <div class="span6">
    <h3><?php echo ucfirst($lorem->getContent(3)); ?></h3>
    <p><?php echo ucfirst($lorem->getContent(50, 'plain', false)); ?></p> 
  </div>
</div>

</div><!-- /container -->

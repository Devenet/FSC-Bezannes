// go home, you're drunk
$(function(){
    $('#go_home_you_are_drunk').click(function() {
      $('html,body').animate({scrollTop: 0}, 'slow');
      return false;
    });
});

// external links
$('a[rel=\"external\"]').click(function() {
  window.open($(this).attr('href'));
  return false;
});
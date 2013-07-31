$(function(){
// go home, you're drunk
$('#go_home_you_are_drunk').click(function() { $('html,body').animate({scrollTop: 0}, 'slow'); return false; });
// external links
$('a[rel=\"external\"]').click(function() { window.open($(this).attr('href')); return false; });
// table cell with link
$('table.table-go td.go').click(function() {
	var url = $(this).children('a').attr('href');
	if ($(this).children('a').attr('rel') == 'external') window.open(url);
	else document.location.href = url;
});
$('table.table-go td.go').css('cursor', 'pointer');
});
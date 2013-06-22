$(function() {
  var url = document.location.hash;
  if (url != "") $('#link-tab-'+url.substring(1)).click();
});
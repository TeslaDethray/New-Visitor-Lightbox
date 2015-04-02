jQuery(document).ready(function(){
  if(!readCookie(popupName) && !<?php echo js_is_user_logged_in(); ?>) {     //if the 'popup' cookie does not exist and the user is not logged in, create a cookie and show the lightbox.
    createCookie(popupName, true, daysToExpiry);
    jQuery('#lightbox-elements').fadeIn("fast");
  }
});
jQuery('#back-overlay, #close').click(function() {  //Click the back-overlay (anywhere outside the form) div to hide the page content
  exitLightbox();
});
jQuery(document).on('keydown', function(e) {
  if(e.keyCode == 27) exitLightbox();
});
jQuery('#lightbox-elements form').submit(function() {
  createCookie(popupName, true, daysToExpiry);
});
jQuery('#lightbox-elements .set-cookie').click(function() {
  createCookie(popupName, true, daysToExpiry);
});

function exitLightbox() {
  jQuery('#lightbox-elements').fadeOut("fast");   // other options include .slideUp("fast");
}

function createCookie(name, value, days) {
  var expires;

  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
  } else {
    expires = "";
  }
  document.cookie = name + '=' + value +';path=/'+ ';expires=' + date.toUTCString();
}

function readCookie(name) {
  var nameEQ = escape(name) + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
  }
  return false;
}

/*function eraseCookie(name) {
  createCookie(name, "", -1);
}*/

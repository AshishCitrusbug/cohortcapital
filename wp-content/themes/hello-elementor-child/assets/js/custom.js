jQuery(document).ready(function ($) {

  $(window).scroll(function() {
    if($(window).scrollTop() > 50){
      $('.header-main').addClass('header-sticky');
    } else {
      $('.header-main').removeClass('header-sticky');
    }
  });
  
});
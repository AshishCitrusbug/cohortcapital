jQuery(document).ready(function ($) {
  AOS.init()
  $(window).scroll(function() {
    if($(window).scrollTop() > 50){
      $('.header-main').addClass('header-sticky');
    } else {
      $('.header-main').removeClass('header-sticky');
    }
  });
  
});

// ============================= Loan inquiry page  ==================================

var $ = jQuery; 
jQuery(document).ready(function($) {

	/* Restrict Char and special Char */
    // $('input[name="phonetext-987"]').on('input', function() {
    //     this.value = this.value.replace(/[^0-9]/g, '');
    // });

  

    $('input[name="amount-text"]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
	/* Restrict e and - in number field */
    $('input[name="property-value"]').on('keydown', function(event) {
		if (event.key === 'e' || event.key === '-' || event.key === '+' || event.key === '.' || 
			event.key === 'E' || event.key === ' ' || !/^[0-9]$/.test(event.key) && event.key !== 'Backspace' && event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') {
			event.preventDefault();
		}
    });
    
	/* Restrict manually add DOB  */
	$('#dob-date').keydown(function(e){
	    e.preventDefault();
	});
    $('#dob-date').removeAttr('readonly');

});

// ============================= fade in Social icon  ==================================

jQuery(document).ready(function ($) {
  $(".elementor-social-icons-wrapper span.elementor-grid-item").each(function(index) {
    $(this).addClass("fadein__other").css("animation-delay", 400 * (index + 1) + "ms");
  });
});

// jQuery(document).ready(function ($) {
//   $(".elementor-social-icons-wrapper span.elementor-grid-item").each(function(index) {
//     $(this).addClass("fadein__other").attr("data-aos-delay", 200 * (index + 1)).attr("data-aos","fade-up").attr("data-aos-duration",1000);
//   });
// });


jQuery(document).ready(function ($) {
  $(".elementor-loop-container .transaction__img").each(function(index) {
    $(this).addClass("fadein__other").css("animation-delay", 400 * (index + 3) + "ms");
  });
});

// ============================================= Add Custom Validation error message ===============================================

jQuery(document).ready(function ($) {
  $('.wpcf7-submit').on('click', function (e) {
    setTimeout(function() {
      $('.wpcf7-form-control-wrap').each(function() {
        if ($(this).find('.wpcf7-not-valid-tip').length) {
            var placeholder = $(this).find('input').attr('placeholder');
            if (placeholder && placeholder.includes('Enter')) {
                placeholder = placeholder.replace('Enter ', '');
            }
            if ($(this).find('input').hasClass('wpcf7-text')) {
              if ($(this).find('input').val() === '') {  
                $(this).find('.wpcf7-not-valid-tip').text(placeholder + ' field is required.');
              }
            }
            if ($(this).find('input').hasClass('wpcf7-number')) {
              if ($(this).find('input').val() === '') {  
                $(this).find('.wpcf7-not-valid-tip').text('Property’s value field is required.');
              }
            }
            var textplaceholder = $(this).find('textarea').attr('placeholder');
            if (textplaceholder && textplaceholder.includes('Enter')) {
                textplaceholder = textplaceholder.replace('Enter ', '');
            }
            if($(this).find('input').hasClass('wpcf7-phonetext'))
            {
              if ($(this).find('input').val() === '') {  
                $(this).find('.wpcf7-not-valid-tip').text('phone number field is required.');
              }
            }
            if($(this).find('textarea').hasClass('wpcf7-textarea'))
            {
              $(this).find('.wpcf7-not-valid-tip').text(textplaceholder + ' field is required.');
            }
            if($(this).find('select').hasClass('wpcf7-select'))
            {
              $(this).find('.wpcf7-not-valid-tip').text('Please select the field.');
            }
            if($(this).find('input').hasClass('wpcf7-date'))
            {
              if ($(this).find('input').val() === '') {  
                $(this).find('.wpcf7-not-valid-tip').text('Please date the field.');
              }
            }
            $('.wpcf7-not-valid-tip').show();
        } 
      });
    }, 1000); 
  });
});

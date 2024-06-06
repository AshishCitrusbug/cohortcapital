jQuery(document).ready(function ($) {
  AOS.init({
    anchorPlacement: 'top-bottom',
  });
  $(window).scroll(function() {
    if($(window).scrollTop() > 50){
      $('.header-main').addClass('header-sticky');
    } else {
      $('.header-main').removeClass('header-sticky');
    }
  });
  
  var lastScrollTop = 0;
  $(window).scroll(function(event){
    var st = $(this).scrollTop();
    if (st > lastScrollTop){
        //âíèç
      $('.header-main').addClass('scrolling_down');
      $('.header-main').removeClass('scrolling_up');
    } else {
        // ââåðõ 
      $('.header-main').addClass('scrolling_up');
      $('.header-main').removeClass('scrolling_down');
    }
    lastScrollTop = st;
  });	


  /* ----- Hire Related Js Start ----- */

  class Testimonial {
    constructor(element) {
      this.$element = $(element);
      this.$slider = this.$element.find('.testimonial__main');
      this.init()
    }
    init() {
      this.$slider.owlCarousel({
        loop: true,
        autoplay: false,
        dots: true,
        margin: 23,
        nav: true,
        navText: [
          "<img src='" + document.location.origin + "/wp-content/uploads/2024/05/left-arrow.svg' alt='Previous'>",
          "<img src='" + document.location.origin + "/wp-content/uploads/2024/05/right-arrow.svg' alt='Next'>"
        ],
        
        responsive: {
          0: {
            items: 1,
          },
          768: {
            items: 2,
          },
          1200: {
            items: 3,
          },
        }
      });
    }
  }

  $('[data-testimonial]').each(
    (index, element) => new Testimonial(element)
  )

  /* ----- Hire Related Js End ----- */
  
});

// ============================= Loan inquiry page  ==================================

var $ = jQuery; 
jQuery(document).ready(function($) {

	/* Restrict Char and special Char */
    // $('input[name="phonetext-987"]').on('input', function() {
    //     this.value = this.value.replace(/[^0-9]/g, '');
    // });

      // Function to restrict characters in the phone number field
    $('input[name="phonetext-987"]').on('keypress', function(event) {
        var charCode = event.which || event.keyCode;
        // Allow digits (0-9) and hyphen (-)
        if (charCode >= 48 && charCode <= 57 || charCode == 45) {
            return true;
        }
        // Prevent any other character from being entered
        event.preventDefault();
    });

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


jQuery(document).ready(function($) {
  $('.elementor-search-form__submit').on('click', function(e){ e.preventDefault(); })
  let typingTimer;
  let currentRequest = null;
  const doneTypingInterval = 300;

  jQuery('#searchbox_art input').on('keyup', function() {
      
      clearTimeout(typingTimer);
      const searchQuery = jQuery(this).val().trim();

      if (currentRequest) {
          currentRequest.abort();
      }

      if (searchQuery.length === 0) {
          $("#ajaxcontainercust").load(location.href+" #ajaxcontainercust>*","");
        } else {
          typingTimer = setTimeout(function() {
              currentRequest = jQuery.ajax({
                  url: ajax_search_params.ajax_url,
                  type: 'POST',
                  data: {
                      action: 'ajax_search',
                      search_data: searchQuery
                  },
                  success: function(data) {
                      jQuery('#ajaxcontainercust .insights__main').html(data);
                  },
                  complete: function() {
                      currentRequest = null; // Reset the currentRequest when the request is complete

                  }
              });
          }, doneTypingInterval);
      }
  });
});


/* ====================== Home page transactions post add Counter ========================================================= */
jQuery(document).ready(function($) {
  // Function to check if element is in viewport
  function isElementInViewport(el) {
    var rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }

  // Function to handle scroll event
  function handleScroll() {
    $('.home-branch__main .transactions__main--cont-data--value').each(function () {
        var $this = $(this);
        if (isElementInViewport(this) && !$this.data('animated')) {
            var originalText = $this.text();
            var decimalIndex = originalText.indexOf('.');
            var size = decimalIndex >= 0 ? originalText.length - decimalIndex - 1 : 0;

            // Extract the numeric part of the text, including the sign
            var originalNumber = parseFloat(originalText.replace(/[^0-9.+-]/g, '')) || 0;

            // Check if originalText has any non-numeric characters at the start or end
            var prefix = originalText.match(/^[^0-9.+-]*/)[0];
            var suffix = originalText.match(/[^0-9.+-]*$/)[0];

            $this.prop('Counter', 0).animate({
                Counter: originalNumber
            }, {
                duration: 2000,
                step: function (now) {
                    var formattedNumber;
                    if (size > 0) {
                        formattedNumber = now.toFixed(size).replace(/\.?0+$/, ''); // Remove trailing zeros
                    } else {
                        formattedNumber = Math.round(now); // Round to nearest integer if no decimal part
                    }
                    // Reconstruct the original string with prefix and suffix
                    $this.text(prefix + formattedNumber + suffix);
                }
            });
            // Set data attribute to mark element as animated
            $this.data('animated', true);
        }
    });
  }

  // Attach scroll event listener
  $(window).on('scroll', handleScroll);

  // Initial check on page load
  $(document).ready(function () {
    handleScroll();
  });

});


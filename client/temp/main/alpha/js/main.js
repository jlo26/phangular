/*-----------------------------------------------------------------------------------------------
Project:  Mos7 - Responsive Bootstrap 3 App Landing Page Template
Version:  1.6
Last change:  21/09/2016
Design by:  TemplatesPRO.com.br
-------------------------------------------------------------------------------------------------

INDEX:
--- DOCUMENT.READY ---
01) PRELOADER
02) BOOTSTRAP - Internet Explorer 10 in Windows 8 and Windows Phone 8 Fix
03) BOOTSTRAP - Android stock browser Fix
04) BOOTSTRAP - Modal Clear
05) BOOTSTRAP - Tooltips
06) NAVIGATION - Browser History (PushState)
07) NAVIGATION - Navbar Fixed to Top
08) NAVIGATION - ScrollTo - Navigation
09) NAVIGATION - Hover Item Menu
10) NAVIGATION - Menu More
11) NAVIGATION - ScrollBar
12) SLIDESHOW - Adjustable Dimensions
13) SLIDESHOW - Carousel
14) SLIDESHOW - Countdown
15) FEATURES - Carousel
16) STATS and CALL TO ACTION - Background-size fix iOS
17) GALLERY - Carousel
18) TESTIMONIAL - Carousel
19) CLIENTS - Carousel
20) MORE - Collapse ScrollBar
21) BLOG - Carousel
22) TEAM - Carousel
23) ANIMATION and STATS - Trigger to Elements Animation and Circles Stats
24) NEWSLETTER - Form Mailchimp Subscription Ajax
25) SLIDESHOW - Form Subscription
26) SLIDESHOW - Form Subscription (Modal)
27) CONTACT - Form Contact Ajax

--- WINDOW.SCROLL ---
28) NAVIGATION - Go Top Scroll
29) ANIMATION - Parallax Effect
-----------------------------------------------------------------------------------------------*/


/* DOCUMENT.READY =============================================================================*/
$(document).ready(function () {
  'use strict';

  /*--------------------------------------------------------------------------------------------
   01) PRELOADER
   --------------------------------------------------------------------------------------------*/
  $('.status').fadeOut(); // will first fade out the loading animation
  $('.preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.


  /*--------------------------------------------------------------------------------------------
   02) BOOTSTRAP - Internet Explorer 10 in Windows 8 and Windows Phone 8 Fix
   --------------------------------------------------------------------------------------------*/
  if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement('style');

    msViewportStyle.appendChild(
      document.createTextNode(
        '@-ms-viewport{width:auto!important}'
      )
    );
    document.querySelector('head').appendChild(msViewportStyle);
  }
  

  /*--------------------------------------------------------------------------------------------
   03) BOOTSTRAP - Android stock browser Fix
   --------------------------------------------------------------------------------------------*/
  var nua = navigator.userAgent,
    isAndroid = (nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1 && nua.indexOf('Chrome') === -1);

  if (isAndroid) {
    $('select.form-control').removeClass('form-control').css('width', '100%');
  }
  

  /*--------------------------------------------------------------------------------------------
   04) BOOTSTRAP - Modal Clear
   --------------------------------------------------------------------------------------------*/
  $('.modal').on('hidden.bs.modal', function (e) {
    $(this).find('iframe').attr('src', $(this).find('iframe').attr('src'));
    $(this).removeData();
  });
  

  /*--------------------------------------------------------------------------------------------
   05) BOOTSTRAP - Tooltips
   --------------------------------------------------------------------------------------------*/
  $('[data-toggle="tooltip"]').tooltip();
  

  /*--------------------------------------------------------------------------------------------
   06) NAVIGATION - Browser History (PushState)
   --------------------------------------------------------------------------------------------*/
  $('html, body').animate({scrollTop: 0}, 1);
  
  $('nav a[href^="#"]').click(function () {
    history.pushState({}, '', $(this).attr("href"));
    return false;
  });
  
  setTimeout(function () {
    if(window.location.hash) {
      var currentUrl = window.location.hash,
        sectionTarget = currentUrl.replace('#', '');

      $('html,body').animate({
        scrollTop: $(currentUrl).offset().top
      }, 1000);
    }
  }, 1000);
  

  /*--------------------------------------------------------------------------------------------
   07) NAVIGATION - Navbar Fixed to Top
   --------------------------------------------------------------------------------------------*/
  $('.navbar').affix({
    offset: {
      top: $(window).height() - $('.navbar').height() - 2
    }
  });
  

  /*--------------------------------------------------------------------------------------------
   08) NAVIGATION - ScrollTo - Navigation
   --------------------------------------------------------------------------------------------*/
  $('nav a[href^="#"], .go-top, .carousel-caption a[href^="#"]').on('click', function (event) {
    var target = $($(this).attr('href'));

    if (target.length) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: target.offset().top
      }, 1000);
    }
    $(this).blur();
  });
  
  
  /*--------------------------------------------------------------------------------------------
   09) NAVIGATION - Hover Item Menu
   --------------------------------------------------------------------------------------------*/
  var windowWidth = $(window).width();

  if (windowWidth < 768) {
    $('.navbar-nav>li.dropdown>a').on('click', function () {
      $('.navbar-nav>li.dropdown').toggleClass('open');
      if ($(this).attr('aria-expanded')==='false') {
        $('.navbar-nav>li.dropdown>a').attr('aria-expanded', 'true');
      } else {
        $('.navbar-nav>li.dropdown>a').attr('aria-expanded', 'false');
      }
    });
  }
  if (windowWidth > 767) {
    $('.navbar-nav>li.dropdown').on('mouseenter', function () {
      $(this).addClass('open');
      $('.navbar-nav>li.dropdown>a').attr('aria-expanded', 'true');
    });
    $('.navbar-nav>li.dropdown').on('mouseleave', function () {
      $(this).removeClass('open');
      $('.navbar-nav>li.dropdown>a').attr('aria-expanded', 'false');
    });
    $('.navbar-nav>li.dropdown>ul>li.dropdown').on('mouseenter', function () {
      $(this).addClass('open');
      $('.navbar-nav>li.dropdown>ul>li.dropdown>a').attr('aria-expanded', 'true');
    });
    $('.navbar-nav>li.dropdown>ul>li.dropdown').on('mouseleave', function () {
      $(this).removeClass('open');
      $('.navbar-nav>li.dropdown>ul>li.dropdown>a').attr('aria-expanded', 'false');
    });
  }
  

  /*--------------------------------------------------------------------------------------------
   10) NAVIGATION - Menu More
   --------------------------------------------------------------------------------------------*/
  function navigationResize() {
    $('.navbar-nav .li-more').before($('#overflow > li'));

    var $navItemMore = $('.navbar-nav > .li-more'),
      $navItems = $('.navbar-nav > li:not(.li-more)'),
      navItemMoreWidth = navItemWidth,
      navItemWidth = $navItemMore.width(),
      windowWidth = $(window).width() - 110,
      navItemMoreLeft, offset, navOverflowWidth;

    $navItems.each(function () {
      navItemWidth += $(this).width();
    });

    navItemWidth > windowWidth ? $navItemMore.show() : $navItemMore.hide();

    while (navItemWidth > windowWidth) {
      navItemWidth -= $navItems.last().width();
      $navItems.last().prependTo('#overflow');
      $navItems.splice(-1, 1);
    }

    navItemMoreLeft = $('.navbar-nav .li-more').offset().left;
    navOverflowWidth = $('#overflow').width();
    offset = navItemMoreLeft + navItemMoreWidth - navOverflowWidth;

    $('#overflow').css({
      'left': offset
    });
  }

  navigationResize();
  $(window).on('resize', navigationResize);
  

  /*--------------------------------------------------------------------------------------------
   11) NAVIGATION - ScrollBar
   --------------------------------------------------------------------------------------------*/
  $('html').niceScroll({
    cursorcolor: '#777',
    cursoropacitymax: 0.7,
    cursorwidth: '9',
    cursorborder: 'none',
    cursorborderradius: '10px',
    background: '#ccc',
    zindex: '9999999',
    touchbehavior: false
  });
  

  /*--------------------------------------------------------------------------------------------
   12) SLIDESHOW - Adjustable Dimensions
   --------------------------------------------------------------------------------------------*/
  function slideshowFit() {
    var slideshowWidth = $(window).width(),
      slideshowHeight = $(window).height() - 50;

    $('.slideshow .item').css('min-height', slideshowHeight);

    if (slideshowWidth > slideshowHeight) { // Landascape
      $('.slideshow .bg-item').removeAttr('style');
      $('.slideshow .bg-item').css('min-width', slideshowWidth);
    } else {                                  // Portrait
      $('.slideshow .bg-item').removeAttr('style');
      $('.slideshow .bg-item').css('max-height', slideshowHeight);
      $('.slideshow .bg-item').css('max-width', 'initial');
    }
  }

  slideshowFit();
  $(window).on('resize', slideshowFit);
  

  /*--------------------------------------------------------------------------------------------
   13) SLIDESHOW - Carousel
   --------------------------------------------------------------------------------------------*/
  $('#slideshow-carousel-1').carousel({
    interval: 10000
  });
  

  /*--------------------------------------------------------------------------------------------
   14) SLIDESHOW - Countdown
   --------------------------------------------------------------------------------------------*/
  if ($('section.slideshow .slide-form').length) {
    $('.countdown').countdown('2016/12/31', function (event) {  // Enter your event date (aaaa/mm/dd)
      var $this = $(this).html(event.strftime(''
        + '<div class="c1 col-xs-3">'
        +   '<div class="count count-days center-block">'
        +     '<strong>%-D</strong><span>days</span>'
        +   '</div>'
        + '</div>'
        + '<div class="c2 col-xs-3">'
        +   '<div class="count count-hours center-block">'
        +     '<strong>%H</strong><span>hours</span>'
        +   '</div>'
        + '</div>'
        + '<div class="c3 col-xs-3">'
        +   '<div class="count count-minutes center-block">'
        +     '<strong>%M</strong><span>minutes</span>'
        +   '</div>'
        + '</div>'
        + '<div class="c4 col-xs-3">'
        +   '<div class="count count-seconds center-block">'
        +     '<strong>%S</strong><span>seconds</span>'
        +   '</div>'
        + '</div>'));
    });
  }
  

  /*--------------------------------------------------------------------------------------------
   15) FEATURES - Carousel
   --------------------------------------------------------------------------------------------*/
  if ($('section.features').length) {
    $('#features-carousel-1').slick({
      slidesToShow: 4,
      slidesToScroll: 4,
      speed: 700,
      dots: true,
      useTransform: true,
      cssEase: 'ease-in-out',
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            mobileFirst: true
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            mobileFirst: true
          }
        },
        {
          breakpoint: 540,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            mobileFirst: true
          }
        }
      ]
    });
  }
  

  /*--------------------------------------------------------------------------------------------
   16) STATS and CALL TO ACTION - Background-size fix iOS
   --------------------------------------------------------------------------------------------*/
  var userAgent = window.navigator.userAgent;

  if (/iP(hone|od|ad)/.test(userAgent)) {
    $('.stats .bg-section').css('display', 'block');
    $('.calltoaction .bg-section').css('display', 'block');
  }
  

  /*--------------------------------------------------------------------------------------------
   17) GALLERY - Carousel
   --------------------------------------------------------------------------------------------*/
  if ($('section.gallery').length) {
    $('#gallery-carousel-1').slick({
      slidesToShow: 4,
      slidesToScroll: 4,
      speed: 700,
      dots: true,
      useTransform: true,
      cssEase: 'ease-in-out',
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            mobileFirst: true
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            mobileFirst: true
          }
        },
        {
          breakpoint: 540,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            mobileFirst: true
          }
        }
      ]
    });
  }
  

  /*--------------------------------------------------------------------------------------------
   18) TESTIMONIAL - Carousel
   --------------------------------------------------------------------------------------------*/
  if ($('section.testimonials').length) {
    $('#testimonials-carousel-1').carousel({
      interval: 10000
    });

    function testimonialControl() {
      var $testimonial = $('.testimonials'),
          windowTop = $(window).scrollTop(),
          testimonialTop = $testimonial.offset().top,
          testimonialBottom = testimonialTop + $testimonial.height();

      if (testimonialBottom <= windowTop) {
        $('#testimonials-carousel-1').carousel('pause');
      } else {
        $('#testimonials-carousel-1').carousel('cycle');
      }
    }

    $(window).scroll(function () {
      testimonialControl();
    });
  }
  

  /*--------------------------------------------------------------------------------------------
   19) CLIENTS - Carousel
   --------------------------------------------------------------------------------------------*/
  if ($('section.clients').length) {
    $('#clients-carousel-1').slick({
      slidesToShow: 6,
      slidesToScroll: 6,
      speed: 700,
      arrows: false,
      dots: false,
      useTransform: true,
      cssEase: 'ease-in-out',
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
            mobileFirst: true
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            mobileFirst: true
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            mobileFirst: true
          }
        },
        {
          breakpoint: 375,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            mobileFirst: true
          }
        }
      ]
    });
  }
  

  /*--------------------------------------------------------------------------------------------
   20) MORE - Collapse ScrollBar
   --------------------------------------------------------------------------------------------*/
  setTimeout(function () {
    $('.more .panel-default>.panel-heading+.collapse.in>.panel-body').niceScroll({
      cursorcolor: '#777',
      cursoropacitymax: 0.7,
      cursorwidth: '9',
      cursorborder: 'none',
      cursorborderradius: '10px',
      background: '#ccc',
      zindex: '9999999',
      touchbehavior: false
    });
  }, 1000);
  
  $('#more-accordion-1').on('shown.bs.collapse', function () {
    $('.more .panel-default>.panel-heading+.collapse.in>.panel-body').niceScroll({
      cursorcolor: '#777',
      cursoropacitymax: 0.7,
      cursorwidth: '9',
      cursorborder: 'none',
      cursorborderradius: '10px',
      background: '#ccc',
      zindex: '9999999',
      touchbehavior: false
    });
  });
  
  $('#more-accordion-1').on('hide.bs.collapse', function () {
    $('.more .panel-body').getNiceScroll().remove();
  });
  

  /*--------------------------------------------------------------------------------------------
   21) BLOG - Carousel
   --------------------------------------------------------------------------------------------*/
  if ($('section.blog').length) {
    $('#blog-carousel-1').slick({
      slidesToShow: 3,
      slidesToScroll: 3,
      speed: 700,
      dots: true,
      useTransform: true,
      cssEase: 'ease-in-out',
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            mobileFirst: true
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            mobileFirst: true
          }
        },
        {
          breakpoint: 540,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            mobileFirst: true
          }
        }
      ]
    });
  }
  

  /*--------------------------------------------------------------------------------------------
   22) TEAM - Carousel
   --------------------------------------------------------------------------------------------*/
  if ($('section.team').length) {
    $('#team-carousel-1').slick({
      slidesToShow: 4,
      slidesToScroll: 4,
      speed: 700,
      dots: true,
      useTransform: true,
      cssEase: 'ease-in-out',
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            mobileFirst: true
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            mobileFirst: true
          }
        },
        {
          breakpoint: 540,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            mobileFirst: true
          }
        }
      ]
    });
  }
  

  /*--------------------------------------------------------------------------------------------
   23) ANIMATION and STATS - Trigger to Elements Animation and Circles Stats
   --------------------------------------------------------------------------------------------*/
  var $elems = $('.animateblock'),
      windowHeight = $(window).height(),
      fullHeight = $(document).height();

  function animateElems() {
    var windowTop = $(window).scrollTop(); // calculate distance from top of window

    // loop through each item to check when it animates
    $elems.each(function () {
      var $elm = $(this);

      if ($elm.hasClass('animated')) {
        return true;
      } // if already animated skip to the next item

      var topCoords = $elm.offset().top; // element's distance from top of page in pixels

      function getWidth() {
        return window.innerWidth / 14;  // for responsive circles
      }

      if (windowTop > (topCoords - (windowHeight * 0.7))) {
        // animate when top of the window is 3/4 above the element
        $elm.addClass('animated');

        /*** Circles Stats ***/
        if ($elm.hasClass('circle')) {
          // animate circles stats
          var circle1 = Circles.create({
            id: 'circle-1',
            radius: getWidth(),
            value: 25,  // Set the first percentage here
            maxValue: 100,
            width: 18,
            text: function (value) {
              return value + '%';
            },
            colors: ['#7a8691', '#d9534f'],
            duration: 1200,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText:    true
          });
          var circle2 = Circles.create({
            id: 'circle-2',
            radius: getWidth(),
            value: 50,  // Set the second percentage here
            maxValue: 100,
            width: 18,
            text: function (value) {
              return value + '%';
            },
            colors: ['#7a8691', '#d9534f'],
            duration: 1200,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText:    true
          });
          var circle3 = Circles.create({
            id: 'circle-3',
            radius: getWidth(),
            value: 75,  // Set the third percentage here
            maxValue: 100,
            width: 18,
            text: function (value) {
              return value + '%';
            },
            colors: ['#7a8691', '#d9534f'],
            duration: 1200,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText:    true
          });
          var circle4 = Circles.create({
            id: 'circle-4',
            radius: getWidth(),
            value: 100,  // Set the fourth percentage here
            maxValue: 100,
            width: 18,
            text: function (value) {
              return value + '%';
            },
            colors: ['#7a8691', '#d9534f'],
            duration: 1200,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText:    true
          });
          window.onresize = function (e) {
            circle1.updateRadius(getWidth());
            circle2.updateRadius(getWidth());
            circle3.updateRadius(getWidth());
            circle4.updateRadius(getWidth());
          };
        }

      }
    });
  } // end animateElems()

  $(window).scroll(function () {
    animateElems();
  });
  

  /*--------------------------------------------------------------------------------------------
   24) NEWSLETTER - Form Mailchimp Subscription Ajax
   --------------------------------------------------------------------------------------------*/
  if ($('section.calltoaction').length) {
    $('.subscription-mailchimp').ajaxChimp({
      callback: mailchimpCallback,
      //Replace this url with your own mailchimp post URL
      url: 'http://templatespro.us10.list-manage.com/subscribe/post?u=e1b67e42c0c37f1e5eb1c76c6&amp;id=17c3681cdf'
    });

    function mailchimpCallback(resp) {
      if (resp.result === 'success') {
        $('.alerts-newsletter').hide().html('<div class="alert alert-success alert-dismissible" role="alert"><button class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Success!&nbsp;&nbsp;</strong>' + resp.msg + '</div>').slideDown();
        $('.alerts-newsletter').delay(10000).slideUp();
      } else if (resp.result === 'error') {
        $('.alerts-newsletter').hide().html('<div class="alert alert-danger alert-dismissible" role="alert"><button class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error:&nbsp;&nbsp;</strong>' + resp.msg + '</div>').slideDown();
      }
    }
  }
  

  /*--------------------------------------------------------------------------------------------
   25) SLIDESHOW - Form Subscription
   --------------------------------------------------------------------------------------------*/
  $('.submit-form-trial').on('click', function () {
    var proceed = true;
    //simple validation at client's end
    //loop through each field and we simply change border color to red for invalid fields
    $('.trial-form input[required=true]').each(function () {
      $(this).css('border-color', '');
      if (!$.trim($(this).val())) { //if this field is empty
        $(this).css('border-color', '#d9534f'); //change border color to red
        proceed = false; //set do not proceed flag
      }
      //check invalid email
      var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if ($(this).attr('type') === 'email' && !email_reg.test($.trim($(this).val()))) {
        $(this).css('border-color', '#d9534f'); //change border color to red
        proceed = false; //set do not proceed flag
      }
    });

    if (proceed) { //everything looks good! proceed...
      //get input field values data to be sent to server
      var post_data = {
        'user_trial_name' : $('input[name=trial-name]').val(),
        'user_trial_email': $('input[name=trial-email]').val(),
        'user_trial_phone': $('input[name=trial-phone]').val()
      };

      //Ajax post data to server
      $.post('subscription_trial.php', post_data, function (response) {
        if (response.type === 'error') { //load json data from server and output message
          var output = '<div class="alert alert-danger alert-dismissible" role="alert"><button class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error:&nbsp;&nbsp;</strong>' + response.text + '</div>';
          $('.alerts-trial').hide().html(output).slideDown();
        } else {
          var output = '<div class="alert alert-success alert-dismissible" role="alert"><button class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Success!&nbsp;&nbsp;</strong>' + response.text + '</div>';
          //reset values in all input fields
          $('.trial-form input').val('');
          $('.alerts-trial').hide().html(output).slideDown();
          $('.alerts-trial').delay(10000).slideUp();
        }
      }, 'json');
    }
  });

  //reset previously set border colors and hide all message on .keyup()
  $('.trial-form input[required=true]').keyup(function () {
    $(this).css('border-color', '');
    $('.alerts-contact').slideUp();
  });
  

  /*--------------------------------------------------------------------------------------------
   26) SLIDESHOW - Form Subscription (Modal)
   --------------------------------------------------------------------------------------------*/
  $('.submit-modal-form-trial').on('click', function () {
    var proceed = true;
    //simple validation at client's end
    //loop through each field and we simply change border color to red for invalid fields
    $('.modal-trial-form input[required=true]').each(function () {
      $(this).css('border-color', '');
      if (!$.trim($(this).val())) { //if this field is empty
        $(this).css('border-color', '#d9534f'); //change border color to red
        proceed = false; //set do not proceed flag
      }
      //check invalid email
      var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if ($(this).attr('type') === 'email' && !email_reg.test($.trim($(this).val()))) {
        $(this).css('border-color', '#d9534f'); //change border color to red
        proceed = false; //set do not proceed flag
      }
    });

    if (proceed) { //everything looks good! proceed...
      //get input field values data to be sent to server
      var post_data = {
        'user_modal_trial_name' : $('input[name=modal-trial-name]').val(),
        'user_modal_trial_email': $('input[name=modal-trial-email]').val(),
        'user_modal_trial_phone': $('input[name=modal-trial-phone]').val()
      };

      //Ajax post data to server
      $.post('modal_subscription_trial.php', post_data, function (response) {
        if (response.type === 'error') { //load json data from server and output message
          var output = '<div class="alert alert-danger alert-dismissible" role="alert"><button class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error:&nbsp;&nbsp;</strong>' + response.text + '</div>';
          $('.alerts-trial-modal').hide().html(output).slideDown();
        } else {
          var output = '<div class="alert alert-success alert-dismissible" role="alert"><button class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Success!&nbsp;&nbsp;</strong>' + response.text + '</div>';
          //reset values in all input fields
          $('.modal-trial-form input').val('');
          $('.alerts-trial-modal').hide().html(output).slideDown();
          $('.alerts-trial-modal').delay(10000).slideUp();
        }
      }, 'json');
    }
  });

  //reset previously set border colors and hide all message on .keyup()
  $('.modal-trial-form input[required=true]').keyup(function () {
    $(this).css('border-color', '');
    $('.alerts-contact').slideUp();
  });
  

  /*--------------------------------------------------------------------------------------------
   27) CONTACT - Form Contact Ajax
   --------------------------------------------------------------------------------------------*/
  $('.submit-form-contact').on('click', function () {
    var proceed = true;
    //simple validation at client's end
    //loop through each field and we simply change border color to red for invalid fields
    $('.contact-form input[required=true], .contact-form textarea[required=true]').each(function () {
      $(this).css('border-color', '');
      if (!$.trim($(this).val())) { //if this field is empty
        $(this).css('border-color', '#d9534f'); //change border color to red
        proceed = false; //set do not proceed flag
      }
      //check invalid email
      var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if ($(this).attr('type') === 'email' && !email_reg.test($.trim($(this).val()))) {
        $(this).css('border-color', '#d9534f'); //change border color to red
        proceed = false; //set do not proceed flag
      }
    });

    if (proceed) { //everything looks good! proceed...
      //get input field values data to be sent to server
      var post_data = {
        'user_fname'  : $('input[name=fname]').val(),
        'user_lname'  : $('input[name=lname]').val(),
        'user_email'  : $('input[name=email]').val(),
        'user_phone'  : $('input[name=phone]').val(),
        'user_company': $('input[name=company]').val(),
        'user_website': $('input[name=website]').val(),
        'subject'     : $('input[name=subject]').val(),
        'msg'         : $('textarea[name=message]').val()
      };

      //Ajax post data to server
      $.post('contact.php', post_data, function (response) {
        if (response.type === 'error') { //load json data from server and output message
          var output = '<div class="alert alert-danger alert-dismissible" role="alert"><button class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error:&nbsp;&nbsp;</strong>' + response.text + '</div>';
          $('.alerts-contact').hide().html(output).slideDown();
        } else {
          var output = '<div class="alert alert-success alert-dismissible" role="alert"><button class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Success!&nbsp;&nbsp;</strong>' + response.text + '</div>';
          //reset values in all input fields
          $('.contact-form input, .contact-form textarea').val('');
          $('.alerts-contact').hide().html(output).slideDown();
          $('.alerts-contact').delay(10000).slideUp();
        }
      }, 'json');
    }
  });

  //reset previously set border colors and hide all message on .keyup()
  $('.contact-form input[required=true], .contact-form textarea[required=true]').keyup(function () {
    $(this).css('border-color', '');
    $('.alerts-contact').slideUp();
  });

});
/* END DOCUMENT.READY =========================================================================*/



/* WINDOW.SCROLL ==============================================================================*/
$(window).scroll(function () {
  'use strict';

  /*--------------------------------------------------------------------------------------------
   28) NAVIGATION - Go Top Scroll
   --------------------------------------------------------------------------------------------*/
  if ($(this).scrollTop() > 100) {
    $('.go-top').fadeIn();
  } else {
    $('.go-top').fadeOut();
  }
  

  /*--------------------------------------------------------------------------------------------
   29) ANIMATION - Parallax Effect
   --------------------------------------------------------------------------------------------*/
  $('.parallax').each(function () {
    var $obj = $(this),
        yPos = (($(window).scrollTop() / $obj.data('speed')) / 2),
        bgPos = yPos + 'px';
    $obj.css('top', bgPos);
  });

});
/* END WINDOW.SCROLL ==========================================================================*/

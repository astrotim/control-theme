/**
 * Control project module
 * ------------------------------------------------------------
 *
 */




var ctrl = (function($) {

  var log = false;

  /**
   * log viewport dimensions
   */

  this.viewportDimensions = function() {

    // browser dimensions
    if(log) console.log('width: ', $(window).width());
    if(log) console.log('height: ', $(window).height());

  };


  /**
   * Off-canvas Navigation
   */

  this.offCanvasNav = function(){

    var page      = $('html'),
        body      = $('body'),
        wrapper   = $('.off-canvas-wrapper'),
        navToggle = $('#navToggle'),
        overlay   = $('#overlay'),
        viewportHt= $(window).innerHeight();

    function offCanvasActiveLink() {
      $('#navMain ul').on('click', 'li', function(){
        $(this)
          .siblings()
            .removeClass('active')
            .end()
          .addClass('active');
      });
    }

    navToggle.on('click', function(e){

      e.preventDefault();

      page.toggleClass('nav-open');

      $('body').removeClass('loading');

      if ( page.hasClass('nav-open') ) {
        wrapper.css('height', viewportHt);
        offCanvasActiveLink();
      } else {
        wrapper.css('height', 'auto');
      }

    });

    overlay.on('click', function(){
      page.removeClass('nav-open');
    });

  };




  /**
   * Subscribe Modal
   */

  this.subscribeModal = function(){

    if(window.innerWidth < 600) return;

    var overlay = $('#modalOverlay'),
        modal = $('#modalWrapper'),
        closeButton = modal.find('#modalClose');

    setTimeout(function() {

        overlay.fadeIn(0, function() {
          overlay
            .removeAttr('style')
            .removeClass('modal-hidden');
        });

        modal
          .removeClass('modal-hidden')
          .addClass('slide-in');

    }, 2500);

    function closeModal() {

      modal.addClass('slide-out');

      setTimeout(function() {
        modal
          .removeClass('slide-in')
          .removeClass('slide-out')
          .addClass('modal-hidden');

        overlay.fadeOut(100, function() {
          overlay
            .removeAttr('style')
            .addClass('modal-hidden');
        });

      }, 300);

    }

    closeButton.on('click', function(e) {
      e.preventDefault();

      closeModal();
    });

    $(document).on('keydown', function (e) {
        if ( e.keyCode === 27 ) { // ESC
          closeModal();
        }
    });

    overlay.on('click', function(){
      closeModal();
    });


    // Close modal on subscribe
    $('.form-subscribe-modal #gform_1').on('submit', function(){

      closeModal();

    });

  };




  /**
   * Affix and Scrollspy
   *
   * @package Bootstrap
   *
   * use with smooth scroll between anchor links
   */
  this.AffixScrollspy = function(){

    var viewportWidth = $(window).width();
    var sideNav = $('#sideNav');
    var affixOffset;

    if( (viewportWidth > 767) ) {

      affixOffset = 20; // set in CSS

    } else {

      affixOffset = 20; // set in CSS
    }

    if (sideNav.length > 0) {

      var sideNavTopOffset = sideNav.offset().top - affixOffset;

      sideNav.affix({
        offset: {
          top: sideNavTopOffset
        }
      });

      $('body').scrollspy({
        target: '.side-nav',
        offset: 50
      });
    }

  };



  /**
   * Smooth Scroll
   *
   */
  this.smoothScrollCSS = function() {

    var target, scroll;

    $("a[href*=#]:not([href=#])").on("click", function(e) {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        target = $(this.hash);
        target = target.length ? target : $("[id=" + this.hash.slice(1) + "]");

        if (target.length) {
          if (typeof document.body.style.transitionProperty === 'string') {
            e.preventDefault();

            var avail = $(document).height() - $(window).height();

            scroll = target.offset().top;

            if (scroll > avail) {
              scroll = avail;
            }

            $("html").css({
                "margin-top" : ( $(window).scrollTop() - scroll ) + "px",
                "transition" : "1s ease-in-out"
            }).data("transitioning", true);
          } else {
            $("html, body").animate({
              scrollTop: scroll
            }, 1000);
            return;
          }
        }
      }
    });

    $("html").on("transitionend webkitTransitionEnd msTransitionEnd oTransitionEnd", function (e) {
      if (e.target == e.currentTarget && $(this).data("transitioning") === true) {
        $(this).removeAttr("style").data("transitioning", false);
        $("html, body").scrollTop(scroll);
        return;
      }
    });

  };





  /**
   * Social Media Scripts
   */
  this.socialScripts = function(doc, script, async){

    var socialButtons = $('#socialButtons, #fbHeader');

    var js,
        first_js = doc.getElementsByTagName(script)[0],
        frag = doc.createDocumentFragment(),
        add = function(url, id) {
            if (doc.getElementById(id)) {return;}
            js = doc.createElement(script);
            js.src = url;
            js.async = async;
            if(id) js.id = id;
            frag.appendChild(js);
        };

    // Google+ button
    // add('http://apis.google.com/js/plusone.js');
    // Facebook SDK //&appId=0000000000000000
    add('//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0', 'facebook-jssdk');
    // Twitter SDK
    add('//platform.twitter.com/widgets.js', 'twitter-wjs');
    // Pinterest
    add('//assets.pinterest.com/js/pinit.js', 'pinterest-js');

    first_js.parentNode.insertBefore(frag, first_js);

    // detect when FB buttons have loaded
    window.fbAsyncInit = function() {
      FB.Event.subscribe('xfbml.render', function(response) {
          socialButtons.addClass('fb-loaded');
      });
    };

  };










  /**
   * old IE message
   */

  this.closeOldBrowserMessage = function(){

    if($('html.ie7').length) {

      var browserMessage = $('.browsehappy'),
          closeBtn = browserMessage.find('.close');

      closeBtn.on('click', function(){
        browserMessage.hide();
        $('html').removeClass('browser-warning');
      });

    }

  };


  /**
   * Drop down navigation
   */
  this.dropdownNav = function() {

    var navParent = $('#navMain ul > .menu-item-has-children');

    if(!navParent.length) return;

    // console.log(navParent.length + 1, 'submenus exist');

    navParent.on({
      mouseenter: function () {
          $(this).find('ul.sub-menu').addClass('open');
      },

      mouseleave: function () {
          $(this).find('ul.sub-menu').removeClass('open');
      }
    });

  };




  /**
   * Google Map (single)
   */
  this.googleMap = function(){

    if(!$('#contact-page-map').length) return;

    var latlng = new google.maps.LatLng( -33.856885, 151.215292 );
    var options = {
        zoom: 17,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: false,
        zoomControl: true
    };

    var map = new google.maps.Map(
        document.getElementById("contact-page-map"),
        options
    );

    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
    });

  };




  /**
   * Flexslider
   */
  this.flexslider = function(){

    var slider = $('#slider');

    if(!slider.length) return;

    $(window).load(function(){

      slider.flexslider({
        selector: ".slides > .slide",
        slideshowSpeed: 6000,
        animationSpeed: 500,
        pauseOnHover: true,
        controlNav: false,
        start: function(){
          slider.removeClass('slider-loading');
        }
      });

    });

  };



  return this;

}(jQuery)); /* end of module */


/**
 * Invoke module methods
 * ----------------------------------------------------------
 */

// ctrl.viewportDimensions();
// ctrl.offCanvasNav();
// ctrl.subscribeModal();
// ctrl.socialScripts(document, 'script');
// ctrl.closeOldBrowserMessage();
// ctrl.dropdownNav();
// ctrl.googleMap();
// ctrl.AffixScrollspy();
// ctrl.smoothScrollCSS();
// ctrl.flexslider();
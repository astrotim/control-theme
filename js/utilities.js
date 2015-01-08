/**
 * Contents:
 * ------------------------------------------------------------
 *
 * Flexbox tests for Modernizr
 * Conditionizr tests
 * smart resize
 *
 */


/**
 * add new Flexbox tests to Modernizr
 * ------------------------------------------------------------
 */

Modernizr.addTest('flexbox', Modernizr.testAllProps('flexBasis', '1px', true));
Modernizr.addTest('flexboxtweener', Modernizr.testAllProps('flexAlign', 'end', true));


/**
 * add browser classes with Conditionizr detects
 * ------------------------------------------------------------
 */

conditionizr.add('chrome', !!window.chrome && /google/i.test(navigator.vendor));
conditionizr.add('ie11', /(?:\sTrident\/7\.0;.*\srv:11\.0)/i.test(navigator.userAgent));
conditionizr.add('ie10', !!(Function('/*@cc_on return (/^10/.test(@_jscript_version) && /MSIE 10\.0(?!.*IEMobile)/i.test(navigator.userAgent)); @*/')()));
conditionizr.add('ie9', !!(Function('/*@cc_on return (/^9/.test(@_jscript_version) && /MSIE 9\.0(?!.*IEMobile)/i.test(navigator.userAgent)); @*/')()));
conditionizr.add('ios', /iP(ad|hone|od)/i.test(navigator.userAgent));
conditionizr.add('safari', /Constructor/.test(window.HTMLElement));
conditionizr.add('retina', window.devicePixelRatio >= 1.5);
conditionizr.add('mac', /mac/i.test(navigator.platform));
conditionizr.add('windows', /win/i.test(navigator.platform));
conditionizr.add('firefox', 'InstallTrigger' in window);

conditionizr.config({
  tests: {
     'chrome':  ['class']
    ,'ie11':    ['class']
    ,'ie10':    ['class']
    ,'ie9':     ['class']
    ,'ios':     ['class']
    ,'safari':  ['class']
    ,'retina':  ['class']
    ,'mac':     ['class']
    ,'windows': ['class']
    ,'firefox': ['class']
  }
});



/**
 * jQuery smart resize debounce function
 * ------------------------------------------------------------
 */

(function($,sr){

  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null;
          }

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100);
      };
  };
  // smartresize
  jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');

<?php

// <head> FEATURES -------------------------------------------------------------------------------- //

  // css for back end
  // add_editor_style('css/editor-style.css');

  // JS
  function ctrl_enqueue_scripts() {
    if (!is_admin()) {

      wp_deregister_script('jquery');
      wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"), false);
      wp_enqueue_script('jquery'); // **WP default is no-conflict**
      // wp_enqueue_script('jquery-ui-core');

      wp_register_script('bootstrap',   JS_DIR . 'bootstrap.min.js', array('jquery'),'2.22',  true);
      // wp_enqueue_script('bootstrap');

      wp_enqueue_script('modernizr',    JS_DIR . 'modernizr.min.js',    null,   '2.6.2',  true);
      wp_enqueue_script('conditionizr', JS_DIR . 'conditionizr.min.js',   null,   '1.0.0',  true);
      wp_enqueue_script('project',      JS_DIR . 'project.js', array('jquery'),   '1',    true);

      wp_register_script('flexslider',  JS_DIR . 'jquery.flexslider-min.js', array('jquery'), null, true);
      // if (is_front_page()) {
      //  wp_enqueue_script('flexslider');
      // }

      wp_register_script('googlemaps', 'http://maps.google.com/maps/api/js?sensor=false', null, null, false);
      // if (is_page('contact')) {
      //  wp_enqueue_script('googlemaps');
      // }
    }
  }
  add_action('wp_enqueue_scripts', 'ctrl_enqueue_scripts');

  function ctrl_enqueue_styles() {

    // auto versioning of style.css by last modified timestamp
    $ver = filemtime( realpath( get_stylesheet_directory() . '/style.css' ) );

    $font_url = '//fonts.googleapis.com/css?family=Open+Sans:400,600,800';

    wp_enqueue_style( 'google-font', $font_url, null, null );
    wp_enqueue_style( 'style', get_stylesheet_uri(), null, $ver );
  }
  // run with priority 1 to load after Gravity Forms forms.css
  add_action('wp_enqueue_scripts', 'ctrl_enqueue_styles', 1);


  // typekit
  function ctrl_load_typekit($id) {
    $script = "
<script>
  TypekitConfig = {
    kitId: '" . $id . "',
    scriptTimeout: 3000
  };
  (function() {
    var h = document.getElementsByTagName('html')[0];
    h.className += ' wf-loading';
    var t = setTimeout(function() {
      h.className = h.className.replace(/(\s|^)wf-loading(\s|$)/g, '');
      h.className += ' wf-inactive';
    }, TypekitConfig.scriptTimeout);
    var tk = document.createElement('script');
    tk.src = '//use.typekit.com/' + TypekitConfig.kitId + '.js';
    tk.type = 'text/javascript';
    tk.async = 'true';
    tk.onload = tk.onreadystatechange = function() {
      var rs = this.readyState;
      if (rs && rs != 'complete' && rs != 'loaded') return;
      clearTimeout(t);
      try { Typekit.load(TypekitConfig); } catch (e) {}
    };
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(tk, s);
  })(); </script>
    ";
    echo $script;
  }
  add_action( 'typekit', 'ctrl_load_typekit', 10, 1 );
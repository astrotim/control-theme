<?php
/**
 * Scripts and styles
 *
 * @package Control
 */



  /**
   * JavaScript
   *
   */
  function ctrl_enqueue_scripts() {
    if (!is_admin()) {

      $dep = array('jquery');

      if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

        wp_enqueue_script('modernizr',    JS_DIR . 'modernizr.min.js',    null,   '2.8.1',  true);
        wp_enqueue_script('conditionizr', JS_DIR . 'conditionizr.min.js',   null,   '4.3.0',  true);
        // wp_enqueue_script('affix',        JS_DIR . 'affix.js', $dep,'3.1.1',  true);
        // wp_enqueue_script('forms',        JS_DIR . 'forms.js', $dep, null,  true);
        // wp_enqueue_script('instagram',    JS_DIR . 'jquery.instagram.min.js', $dep, null,  true);
        // wp_enqueue_script('flexslider',   JS_DIR . 'jquery.flexslider.js', $dep, '2.2.2', true);

        // auto versioning of project.js by last modified timestamp
        $jsver = filemtime( THEME_ABS . 'js/project.js' );
        wp_enqueue_script('project',      JS_DIR . 'project.js', $dep, $jsver, true);

      } else {
        wp_deregister_script('jquery');
        wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"), false);
        wp_enqueue_script('jquery');

        // auto versioning of project.min.js by last modified timestamp
        $jsver = filemtime( realpath( THEME_ABS . 'js/project.min.js' ) );
        wp_enqueue_script('minified',     JS_DIR . 'project.min.js', $dep, $jsver, true);
      }

    }
  }
  add_action('wp_enqueue_scripts', 'ctrl_enqueue_scripts');


  /**
   * Development CSS file definition
   *
   */
  function ctrl_dev_stylesheet( $stylesheet_uri, $stylesheet_dir_uri ) {

      if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
          $stylesheet = str_replace( trailingslashit( $stylesheet_dir_uri ), '', $stylesheet_uri );
          $stylesheet = str_replace( '.css', '.dev.css', $stylesheet );

          if ( file_exists( trailingslashit( STYLESHEETPATH ) . $stylesheet ) )
              $stylesheet_uri = trailingslashit( $stylesheet_dir_uri ) . $stylesheet;
      }

      return $stylesheet_uri;
  }
  add_filter( 'stylesheet_uri', 'ctrl_dev_stylesheet', 10, 2 );



  /**
   * CSS
   *
   */
  function ctrl_enqueue_styles() {

    wp_dequeue_style('gforms_css');

    $font_url = '//fonts.googleapis.com/css?family=Open+Sans:300,400,600';
    wp_enqueue_style( 'google-font', $font_url, null, null );

    if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
      $stylecss = 'style.dev.css';
    } else {
      $stylecss = 'style.css';
    }

    // auto versioning of style.css by last modified timestamp
    $cssver = filemtime( THEME_ABS . $stylecss );

    $cssuri = get_stylesheet_uri();

    wp_enqueue_style( 'style', $cssuri, null, $cssver );

  }
  // run with priority 1 to load after Gravity Forms forms.css
  add_action('wp_enqueue_scripts', 'ctrl_enqueue_styles', 1);
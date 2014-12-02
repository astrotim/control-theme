<?php
/**
 * Main functions.php file
 * includes smaller functions files organised by purpose,
 * constant definitions, ACF set up
 *
 * @package Control
 */



  /**
   * File and directory paths
   *
   */
  define( "THEME_DIR" , get_template_directory_uri() );
  define( "CSS_DIR" ,   get_template_directory_uri() . '/css/'  );
  define( "JS_DIR"  ,   get_template_directory_uri() . '/js/'   );
  define( "INCPATH" ,   'includes/'   );
  define( "PLUGINS" ,   'plugins/'  );
  define( "THEME_ABS" , get_theme_root() . '/' . get_option('template') . '/'   );
  define( "HOSTNAME"  ,   get_option('siteurl') );
  define( "FRAG_CACHE", false );


  /**
   * Include other functions partials
   *
   */
  if ( ! function_exists('ctrl_setup') ) :
  function ctrl_setup() {
    include(get_template_directory() . '/functions/fn-scripts-styles.php');
    include(get_template_directory() . '/functions/fn-head.php');
    include(get_template_directory() . '/functions/fn-redirects.php');
    include(get_template_directory() . '/functions/fn-template.php');
    include(get_template_directory() . '/functions/fn-images.php');
    include(get_template_directory() . '/functions/fn-pre-get-posts.php');
    include(get_template_directory() . '/functions/fn-fragment-caching.php');
    include(get_template_directory() . '/functions/fn-post.php');
    // include(get_template_directory() . '/functions/fn-gravity-forms.php');
    include(get_template_directory() . '/functions/fn-excerpts.php');
    include(get_template_directory() . '/functions/fn-navigation.php');
    include(get_template_directory() . '/functions/fn-search.php');
    include(get_template_directory() . '/functions/fn-pagination.php');
    include(get_template_directory() . '/functions/fn-admin.php');
    include(get_template_directory() . '/functions/fn-acf.php');
    include(get_template_directory() . '/functions/fn-whitelabel.php');
    include(get_template_directory() . '/functions/fn-remove-stuff.php');
  }
  endif;

  add_action( 'after_setup_theme', 'ctrl_setup' ); // runs before 'init' hook


  /**
   * Advanced Custom Fields set up
   *
   */
  if ( ! function_exists('ctrl_acf_setup') ) :
  function ctrl_acf_setup() {
    // define( 'ACF_LITE' , true );
    include_once( 'acf/acf-register-fields.php' );
  }
  endif;


  $test_acf_php = 0;
  if((!IS_DEV) || ($test_acf_php)) {
    add_action( 'after_setup_theme', 'ctrl_acf_setup' ); // runs before 'init' hook
  }


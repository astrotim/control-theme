<?php
/**
 * Template functions
 *
 * @package Control
 */



  /**
   * Get partial
   *
   */
  function ctrl_get_partial($filename, $dir = 'partials') {
    $filepath = "{$dir}/{$filename}.php";
    $abspath = WP_CONTENT_DIR . '/themes/' . get_option('template') . '/' . $filepath;
    $files = array();
    $files[] = $filepath;

    if(file_exists($abspath)) {
      locate_template($files, true, false);
    } else {
      echo '<div class="alert alert-warning">Error: could not locate partial file "' . $filename . ' at ' . $abspath . '".</div>';
    }
  }

  /**
   * The WooCommerce version (adapted)
   *
   */
  function ctrl_get_template_part( $slug, $name = '' ) {
    $template = '';

    // Look in yourtheme/slug-name.php and yourtheme/woocommerce/slug-name.php
    if ( $name ) {
      $template = locate_template( array( "{$slug}-{$name}.php", WP_CONTENT_DIR . '/themes/' . get_option('template') . '/' . "{$slug}-{$name}.php" ) );
    }

    // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/woocommerce/slug.php
    if ( ! $template ) {
      $template = locate_template( array( "{$slug}.php", WP_CONTENT_DIR . '/themes/' . get_option('template') . '/' . "{$slug}.php" ) );
    }

    if ( $template ) {
      load_template( $template, false );
    }
  }


  /**
   * Create slug from string
   *
   * ref: http://codex.wordpress.org/Function_Reference/sanitize_file_name
   *
   */
  function slugify($text) {

      // replace non letter or digits by -
      $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
      // trim
      $text = trim($text, '-');
      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      // lowercase
      $text = strtolower($text);
      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      if (empty($text)) {
          return 'n-a';
      }

      return $text;

  }



  /**
   * Widgets
   *
   */
  function sidebars_init() {

    register_sidebar( array(
      'name' => __( 'Twitter', '' ), 'id' => 'twitter',
      'before_widget' => '', 'after_widget' => '',
      'before_title' => '<h4>', 'after_title' => '</h4>',
    ) );
  }
  // add_action( 'widgets_init', 'sidebars_init' );




  /**
   * Body and post class
   *
   */
  function ctrl_page_name_body_class( $classes ){

      global $post;
      if( isset($post) ) {
        $classes[] = "page-{$post->post_name}";
      }
      return $classes;
  }
  add_filter( 'body_class', 'ctrl_page_name_body_class' );


  function ctrl_clearfix_post_class( $classes ){

      global $post;
        $classes[] = "clearfix";
      return $classes;
  }
  // add_filter( 'post_class', 'ctrl_clearfix_post_class' );


  function ctrl_mobile_class( $classes ){

    if ( function_exists( wpmd_is_notphone() ) ) {
      if(wpmd_is_notphone()) {
        $classes[] = "not-mobile";
      } else {
        $classes[] = "is-mobile";
      }
    }
    return $classes;
  }
  // add_filter( 'body_class', 'ctrl_mobile_class' );
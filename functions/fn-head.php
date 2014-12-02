<?php
/**
 * wp_head() functions
 *
 * @package Control
 */


  /**
   *   Set a cookie for first time visitors
   *   to suppress subscribe modal on next visit
   */
  function ctrl_set_cookie() {
    if (!isset($_COOKIE['popup_viewed']) ) {
      setcookie('popup_viewed', true);
    }
  }
  add_action('init', 'ctrl_set_cookie');



  /**
   * open graph
   *
   */
  function ctrl_cpt_og_title() {

    global $post;

    if( is_singular('cpt') ) {
      return $post->post_title;
    }

  }
  // add_filter('wpseo_opengraph_title', 'ctrl_cpt_og_title');


  function ctrl_cpt_og_type() {

    if( is_singular('cpt') ) {
      return 'cpt';
    }

  }
  // add_filter('wpseo_opengraph_type', 'ctrl_cpt_og_type');


  add_filter('wpseo_opengraph_image', '__return_false');

  function ctrl_cpt_og_image() {
    global $post;

    if( is_singular('cpt') ) {
      $post_id = $post->ID;
      $image_obj  = get_field('field_name');
      $image_src  = $image_obj['sizes']['full_width'];
      echo "<meta property=\"og:image\" content=\"" . $image_src . "\" />\n";
    }
  }
  // add_filter('wpseo_opengraph', 'ctrl_cpt_og_image');


  function ctrl_post_og_image() {
    global $post;

    if( is_singular('post') ) {

      $post_id = $post->ID;
      $image_arr = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
      $image_src = $image_arr[0];
      echo "<meta property=\"og:image\" content=\"" . $image_src . "\" />\n";
    }
  }
  // add_filter('wpseo_opengraph', 'ctrl_post_og_image');



<?php
/**
 * Images
 *
 * @package Control
 */



  /**
   * Post thumbnails
   *
   */
  // add_theme_support( 'post-thumbnails' );
  // set_post_thumbnail_size( 150, 100, true );
  // add_image_size('thumbnail-tiny', 80, 45, true);


  /**
   * System image sizes
   *
   */
  if ( function_exists( 'add_image_size' ) ) {
      // add_image_size( 'new_size_name', WWW, HHH, true );
  }

  function ctrl_extra_image_sizes($sizes) {
      $addsizes = array(
          "new_size_name" => __( "New Size Label"),
      );
      $newsizes = array_merge($sizes, $addsizes);
      return $newsizes;
  }
  // add_filter('image_size_names_choose', 'ctrl_extra_image_sizes');
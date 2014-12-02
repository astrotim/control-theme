<?php
/**
 * Admin area functions
 *
 * @package Control
 */


  /**
   * current post type
   *
   */
  function get_current_post_type() {
  global $post, $typenow, $current_screen;

    //we have a post so we can just get the post type from that
    if ( $post && $post->post_type )
      return $post->post_type;

    //check the global $typenow - set in admin.php
    elseif( $typenow )
      return $typenow;

    //check the global $current_screen object - set in screen.php
    elseif( $current_screen && $current_screen->post_type )
      return $current_screen->post_type;

    //lastly check the post_type querystring
    elseif( isset( $_REQUEST['post_type'] ) )
      return sanitize_key( $_REQUEST['post_type'] );

    //we do not know the post type!
    return null;
  }


  /**
   * tiny mce editor height
   *
   * @todo define CPT, set height
   */
  function ctrl_CPT_tinymce_height() {
    if (get_current_post_type() == 'CPT') {
  ?>
    <style>
      #content_ifr {
        height: 120px !important;
      }
    </style>
  <?php
    }
  }
  // add_action("admin_head", "ctrl_CPT_tinymce_height");



  /**
   * hide date dropdown for specific post type
   *
   * @todo need to define CPT in this function
   */
  function ctrl_CPT_hide_date_dropdown() {
    if (get_current_post_type() == 'CPT') {
  ?>
    <style>
      .tablenav select[name=m] {
        display: none;
      }
    </style>
  <?php
    }
  }
  // add_action("admin_head", "ctrl_CPT_hide_date_dropdown");



  /**
   * columns for post menu page
   *
   */
  function ctrl_post_edit_columns($columns) {

    $columns['image'] = "Image";
    $columns = array(
      "cb" => '<input type="checkbox" />',
      "image" => '',
      "title" => __('Title'),
      "categories" => __('Categories'),
      "date" => __('Date'),
    );

    return $columns;
  }
  // add_filter("manage_edit-post_columns", "ctrl_post_edit_columns");


  function ctrl_post_custom_columns($column, $post_id) {
    global $post;

    switch ($column) {
      case "image":
        if ( has_post_thumbnail() ) {
          $thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail-tiny' )[0];
          echo '<img src="' . $thumb_src . '" width="80" height="45">';
        }
        break;
    }
  }
  // add_action("manage_post_posts_custom_column", "ctrl_post_custom_columns", 10, 2);
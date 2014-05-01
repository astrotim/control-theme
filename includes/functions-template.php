<?php

// TEMPLATE FEATURES -------------------------------------------------------------------------------- //


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



  // remove 'Uncategorised' from category link list
  function ctrl_cat_link() {
      $exclude = array("Uncategorized");
      $separator = " / ";
      $new_the_category = '';
      foreach((get_the_category()) as $category) {
          if ($category->category_parent == 0) {
              if (!in_array($category->cat_name, $exclude)) {
                  $new_the_category .= '<a href="'.get_bloginfo(url).'/'.get_option('category_base').'/'.$category->slug.'">'.$category->name.'</a>'.$separator;
              }
          }
      }
      return substr($new_the_category, 0, strrpos($new_the_category, $separator));
  }


  // create a slug from post title
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

  // check out sanitize_file_name
  // http://codex.wordpress.org/Function_Reference/sanitize_file_name



// -- NAVIGATION -------------------------------------------------------------------------------- //



  // nav menus
  register_nav_menus( array(
    'primary' => __( 'Primary Navigation', '' ),
  ));



  // current class for single post or taxonomy page
  /*
    check for custom post type
    get taxonomy of current post and extract first term from array
    if the title of the nav item ($item->title) matches the required string or the taxonomy term
    add CSS classes

    used on GML Heritage
  */
  function parent_type_nav_class($classes, $item) {

    // var_dump($item);

    global $post, $wp_query;

      switch (get_post_type()) {
        case 'cpt':

          // single post template
          if (is_single()) :

            $terms = wp_get_post_terms($post->ID, 'cpt-taxonomy', array("fields" => "ids"));

            foreach ($terms as $term) {
              if ( ($item->object_id == $term) ) {
                array_push($classes, 'current-menu-item');
              }
            }

          // taxonomy template
          elseif (is_tax()) :

            $tax = $wp_query->get_queried_object();

            if ( ($item->object_id == $tax->term_id) ) {
              array_push($classes, 'current-menu-item');
            }

          endif;

      break;
      // repeat for other CPTs

    }

    return $classes;
  }
  // add_filter('nav_menu_css_class', 'parent_type_nav_class', 10, 2 );



  // sub menu items hook
  /*
      credit: http://christianvarga.com/2012/12/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/
  */

  // filter_hook function to react on sub_menu flag
  function my_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {
    if ( isset( $args->sub_menu ) ) {
      $root_id = 0;

      // find the current menu item
      foreach ( $sorted_menu_items as $menu_item ) {
        if ( $menu_item->current ) {
          // set the root id based on whether the current menu item has a parent or not
          $root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
          break;
        }
      }

      // find the top level parent
      if ( ! isset( $args->direct_parent ) ) {
        $prev_root_id = $root_id;
        while ( $prev_root_id != 0 ) {
          foreach ( $sorted_menu_items as $menu_item ) {
            if ( $menu_item->ID == $prev_root_id ) {
              $prev_root_id = $menu_item->menu_item_parent;
              // don't set the root_id to 0 if we've reached the top of the menu
              if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
              break;
            }
          }
        }
      }

      $menu_item_parents = array();
      foreach ( $sorted_menu_items as $key => $item ) {
        // init menu_item_parents
        if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;

        if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
          // part of sub-tree: keep!
          $menu_item_parents[] = $item->ID;
        } else {
          // not part of sub-tree: away with it!
          unset( $sorted_menu_items[$key] );
        }
      }

      return $sorted_menu_items;
    } else {
      return $sorted_menu_items;
    }
  }
  // add_filter( 'wp_nav_menu_objects', 'my_wp_nav_menu_objects_sub_menu', 10, 2 );




// -- WIDGETS -------------------------------------------------------------------------------- //


  function sidebars_init() {

    register_sidebar( array(
      'name' => __( 'Twitter', '' ), 'id' => 'twitter',
      'before_widget' => '', 'after_widget' => '',
      'before_title' => '<h4>', 'after_title' => '</h4>',
    ) );
  }

  add_action( 'widgets_init', 'sidebars_init' );


  // allow shortcodes in text widgets
  add_filter('widget_text', 'do_shortcode');




// -- IMAGES -------------------------------------------------------------------------------- //



  //     post thumbnails
  add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 160, 130, true );
    // add_image_size('thumbnail-single', 200, 150);


  // additional thumbnail size
  if ( function_exists( 'add_image_size' ) ) {
      // add_image_size( 'size1', 180, null );
      // add_image_size( 'size2', 200 );
      // add_image_size( 'size3', 300, 200, true );
  }

  function ctrl_extra_image_sizes($sizes) {
      $addsizes = array(
          // "size1" => __( "Size 1"),
          // "size2" => __( "Size 2"),
          // "size3" => __( "Size 3")
      );
      $newsizes = array_merge($sizes, $addsizes);
      return $newsizes;
  }
  // add_filter('image_size_names_choose', 'ctrl_extra_image_sizes');







// CLASSES -------------------------------------------------------------------------------- //


  // page title class
  function ctrl_title_class( $classes ){

      global $post;
      if( isset($post) ) {
        $classes[] = "page-{$post->post_name}";
      }
      return $classes;
  }
  add_filter( 'body_class', 'ctrl_title_class' );



  // clearfix post class
  function ctrl_clearfix_class( $classes ){

      global $post;
        $classes[] = "clearfix";
      return $classes;
  }
  // add_filter( 'post_class', 'ctrl_clearfix_class' );


  // mobile class
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




// -- PRE GET POSTS --------------------------------------------------------------------------- //


  function ctrl_get_post_types( $query ) {
      if (is_admin())
      return;

      // where query runs
      if ( is_front_page() && $query->is_main_query() )
          $query->set( 'post_type', array( 'post', 'page' ) );
      return $query;
  }
  // add_action( 'pre_get_posts', 'ctrl_get_post_types' );

  function ctrl_exclude_category_query( $query ) {
      if (is_admin())
      return;

      // where query runs
      if ( is_front_page() && $query->is_main_query() )
          $query->set( 'cat', '-1,-2' );
      return $query;
  }
  // add_action( 'pre_get_posts', 'ctrl_exclude_category_query' );

  function ctrl_posts_per_page( $query ) {
      if (is_admin())
      return;

      // where query runs
      if ( is_front_page() && $query->is_main_query() )
          $query->set( 'posts_per_page', '5' );
      return $query;
  }
  // add_action( 'pre_get_posts', 'ctrl_posts_per_page' );

  function ctrl_query_vars( $query ) {
      if (is_admin())
      return;

      // where query runs
      if ( is_front_page() && $query->is_main_query() )
          $query->query_vars['orderby'] = 'title';
          $query->query_vars['order'] = 'desc';
      return $query;
  }
  // add_action( 'pre_get_posts', 'ctrl_query_vars' );



// FRAGMENT CACHING -------------------------------------------------------------------------------- //

  function fragment_cache($key, $ttl, $function) {

    // if ( is_user_logged_in() ) {
    //  call_user_func($function);
    //  return;
    // }

    $key = apply_filters('fragment_cache_prefix','fragment_cache_') . $key;
    $output = get_transient($key);

     if ( false === $output ) {
      ob_start();
      call_user_func($function);
      $output = ob_get_clean();
      set_transient($key, $output, $ttl);
    }

    echo $output;
  }

  function fragment_cache_random_prefix() {

    return get_option('random_prefix');
  }
  add_action('fragment_cache_prefix', 'fragment_cache_random_prefix');

  function clear_fragment_cache() {

    $random = rand(0,999);
    update_option('random_prefix','rand' . $random . '_fragment_');
  }
  add_action('save_post','clear_fragment_cache');
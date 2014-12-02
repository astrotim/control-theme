<?php
/**
 * Navigation
 *
 * @package Control
 */



  /**
   * Register Nav Menus
   *
   */
  register_nav_menus( array(
    'primary' => __( 'Primary Navigation', '' ),
  ));



  /**
   * current class for single post or taxonomy page
   *
   * check for custom post type
   * get taxonomy of current post and extract first term from array
   * if the title of the nav item ($item->title) matches the required string or the taxonomy term
   * add CSS classes
   *
   * used on GML Heritage
   *
   * @todo define 'cpt', repeat case for each cpt
   */
  function ctrl_parent_type_nav_class($classes, $item) {

    // var_dump($item);

    global $post, $wp_query;

      switch (get_post_type()) {
        case 'cpt':

          // single post template
          if (is_single()) :

            $terms = wp_get_post_terms($post->ID, 'cpt_category', array("fields" => "ids"));

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
  add_filter('nav_menu_css_class', 'ctrl_parent_type_nav_class', 10, 2 );


  /**
   * remove parent classes
   *
   */
  function ctrl_remove_parent_classes($class) {
    // check for current page classes, return false if they exist.
    return ($class == 'current_page_item' || $class == 'current_page_parent' || $class == 'current_page_ancestor'  || $class == 'current-menu-item') ? FALSE : TRUE;
  }



  /**
   * Options page
   *
   * add the current page class to a specific menu item
   *
   * @todo replace ###
   */
  function ctrl_add_class_to_wp_nav_menu($classes) {
      switch (get_post_type()) {
        case 'cpt':
          // we're viewing a custom post type, so remove the 'current_page_xxx and current-menu-item' from all menu items.
          $classes = array_filter($classes, "ctrl_remove_parent_classes");

          if (in_array('menu-item-###', $classes)) {
             $classes[] = 'current_page_parent';
            }

          break;
      // repeat for other CPTs

      }

    return $classes;
  }
  add_filter('nav_menu_css_class', 'ctrl_add_class_to_wp_nav_menu');



  /**
   * sub menu items
   *
   * filter_hook function to react on sub_menu flag
   *
   * @link [http://christianvarga.com/2012/12/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/]
   */
  function ctrl_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {
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
  // add_filter( 'wp_nav_menu_objects', 'ctrl_wp_nav_menu_objects_sub_menu', 10, 2 );


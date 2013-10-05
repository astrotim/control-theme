<?php 

// TEMPLATE FEATURES -------------------------------------------------------------------------------- //


	// function astro_load_partial($filename) {
	// 	$file = get_template_directory() . '/partials/' . $filename . '.php';
	// 	if (file_exists($file)) {
	// 		include($file);
	// 	} else {
	// 		echo 'Error: partial file cannot be found.';
	// 	}
	// }

	// function astro_load_partial($filename, $dir = '/partials/') {
	// 	$file = get_template_directory() . $dir . $filename . '.php';
	// 	if (file_exists($file)) {
	// 		include($file);
	// 	} else {
	// 		echo 'Error: partial file cannot be found.';
	// 	}
	// }

	// function astro_locate_partial($filename) {
	// 	// $file = 'partials/' . $filename . '.php';
	// 	// locate_template( array($file), true, false );
	// 	$files = array();
	// 	$files[] = "partials/{$filename}.php";
	// 	locate_template($files, true, false);
	// }

	function astro_load_partial($filename, $dir = 'partials') {
		$files = array();
		$files[] = "{$dir}/{$filename}.php";
		locate_template($files, true, false);
	}


	// nav menus
	register_nav_menus( array( 
		'primary' => __( 'Primary Navigation', '' ),
	));


	// sub menu items hook
	add_filter( 'wp_nav_menu_objects', 'my_wp_nav_menu_objects_sub_menu', 10, 2 );

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
	/*
	** credit: http://christianvarga.com/2012/12/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/
	*/


	// use walker instead ***
	// add dropdown class for bootstrap
	function astro_add_dropdown_class($classes, $item) {
	    global $wpdb;
	    $has_children = $wpdb->get_var("
	            SELECT COUNT(meta_id)
	            FROM wp_postmeta
	            WHERE meta_key='_menu_item_menu_item_parent'
	            AND meta_value='".$item->ID."'
	        ");
	    // add the class dropdown to the current list
	    if ($has_children > 0) array_push($classes,'dropdown');
	    return $classes;
	}
	if(BOOTSTRAP) { 
		add_filter( 'nav_menu_css_class', 'astro_add_dropdown_class', 10, 2);
	}



	// sidebar widgets - template usage: dynamic_sidebar('Widget');
	function sidebars_init() {		
		register_sidebar( array(
			'name' => __( 'Widget', '' ), 'id' => 'widget',
			'before_widget' => '', 'after_widget' => '', 
			'before_title' => '<h3>', 'after_title' => '</h3>',
		) );
	}	
	add_action( 'widgets_init', 'sidebars_init' );

	// allow shortcodes in text widgets
	add_filter('widget_text', 'do_shortcode');



	//     post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 160, 130, true );


	// additional thumbnail size
	if ( function_exists( 'add_image_size' ) ) {
	    add_image_size( 'logo', 180, null );
	    add_image_size( 'medium-portrait', 200 );
	    add_image_size( 'slider', 636, 320, true );
	}
	 
	function astro_extra_image_sizes($sizes) {
        $addsizes = array(
            "logo" => __( "Logo"),
            "medium-portrait" => __( "Medium Portrait"),
            "slider" => __( "Slider Full Width")
        );
        $newsizes = array_merge($sizes, $addsizes);
        return $newsizes;
	}
	add_filter('image_size_names_choose', 'astro_extra_image_sizes');
	

	// remove 'Uncategorised' from category link list
	function astro_cat_link() {
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


// CLASSES -------------------------------------------------------------------------------- //


	// body class **** TODO add 404 condition for error 'trying to get property of non-object'
	function astro_title_class( $classes ){
		global $post;
		if (is_singular()) {
			array_push( $classes, "{$post->post_name}" );
		}
		return $classes;
	}
	
	add_filter( 'body_class', 'astro_title_class' );
	
	// post class
	function astro_group_class( $classes ){
		global $post;
		array_push( $classes, "group" );
		return $classes;
	}
	
	add_filter( 'post_class', 'astro_group_class' );

// -- PRE GET POSTS --------------------------------------------------------------------------- //


	function astro_get_post_types( $query ) {
		if (is_admin())
		return;         

		// where query runs
		if ( is_front_page() && $query->is_main_query() )
			$query->set( 'post_type', array( 'post', 'page' ) );    
		return $query;
	}
	// add_action( 'pre_get_posts', 'astro_get_post_types' );

	function astro_exclude_category_query( $query ) {
		if (is_admin())
		return;         

		// where query runs
		if ( is_front_page() && $query->is_main_query() )
			$query->set( 'cat', '-1,-2' );    
		return $query;
	}
	// add_action( 'pre_get_posts', 'astro_exclude_category_query' );	

	function astro_posts_per_page( $query ) {
		if (is_admin())
		return;         

		// where query runs
		if ( is_front_page() && $query->is_main_query() )
			$query->set( 'posts_per_page', '5' );
		return $query;
	}
	// add_action( 'pre_get_posts', 'astro_posts_per_page' );	

	function astro_query_vars( $query ) {
		if (is_admin())
		return;         

		// where query runs
		if ( is_front_page() && $query->is_main_query() )
			$query->query_vars['orderby'] = 'title';
			$query->query_vars['order'] = 'desc';
		return $query;
	}
	// add_action( 'pre_get_posts', 'astro_query_vars' );	



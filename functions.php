<?php 

// CONFIG -------------------------------------------------------------------------------- //

	require_once(get_template_directory() . '/includes/config.php');
	// define( "CSSPATH"	, 	get_bloginfo('template_directory') . '/css/'	);
	// define( "JSPATH"	, 	get_bloginfo('template_directory') . '/js/' 	);


// INCLUDES -------------------------------------------------------------------------------- //

	if ( ! function_exists('astro_control_setup') ) :
	function astro_control_setup() {
		include(get_template_directory() . '/includes/whitelabel.php');
		include(get_template_directory() . '/includes/google-map.php');
		// include('includes/custom-post-type-[basic].php');
	}
	endif;
	// runs before 'init' hook
	add_action( 'after_setup_theme', 'astro_control_setup' );
	

// <head> FEATURES -------------------------------------------------------------------------------- //

	// css for back end
	// add_editor_style('css/editor-style.css');

	// JS
	function astro_enqueue_scripts() {
		if (!is_admin()) {

			if (PRODUCTION) {
			wp_deregister_script('jquery');
			wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"), false);
			}		
			wp_enqueue_script('jquery'); // **WP default is no-conflict**
			// wp_enqueue_script('jquery-ui-core');

			wp_register_script('bootstrap', 	JSPATH . 'bootstrap.min.js', array('jquery'),'2.22', 	true);
			if (BOOTSTRAP) {wp_enqueue_script('bootstrap');}

			wp_enqueue_script('modernizr', 		JSPATH . 'modernizr.min.js', 		null, 	'2.6.2', 	true);
			wp_enqueue_script('conditionizr', 	JSPATH . 'conditionizr.min.js', 	null, 	'1.0.0', 	true);
			wp_enqueue_script('project', 		JSPATH . 'project.js', array('jquery'), 	'1', 		true);

			wp_register_script('flexslider', 	JSPATH . 'jquery.flexslider-min.js', array('jquery'), null, true);
			if (FLEXSLIDER) {wp_enqueue_script('flexslider');}

			wp_register_script('googlemaps', 'http://maps.google.com/maps/api/js?sensor=false', null, null, false);
			if (is_page('contact')) {wp_enqueue_script('googlemaps');}
		}
	}
	add_action('wp_enqueue_scripts', 'astro_enqueue_scripts');

	function astro_enqueue_styles() {
		if (!is_admin()) {

			wp_register_style( 'bootstrap', CSSPATH . 'bootstrap/bootstrap.css', null, '2.2.2' );
			if (BOOTSTRAP) {wp_enqueue_style('bootstrap');}
			wp_register_style( 'bootstrap-responsive', CSSPATH . 'bootstrap/responsive.css', null, '2.2.2' );
			if (RESPONSIVE) {wp_enqueue_style('bootstrap-responsive');}

			// auto versioning of file by last modified timestamp
			wp_enqueue_style( 'style', get_stylesheet_uri(), null, filemtime( dirname( __FILE__ ) . '/style.css' ) );			
		}
	}
	// run with priority 1 to load after Gravity Forms forms.css			
	add_action('wp_head', 'astro_enqueue_styles', 1);


	// typekit
	function astro_load_typekit($id) {
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
	add_action( 'typekit', 'astro_load_typekit', 10, 1 );

	// google fonts
	function astro_load_googlefonts($families) {
		$script = "
<script>
  WebFontConfig = {
    google: { families: [ '" . $families . "' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>		
		";
		echo $script;
	}
	add_action( 'googlefont', 'astro_load_googlefonts', 10, 1 );



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


// EXCERPTS -------------------------------------------------------------------------------- //


	function astro_excerptlength_post($length) { return 40; }
	function astro_excerptlength_home($length) { return 30; }
	function astro_excerptlength_featured($length) { return 50; }
	
	function astro_excerpt_readmore($more) {
		return ' ... <a class="readmore" href="'. get_permalink() .'">' . __( 'read more', '' ) . '</a>';
	}
	
	function astro_excerpt($length_callback='', $more_callback='') {
		global $post;
		if(function_exists($length_callback)) {
			add_filter('excerpt_length', $length_callback);
		}
		if(function_exists($more_callback)) {
			add_filter('excerpt_more', $more_callback);
		}

		$output = get_the_excerpt();
		$output = apply_filters('wptexturize', $output);
		$output = apply_filters('convert_chars', $output);
		$output = '<p class="excerpt">'.$output.'</p>';
		echo $output;
	}

	// template usage: astro_excerpt('astro_excerptlength_post', 'astro_excerpt_readmore', ' ');


	// credit: http://goo.gl/dcgMHK
	function get_excerpt_by_id($post_id){
		// gets post ID
	    $the_post = get_post($post_id); 
	    // gets post_content to be used as a basis for the excerpt
	    $the_excerpt = $the_post->post_content; 
	    // sets excerpt length by word count
	    $excerpt_length = 35; 
	    // strips tags and images
	    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); 
	    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

	    if(count($words) > $excerpt_length) :
	        array_pop($words);
	        array_push($words, '…');
	        $the_excerpt = implode(' ', $words);
	    endif;

	    $the_excerpt = '<p>' . $the_excerpt . '</p>';

	    return $the_excerpt;
	}



// SHORTCODES -------------------------------------------------------------------------------- //


// clear div shortcode
	function clear_div() {
		return "<div class='clearfix'></div>\n";
	}
	add_shortcode('break', 'clear_div');


// youtube shortcode
	function astro_youtube_embed($atts) {
		extract( shortcode_atts( array(
			'id' => '0',
			'width' => '560',
			'height' => '315'
		), $atts ) );

		return '<div class="video"><iframe width="' . $width . '" height="' . $height . '" src="http://www.youtube.com/embed/'. $id .'?autohide=1&showinfo=0&wmode=opaque" frameborder="0" allowfullscreen></iframe></div>';
	}
	add_shortcode('youtube', 'astro_youtube_embed');
	

// button shortcode 
	function astro_button_code($atts) {
		extract( shortcode_atts( array(
			'colour' => 'blue',
			'link' => '',
			'text' => ''
		), $atts));

		return '<a class="btn '. $colour . '" href="' . $link . '">' . $text . '</a>';		
	}
	add_shortcode('button', 'astro_button_code');


// add HR button to tinyMCE
	function enable_more_buttons($buttons) {
	  $buttons[] = 'hr';
	 
	  return $buttons;
	}
	add_filter("mce_buttons", "enable_more_buttons");


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



// THEME OPTIONS --------------------------------------------------------------------------- //

if (THEMEOPTIONS) {

	//header image
	$args = array(
		'width'                  => 940,
		'height'                 => 300,
		'flex-height'            => true,
		'flex-width'             => true,
		'random-default'         => false,
		'header-text'            => false,
	);
	add_theme_support( 'custom-header', $args );

	// background
	$args = array(
		'default-color'          => 'ffffff',
	);
	add_theme_support( 'custom-background', $args );
}


// SEARCH  --------------------------------------------------------------------------- //

if(SEARCH) {

     function astro_search_form( $form ) {

         $form = '<form class="navbar-search pull-right" role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
         <input type="search" name="s" id="s" class="search-query" placeholder="Search this site..." />
         <button class="search-icon" type="submit" id="searchsubmit">Search</button>
         </form>';

         return $form; // template usage: get_search_form()
     }

     add_filter( 'get_search_form', 'astro_search_form' );


	// search all taxonomies, based on: 
	// http://projects.jesseheap.com/all-projects/wordpress-plugin-tag-search-in-wordpress-23
	function atom_search_where($where){
	  global $wpdb;
	  if (is_search())
	    $where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish')";
	  return $where;
	}

	function atom_search_join($join){
	  global $wpdb;
	  if (is_search())
	    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
	  return $join;
	}

	function atom_search_groupby($groupby){
	  global $wpdb;

	  // we need to group on post ID
	  $groupby_id = "{$wpdb->posts}.ID";
	  if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

	  // groupby was empty, use ours
	  if(!strlen(trim($groupby))) return $groupby_id;

	  // wasn't empty, append ours
	  return $groupby.", ".$groupby_id;
	}

	add_filter('posts_where','atom_search_where');
	add_filter('posts_join', 'atom_search_join');
	add_filter('posts_groupby', 'atom_search_groupby');
}

// -- PAGINATION --------------------------------------------------------------------------- //


	function astro_pagination() {

	    global $wp_query;  
	    $total_pages = $wp_query->max_num_pages;

	    if ($total_pages > 1){  
		    $current_page = max(1, get_query_var('paged'));

		    $args = array (
		    	'type' => 'list',
		    	'show_all' => 'true',
		    	'prev_text'    => __('&lt;'),
			    'next_text'    => __('&gt;'),
				'base' => get_pagenum_link(1) . '%_%',  
				'format' => '/page/%#%',  
				'current' => $current_page,  
				'total' => $total_pages,  
	 	    );

		    echo '<div class="pagination">';
			    echo paginate_links( $args );
		    echo '</div>';
	    }  
    }

    function astro_cpt_pagination() {
    	
    	global $wp_query;
	    $total_pages = $wp_query->max_num_pages;

	    if ($total_pages > 1) {  
		    // test for current page
		    ($wp_query->query_vars['paged'] > 1) ? $current = $wp_query->query_vars['paged'] : $current = 1;

		    $big = 999999999;

		    $pagination = array (
		    	'type' => 'list',
		    	'show_all' => true,
		    	'prev_text'    => __('&lt;'),
			    'next_text'    => __('&gt;'),
				'base' => @add_query_arg('page','%#%'),
				'format' => '',
				'current' => $current,  
				'total' => $total_pages,  
	 	    );

		    echo '<div class="pagination">';
			    echo paginate_links( $pagination );
		    echo '</div>';
	    }
	}

//--end functions


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



// gets the current post type in the WordPress Admin
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


// reduce height of content editor for [cpt] only
	function cpt_tinymce_height() { 
		if (get_current_post_type() == 'cpt') {
	?>
		<style>
			#content_ifr {
				height: 120px !important;
			}			
		</style> 
	<?php 
		}
	}

	add_action("admin_head", "cpt_tinymce_height");

	// hide date dropdown for [cpt] only
	function cpt_hide_date_dropdown() { 
		if (get_current_post_type() == 'cpt') {
	?>
		<style>
			.tablenav select[name=m] {
				display: none;
			}		
		</style> 
	<?php 
		}
	}

	add_action("admin_head", "cpt_hide_date_dropdown");


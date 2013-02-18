<?php 

// CONFIG -------------------------------------------------------------------------------- //

	require_once('includes/config.php');

// INCLUDES -------------------------------------------------------------------------------- //

	include('includes/whitelabel.php');
	// include('includes/google-map.php');
	// include('includes/custom-post-type-[basic].php');
	

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
			wp_enqueue_script('jquery-ui-core');

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

	// GRAVITYFORMS
	function astro_enqueue_forms_css() {
		echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( "gravityforms/css/") . 'forms.css" />
';
	}


	function astro_gravity_forms_css() {
	    if(!wp_style_is("gforms_css", "queue")){
	        wp_enqueue_style("gforms_css", plugins_url( 'gravityforms' ) . "/css/forms.css", null, '1.6.5.1');
	        wp_print_styles(array("gforms_css"));
	    }
	}
	add_action( 'gravitycss', 'astro_gravity_forms_css');


	// auto version CSS file	
	function fileVersion($filename) {
	    $pathToFile = TEMPLATEPATH.'/'.$filename;
	    if (file_exists($pathToFile)) {
	        echo filemtime($pathToFile); 
	    } else {
	        echo 'FileNotFound';
	    }
	}


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


	function astro_load_partial($filename) {
		$file = get_template_directory() . '/partials/' . $filename . '.php';
		if (file_exists($file)) {
			include($file);
		} else {
			echo 'Error: partial file cannot be found.';
		}
	}

	function astro_locate_partial($filename) {
		// $file = 'partials/' . $filename . '.php';
		// locate_template( array($file), true, false );
		$files = array();
		$files[] = "partials/{$filename}.php";
		locate_template($files, true, false);
	}


	// nav menus
	register_nav_menus( array( 
		'primary' => __( 'Primary Navigation', '' ),
	));

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
	 
	add_filter( 'nav_menu_css_class', 'astro_add_dropdown_class', 10, 2);


	//     post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 160, 130, true );


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
		array_push( $classes, "{$post->post_name}" );
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


	// search all taxonomies, based on: http://projects.jesseheap.com/all-projects/wordpress-plugin-tag-search-in-wordpress-23
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



//--end functions

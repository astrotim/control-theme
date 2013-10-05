<?php
/*  
CustomPost custom post type definition
*/

//  CPT
	function create_post_type_custompost() {
		$labels = array (
			'name' => _x('CustomPosts', 'post type general name'),
			'singular_name' => _x('CustomPost', 'post type singular name'),
			'add_new' => _x('Add New', 'custompost'),
			'add_new_item' => __('Add New CustomPost'),
			'edit' => __('Edit'),
			'edit_item' => __('Edit CustomPost'),
			'new_item' => __('New CustomPost'),
			'view_item' => __('View CustomPost Page'),
			'search_items' => __('Search CustomPosts'),
			'not_found' =>  __('No custompost found'),
			'not_found_in_trash' => __('No custompost found in Trash'), 
			'parent_item_colon' => ''
		);
		$args = array (
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'_builtin' => false, 
			'_edit_link' => 'post.php?post=%d',
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array('slug' => "custompost" , 'with_front' => true), // Permalinks
			'has_archive' => false, // true for archive-custompost.php file
			'query_var' => "custompost",
			'menu_position' => 20,
			'taxonomies' => array( 'post_tag', 'category' ),
			'supports' => array('title' , 'editor', 'excerpt', 'thumbnail', 'revisions'),
		);
	register_post_type( 'custompost', $args); 
	
}//--end create_post_type_custompost
	
	//--hook CPT to init
	add_action('init', 'create_post_type_custompost');


	//--flush on theme switch
	function flush_rewrite_rules_custompost() {
		flush_rewrite_rules( false );
	}
	add_action('after_switch_theme', 'flush_rewrite_rules_custompost');




//	Title prompt
	function change_custompost_title( $title ){
		 $screen = get_current_screen();
	 
		 if  ( 'custompost' == $screen->post_type ) {
			  $title = 'Enter CustomPost Name';
		 }
	 
		 return $title;
	}
	
	// hook filter
	add_filter( 'enter_title_here', 'change_custompost_title' );




//	Custom icon	 
	function wpt_custompost_icons() {
		?>
		<style type="text/css" media="screen">
			#menu-posts-custompost .wp-menu-image {
				background: url(<?php bloginfo('template_url') ?>/images/custompost-icon.png) no-repeat 6px -16px !important;
			}
		#menu-posts-custompost:hover .wp-menu-image, #menu-posts-custompost.wp-has-current-submenu .wp-menu-image {
				background-position: 6px 8px !important;
			}
		#icon-edit.icon32-posts-custompost {background: url(<?php bloginfo('template_url') ?>/images/folder-32x32.png) no-repeat;}
		</style>
	<?php } //--end wpt_custompost_icons

	add_action( 'admin_head', 'wpt_custompost_icons' );




//--end CPT plugin




?>
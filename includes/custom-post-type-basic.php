<?php
/*  
Document custom post type definition
*/

//  CPT
	function create_post_type_document() {
		$labels = array (
			'name' => _x('Documents', 'post type general name'),
			'singular_name' => _x('Document', 'post type singular name'),
			'add_new' => _x('Add New', 'document'),
			'add_new_item' => __('Add New Document'),
			'edit' => __('Edit'),
			'edit_item' => __('Edit Document'),
			'new_item' => __('New Document'),
			'view_item' => __('View Document Page'),
			'search_items' => __('Search Documents'),
			'not_found' =>  __('No document found'),
			'not_found_in_trash' => __('No document found in Trash'), 
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
			'rewrite' => array('slug' => "document" , 'with_front' => true), // Permalinks
			'query_var' => "document",
			'menu_position' => 20,
			'taxonomies' => array( 'post_tag', 'category' ),
			'supports' => array('title' , 'editor', 'excerpt', 'thumbnail', 'revisions'),
		);
	register_post_type( 'document', $args); 
	
		flush_rewrite_rules( false );

}//--end create_post_type_document
	
	//--hook CPT to init
	add_action('init', 'create_post_type_document');




//	Title prompt
	function change_document_title( $title ){
		 $screen = get_current_screen();
	 
		 if  ( 'document' == $screen->post_type ) {
			  $title = 'Enter Document Name';
		 }
	 
		 return $title;
	}
	
	// hook filter
	add_filter( 'enter_title_here', 'change_document_title' );




//	Custom icon	 
	function wpt_document_icons() {
		?>
		<style type="text/css" media="screen">
			#menu-posts-document .wp-menu-image {
				background: url(<?php bloginfo('template_url') ?>/images/document-icon.png) no-repeat 6px -16px !important;
			}
		#menu-posts-document:hover .wp-menu-image, #menu-posts-document.wp-has-current-submenu .wp-menu-image {
				background-position: 6px 8px !important;
			}
		#icon-edit.icon32-posts-document {background: url(<?php bloginfo('template_url') ?>/images/folder-32x32.png) no-repeat;}
		</style>
	<?php } //--end wpt_document_icons

	add_action( 'admin_head', 'wpt_document_icons' );




//--end CPT plugin




?>
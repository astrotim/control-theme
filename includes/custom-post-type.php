<?php
/*
Custom Post Type: CustomPost


Contents:
1.	custom post type
2a.	taxonomy (hierarchical for category format)
2b.	taxonomy (non-hierarchical for tag format)
3.	default title prompt
4.	columns for post overview page
5.	taxonomy dropdown filter



checklist for deployment

****** find & replace labels, meta field names, etc
custompost
CustomPost
cptcategory
CPT Categories
CPT Category
cptcat
cptag
CPtag

*/

//  1. CPT
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
			'labels' => $labels, /* array from above */
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
			'supports' => array('title' , 'editor', 'thumbnail', 'revisions'),
			'menu_icon' => 'dashicons-admin-users',
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




//	2. taxonomies
	function create_custompost_taxonomies() {
		//	2a. add taxonomy (hierarchical for category format)
		$labels = array(
			'name' => __( 'CPT Categories', 'taxonomy general name' ),
			'singular_name' => __( 'CPT Category', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search CPT Categories' ),
			'all_items' => __( 'All CPT Categories' ),
			'parent_item' => __( 'Parent CPT Category' ),
			'parent_item_colon' => __( 'Parent CPT Category:' ),
			'edit_item' => __( 'Edit CPT Category' ),
			'update_item' => __( 'Update CPT Category' ),
			'add_new_item' => __( 'Add New CPT Category' ),
			'new_item_name' => __( 'New CPT Category' ),
		);
		$args = array (
			'labels' => $labels, /* array from above */
			'hierarchical' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'cptcategory' ),
		);
		register_taxonomy( 'cptcategory', 'custompost', $args ); /* must have CPT as 2nd argument */

		//	2b. add another taxonomy (non-hierarchical for tag format)
		$labels = array(
			'name' => _x( 'CPTags', 'taxonomy general name' ),
			'singular_name' => _x( 'CPTag', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search CPTags' ),
			'popular_items' => __( 'Popular CPTags' ),
			'all_items' => __( 'All CPTags' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit CPTag' ),
			'update_item' => __( 'Update CPTag' ),
			'add_new_item' => __( 'Add New CPTag' ),
			'new_item_name' => __( 'New CPTag Name' ),
			'separate_items_with_commas' => __( 'Separate cptags with commas' ),
			'add_or_remove_items' => __( 'Add or remove cptags' ),
			'choose_from_most_used' => __( 'Choose from the most used cptags' ),
			'menu_name' => __( 'CPTags' ),
		);
		$args = array(
			'labels' => $labels,
			'hierarchical' => false,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'cptag' ),
		);
		register_taxonomy( 'cpttag', 'custompost', $args ); /* must have CPT as 2nd argument */

	}//--end create_custompost_taxonomies

	// hook taxonomies to init
	add_action( 'init', 'create_custompost_taxonomies', 0 );




//	3. change default title prompt
	function change_custompost_title( $title ){
		 $screen = get_current_screen();

		 if  ( 'custompost' == $screen->post_type ) {
			  $title = 'Enter CustomPost Name';
		 }

		 return $title;
	}

	// hook filter
	add_filter( 'enter_title_here', 'change_custompost_title' );




//	4. columns for post menu page
	function edit_columns($columns) {
		$columns = array(
			"cb" => '<input type="checkbox" />',
			"title" => __( 'CustomPost Title',      'trans' ),
			"_meta_field_1" => __( 'Field One',      'trans' ),
			"_meta_field_2" => __( 'Field Two',      'trans' ),
			"cptcat" => __( 'CPT Category',      'trans' ),
		);

		return $columns;
	}//--end edit_columns

	function custom_columns($column, $post_id) { // need $post_id here for columns output to work (1 of 2)
		global $post;
		switch ($column)
		{
			case "_meta_field_1":
			  echo get_post_meta( $post_id, '_meta_field_1', true);
			  break;
			case "_meta_field_2":
			  echo get_post_meta( $post_id, '_meta_field_2', true);
			  break;
			case "cptcat":
				$cptcats = get_the_terms(0, "cptcategory");
				$cptcats_html = array();
                                if(is_array($cptcats)){
                                    foreach ($cptcats as $cptcat)
                                            array_push($cptcats_html, '<a href="' . get_term_link($cptcat->slug, "cptcategory") . '">' . $cptcat->name . '</a>');

                                    echo implode($cptcats_html, ", ");
                                }
				break;
		}
	}//--end custom_columns

	//	hook columns
	add_filter("manage_edit-custompost_columns", "edit_columns");
	add_action("manage_custompost_posts_custom_column", "custom_columns", 10, 2); // need the 10,2 here for columns output to work (2 of 2)




//	5. taxonomy dropdown filter
	function taxonomy_filter_restrict_manage_posts() { //build drop down
		global $typenow, $wp_query;

		$post_types = get_post_types( array( '_builtin' => false ) );

		if ( in_array( $typenow, $post_types ) ) {
			$filters = get_object_taxonomies( $typenow );

			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );

				// check if anything has been selected, else set selected to null
				$selected = isset($wp_query->query[$tax_slug]) ? $wp_query->query[$tax_slug] : null;

				wp_dropdown_categories( array(
					'show_option_all'	=> __('Show All ' . $tax_obj->label . '&nbsp;'),
					'taxonomy' 	  		=> $tax_slug,
					'name' 		  		=> $tax_obj->name,
					'orderby' 	  		=> 'name',
					'selected' 			=> $selected,
					'hierarchical' 		=> $tax_obj->hierarchical,
					'show_count' 		=> false,
					'hide_empty' 		=> false
				) );
			}
			// debug -------------------
			// echo '<pre>';
			// print_r($wp_query->query);
			// echo '</pre>';
		}
	}
	add_action( 'restrict_manage_posts', 'taxonomy_filter_restrict_manage_posts' );


	function taxonomy_filter_post_type_request( $query ) { //add filter to query so dropdown will work
		global $pagenow, $typenow;

		if ( 'edit.php' != $pagenow )
			return;

		$filters = get_object_taxonomies( $typenow );
		foreach ( $filters as $tax_slug ) {
			$var = &$query->query_vars[$tax_slug];
			if ( $var != 0 )  { // query string has value of 0 if no term is selected
				$term = get_term_by( 'id', $var, $tax_slug );
				$var = $term->slug;
			}
		}
		// echo '<pre>';
		// print_r($filters);
		// echo '</pre>';

		// foreach ( $filters as $tax_slug ) {
		// 	echo 'taxonomy: ' . $tax_slug . '<br>';
		// 	$var = &$query->query_vars[$tax_slug];
		// 	if ( $var != 0 )  {
		// 		$term = get_term_by( 'id', $var, $tax_slug );
		// 		echo '<pre>';
		// 		print_r($term);
		// 		echo '</pre>';
		// 		$slug = $term->slug;
		// 		echo '[slug]: ' . $slug . '<br><br>';
		// 	} else {
		// 		echo 'no term selected<br><br>';
		// 	}
		// }
	}
	add_filter( 'parse_query', 'taxonomy_filter_post_type_request' );




/**
 * Remove the slug from published post permalinks. Only affect our CPT though.
 */
	function ctrl_remove_cpt_slug( $post_link, $post, $leavename ) {

		if( !in_array( $post->post_type, array( 'custompost' ) ) || ( 'publish' != $post->post_status ) ) {
			return $post_link;
		} else {
			$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
			return $post_link;
		}

	}
	// add_filter( 'post_type_link', 'ctrl_remove_cpt_slug', 10, 3 );


/**
 * Some hackery to have WordPress match postname to any of our public post types
 * All of our public post types can have /post-name/ as the slug, so they better be unique across all posts
 * Typically core only accounts for posts and pages where the slug is /post-name/
 */
	function ctrl_parse_request_tricksy( $query ) {

	    // Only noop the main query
	    if ( ! $query->is_main_query() )
	        return;

	    // Only noop our very specific rewrite rule match
	    if ( 2 != count( $query->query )
	        || ! isset( $query->query['page'] ) )
	        return;

	    // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
	    if ( ! empty( $query->query['name'] ) )
	        $query->set( 'post_type', array( 'post', 'custompost', 'page' ) );
	}
	// add_action( 'pre_get_posts', 'ctrl_parse_request_tricksy' );



// admin columns
	function custompost_admin_columns() {
		$columns = array(
			'cb'	 	=> '<input type="checkbox" />',
			'image' 	=> '',
			'acf_number'=> 'No.',
			'title' 	=> 'Title',
			'acf_field'	=> 'Custom Field',

		);
		return $columns;
	}
	// add_filter("manage_custompost_posts_columns", "custompost_admin_columns");


	function custompost_custom_columns($column, $post_id) {
		global $post;
		switch ($column) {
			case "acf_number":
				echo get_field('acf_number', $post_id);
				break;
			case "image":
				$image_src 	= get_field('cover_art'); // or post_thumbnail
				if($image_src) {
					$thumb_src = $image_src['sizes']['thumbnail'];
					echo '<img src="' . $thumb_src . '" width="40" height="40">';
				}
				break;
			case "acf_field":
				echo get_field('acf_field', $post_id);
				break;
		}
	}
	// add_action("manage_custompost_posts_custom_column", "custompost_custom_columns", 10, 2);



	function cpt_custom_column_width() {
		?>
		<style>
			#posts-filter th#column_name {
				width: 65px;
			}
		</style>
		<?php
	}
	// add_action("admin_head", "cpt_custom_column_width");


	function remove_row_actions_links($actions, $post) {
		if ($post->post_type == "cpt"){
			unset( $actions['inline hide-if-no-js'] ); // quick edit
			unset( $actions['trash'] );
			unset( $actions['view'] );
		}

	   return $actions;
	}
	// add_filter('post_row_actions', 'remove_row_actions_links', 10, 2);


	function set_cpt_admin_order($query) {
		if (is_admin()) {

			// Get the post type from the query
			$post_type = $query->query['post_type'];

			if ( $post_type == 'song') {
				$query->set('orderby', 'meta_value_num');
				$query->set('meta_key', 'number');
				$query->set('order', 'ASC');
			}
		}
	}
	// add_filter('pre_get_posts', 'set_cpt_admin_order');



//--end CPT plugin


?>
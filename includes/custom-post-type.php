<?php
/*  
Plugin Name: Custom Post Type base
Description: Custom post type plugin 
Version: 1.0  
Author: Tim Holt  
*/  

/*
Contents:
1.	custom post type
2a.	taxonomy (hierarchical for category format)
2b.	taxonomy (non-hierarchical for tag format)
3.	create meta options box
4.	hook meta box
5.	save post
6.	default title prompt
7.	columns for post overview page
8.	taxonomy dropdown filter
9.	custom post icon
10.	mulitple featured images
*/

/*
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
			'query_var' => "custompost",
			'menu_position' => 20,
			'supports' => array('title' , 'editor', 'thumbnail', 'revisions'),
		);
	register_post_type( 'custompost', $args); 
	
		flush_rewrite_rules( false );

}//--end create_post_type_custompost
	
	//--hook CPT to init
	add_action('init', 'create_post_type_custompost');



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


//	3. create meta options box
	function meta_options_custompost() {
		
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'custompost_noncename' );
		
		global $post;
		$custom = get_post_custom($post->ID);
			  $meta_field_1 = $custom["_meta_field_1"][0];
			  $meta_field_2 = $custom["_meta_field_2"][0];
			  $meta_field_3 = $custom["_meta_field_3"][0];
			  $meta_field_4 = $custom["_meta_field_4"][0];

		if(isset($custom["_meta_field_1"])) $meta_field_1 = $custom["_meta_field_1"][0];else $meta_field_1 = '';
		if(isset($custom["_meta_field_2"])) $meta_field_2 = $custom["_meta_field_2"][0];else $meta_field_2 = '';
		if(isset($custom["_meta_field_3"])) $meta_field_3 = $custom["_meta_field_3"][0];else $meta_field_3 = '';
		if(isset($custom["_meta_field_4"])) $meta_field_4 = $custom["_meta_field_4"][0];else $meta_field_4 = '';
                ?>
                    <div>
                        <table border="0" cellspacing="0" cellpadding="0">
                        <tr><td class="meta_field"><label>Field One:</label></td>
                        	<td class="meta_input"><input name="_meta_field_1" value="<?php echo $meta_field_1; ?>" size="60" /></td></tr>
                        <tr><td class="meta_field"><label>Field Two:</label></td>
                        	<td class="meta_input"><input name="_meta_field_2" value="<?php echo $meta_field_2; ?>" size="60" /></td></tr>
                        <tr><td class="meta_field"><label>Field Three:</label></td>
                        	<td class="meta_input"><input name="_meta_field_3" value="<?php echo $meta_field_3; ?>" size="60" /></td></tr>
                        <tr><td class="meta_field"><label>Field Four:</label></td>
                        	<td class="meta_input"><input name="_meta_field_4" value="<?php echo $meta_field_4; ?>" size="60" /></td></tr>
                        </table>
                    </div>
               <?php
	}//--end meta_options_custompost




//	4. hook meta box
	function admin_init_custompost(){
		add_meta_box("custompost-meta", "Meta Box", "meta_options_custompost", "custompost", "normal", "high");
	}
	// hook meta box
	add_action("admin_init", "admin_init_custompost");




//	5. save post
	function save_details_custompost(){
		
	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['custompost_noncename'], plugin_basename( __FILE__ ) ) )
		return;
	
	// Check permissions
	if ( 'page' == $_POST['post_type'] ) 
	{
	  if ( !current_user_can( 'edit_page', $post_id ) )
		  return;
	}
	else
	{
	  if ( !current_user_can( 'edit_post', $post_id ) )
		  return;
	}
		
	global $post;
		update_post_meta($post->ID, "_meta_field_1", $_POST["_meta_field_1"]);
		update_post_meta($post->ID, "_meta_field_2", $_POST["_meta_field_2"]);
		update_post_meta($post->ID, "_meta_field_3", $_POST["_meta_field_3"]);
		update_post_meta($post->ID, "_meta_field_4", $_POST["_meta_field_4"]);
		
	}//--end save_details_custompost
	
	//hook save post
	add_action('save_post', 'save_details_custompost');




//	6. change default title prompt
	function change_custompost_title( $title ){
		 $screen = get_current_screen();
	 
		 if  ( 'custompost' == $screen->post_type ) {
			  $title = 'Enter CustomPost Name';
		 }
	 
		 return $title;
	}
	
	// hook filter
	add_filter( 'enter_title_here', 'change_custompost_title' );




//	7. columns for post menu page
	function edit_columns($columns) {
		$columns = array(
			"cb" => '<input type="checkbox" />',
			"title" => __( 'CustomPost Title',      'trans' ),
			"_meta_field_1" => __( 'Field One',      'trans' ),
			"_meta_field_2" => __( 'Field Two',      'trans' ),
			"_meta_field_3" => __( 'Field Three',      'trans' ),
			"_meta_field_4" => __( 'Field Four',      'trans' ),
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
			case "_meta_field_3":
			  echo get_post_meta( $post_id, '_meta_field_3', true);
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
	add_action("manage_posts_custom_column", "custom_columns", 10, 2); // need the 10,2 here for columns output to work (2 of 2)




//	8. taxonomy dropdown filter
	function taxonomy_filter_restrict_manage_posts() { //build drop down
		global $typenow;
	
		$post_types = get_post_types( array( '_builtin' => false ) );
	
		if ( in_array( $typenow, $post_types ) ) {
			$filters = get_object_taxonomies( $typenow );
	
			foreach ( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				wp_dropdown_categories( array(
					'show_option_all' => __('Show All ' . $tax_obj->label . '&nbsp;'),
					'taxonomy' 	  => $tax_slug,
					'name' 		  => $tax_obj->name,
					'orderby' 	  => 'name',
					'selected' 	  => $_GET[$tax_slug],
					'hierarchical' 	  => $tax_obj->hierarchical,
					'show_count' 	  => false,
					'hide_empty' 	  => true
				) );
			}
		}
	}//--end taxonomy_filter_restrict_manage_posts
	
	// hook action
	add_action( 'restrict_manage_posts', 'taxonomy_filter_restrict_manage_posts' );
	
	function taxonomy_filter_post_type_request( $query ) { //add filter to query so dropdown will work
	  global $pagenow, $typenow;
	
	  if ( 'edit.php' == $pagenow ) {
		$filters = get_object_taxonomies( $typenow );
		foreach ( $filters as $tax_slug ) {
		  $var = &$query->query_vars[$tax_slug];
		  if ( isset( $var ) ) {
			$term = get_term_by( 'id', $var, $tax_slug );
			$var = $term->slug;
		  }
		}
	  }
	}//--taxonomy_filter_post_type_request
	
	// hook filter
	add_filter( 'parse_query', 'taxonomy_filter_post_type_request' );




//	9. custom post icon	/ CSS adjust: 6px -16px / 6px 8px
	function wpt_custompost_icons() {
		?>
		<style type="text/css" media="screen">
			#menu-posts-custompost .wp-menu-image {
				background: url(<?php bloginfo('template_url') ?>/images/custompost-icon.png) no-repeat 6px -16px !important;
			}
		#menu-posts-custompost:hover .wp-menu-image, #menu-posts-custompost.wp-has-current-submenu .wp-menu-image {
				background-position:6px 8px !important;
			}
		#icon-edit.icon32-posts-custompost {background: url(<?php bloginfo('template_url') ?>/images/custompost-32x32.png) no-repeat;}
		</style>
	<?php } //--end wpt_custompost_icons

	add_action( 'admin_head', 'wpt_custompost_icons' );




//--end CPT plugin




?>
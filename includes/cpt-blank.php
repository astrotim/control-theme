<?php
/**
 * Custom Post Type: Cpt
 *
 * @package Control
 */

	function cpt_create_post_type() {
		$labels = array (
			'name' => _x('Cpts', 'post type general name'),
			'singular_name' => _x('Cpt', 'post type singular name'),
			'add_new' => _x('Add New', 'cpt'),
			'add_new_item' => __('Add New Cpt'),
			'edit' => __('Edit'),
			'edit_item' => __('Edit Cpt'),
			'new_item' => __('New Cpt'),
			'view_item' => __('View Cpt Page'),
			'search_items' => __('Search Cpts'),
			'not_found' =>  __('No cpts found'),
			'not_found_in_trash' => __('No cpts found in Trash'),
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
			'rewrite' => array('slug' => "cpt" , 'with_front' => true),
			'has_archive' => 'cpts', // loads archive-cpt.php file for /cpts/
			'query_var' => "cpt",
			'menu_position' => 20,
			'supports' => array(
        'title',
        'editor',
        'revisions',
      ),
			'menu_icon' => 'dashicons-editor-help',
		);

		register_post_type('cpt', $args);

	}

	//--hook CPT to init
	add_action('init', 'cpt_create_post_type');


	//--flush on theme switch
	function flush_rewrite_rules_cpt() {
		flush_rewrite_rules( false );
	}
	add_action('after_switch_theme', 'flush_rewrite_rules_cpt');




//	2. taxonomies
	function cpt_create_taxonomies() {

		$labels = array(
			'name' => __( 'Cpt Category', 'taxonomy general name' ),
			'singular_name' => __( 'Cpt Categories', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Cpt Categories' ),
			'all_items' => __( 'All Categories' ),
			'parent_item' => __( 'Parent Cpt Category' ),
			'parent_item_colon' => __( 'Parent Cpt Category:' ),
			'edit_item' => __( 'Edit Cpt Category' ),
			'update_item' => __( 'Update Cpt Category' ),
			'add_new_item' => __( 'Add New Cpt Category' ),
			'new_item_name' => __( 'New Cpt Category' ),
		);
		$args = array (
			'labels' => $labels, /* array from above */
			'hierarchical' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'cpts' ),
		);

		register_taxonomy( 'cpt_category', 'cpt', $args );

	}

	// hook taxonomies to init
	add_action( 'init', 'cpt_create_taxonomies', 0 );



//	3. change default title prompt
	function cpt_change_title( $title ){
		 $screen = get_current_screen();

		 if  ( 'cpt' == $screen->post_type ) {
			  $title = 'Enter Cpt Name';
		 }

		 return $title;
	}

	// hook filter
	add_filter( 'enter_title_here', 'cpt_change_title' );




//	4. columns for post menu page
	function cpt_edit_columns($columns) {
		$columns = array(
			"cb" => '<input type="checkbox" />',
      "image" => '',
			"title" => 'Cpt',
			"category" => 'Category',
			"date" => 'Date'
		);

		return $columns;
	}//--end edit_columns


	function cpt_custom_columns($column, $post_id) {
		global $post;
		switch ($column)
		{
      case "image":
        // $image_src  = get_field('acf_image', $post_id);
        $image_src   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail-tiny', false);
        if($image_src) {
          // $thumb_src = $image_src['sizes']['thumbnail-tiny'];
          $thumb_src = $image_src[0];
          echo '<img src="' . $thumb_src . '" width="80" height="45">';
        }
        break;
			case "category":
				$cptcats = get_the_terms(0, "cpt_category");
				$cptcats_html = array();
          if(is_array($cptcats)){
            foreach ($cptcats as $cptcat)
              array_push($cptcats_html, '<a href="' . get_term_link($cptcat->slug, "cpt_category") . '">' . $cptcat->name . '</a>');

            echo implode($cptcats_html, ", ");
          }
				break;
		}
	}//--end custom_columns

	//	hook columns
	// add_filter("manage_edit-cpt_columns", "cpt_edit_columns");
	// add_action("manage_cpt_posts_custom_column", "cpt_custom_columns", 10, 2);


	function cpt_custom_column_width() {
		?>
		<style>
      #posts-filter th#image {
        width: 80px;
      }
		</style>
		<?php
	}
	// add_action("admin_head", "cpt_custom_column_width");



	function cpt_set_cpt_admin_order($query) {
		if (is_admin()) {

			// Get the post type from the query
			$post_type = $query->query['post_type'];

			if ( $post_type == 'cpt') {
				$query->set('orderby', 'meta_value_num');
				$query->set('meta_key', 'number');
				$query->set('order', 'ASC');
			}
		}
	}
	// add_filter('pre_get_posts', 'set_cpt_admin_order');





//--end CPT plugin
?>
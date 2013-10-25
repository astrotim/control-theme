<?php

/* CREATE SLUG 
---------------------------------------------------------------------------- */

	// convert title into slug
	function title_to_slug($str){
		$str = html_entity_decode($str);
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		$str = preg_replace('/-+/', "-", $str);
		$str = preg_replace('/^\PL+|\PL\z/', '', $str);
		return $str;
	}



/* CHECK IF POST EXISTS  
---------------------------------------------------------------------------- */

	function check_for_post_slug($slug) {

		$args = array(
			'name' 			=> $slug,
			'post_type'		=> 'post',
			'posts_per_page'=> 1
		);

		$post = get_posts($args);

		return $post;

	}



/* CREATE POST
---------------------------------------------------------------------------- */

	// main insert post function
	function create_post($title) {

		$slug = title_to_slug($title);

		// insert merchant as 'post'
		$post_id = wp_insert_post( array(
				'post_name' => $slug,
				'post_title' => $title,
				'post_type' => 'post',
				'post_status' => 'publish'
			)
			// , $wp_error // not sure why this throws an error, so leaving it out
		);

		// set a meta field
		// update_post_meta($post_id, 'meta_field_name', 	$id );

		// tell us what just happened
		$message = 'Added post "' . $title . '" (Post ID: ' . $post_id  . ').<br>';

		return $message;

	} // create_post()


/* UPDATE POST  
---------------------------------------------------------------------------- */

	function update_post($post_id, $title) {

		// update post data
		$post_data = array(
			'ID'			=> $post_id,
			'post_title'	=> $title,
		);

		wp_update_post($post_data);

		// update meta data
		// update_post_meta($post_id, 'meta_field_name', 	$id );

		$message = 'Updated post "' . $title . '" (Post ID: ' . $post_id  . ').<br>';

		return $message;

	}

/* MAIN IMPORT FUNCTION  
---------------------------------------------------------------------------- */

	function import_posts() {

		include('dummy-post-data.php');

		// loop through 'titles' array
		foreach ($titles as $title) {

			$slug = title_to_slug($title);

			// insert or update?
			if ( !check_for_post_slug($slug) ) {

				echo create_post($title);

			} else {

				$post_obj = check_for_post_slug($slug);
				$post_id = $post_obj[0]->ID;

				echo update_post($post_id, $title);

			}

		} // end foreach

	} // end import_posts()


/* ADMIN PAGE  
---------------------------------------------------------------------------- */

	function import_posts_admin() {
		add_submenu_page( 'tools.php', 'Import Dummy Posts', 'Import Dummy Posts', 'edit_pages', 'import-posts', 'import_dummy_posts_admin_page');	
	}

	function import_dummy_posts_admin_page() {
		echo '<div class="wrap">';
		echo '  <div id="icon-tools" class="icon32"></div>';
		echo '  <h2>Import Dummy Posts</h2>';
		echo '  <div><p>';

		echo import_posts();

		echo '  </p></div>';
		echo '</div>';
	}

	add_action('admin_menu', 'import_posts_admin');

?>
<?php 

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


// ADMIN UTILITIES --------------------------------------------------------------------------- //


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


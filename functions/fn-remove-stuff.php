<?php
/**
 * Remove stuff from WP admin and page output
 *
 * @package Control
 */



  /**
   * remove WP SEO options
   *
   * hides drop down on all posts admin page
   */
	add_filter( 'wpseo_use_page_analysis', '__return_false' );



  /**
   * hide upgrade notification
   *
   */
	function ctrl_no_update_notification() {
		remove_action('admin_notices', 'update_nag', 3);
	}
	if (!current_user_can('activate_plugins')) {
		add_action('admin_notices', 'ctrl_no_update_notification', 1);
	}



  /**
   * disable admin bar
   *
   */
	add_filter( 'show_admin_bar', '__return_false' );




  /**
   * remove unnecessary admin menu items
   *
   */
	function ctrl_remove_admin_menus() {

		global $menu, $submenu;
		// all users
		$restrict = explode(',', 'Links');

		// sub-menus removed for all users
		// $restrictsub = explode(',', 'Categories,Tags');

		// non-administrator users
		$restrict_user = explode(',', 'Links,Plugins,Users,Tools,Settings');
		// WP localization
		$f = create_function('$v,$i', 'return __($v);');
		array_walk($restrict, $f);
		if (!current_user_can('activate_plugins')) {
			array_walk($restrict_user, $f);
			$restrict = array_merge($restrict, $restrict_user);
		}
		// remove menus
		end($menu);
		while (prev($menu)) {
			$k = key($menu);
			$v = explode(' ', $menu[$k][0]);
			if(in_array(is_null($v[0]) ? '' : $v[0] , $restrict)) unset($menu[$k]);
		}

		// remove sub-menus
		// foreach ($submenu as $k => $p) {
		// 	foreach($submenu[$k] as $j => $s) {
		// 		if (in_array(is_null($s[0]) ? '' : $s[0] , $restrictsub)) unset($submenu[$k][$j]);
		// 	}
		// }
	}
	add_action('admin_menu', 'ctrl_remove_admin_menus');



  /**
   * remove junk from head
   *
   * @todo do this with Yoast SEO
   */
	// remove_action('wp_head', 'wp_generator');



  /**
   * remove default widgets, including Nav_Menu_Widget
   *
   */
	function ctrl_unregister_widgets() {
		unregister_widget( 'WP_Widget_Archives' );
		unregister_widget( 'WP_Widget_Calendar' );
		unregister_widget( 'WP_Widget_Categories' );
		unregister_widget( 'WP_Widget_Links' );
		unregister_widget( 'WP_Widget_Meta' );
		unregister_widget( 'WP_Widget_Pages' );
		unregister_widget( 'WP_Widget_Recent_Comments' );
		unregister_widget( 'WP_Widget_Recent_Posts' );
		unregister_widget( 'WP_Widget_RSS' );
		unregister_widget( 'WP_Widget_Search' );
		unregister_widget( 'WP_Widget_Tag_Cloud' );
		unregister_widget( 'WP_Nav_Menu_Widget' ); /* different to rest of naming convention */
	}
	add_action( 'widgets_init', 'ctrl_unregister_widgets' );


  /**
   * remove default dashboard widgets and register custom widgets
   *
   */
	function ctrl_custom_dashboard_widgets() {
		global $wp_meta_boxes;

		// remove default widgets
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	}

	add_action('wp_dashboard_setup', 'ctrl_custom_dashboard_widgets');




  /**
   * remove author column and comments column from pages
   *
   */
	function ctrl_custom_pages_columns( $columns ) {
		unset(
			// $columns['author'],
			// $columns['comments']
		);
		return $columns;
	}
	// add_filter( 'manage_pages_columns', 'ctrl_custom_pages_columns' );


  /**
   * remove author column and comments column from posts
   *
   */
	function ctrl_custom_posts_columns( $columns ) {
		unset(
			$columns['author'],
			$columns['comments'],
			$columns['categories'],
			$columns['tags']
		);
		return $columns;
	}
	// add_filter( 'manage_posts_columns', 'ctrl_custom_posts_columns' );



  /**
   * remove page/post meta boxes, except for full admins
   *
   * @example	revisionsdiv authordiv postexcerpt postimagediv formatdiv tagsdiv-post_tag categorydiv pageparentdiv
   */
	function ctrl_customize_page_meta_boxes() {
		remove_meta_box('postcustom','page','normal');
		remove_meta_box('postcustom','post','normal');
		remove_meta_box('slugdiv','page','normal');
		remove_meta_box('commentsdiv','page','normal');
		remove_meta_box('commentstatusdiv','page','normal');
		remove_meta_box('authordiv','page','normal');
		remove_meta_box('trackbacksdiv','post','normal');
	}
	add_action('admin_init','ctrl_customize_page_meta_boxes');



  /**
   * profile page
   *
   */
	remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

	/* Removes the leftover 'Visual Editor', 'Keyboard Shortcuts' and 'Toolbar' options */
	if ( ! function_exists( 'ctrl_remove_personal_options' ) ) {
		function ctrl_remove_personal_options( $subject ) {
			$subject = preg_replace( '#<h3>Personal Options</h3>.+?/table>#s', '', $subject, 1 );
			return $subject;
		}

		function ctrl_profile_subject_start() {
			ob_start( 'ctrl_remove_personal_options' );
		}

		function ctrl_profile_subject_end() {
			ob_end_flush();
		}
	}
	add_action( 'admin_head-profile.php', 'ctrl_profile_subject_start' );
	add_action( 'admin_footer-profile.php', 'ctrl_profile_subject_end' );


	/* remove user profile contact methods */
	function trim_user_profile_admin( $contactmethods ) {
		$contactmethods = array();
		return $contactmethods;
	}
	add_filter('user_contactmethods','trim_user_profile_admin',10,1);


	/* remove user profile bio box plugin */
	// include(get_template_directory() . '/plugins/remove-bio-box.php');

	/* hide fields with CSS */
	function ctrl_hide_website_field() { ?>
		<style>
			#profile-page .form-table label[for='url'],
			#profile-page .form-table input#url {
				display: none;
			}
		</style> <?php
	}
	add_action("admin_head", "ctrl_hide_website_field");


<?php  

// hide "Events Calendar" toolbar links
// define('TRIBE_DISABLE_TOOLBAR_ITEMS', true);


// remove WP SEO options
	// hides drop down on all posts admin page 
	add_filter( 'wpseo_use_page_analysis', '__return_false' ); 
	// not sure what this one does ??
	// add_filter( 'wpseo_options', '__return_false' );

// remove upgrade notification
	function no_update_notification() {
		remove_action('admin_notices', 'update_nag', 3);
	}
	if (!current_user_can('activate_plugins')) { 
		add_action('admin_notices', 'no_update_notification', 1); 
	}

// client logo on login page
	function change_admin_logo() { ?>
		<style>
		body.login {
			background: #fff url(<?php bloginfo('template_directory') ?>/images/cross.jpg); 
		}
		#login {
			padding-top: 20px;
		}
		#login h1 a {
			background: url(<?php bloginfo('template_directory') ?>/screenshot.png) no-repeat center;
			background-size: auto;
			/*width: 300px;*/
			height: 135px;
		}
		</style> <?php 
	}
	add_action("login_head", "change_admin_logo");

	function change_login_url() {
		return site_url();
	}
	add_filter( 'login_headerurl', 'change_login_url', 10, 4 );

	function change_login_header_title() {
		return get_bloginfo('name');
	}

	add_filter('login_headertitle','change_login_header_title');


// add a favicon for your admin
	function admin_favicon() {
		echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('template_directory').'/images/favicon.ico" />';
	}
	add_action('admin_head', 'admin_favicon');


// hide plugin ads ** NSP Post Types Order
	function hide_plugin_ads() { ?>
		<style>
		.posts_page_to-interface-post #cpt_info_box,
		.settings_page_cpto-options #cpt_info_box {
			display: none;
		}		
		</style> <?php 
	}
	add_action("admin_head", "hide_plugin_ads");
	

// remove unnecessary menus
		function remove_admin_menus () {
		global $menu;
		// all users
		$restrict = explode(',', 'Links');
		
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
	}
	add_action('admin_menu', 'remove_admin_menus');


// remove junk from head
	remove_action('wp_head', 'wp_generator');


// remove default widgets, including Nav_Menu_Widget
	function my_unregister_widgets() {
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
	add_action( 'widgets_init', 'my_unregister_widgets' );


// remove default dashboard widgets and register custom widgets
	function custom_dashboard_widgets() {
		global $wp_meta_boxes;
			// remove default widgets	
			unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
			unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	}

	add_action('wp_dashboard_setup', 'custom_dashboard_widgets');





 // disable admin bar
	// if (!function_exists('disableAdminBar')) {
	// 	function disableAdminBar() {
	// 		remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 ); // for the front end

	// 		function remove_admin_bar_style_frontend() { // css override for the frontend
	// 		  echo '<style type="text/css" media="screen">
	// 		  html { margin-top: 0px !important; }
	// 		  * html body { margin-top: 0px !important; }
	// 		  </style>';
	// 		}
	// 		add_filter('wp_head','remove_admin_bar_style_frontend', 99);
	// 	}
	// }
	// add_filter('admin_head','remove_admin_bar_style_backend'); // Original version
	// add_action('init','disableAdminBar'); // New version

	add_filter( 'show_admin_bar', '__return_false' );


// PAGES & POSTS -----------------------------------------------------------------------------


	// remove author column and comments column from pages
	function astro_custom_pages_columns( $columns ) {
		unset(
			// $columns['author'],
			$columns['comments']
		);
		return $columns;
	}
	add_filter( 'manage_pages_columns', 'astro_custom_pages_columns' ) ;

	// remove author column and comments column from posts
	function astro_custom_posts_columns( $columns ) {
		unset(
			$columns['author'],
			$columns['comments'],
			$columns['categories'],
			$columns['tags']
		);
		return $columns;
	}
	// add_filter( 'manage_posts_columns', 'astro_custom_posts_columns' ) ;

	// remove page/post meta boxes, except for full admins
	function customize_page_meta_boxes() {
		remove_meta_box('postcustom','page','normal');
		remove_meta_box('postcustom','post','normal');
		remove_meta_box('slugdiv','page','normal');
		remove_meta_box('commentsdiv','page','normal');
		remove_meta_box('commentstatusdiv','page','normal');
		// remove_meta_box('authordiv','page','normal');
		remove_meta_box('trackbacksdiv','post','normal');
	}
	add_action('admin_init','customize_page_meta_boxes');  
	// revisionsdiv authordiv postexcerpt postimagediv formatdiv tagsdiv-post_tag categorydiv pageparentdiv





// PROFILE PAGE -----------------------------------------------------------------------------


	// removes the color scheme options
	remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

	// Removes the leftover 'Visual Editor', 'Keyboard Shortcuts' and 'Toolbar' options.
	if ( ! function_exists( 'cor_remove_personal_options' ) ) {
		function cor_remove_personal_options( $subject ) {
			$subject = preg_replace( '#<h3>Personal Options</h3>.+?/table>#s', '', $subject, 1 );
			return $subject;
		}

		function cor_profile_subject_start() {
			ob_start( 'cor_remove_personal_options' );
		}

		function cor_profile_subject_end() {
			ob_end_flush();
		}
	}
	add_action( 'admin_head-profile.php', 'cor_profile_subject_start' );
	add_action( 'admin_footer-profile.php', 'cor_profile_subject_end' );


// remove user profile contact methods
	function trim_user_profile_admin( $contactmethods ) {
		$contactmethods = array(); 
		return $contactmethods;
	}
	add_filter('user_contactmethods','trim_user_profile_admin',10,1);


// remove user profile bio box plugin
	include('remove-bio-box.php');

	function hide_website_field() { ?>
		<style>
			#profile-page .form-table label[for='url'],
			#profile-page .form-table input#url {
				display: none;
			}			
		</style> <?php 
	}

	add_action("admin_head", "hide_website_field");


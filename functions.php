<?php

// PATHS -------------------------------------------------------------------------------- //

define( "THEME_DIR"	, 	get_template_directory_uri() );
define( "CSS_DIR"	, 	get_template_directory_uri() . '/css/'	);
define( "JS_DIR"	, 	get_template_directory_uri() . '/js/' 	);
define( "INCPATH"	, 	'includes/' 	);
define( "PLUGINS"	, 	'plugins/' 	);


// INCLUDES -------------------------------------------------------------------------------- //

	if ( ! function_exists('ctrl_ctrl_setup') ) :
	function ctrl_ctrl_setup() {
		include(get_template_directory() . '/includes/functions-head.php');
		include(get_template_directory() . '/includes/functions-template.php');
		include(get_template_directory() . '/includes/functions-excerpts.php');
		include(get_template_directory() . '/includes/functions-shortcodes.php');
		include(get_template_directory() . '/includes/functions-search.php');
		include(get_template_directory() . '/includes/functions-pagination.php');
		include(get_template_directory() . '/includes/functions-admin.php');
		include(get_template_directory() . '/includes/functions-whitelabel.php');
		include(get_template_directory() . '/plugins/google-map.php');
		include(get_template_directory() . '/_import/import-functions.php');
		// include(get_template_directory() . '/includes/custom-post-type-[basic].php');
	}
	endif;
	// runs before 'init' hook
	add_action( 'after_setup_theme', 'ctrl_ctrl_setup' );


// ADVANCED CUSTOM FIELDS ------------------------------------------------------------------ //

	if ( ! function_exists('ctrl_acf_setup') ) :
	function ctrl_acf_setup() {
		// define( 'ACF_LITE' , true );
		include_once( 'acf/acf-register-fields.php' );
	}
	endif;
	// runs before 'init' hook
	if(!IS_DEV) {
	add_action( 'after_setup_theme', 'ctrl_acf_setup' );
	}

	function ctrl_acf_admin_style() {
	    wp_enqueue_style( 'ctrl_acf_admin_style', get_template_directory_uri() . '/acf/acf-admin-style.css' );
	}
	add_action( 'admin_enqueue_scripts', 'ctrl_acf_admin_style' );
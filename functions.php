<?php 

// CONSTANTS -------------------------------------------------------------------------------- //

define( "PRODUCTION"	, 	false 	);
define( "BOOTSTRAP"		, 	true 	);
define( "RESPONSIVE"	, 	true 	);
define( "FLEXSLIDER"	, 	true 	);
define( "THEMEOPTIONS"	, 	false 	);
define( "SEARCH"		, 	true 	);

// PATHS -------------------------------------------------------------------------------- //

define( "THEMEPATH"	, 	get_bloginfo('template_directory') );
define( "CSSPATH"	, 	get_bloginfo('template_directory') . '/css/'	);
define( "JSPATH"	, 	get_bloginfo('template_directory') . '/js/' 	);


// INCLUDES -------------------------------------------------------------------------------- //

	if ( ! function_exists('astro_control_setup') ) :
	function astro_control_setup() {
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
	add_action( 'after_setup_theme', 'astro_control_setup' );
	









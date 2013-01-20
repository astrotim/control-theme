<?php 

// CONSTANTS -------------------------------------------------------------------------------- //

define( "PRODUCTION"	, 	false 	);
define( "BOOTSTRAP"		, 	true 	);
define( "RESPONSIVE"	, 	true 	);
define( "FLEXSLIDER"	, 	true 	);
define( "THEMEOPTIONS"	, 	false 	);
define( "GOOGLEMAP"		, 	true 	);

	// test for constant
	function theme_has($test) {
		if($test === true) {
			return true;
		} else {
			return false;
		}
	}


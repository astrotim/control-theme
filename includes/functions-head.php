<?php 
	
// <head> FEATURES -------------------------------------------------------------------------------- //

	// css for back end
	// add_editor_style('css/editor-style.css');

	// JS
	function astro_enqueue_scripts() {
		if (!is_admin()) {

			if (PRODUCTION) {
			wp_deregister_script('jquery');
			wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"), false);
			}		
			wp_enqueue_script('jquery'); // **WP default is no-conflict**
			// wp_enqueue_script('jquery-ui-core');

			wp_register_script('bootstrap', 	JSPATH . 'bootstrap.min.js', array('jquery'),'2.22', 	true);
			// wp_enqueue_script('bootstrap');

			wp_enqueue_script('modernizr', 		JSPATH . 'modernizr.min.js', 		null, 	'2.6.2', 	true);
			wp_enqueue_script('conditionizr', 	JSPATH . 'conditionizr.min.js', 	null, 	'1.0.0', 	true);
			wp_enqueue_script('project', 		JSPATH . 'project.js', array('jquery'), 	'1', 		true);

			wp_register_script('flexslider', 	JSPATH . 'jquery.flexslider-min.js', array('jquery'), null, true);
			// if (is_front_page()) {
			// 	wp_enqueue_script('flexslider');
			// }

			wp_register_script('googlemaps', 'http://maps.google.com/maps/api/js?sensor=false', null, null, false);
			// if (is_page('contact')) {
			// 	wp_enqueue_script('googlemaps');
			// }
		}
	}
	add_action('wp_enqueue_scripts', 'astro_enqueue_scripts');

	function astro_enqueue_styles() {
		if (!is_admin()) {

			// wp_register_style( 'bootstrap', CSSPATH . 'bootstrap/bootstrap.css', null, '2.2.2' );
			// if (BOOTSTRAP) {wp_enqueue_style('bootstrap');}
			// wp_register_style( 'bootstrap-responsive', CSSPATH . 'bootstrap/responsive.css', null, '2.2.2' );
			// if (RESPONSIVE) {wp_enqueue_style('bootstrap-responsive');}

			// auto versioning of file by last modified timestamp
			wp_enqueue_style( 'style', get_stylesheet_uri(), null, filemtime( realpath(__DIR__ . '/../style.css' ) ) );			
		}
	}
	// run with priority 1 to load after Gravity Forms forms.css			
	add_action('wp_head', 'astro_enqueue_styles', 1);


	// typekit
	function astro_load_typekit($id) {
		$script = "
<script>
	TypekitConfig = {
		kitId: '" . $id . "',
		scriptTimeout: 3000
	};
	(function() {
		var h = document.getElementsByTagName('html')[0];
		h.className += ' wf-loading';
		var t = setTimeout(function() {
			h.className = h.className.replace(/(\s|^)wf-loading(\s|$)/g, '');
			h.className += ' wf-inactive';
		}, TypekitConfig.scriptTimeout);
		var tk = document.createElement('script');
		tk.src = '//use.typekit.com/' + TypekitConfig.kitId + '.js';
		tk.type = 'text/javascript';
		tk.async = 'true';
		tk.onload = tk.onreadystatechange = function() {
			var rs = this.readyState;
			if (rs && rs != 'complete' && rs != 'loaded') return;
			clearTimeout(t);
			try { Typekit.load(TypekitConfig); } catch (e) {}
		};
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(tk, s);
	})(); </script>
		";
		echo $script;
	}
	add_action( 'typekit', 'astro_load_typekit', 10, 1 );

	// google fonts
	function astro_load_googlefonts($families) {
		$script = "
<script>
  WebFontConfig = {
    google: { families: [ '" . $families . "' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>		
		";
		echo $script;
	}
	add_action( 'googlefont', 'astro_load_googlefonts', 10, 1 );




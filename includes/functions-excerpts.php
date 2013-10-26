<?php 

// EXCERPTS -------------------------------------------------------------------------------- //


	function control_excerptlength_post($length) { return 40; }
	function control_excerptlength_home($length) { return 30; }
	function control_excerptlength_featured($length) { return 50; }
	
	function control_excerpt_readmore($more) {
		return ' ... <a class="readmore" href="'. get_permalink() .'">' . __( 'read more', '' ) . '</a>';
	}
	
	function control_excerpt($length_callback='', $more_callback='') {
		global $post;
		if(function_exists($length_callback)) {
			add_filter('excerpt_length', $length_callback);
		}
		if(function_exists($more_callback)) {
			add_filter('excerpt_more', $more_callback);
		}

		$output = get_the_excerpt();
		$output = apply_filters('wptexturize', $output);
		$output = apply_filters('convert_chars', $output);
		$output = '<p class="excerpt">'.$output.'</p>';
		echo $output;
	}

	// template usage: control_excerpt('control_excerptlength_post', 'control_excerpt_readmore', ' ');


	// credit: http://goo.gl/dcgMHK
	function get_excerpt_by_id($post_id){
		// gets post ID
	    $the_post = get_post($post_id); 
	    // gets post_content to be used as a basis for the excerpt
	    $the_excerpt = $the_post->post_content; 
	    // sets excerpt length by word count
	    $excerpt_length = 35; 
	    // strips tags and images
	    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); 
	    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

	    if(count($words) > $excerpt_length) :
	        array_pop($words);
	        array_push($words, '…');
	        $the_excerpt = implode(' ', $words);
	    endif;

	    $the_excerpt = '<p>' . $the_excerpt . '</p>';

	    return $the_excerpt;
	}



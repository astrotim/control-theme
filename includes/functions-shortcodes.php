<?php

// SHORTCODES -------------------------------------------------------------------------------- //


// clear div shortcode
	function clear_div() {
		return "<div class='clearfix'></div>\n";
	}
	add_shortcode('break', 'clear_div');


// youtube shortcode
	function ctrl_youtube_embed($atts) {
		extract( shortcode_atts( array(
			'id' => '0',
			'width' => '560',
			'height' => '315'
		), $atts ) );

		return '<div class="video"><iframe width="' . $width . '" height="' . $height . '" src="http://www.youtube.com/embed/'. $id .'?autohide=1&showinfo=0&wmode=opaque" frameborder="0" allowfullscreen></iframe></div>';
	}
	add_shortcode('youtube', 'ctrl_youtube_embed');


// button shortcode
	function ctrl_button_code($atts) {
		extract( shortcode_atts( array(
			'colour' => 'blue',
			'link' => '',
			'text' => ''
		), $atts));

		return '<a class="btn '. $colour . '" href="' . $link . '">' . $text . '</a>';
	}
	add_shortcode('button', 'ctrl_button_code');


// add HR button to tinyMCE
	function enable_more_buttons($buttons) {
	  $buttons[] = 'hr';

	  return $buttons;
	}
	add_filter("mce_buttons", "enable_more_buttons");




<script>
// define $ alias if using WP's no-conflict mode
jQuery(function($) {
	$(window).load(function() {
	    $(".flexslider").flexslider({
	        // animation: "slide",
	    });
	});
});
</script> 

<div class="flexslider">
	<ul class="slides">

<?php 

	$rows = get_field('slide');
	if($rows) {

		foreach($rows as $row) {
			$output = "<li style='background-image: url(". $row['bg_image'] .");'>\n";
			// $output .= "  <img src='". $row['bg_image'] ."'>\n";
			$output .= "  <div class='slide-text'>\n";
			$output .= "  <h2>". $row['slide_heading'] ."</h2>\n";
			$output .= "  " . $row['slide_text'];
			$output .= "  </div>\n";
			$output .= "</li>\r\n\n";

			echo $output;
		} 
	}
?>
	</ul>
</div>
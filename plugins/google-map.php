<?php 

// geocode an address
	function ast_gmap_geocode ( $address ) {
		// make Google Geocoding API
		$map_url = 'http://maps.google.com/maps/api/geocode/json?address=';
		$map_url .= urlencode( $address ) . '&sensor=false';

		// send GET request
		$request = wp_remote_get( $map_url );

		// get JSON object
		$json = wp_remote_retrieve_body( $request );

		// make sure the request was successful or return false
		if( empty( $json ) )
			return false;

		// decode the JSON object
		$json = json_decode( $json );

		// get coordinates
		$lat  = $json->results[0]->geometry->location->lat; // latitude
		$long = $json->results[0]->geometry->location->lng; // longitude

		// return array of latitude and longitude
		return compact( 'lat', 'long' );
	}

	// $coodrs = ast_gmap_geocode( '30 Inkerman Street, St Kilda VIC' );

	// var_dump( $coodrs );

	// convert a  plain text address into lat/long 
	// retrieved from meta data if available, or get fresh then cached otherwise
	function ast_gmap_get_coords( $address = '30 Inkerman Street, St Kilda VIC' ) {

		//current post id
		global $id;

		// check if coordinates are in the database
		$saved = get_post_meta( $id, 'ast_gmap_addresses' );
		foreach( (array)$saved as $_saved ) {
			if( isset ($_saved['address']) && $_saved['address'] == $address) {
				extract($_saved);
				return compact( 'lat' , 'long' );
			}
		}

	// coordinates not cached - get fresh ones
	$coords = ast_gmap_geocode( $address );
	if( !$coords )
		return false;

	// cache result in a post meta data
	add_post_meta( $id, 'ast_gmap_addresses', array(
			'address' => $address,
			'lat' => $coords['lat'],
			'long' => $coords['long']
		)
	);

		extract( $coords );
		return compact( 'lat', 'long');

	}


	// add the shortcode
	add_shortcode( 'googlemap', 'ast_gmap_generate_map' );

	//the shortcode callback
	function ast_gmap_generate_map( $attr, $address ) {

			//set the map default
			$defaults = array(
				'width' => '100%',
				'height' => '400',
				'zoom' => 17
			);

		// get the map attributes (set to defaults if omitted)
		// extract imports variables from the array, eg: $width = 400
		extract( shortcode_atts( $defaults, $attr ) );

		// get coordinates
		$coord = ast_gmap_get_coords( $address );

		// make sure we have coords, otherwise return empty
		if (!$coord) 
			return '';

		// output for th shortcode
		$output = '';

		// populate lat and long
		extract($coord);

		//sanitize the variables, depending on context
        $lat     = esc_js( $lat );
        $long    = esc_js( $long );
        $address = esc_js( $address );
        $zoom    = esc_js( $zoom );
        $width   = esc_attr( $width );
        $height  = esc_attr( $height );

        // check if width is defined
        if ($width == '100%') {
        	$width = $width;
        } else {
        	$width = $width . "px";
        }
        $height = $height . 'px';

		// generate a unique map ID so we can have multiple maps on a page
		$map_id = 'ast_map_'.md5( $address );


		    // Add the map specific code
		    $output .= <<<CODE
		    <div id="$map_id" class="google-map" style="width: $width; height: $height;"></div>
		    
		    <script>
		    function generate_$map_id() {
		        var latlng = new google.maps.LatLng( $lat, $long );
		        var options = {
		            zoom: $zoom,
		            center: latlng,
		            mapTypeId: google.maps.MapTypeId.ROADMAP
		        }

		        var map = new google.maps.Map(
		            document.getElementById("$map_id"),
		            options
		        );

		        var marker = new google.maps.Marker({
		            position: latlng,
		            map: map,
		        });

		    }

		    generate_$map_id();
		    
		    </script>

		    
CODE;

		return $output;
	}

 ?>
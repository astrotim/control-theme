<?php

// gravity forms labels
	function change_prefix($label, $form_id){
	    return "Title";
	}
	add_filter("gform_name_prefix", "change_prefix", 10, 2);


	function change_address_city($label, $form_id){
	    return "Suburb";
	}
	add_filter("gform_address_city", "change_address_city", 10, 2);


	function change_address_state($label, $form_id){
	    return "State";
	}
	add_filter("gform_address_state", "change_address_state", 10, 2);


	function change_address_zip($label, $form_id){
	    return "Postcode";
	}
	add_filter("gform_address_zip", "change_address_zip", 10, 2);


// add default FIELDNAME value because the input is hidden
	function default_FIELDNAME($value){
	    return '-';
	}
	add_filter('gform_field_value_FIELDNAME', 'default_FIELDNAME');

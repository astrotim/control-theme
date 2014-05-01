<?php

// -- PAGINATION --------------------------------------------------------------------------- //


	function ctrl_pagination() {

	    global $wp_query;
	    $total_pages = $wp_query->max_num_pages;

	    if ($total_pages > 1){
		    $current_page = max(1, get_query_var('paged'));

		    $args = array (
		    	'type' => 'list',
		    	'show_all' => 'true',
		    	'prev_text'    => __('&lt;'),
			    'next_text'    => __('&gt;'),
				'base' => get_pagenum_link(1) . '%_%',
				'format' => '/page/%#%',
				'current' => $current_page,
				'total' => $total_pages,
	 	    );

		    echo '<div class="pagination">';
			    echo paginate_links( $args );
		    echo '</div>';
	    }
    }

    function ctrl_cpt_pagination() {

    	global $wp_query;
	    $total_pages = $wp_query->max_num_pages;

	    if ($total_pages > 1) {
		    // test for current page
		    ($wp_query->query_vars['paged'] > 1) ? $current = $wp_query->query_vars['paged'] : $current = 1;

		    $big = 999999999;

		    $pagination = array (
		    	'type' => 'list',
		    	'show_all' => true,
		    	'prev_text'    => __('&lt;'),
			    'next_text'    => __('&gt;'),
				'base' => @add_query_arg('page','%#%'),
				'format' => '',
				'current' => $current,
				'total' => $total_pages,
	 	    );

		    echo '<div class="pagination">';
			    echo paginate_links( $pagination );
		    echo '</div>';
	    }
	}


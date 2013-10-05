<?php 

// SEARCH  --------------------------------------------------------------------------- //

if(SEARCH) {

     function astro_search_form( $form ) {

         $form = '<form class="navbar-search pull-right" role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
         <input type="search" name="s" id="s" class="search-query" placeholder="Search this site..." />
         <button class="search-icon" type="submit" id="searchsubmit">Search</button>
         </form>';

         return $form; // template usage: get_search_form()
     }

     add_filter( 'get_search_form', 'astro_search_form' );


	// search all taxonomies, based on: 
	// http://projects.jesseheap.com/all-projects/wordpress-plugin-tag-search-in-wordpress-23
	function atom_search_where($where){
	  global $wpdb;
	  if (is_search())
	    $where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish')";
	  return $where;
	}

	function atom_search_join($join){
	  global $wpdb;
	  if (is_search())
	    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
	  return $join;
	}

	function atom_search_groupby($groupby){
	  global $wpdb;

	  // we need to group on post ID
	  $groupby_id = "{$wpdb->posts}.ID";
	  if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

	  // groupby was empty, use ours
	  if(!strlen(trim($groupby))) return $groupby_id;

	  // wasn't empty, append ours
	  return $groupby.", ".$groupby_id;
	}

	add_filter('posts_where','atom_search_where');
	add_filter('posts_join', 'atom_search_join');
	add_filter('posts_groupby', 'atom_search_groupby');
}


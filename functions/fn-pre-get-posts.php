<?php
/**
 * Pre Get Posts
 *
 * @package Control
 */


  function ctrl_blog_index_order( $query ) {
      if (is_admin())
      return;

      // where query runs
      if ( is_home() && $query->is_main_query() )
          $query->query_vars['orderby'] = 'menu_order';
          $query->query_vars['order'] = 'DESC';
      return $query;
  }
  // add_action( 'pre_get_posts', 'ctrl_blog_index_order' );

  function ctrl_posts_per_taxonomy( $query ) {
      if (is_admin())
      return;

      // where query runs
      if ( is_tax() && $query->is_main_query() )
          $query->set( 'posts_per_page', '30' );
      return $query;
  }
  // add_action( 'pre_get_posts', 'ctrl_posts_per_taxonomy' );

  function ctrl_query_vars( $query ) {
      if (is_admin())
      return;

      // where query runs
      if ( is_front_page() && $query->is_main_query() )
          $query->query_vars['orderby'] = 'title';
          $query->query_vars['order'] = 'desc';
      return $query;
  }
  // add_action( 'pre_get_posts', 'ctrl_query_vars' );
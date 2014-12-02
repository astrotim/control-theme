<?php
/**
 * Search form functions
 *
 * @package Control
 */



  /**
   * empty search query
   * if 's' request variable is set but empty
   *
   * @link [http://www.evagoras.com/2012/11/01/how-to-handle-and-customize-an-empty-search-query-in-wordpress/]
   */
  function ctrl_search_filter($query) {
      if (isset($_GET['s']) && empty($_GET['s']) && $query->is_main_query()){
          $query->is_search = true;
          $query->is_home = false;
      }
      return $query;
  }
  add_filter('pre_get_posts','ctrl_search_filter');




  /**
   * number of search results
   *
   * @todo define NUMBER
   */
  function ctrl_search_results_number( $query ) {
      if (is_admin())
      return;

      // where query runs
      if ( $query->is_search )
          $query->set( 'posts_per_page', '50' );
      return $query;
  }
  // add_action( 'pre_get_posts', 'ctrl_search_results_number' );




  /**
   * Group search results by post type
   *
   */
  function ctrl_group_by_post_type($orderby, $query) {
      global $wpdb;
      if ($query->is_search) {
          return $wpdb->posts . '.post_type ASC';
      }
      return $orderby;
  }
  // add_filter('posts_orderby', 'ctrl_group_by_post_type', 10, 2);




  /**
   * custom search form output
   *
   * @todo define form name, label, id, class, placeholder
   */
  // function ctrl_search_form_NAME() {

  //   $form  = '<div class="search-by-NAME form-group">';
  //   $form .= '  <label for="label-name">label</label>';
  //   $form .= '  <input id="hidden-name-field" type="hidden" name="s">';
  //   $form .= '  <input type="TYPE" id="NAME-ID" class="NAME-CLASS form-control" placeholder="PLACEHOLDER">';
  //   $form .= '  <button type="submit">Go</button>';
  //   $form .= '</div>';

  //   return $form;
  // }




  /**
   * custom search results by meta query
   *
   * @todo define QUERYVAR
   */
  function ctrl_custom_search_results($query) {

      if (is_admin())
      return;

      if (!$query->is_main_query())
      return;

      // get original meta query
      $meta_query = $query->get('meta_query');

      if (isset($_GET['QUERYVAR']) && !empty($_GET['QUERYVAR'] )) {
          $QUERYVAR = explode(',' , $_GET['QUERYVAR']);

          //Add our meta query to the original meta queries
          $meta_query[] = array(
            'key' => 'QUERYVAR',
            'value' => $QUERYVAR,
            'compare' => 'IN'
          );
      }

      // update the meta query args
      $query->set('meta_query', $meta_query);

      return $query;
  }
  // add_filter('pre_get_posts','ctrl_custom_search_results');



  /**
   * search all taxonomies
   *
   * @link [http://projects.jesseheap.com/all-projects/wordpress-plugin-tag-search-in-wordpress-23]
   */
  function ctrl_search_where($where){
    global $wpdb;
    if (is_search())
      $where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish')";
    return $where;
  }
  // add_filter('posts_where','ctrl_search_where');

  function ctrl_search_join($join){
    global $wpdb;
    if (is_search())
      $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
    return $join;
  }
  // add_filter('posts_join', 'ctrl_search_join');

  function ctrl_search_groupby_type($groupby){
    global $wpdb;

    // we need to group on post ID
    $groupby_type = "{$wpdb->posts}.post_type";
    if(!is_search() || strpos($groupby, $groupby_type) !== false) return $groupby;

    // groupby was empty, use ours
    if(!strlen(trim($groupby))) return $groupby_type;

    // wasn't empty, append ours
    return $groupby.", ".$groupby_type;
  }
  // add_filter('posts_groupby', 'ctrl_search_groupby_type');



  /**
   * Copy meta field to 'post_content' so that it is searchable
   *
   * @link [http://wordpress.stackexchange.com/questions/126764/using-a-custom-field-instead-of-original-title-field-but-only-for-custom-post-ty#answer-126777]
   *
   * @todo define META_FIELD and 'cpt'
   */
  function ctrl_copy_META_FIELD_to_post_content($post_id) {
    if(get_post_type( $post_id ) !== 'acf') {

      global $_POST;
      if('cpt' === get_post_type()) {
        $post_ingredients = get_post_meta($post_id,'META_FIELD',true);
        $my_post = array();
            $my_post['ID'] = $post_id;
            $my_post['post_content'] = $post_ingredients;
          remove_action('acf/save_post', 'ctrl_copy_META_FIELD_to_post_content');
                wp_update_post( $my_post );
          add_action('acf/save_post', 'ctrl_copy_META_FIELD_to_post_content');
      }

    }
  }
  // add_action('acf/save_post', 'ctrl_copy_META_FIELD_to_post_content', 20);


<?php
/**
 * Post functions
 *
 * @package Control
 */


  /**
   * remove 'Uncategorised' from category link list
   *
   */
  function ctrl_cat_link() {

    $exclude = array("Uncategorized");
    $separator = " / ";
    $new_the_category = '';

    foreach((get_the_category()) as $category) {
      if ($category->category_parent == 0) {
        if (!in_array($category->cat_name, $exclude)) {
          $new_the_category .= '<a href="'.get_bloginfo(url).'/'.get_option('category_base').'/'.$category->slug.'">'.$category->name.'</a>'.$separator;
        }
      }
    }

    return substr($new_the_category, 0, strrpos($new_the_category, $separator));

  }



  /**
   * get current category/taxonomy object
   *
   */
  function ctrl_get_current_term_object($post_id, $taxonomy) {

    $terms = wp_get_post_terms($post_id, $taxonomy, array("fields" => "all"));

    if(!$terms) return false;

    $term_object = $terms[0];

    return $term_object;

  }

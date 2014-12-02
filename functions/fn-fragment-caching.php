<?php
/**
 * Fragment Caching
 *
 * stores blocks of content as HTML in options table
 *
 * @uses purge-transients.php plugin
 * @link [https://github.com/Seebz/Snippets/blob/master/Wordpress/plugins/purge-transients/purge-transients.php]
 *
 * @package Control
 */

  function fragment_cache($key, $ttl, $function) {

    // if ( is_user_logged_in() ) {
    //  call_user_func($function);
    //  return;
    // }

    $key = apply_filters('fragment_cache_prefix','fragment_cache_') . $key;
    $output = get_transient($key);

    if ( false === $output ) {
      ob_start();
      call_user_func($function);
      $output = ob_get_clean();
      set_transient($key, $output, $ttl);
    }

    echo $output;
  }

  function fragment_cache_random_prefix() {

    return get_option('random_prefix');
  }
  add_action('fragment_cache_prefix', 'fragment_cache_random_prefix');

  function clear_fragment_cache() {

    $random = rand(0,999);
    update_option('random_prefix','rand' . $random . '_fragment_');
  }
  add_action('save_post','clear_fragment_cache');
  // add_action('w3tc_flush_all', 'clear_fragment_cache');
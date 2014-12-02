<?php

/**
 * Template redirects
 *
 */


/**
 * Redirect to child page
 *
 */
function ctrl_redirect_to_child_page() {

    // use page ID
    if(is_page('parent-page')) {
        wp_redirect( home_url('/parent-page/sub-page/'));
        exit();
    }

}
// add_action('template_redirect', 'ctrl_redirect_to_child_page');


/**
 * Redirect if not logged in
 *
 */
function ctrl_redirect_if_not_logged_in() {

    if( !is_user_logged_in() ) {
      $origin = urlencode( home_url($_SERVER['REQUEST_URI']) );
      $location = home_url('/wp-login.php?redirect_to=') . $origin;
      wp_redirect( $location ); exit;
    }

}
// add_action('template_redirect', 'ctrl_redirect_if_not_logged_in');


/**
 * Redirect tag archives to main blog page
 */
function ctrl_redirect_tag_archives() {

    if ( is_tag() ) {
        wp_redirect( home_url('/news/'));
        exit();
    }
}
// add_action('template_redirect', 'ctrl_redirect_tag_archives');


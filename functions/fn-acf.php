<?php
/**
 * Advanced Custom Fields utilities
 *
 * @package Control
 */



  /**
   * Options page
   *
   */
  // if( function_exists('acf_add_options_page') ) {

  //   $partners = acf_add_options_page(array(
  //     'page_title'  => 'PageName',
  //     'menu_title'  => 'PageName',
  //     'menu_slug'   => 'acf-options-pagename',
  //     'position'    => '20.1'
  //   ));

  // }



  /**
   * Admin CSS & JavaScript
   *
   */
  function ctrl_acf_admin_css_js() {

    wp_enqueue_style( 'ctrl_acf_admin_style', get_template_directory_uri() . '/acf/acf-admin-style.css' );
    wp_enqueue_script( 'ctrl_acf_admin_script', get_template_directory_uri() . '/acf/acf-admin-script.js', null, null, true );

  }
  add_action( 'admin_enqueue_scripts', 'ctrl_acf_admin_css_js' );



  /**
   * ACF wysiwyg toolbar
   *
   */
  function ctrl_acf_toolbars($toolbars) {

    /*
    echo '<pre>';
      print_r($toolbars); // view format of $toolbars
    echo '</pre>';
    die;
    */

    $toolbars['Custom'] = array();
    $toolbars['Custom'][1] = array(
      'bold' , 'italic' , 'underline',
      'blockquote', 'strikethrough',
      'bullist', 'numlist',
      'justifyleft', 'justifycenter', 'justifyright',
      'undo', 'redo',
      'link', 'unlink',
      'code'
      );

    return $toolbars;

  }
  // add_filter( 'acf/fields/wysiwyg/toolbars' , 'ctrl_acf_toolbars'  );


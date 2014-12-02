<?php
/* WooCommerce get_template functions */

/**
 * Get template part (for templates like the shop-loop).
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function wc_get_template_part( $slug, $name = '' ) {
  $template = '';

  // Look in yourtheme/slug-name.php and yourtheme/woocommerce/slug-name.php
  if ( $name ) {
    $template = locate_template( array( "{$slug}-{$name}.php", WC()->template_path() . "{$slug}-{$name}.php" ) );
  }

  // Get default slug-name.php
  if ( ! $template && $name && file_exists( WC()->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
    $template = WC()->plugin_path() . "/templates/{$slug}-{$name}.php";
  }

  // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/woocommerce/slug.php
  if ( ! $template ) {
    $template = locate_template( array( "{$slug}.php", WC()->template_path() . "{$slug}.php" ) );
  }

  // Allow 3rd party plugin filter template file from their plugin
  $template = apply_filters( 'wc_get_template_part', $template, $slug, $name );

  if ( $template ) {
    load_template( $template, false );
  }
}

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function wc_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
  if ( $args && is_array( $args ) ) {
    extract( $args );
  }

  $located = wc_locate_template( $template_name, $template_path, $default_path );

  if ( ! file_exists( $located ) ) {
    _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
    return;
  }

  do_action( 'woocommerce_before_template_part', $template_name, $template_path, $located, $args );

  include( $located );

  do_action( 'woocommerce_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *    yourtheme   / $template_path  / $template_name
 *    yourtheme   / $template_name
 *    $default_path / $template_name
 *
 * @access public
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function wc_locate_template( $template_name, $template_path = '', $default_path = '' ) {
  if ( ! $template_path ) {
    $template_path = WC()->template_path();
  }

  if ( ! $default_path ) {
    $default_path = WC()->plugin_path() . '/templates/';
  }

  // Look within passed path within the theme - this is priority
  $template = locate_template(
    array(
      trailingslashit( $template_path ) . $template_name,
      $template_name
    )
  );

  // Get default template
  if ( ! $template ) {
    $template = $default_path . $template_name;
  }

  // Return what we found
  return apply_filters('woocommerce_locate_template', $template, $template_name, $template_path);
}
?>
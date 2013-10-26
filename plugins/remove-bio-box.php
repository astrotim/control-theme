<?php # -*- coding: utf-8 -*-
// declare( encoding = 'UTF-8' );
/**
 * Plugin Name: Remove Bio Box
 * Description: Removes the user biography field.
 * Version:     2012.01.14
 * Author:      Thomas Scholz
 * Author URI:  http://toscho.de
 * License:     GPL
 *
 * See also: http://wordpress.stackexchange.com/q/38819/73
 *
 * Remove Bio Box, Copyright (C) 2011 Thomas Scholz
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

! defined( 'ABSPATH' ) and exit;

add_action( 'personal_options', array ( 'T5_Hide_Profile_Bio_Box', 'start' ) );

/**
 * Captures the part with the biobox in an output buffer and removes it.
 *
 * @author Thomas Scholz, <info@toscho.de>
 *
 */
class T5_Hide_Profile_Bio_Box
{
	/**
	 * Called on 'personal_options'.
	 *
	 * @return void
	 */
	public static function start()
	{
		$action = ( IS_PROFILE_PAGE ? 'show' : 'edit' ) . '_user_profile';
		add_action( $action, array ( __CLASS__, 'stop' ) );
		ob_start();
	}

	/**
	 * Strips the bio box from the buffered content.
	 *
	 * @return void
	 */
	public static function stop()
	{
		$html = ob_get_contents();
		ob_end_clean();

		// remove the headline
		$headline = __( IS_PROFILE_PAGE ? 'About Yourself' : 'About the user' );
		$html = str_replace( '<h3>' . $headline . '</h3>', '', $html );

		// remove the table row
		$html = preg_replace( '~<tr>\s*<th><label for="description".*</tr>~imsUu', '', $html );
		print $html;
	}
}
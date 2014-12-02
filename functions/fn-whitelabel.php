<?php
/**
 * Whitelabel functions
 *
 * @package Control
 */



  /**
   * login page
   *
   * display client logo, change login URL & header title, favicon
   */
	function ctrl_change_admin_logo() { ?>
		<style>
		body.login {
			background: #f9f9f9;
		}
		#login {
			padding-top: 20px;
		}
		#login h1 a {
			background: url(<?php bloginfo('template_directory') ?>/images/logo.svg) no-repeat center;
			background-size: 220px 170px;
			width: auto;
			height: 170px;
		}
		</style> <?php
	}
	add_action("login_head", "ctrl_change_admin_logo");

	function ctrl_change_login_url() {
		return site_url();
	}
	add_filter( 'login_headerurl', 'ctrl_change_login_url', 10, 4 );

	function ctrl_change_login_header_title() {
		return get_bloginfo('name');
	}
	add_filter('login_headertitle','ctrl_change_login_header_title');

	function ctrl_admin_favicon() {
		echo '<link rel="shortcut icon" type="image/x-icon" href="'.get_bloginfo('template_directory').'/images/favicon.ico?2" />';
	}
	add_action('admin_head', 'ctrl_admin_favicon');


  /**
   * video widget on dashboard
   *
   * @todo set vimeo ID and NAME_OF_VIDEO
   */
	function ctrl_dashboard_videos() { ?>
		<p>NAME_OF_VIDEO</p>
        <iframe class="vimeo" src="http://player.vimeo.com/video/XXXXXXXXX?title=0&amp;byline=0&amp;portrait=0" width="460" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	<?php }

	function ctrl_dashboard_widgets() {
		global $wp_meta_boxes;

		wp_add_dashboard_widget('ctrl_preview_widget', 'Video Guides', 'ctrl_dashboard_videos');
	}
	// add_action('wp_dashboard_setup', 'ctrl_dashboard_widgets');




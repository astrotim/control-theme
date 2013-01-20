<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">

<?php if(theme_has(RESPONSIVE)) : ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php endif; ?>	

<title><?php if (wp_title()) { wp_title(); } else { echo bloginfo('name'); } ?></title>

<!--[if lt IE 9]> 
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php if(theme_has(BOOTSTRAP)) : ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/bootstrap/bootstrap.css" />
<?php endif; ?>	

<?php if(theme_has(RESPONSIVE)) : ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/bootstrap/responsive.css" />	
<?php endif; ?>	

<?php if(is_page('contact')) : ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('home'); ?>/wp-content/plugins/gravityforms/css/forms.css" />
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>?v=<?php fileVersion('style.css'); ?>" />

<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon">

<?php wp_head(); ?>

<?php // astro_load_typekit('XXXXXX'); ?>
<?php // astro_load_googlefonts('XXXXXX'); ?>

<?php if( theme_has(GOOGLEMAP) && is_page('contact') ): ?>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>				
<?php endif ?>

</head>
<body <?php body_class(); ?>>

<div id="wrapper">

<header id="site-header" class="group">
	
	<hgroup>
		<h1 id="logo"><a href="<?php bloginfo('home'); ?>"><?php bloginfo('name'); ?></a></h1>
		<h2 id="tagline"><?php bloginfo('description'); ?></h2>
	</hgroup>

	<nav id="nav" class="navbar navbar-static" role="navigation">
	  <div class="navbar-inner">
	    <div class="container">
			<?php wp_nav_menu( array(
			     'container' => 'null',
			     'menu_class' => 'nav',
			     'theme_location' => 'primary',
			) ); ?>
	    </div> <!-- .container -->
	  </div> <!-- .navbar-inner -->
	</nav> <!-- #nav -->

</header>
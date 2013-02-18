<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">

<?php if(RESPONSIVE) : ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php endif; ?>	

<title><?php if (wp_title()) { wp_title(); } else { echo bloginfo('name'); } ?></title>

<!--[if lt IE 9]> 
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php if(BOOTSTRAP) : ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/bootstrap/bootstrap.css" />
<?php endif; ?>	

<?php if(RESPONSIVE) : ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/bootstrap/responsive.css" />	
<?php endif; ?>	

<?php if(is_page('contact')) : 
do_action( 'gravitycss' );
endif; ?>

<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>?v=<?php fileVersion('style.css'); ?>" />

<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon">

<?php wp_head(); ?>

<?php // do_action('typekit', 'XXXXXX'); ?>
<?php // do_action('googlefont', 'Francois+One::latin'); ?>

</head>
<body <?php body_class(); ?>>

<div id="wrapper">

<header id="site-header" class="group">
	
	<hgroup>
		<h1 id="logo"><a href="<?php home_url('/'); ?>"><?php bloginfo('name'); ?></a></h1>
		<h2 id="tagline"><?php bloginfo('description'); ?></h2>
	</hgroup>

	<div id="search">
		<?php get_search_form(); ?>
	</div>

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
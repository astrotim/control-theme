<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php wp_title( ' ', true, 'right' ); ?></title>

<!--[if lt IE 9]> 
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php wp_head(); ?>

<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon">
<!-- Google +
<link rel="author" href="https://plus.google.com/XXXXXXXXX"> -->
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php // do_action('typekit', 'XXXXXX'); ?>
<?php // do_action('googlefont', 'Name_Of+Font::style'); ?>

</head>
<body <?php body_class(); ?>>

<div class="wrapper">

<header class="site-header" class="group" role="banner">
	
		<h1 class="logo"><a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a></h1>
		<h2 class="tagline"><?php bloginfo('description'); ?></h2>

	<div id="search" class="search" role="search">
		<?php get_search_form(); ?>
	</div>

	<nav class="nav navbar navbar-static" role="navigation">
	  <div class="navbar-inner">
	    <div class="container">
			<?php wp_nav_menu( array(
			     'container' => 'null',
			     'menu_class' => 'nav',
			     'theme_location' => 'primary',
			) ); ?>
	    </div> <!-- .container -->
	  </div> <!-- .navbar-inner -->
	</nav> <!-- nav -->

</header>
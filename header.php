<!doctype html>
<!--[if lt IE 8 ]><html class="no-js ie-old ie-lt8" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie-old ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js ie-old ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php wp_title( ' ', true, 'right' ); ?></title>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php wp_head(); ?>
<!--[if lt IE 9]>
<script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
<![endif]-->
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon">
<!-- Google +
<link rel="author" href="https://plus.google.com/XXXXXXXXX"> -->
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php // control_load_typekit('XXXXXX'); ?>

</head>
<body <?php body_class('loading'); ?>>
<!--[if lte IE 9]>
    <div aria-hidden="true" class="browsehappy"><strong>Seriously?</strong> You're using a <em>terribly old</em>&nbsp; version of Internet Explorer.<br> You really should <a href="http://browsehappy.com/?locale=en">upgrade</a>, you'll find the web works much better in a modern browser.<br>
    I recommend Google Chrome, it's fast, secure and works on this PC. <strong><a href="https://www.google.com/chrome/">Do it!</a></strong> <button class="close">&times;</button></div>
<![endif]-->

<div class="wrapper">

<header class="site-header group" role="banner">

	<h1 class="logo">
		<a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a>
	</h1>
	<h2 class="tagline"><?php bloginfo('description'); ?></h2>

	<div id="search" class="search" role="search">
		<?php get_search_form(); ?>
	</div>

      <div class="nav-bg">
        <nav class="main-nav" role="navigation">
        <?php wp_nav_menu( array(
          'container_class' => null,
          'menu_class' => null,
          'theme_location' => 'primary',
        ) ); ?>
        </nav>
      </div>

      <button class="button nav-toggle" aria-hidden="true">Navigation</button>

</header>
<!doctype html>
<html>
<meta charset="utf-8">
<head>
<title>CRT Style Guide</title>
<link rel="stylesheet" href="<?php echo bloginfo('template_directory'); ?>/style.dev.css">
</head>
<body <?php body_class();?>>

<div class="wrapper">

  <h1 class="logo"><a href="#">CRT - Your local bloke</a></h1>

  <?php

  ctrl_get_partial('colors', 'styleguide');

  ctrl_get_partial('mainnav', 'styleguide');

  ctrl_get_partial('type', 'styleguide');

  ctrl_get_partial('buttons', 'styleguide');

  ctrl_get_partial('icons', 'styleguide');

  ctrl_get_partial('layout', 'styleguide');

  ctrl_get_partial('images', 'styleguide');

  ctrl_get_partial('tables', 'styleguide');

  ctrl_get_partial('forms', 'styleguide');

  ctrl_get_partial('sidenav', 'styleguide');

  ctrl_get_partial('list-panel', 'styleguide');

  ctrl_get_partial('contact', 'styleguide');

  ?>

</div>
<!-- .wrapper -->

<script src="<?php echo bloginfo('template_directory'); ?>/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/modernizr.min.js"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/conditionizr.min.js"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/utilities.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/project.js"></script>

<!-- <script src="//localhost:35729/livereload.js"></script> -->

</body>
</html>
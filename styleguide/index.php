<?php
  $project_name = "Everyday Gourmet";
  $dev = true;
?>
<!doctype html>
<!--[if lt IE 9 ]><html class="no-js ie-old ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js ie-old ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $project_name; ?> Style Guide</title>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600|Rock+Salt|Special+Elite' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="styleguide.css" media="all">
<link rel="stylesheet" type="text/css" href="extra.css" media="all">
<!--[if lt IE 9]>
<script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
<![endif]-->
<!-- <link rel="shortcut icon" href="../images/favicon.png" type="image/png"> -->
<link rel="icon" href="../images/favicon.ico" type="image/x-icon">

</head>
<body class="styleguide">

<div class="wrapper">

<header class="site-header clearfix" role="banner">

  <div class="container">

    <h1 class="logo">
        <a href="./"><?php echo $project_name; ?></a>
    </h1>
    <h2>Style Guide</h2>

  </div>
  <!-- .container -->

  <div class="nav-bg">
    <nav class="main-nav container" role="navigation">
      <ul class="nav">
        <li class="active"><a href="#colors">Colour Palette</a></li>
        <li><a href="#type">Typography</a></li>
        <li><a href="#layout">Layout</a></li>
        <li><a href="#buttons">Buttons</a></li>
        <li><a href="#icons">Icons</a></li>
        <li><a href="#images">Images</a></li>
        <li><a href="#video">Video</a></li>
        <li><a href="#forms">Forms</a></li>
        <li><a href="#tables">Tables</a></li>
        <!-- <li class="favourites"><a href="#">Nav Item</a></li> -->
      </ul>
    </nav>

    <div class="trim-pink" aria-hidden="true"><div class="stitching"></div></div>

  </div>
  <!-- .nav-bg -->

</header>

<main class="body-content main" role="main">

  <div class="container">

      <div class="main-column">

          <?php include('layout.php'); ?>

          <?php include('colors.php'); ?>

          <?php include('type.php'); ?>

          <?php include('buttons.php'); ?>

          <?php include('icons.php'); ?>

          <?php include('images.php'); ?>

          <?php include('video.php'); ?>

          <?php include('forms.php'); ?>

          <?php include('tables.php'); ?>

          <?php //include('other.php'); ?>

      </div>
      <!-- .main-column -->

  </div>
  <!-- .container -->


</main> <!-- .body-content[role="main"] -->


<footer role="contentinfo">

  <div class="container">

    <p id="copyright">&copy; Copyright <?php echo date('Y'); ?> <?php echo $project_name; ?></p>

  </div>
  <!-- .container -->

</footer>

</div> <!-- .wrapper -->

<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/modernizr.min.js"></script>
<script src="../js/conditionizr.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scroll-to.min.js"></script>
<script src="../js/project.js"></script>

<?php if ($dev) : ?>
<!-- remove for production -->
<script src="//localhost:35729/livereload.js"></script>
<?php endif; ?>
</body>
</html>
<?php 
$sc_jdt = get_option('seedprod_comingsoon_options'); 
global $seedprod_comingsoon;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>DJ Semper-Fi :: new website coming soon</title>

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<meta name="robots" content="noindex,nofollow" />

<style> 
*, html {
    margin: 0;
    padding: 0;
}
html, body, .wrapper {
	height: 100%;
}
body {
	background-image: url('http://www.djsemperfi.com/wp-content/uploads/2013/11/bg.jpg');
	background-size: cover;
	background-position: center;
	background-repeat: no-repeat;
}

.wrapper {
	width: 95%;
	max-width: 510px;
	margin: 0 auto;
}

.outer {
	display: table;
	width: 100%;
	height: 100%;
}
.inner {
	display: table-cell;
	text-align: center;
	vertical-align: middle;
	width: 100%;
}

.aligncenter {
	width: 100%;
	max-width: 500px;
	height: auto;
	margin: 20px 0;
	border-radius: 3px;
	box-shadow: 0 0 0 2px white;
}

iframe {
	max-width: 504px;
}

.socials {
	margin: 5% 0 0;
	padding-bottom: 20px;
	font-size: 0;
	text-align: center;
}

.socials li {
	display: inline-block;
	margin: 0 5px;
}

.socials li a {
	background: url('http://www.djsemperfi.com/wp-content/uploads/2013/11/Flat-Social-Media-Icons.png') no-repeat;
	background-position: -210px -280px;
	width: 48px;
	height: 48px;
	display: block;
	opacity: .6;
	-webkit-transition: opacity .2s ease;
	-moz-transition: opacity .2s ease;
	transition: opacity .2s ease;
}

.socials li a:hover {
	opacity: 1;
}

.socials li.fb a {background-position: 0 0; }
.socials li.bc a {background-position: -420px -280px; }
.socials li.tw a {background-position: -70px 0; }
.socials li.gp a {background-position: -210px 0; }

@media screen and (max-width: 767px) {

	body {
		background-image: none;
		background-color: #e9e9e9;
	}

}

@media screen and (max-width: 360px) {

	.socials li a {
		width: 24px;
		height: 24px;
		background-size: 234px 164px;
		background-position: -105px -140px;
	}

	.socials li.bc a {background-position: -210px -140px; }
	.socials li.tw a {background-position: -35px 0; }
	.socials li.gp a {background-position: -105px 0; }

}


</style>

</head>
<body>

<div class="wrapper">

<div class="outer">
     <div class="inner">

		<?php echo shortcode_unautop(wpautop(convert_chars(wptexturize($sc_jdt['comingsoon_description'])))) ?>

        <?php if(!empty($sc_jdt['comingsoon_customhtml'])): ?>
            <?php echo $sc_jdt['comingsoon_customhtml'] ?>
        <?php endif; ?>

     </div>
</div>

</div>

</body>
</html>

<?php exit(); ?>
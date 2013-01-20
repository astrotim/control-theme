<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article <?php post_class(); ?>>

	<div id="page">

		<header id='page-heading'>
			<h1><?php the_title(); ?></h1>
		</header>

		<div id="page-body">

		<?php the_content(); ?>

		</div> <!-- #page-body -->

	</div> <!-- #page -->

</article><!-- .post -->

<?php endwhile; endif; ?>
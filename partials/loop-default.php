<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article <?php post_class(); ?>>

	<?php if(has_post_thumbnail()) : ?>
		<div class="post-thumb">	
				<?php the_post_thumbnail(); ?>
		</div>
	<?php endif; ?>

	<div id="post">

		<header id="post-header" class="group">

			<h1><?php the_title(); ?></h1>

			<div class="date"><?php the_date('jS F Y'); ?></div>

		</header>

		<div id="post-body">

			<?php the_content(); ?>

		</div> <!-- #post-body -->

	</div> <!-- #post -->

</article><!-- .post -->

<?php endwhile; endif; ?>
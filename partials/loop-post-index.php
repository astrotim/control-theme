<?php
		if( have_posts() ): 

		// continue with loop					
		while( have_posts() ): the_post();
?>

<article <?php post_class('group'); ?>>

		<?php if(has_post_thumbnail()) : ?>
		<div class="post-thumb">	
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>

		<div class="post-excerpt">

			<h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			<div class="date"><?php the_date('jS F Y'); ?></div>

			<div class="tags">
				<?php echo get_the_term_list( $post->ID, 'post_tag', '', ' &bull; ', '' ); ?>
			</div>

			<?php the_excerpt(); ?>

			<a href="<?php the_permalink(); ?>">Read Full Story</a> &bull; 
			<?php if (get_comments_number() > 0 ) : ?>
				<?php comments_number( 'No comments', '1 comment', '% comments' ); ?>
			<?php endif; ?>

		</div><!-- .post-excerpt -->

</article><!-- .post -->

<?php 
		endwhile; 

		// pagination
		astro_pagination();

		else :

			echo '<p>No posts found</p>';

		endif; 

?>
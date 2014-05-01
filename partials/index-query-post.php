<?php

		// SET UP PAGINATION - display posts from the current page or set the 'paged' parameter to 1
		$paged = 1;
		if ( get_query_var('paged') ) $paged = get_query_var('paged');
		if ( get_query_var('page') )  $paged = get_query_var('page');

		$args = array (
			'author'			=> '',
			'cat'				=> '',
			'tag'				=> '',
			'tax_query'			=> array(),
			'post__in'			=> '',
			'post__not_in'		=> '',
			'post_parent'		=> '',
			'post_type' 		=> 'custom_post_type',
			'posts_per_page'	=> 10,
			'paged' 			=> $paged,
			'order'				=> 'DESC',
			'orderby'			=> 'date',
			'year' 				=> 2013,
			'meta_query' 		=> array(),
			'no_found_rows'		=> true,
			'cache_results' 	=> true,
			's' 				=> $s,
			'exact' 			=> true,
		);

		$the_query = new WP_Query( $args );

		if( $the_query->have_posts() ):

		// continue with loop
		while( $the_query->have_posts() ) :

			$the_query->the_post();

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
		ctrl_pagination();

		endif;

		// reset post query if using more than one loop on a page
		wp_reset_postdata();
?>
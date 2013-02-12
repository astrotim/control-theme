<?php get_header(); ?>

<div id="body-content">

			<header id="page-heading">
				<h1><?php printf( __( 'Search results for %s', '' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php $title = get_the_title(); $keys= explode(" ",$s); $title = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-excerpt">\0</strong>', $title); ?>

<article class="post group">

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
			<span class="meta tags"><?php echo get_the_term_list( $post->ID, 'post_tag', '', ' ' ); ?></span>

		</div><!-- .post-excerpt -->

</article><!-- .post -->

	<?php endwhile; else : ?>

				<article id="post-0" class="post no-results not-found">

					<h3 class="entry-title"><?php _e( 'Nothing Found', '' ); ?></h3>
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', '' ); ?></p>

				</article><!-- #post-0 -->

<?php endif; ?>
</div> <!-- #body-content -->

<?php get_footer(); ?>
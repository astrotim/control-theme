<?php
/*
The comments page for Bones
*/

// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  if ( post_password_required() ) { ?>
  	<div class="alert alert-info"><?php _e("This post is password protected. Enter the password to view comments.",""); ?></div>
  <?php
    return;
  }
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>

	<h3 id="comments"><?php comments_number('<span>' . __("No","") . '</span> ' . __("Responses","") . '', '<span>' . __("One","") . '</span> ' . __("Response","") . '', '<span>%</span> ' . __("Responses","") );?> <?php _e("to",""); ?> &#8220;<?php the_title(); ?>&#8221;</h3>


	<ol class="commentlist">
		<?php wp_list_comments( array('reverse_top_level' => false) ); ?>
	</ol>
	
  
	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
    	<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>

			<!-- If comments are closed. -->
			<p class="alert alert-info"><?php _e("Comments are closed",""); ?>.</p>			

	<?php endif; ?>

<?php endif; ?>


<?php if ( comments_open() ) : ?>

<section id="respond" class="respond-form">

	<h3 id="comment-form-title"><?php comment_form_title( __("Leave a Comment",""), __("Leave a Reply to","") . ' %s' ); ?></h3>

	<p class="not-published">Your email address will not be published.</p>

	<div id="cancel-comment-reply">
		<p class="small"><?php cancel_comment_reply_link( __("Cancel","") ); ?></p>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
  	<div class="help">
  		<p><?php _e("You must be",""); ?> <a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e("logged in",""); ?></a> <?php _e("to post a comment",""); ?>.</p>
  	</div>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="form-vertical" id="commentform">

	<?php if ( is_user_logged_in() ) : ?>

	<p class="comments-logged-in-as"><?php _e("Logged in as",""); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e("Log out of this account",""); ?>"><?php _e("Log out",""); ?> &raquo;</a></p>

	<?php else : ?>
	
	<ul id="comment-form-elements" class="group">
		
		<li>
			<div class="control-group">
			  <label for="author"><?php _e("Name",""); ?> <?php if ($req) echo "(required)"; ?></label>
			  <div class="input-prepend">
			  	<span class="add-on"><i class="icon-user"></i></span><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e("Your Name (required)",""); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
			  </div>
		  	</div>
		</li>
		
		<li>
			<div class="control-group">
			  <label for="email"><?php _e("Mail",""); ?> <?php if ($req) echo "(required)"; ?></label>
			  <div class="input-prepend">
			  	<span class="add-on"><i class="icon-envelope"></i></span><input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e("Your Email (required)",""); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
			  	<span class="help-inline">(<?php _e("will not be published",""); ?>)</span>
			  </div>
		  	</div>
		</li>
		
<!-- 		<li>
			<div class="control-group">
			  <label for="url"><?php _e("Website",""); ?></label>
			  <div class="input-prepend">
			  <span class="add-on"><i class="icon-home"></i></span><input type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" placeholder="<?php _e("Your Website",""); ?>" tabindex="3" />
			  </div>
		  	</div>
		</li> -->
		
	</ul>

	<?php endif; ?>
	
	<div class="group">
		<div class="input">
			<textarea name="comment" id="comment" placeholder="<?php _e("Your Comment Here…",""); ?>" tabindex="4" rows="6"></textarea>
		</div>
	</div>
	
	  <input class="btn btn-primary" name="submit" type="submit" id="submit" tabindex="5" value="<?php _e("Submit Comment",""); ?>" />
	  <?php comment_id_fields(); ?>
	
	<?php 
		//comment_form();
		do_action('comment_form()', $post->ID); 
	
	?>
	
	</form>
	
	<?php endif; // If registration required and not logged in ?>
</section>

<?php endif; // if you delete this the sky will fall on your head ?>

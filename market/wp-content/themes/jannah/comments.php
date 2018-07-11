<?php
/**
 * The template for displaying comments
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ){
	return;
}

if ( have_comments() || comments_open() ) : ?>
	<div id="comments" class="comments-area">

		<?php if ( have_comments() ) : ?>
			<div id="comments-box" class="container-wrapper">

				<div class="block-head">
					<h3 id="comments-title">
						<?php
							$comments_number = get_comments_number();
							if ( 1 === $comments_number ){
								/* translators: %s: post title */
								printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'jannah' ), get_the_title() );
							} else {
								printf(
									/* translators: 1: number of comments, 2: post title */
									_nx(
										'%1$s thought on &ldquo;%2$s&rdquo;',
										'%1$s thoughts on &ldquo;%2$s&rdquo;',
										$comments_number,
										'comments title',
										'jannah'
									),
									number_format_i18n( $comments_number ),
									get_the_title()
								);
							}
						?>
					</h3>
				</div><!-- .block-head /-->

				<?php the_comments_navigation(); ?>

				<ol class="comment-list">
					<?php
						wp_list_comments( array(
							'style'       => 'ol',
							'short_ping'  => true,
							'avatar_size' => 70,
						) );
					?>
				</ol><!-- .comment-list -->

				<?php the_comments_navigation(); ?>

			</div><!-- #comments-box -->
		<?php endif; // Check for have_comments(). ?>


		<?php comment_form(); ?>

	</div><!-- .comments-area -->

<?php endif; // Check for have_comments() || comments_open() ?>

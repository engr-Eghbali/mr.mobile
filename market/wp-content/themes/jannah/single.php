<?php
/**
 * The template part for displaying single posts
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

<?php

	$post_layout = jannah_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' );
	$post_layout = ! empty( $post_layout ) ? $post_layout : 1;

	if ( have_posts() ) : while ( have_posts()): the_post(); ?>

		<div <?php jannah_content_column_attr(); ?>>

			<?php

			# Above Post Banner ----------
			jannah_above_post_ad();

			?>

			<article <?php jannah_article_attr(); ?>>

				<?php

				# Before post title action ----------
				do_action( 'jannah_before_single_post_title' );


				if( $post_layout == 2 || $post_layout == 3 || $post_layout == 4 || $post_layout == 5 || $post_layout == 8 ){
					get_template_part( 'framework/parts/post', 'featured' );
				}

				if( $post_layout == 1 || $post_layout == 2 || $post_layout == 6 ){
					get_template_part( 'framework/parts/post', 'head' );
				}

				# Get the top share buttons ----------
				jannah_get_template_part( 'framework/parts/post', 'share', array( 'share_position' => 'top' ) );

				if( $post_layout == 1 ){
					get_template_part( 'framework/parts/post', 'featured' );
				}

				?>

				<div class="entry-content entry clearfix">

					<?php

					# Above Post content action ----------
					do_action( 'jannah_below_post_content' );

					$story_highlights = jannah_get_postdata( 'tie_highlights_text' );
					if( ! empty( $story_highlights ) && is_array( $story_highlights ) ){
						echo '
							<div id="story-highlights">
								<div class="widget-title"><h4>'. __ti( 'خلاصه مطلب' ) .'</h4></div>
								<ul>';
									foreach( $story_highlights as $highlight ){
										echo '<li>'. $highlight .'</li>';
									}
									echo '
								</ul>
							</div>
						';
					}

					the_content();

					# Post content navigation ----------
					$args = array(
						'before'         => '<div class="multiple-post-pages clearfix">',
						'after'          => '</div>',
						'link_before'    => '<span>',
						'link_after'     => '</span>',
						'next_or_number' => 'next_and_number',
					);
					wp_link_pages( $args );

					# Get post tags ----------
					if( ( jannah_get_option( 'post_tags' ) && ! jannah_get_postdata( 'tie_hide_tags' ) ) || jannah_get_postdata( 'tie_hide_tags' ) == 'no' ){
						the_tags( '<div class="post-tags"><div class="tags-title"><span class="fa fa-tags" aria-hidden="true"></span> '. __ti( 'Tags' ) .'</div><span class="tagcloud">'  ,' ', '</span></div>');
					}

					# Below Post content action ----------
					do_action( 'jannah_below_post_content' );

					?>

				</div><!-- .entry-content /-->

				<?php

				# End of Post action ----------
				do_action( 'jannah_end_of_post' );

				# Get the bottom share buttons ----------
				jannah_get_template_part( 'framework/parts/post', 'share', array( 'share_position' => 'bottom' ) );

				?>

			</article><!-- #the-post /-->


			<?php

			# Below Post Banner ----------
			jannah_below_post_ad();

			?>


			<div class="post-components">
				<?php

				# Get About author box ----------
				if( (( jannah_get_option( 'post_authorbio' ) && ! jannah_get_postdata( 'tie_hide_author' ) ) || jannah_get_postdata( 'tie_hide_author' ) == 'no' ) && ! jannah_is_mobile_and_hidden( 'post_authorbio' ) ){
					jannah_author_box( get_the_author(), get_the_author_meta( 'ID' ) );
				}

				# Newsletter box ----------
				get_template_part( 'framework/parts/post', 'newsletter' );

				# Next / Prev posts ----------
				if( (( jannah_get_option( 'post_nav' ) && ! jannah_get_postdata( 'tie_hide_nav' ) ) || jannah_get_postdata( 'tie_hide_nav' ) == 'no' ) && ! jannah_is_mobile_and_hidden( 'post_nav' ) ){

					echo'<div class="prev-next-post-nav container-wrapper media-overlay">';
					jannah_prev_post();
					jannah_next_post();
					echo '</div><!-- .prev-next-post-nav /-->';
				}

				# Related posts ----------
				get_template_part( 'framework/parts/post', 'related' );

				# Comments ----------
				comments_template();

				?>
			</div><!-- .post-components /-->

		</div><!-- .main-content -->

		<?php

		# Fly check also ----------
		get_template_part( 'framework/parts/post', 'fly-box' );

	endwhile; endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

<?php
/**
 * The template for displaying pages
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

<?php

	# Page Builder ----------
	if( jannah_get_postdata( 'tie_builder_active' ) ):

		# Get Blocks ----------
		get_template_part( 'framework/blocks' );

		# Below the Post action ----------
		do_action( 'jannah_below_the_post' );


	# Normal Page ----------
	else: ?>

		<div <?php jannah_content_column_attr(); ?>>

		<?php
		if ( have_posts() ) : while ( have_posts()): the_post();

			# Above Post Banner ----------
			jannah_above_post_ad(); ?>

			<article <?php jannah_article_attr(); ?>>

				<?php

				# Before post title action ----------
				do_action( 'jannah_before_single_post_title' );


				# Get the page title ----------
				get_template_part( 'framework/parts/page', 'head' );

				# Get the top share buttons ----------
				jannah_get_template_part( 'framework/parts/post', 'share', array( 'share_position' => 'top' ) );

				?>

				<div class="entry-content entry clearfix">

					<?php

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

			# below the Post action ----------
			do_action( 'jannah_below_the_post' );

			# Below Post Banner ----------
			jannah_below_post_ad();
			?>


			<div class="post-components">
				<?php

				# Comments ----------
				comments_template();

				?>
			</div><!-- .post-components /-->

			<?php
		endwhile; endif;
		?>

		</div><!-- .main-content -->

		<?php
		get_sidebar();
	endif;
	?>

<?php get_footer(); ?>

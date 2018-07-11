<?php
/**
 * The main template file
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

	<div <?php jannah_content_column_attr(); ?>>

		<?php if ( have_posts() ) :

			# Default layout ----------
			$layout = jannah_get_option( 'blog_display', 'excerpt' );

			# Default Excerpt length ----------
			$excerpt_length = jannah_get_option( 'blog_excerpt_length' );


			# Get the layout template part ----------
			jannah_get_template_part( 'framework/parts/archives', '', array(
				'layout'          => $layout,
				'excerpt_length'  => $excerpt_length,
			));


			# Page navigation ----------
			$pagination = jannah_get_option( 'blog_pagination' );

			jannah_pagination( array( 'type' => $pagination ) );

		# If no content, include the "No posts found" template ----------
		else :
			get_template_part( 'framework/parts/not-found' );

		endif;

		?>

	</div><!-- .main-content /-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

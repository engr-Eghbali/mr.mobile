<?php
/**
 * The template for displaying author pages
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

	<div <?php jannah_content_column_attr(); ?>>

		<?php if ( have_posts() ) : ?>

			<header class="entry-header-outer container-wrapper">
				<?php
					jannah_breadcrumbs();
					the_archive_title( '<h1 class="page-title">', '</h1>' );

					# Author bio ----------
					if( jannah_get_option( 'author_bio' ) ){
						jannah_author_box();
					}
				?>
			</header><!-- .entry-header-outer /-->

			<?php

			# Author layout ----------
			$layout = jannah_get_option( 'author_layout', 'excerpt' );

			# Author Excerpt length ----------
			$excerpt_length = jannah_get_option( 'author_excerpt_length' );


			# Get the layout template part ----------
			jannah_get_template_part( 'framework/parts/archives', '', array(
				'layout'          => $layout,
				'excerpt_length'  => $excerpt_length,
			));


			# Page navigation ----------
			$pagination = jannah_get_option( 'author_pagination' );

			jannah_pagination( array( 'type' => $pagination ) );

		# If no content, include the "No posts found" template ----------
		else :
			get_template_part( 'framework/parts/not-found' );

		endif;

		?>

	</div><!-- .main-content /-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

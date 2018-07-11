<?php
/**
 * The template for displaying search results pages
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

	<div <?php jannah_content_column_attr(); ?>>

		<?php if ( have_posts() ) : ?>

			<header class="entry-header-outer container-wrapper">
				<?php jannah_breadcrumbs(); ?>
				<h1 class="page-title"><?php printf( __ti( 'Search Results for: %s' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
			</header><!-- .entry-header-outer /-->

			<?php

			# Archive layout ----------
			$layout = jannah_get_option( 'search_layout', 'excerpt' );

			# Archive Excerpt length ----------
			$excerpt_length = jannah_get_option( 'search_excerpt_length' );


			# Get the layout template part ----------
			jannah_get_template_part( 'framework/parts/archives', '', array(
				'layout'          => $layout,
				'excerpt_length'  => $excerpt_length,
			));


			# Page navigation ----------
			$pagination = jannah_get_option( 'search_pagination' );

			jannah_pagination( array( 'type' => $pagination ) );

		# If no content, include the "No posts found" template ----------
		else :
			get_template_part( 'framework/parts/not-found' );

		endif;

		?>

	</div><!-- .main-content /-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

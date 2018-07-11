<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package Jannah
 */
?>

	<header class="entry-header-outer container-wrapper">
		<h1 class="page-title"><?php _eti( 'Nothing Found' ); ?></h1>
	</header><!-- .entry-header-outer /-->

	<div class="mag-box not-found">
		<div class="container-wrapper">

			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

				<h5><?php printf( wp_kses_post( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'jannah' )), esc_url( admin_url( 'post-new.php' ) ) ); ?></h5>

			<?php elseif ( is_search() ) : ?>

				<h5><?php _eti( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.' ); ?></h5>
				<?php get_search_form(); ?>

			<?php else : ?>

				<h5><?php _eti( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.' ); ?></h5>
				<?php get_search_form(); ?>

			<?php endif; ?>

		</div><!-- .container-wrapper /-->
	</div><!-- .mag-box /-->

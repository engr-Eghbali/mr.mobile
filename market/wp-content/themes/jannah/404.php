<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

	<div <?php jannah_content_column_attr(); ?>>

		<div class="container-404">

			<h2><?php _eti( '404 :(' ); ?></h2>
			<h3><?php _eti( 'Oops! That page can&rsquo;t be found.' ); ?></h3>
			<h4><?php _eti( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.' ); ?></h4>

			<div id="content-404">
				<?php get_search_form(); ?>
			</div><!-- #content-404 /-->

			<?php
				if( has_nav_menu( '404-menu' ) ){
					wp_nav_menu(
						array(
							'menu_id'        => 'menu-404',
							'container_id'   => 'menu-404',
							'theme_location' => '404-menu',
							'depth'          => 1,
						));
				}
			?>

		</div><!-- .container-404 /-->

	</div><!-- .main-content /-->

<?php get_footer(); ?>

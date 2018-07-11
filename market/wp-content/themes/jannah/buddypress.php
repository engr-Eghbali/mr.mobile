<?php
/**
 * The template for displaying BuddyPress
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

<?php
	if ( have_posts() ) : while ( have_posts()): the_post();

		if( ( function_exists( 'bp_is_user' ) && ! bp_is_user() ) && ! jannah_bp_get_page_data( 'tie_hide_title' ) ){
			?>
			<header class="buddypress-header-outer">
				<div class="container">
					<?php jannah_breadcrumbs() ?>
					<div class="entry-header">
						<h1 class="name post-title entry-title"><?php the_title(); ?></h1>
					</div><!-- .entry-header /-->
				</div>
			</header><!-- .entry-header-outer /-->
			<?php
		}

		the_content();

	endwhile; endif;
?>

<?php
# Load the masonry.js library ----------
wp_enqueue_script( 'jquery-masonry' );
?>

<?php get_footer(); ?>

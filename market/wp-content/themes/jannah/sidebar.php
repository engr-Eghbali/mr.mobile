<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


# Returen if the current page is full width or one column ----------
if( ! jannah_has_sidebar() ) return;

# Check if the sidebars is hidden on mobiles ----------
if( jannah_is_mobile_and_hidden( 'sidebars' )) return;


# Sticky Sidebar ----------
$is_sticky = jannah_get_option( 'sticky_sidebar' ) ? true : false;


# Home Page ----------
if ( is_home() || is_front_page() ){
	$sidebar = jannah_get_option( 'sidebar_home' );
}
# BuddyPress ----------
elseif( JANNAH_BUDDYPRESS_IS_ACTIVE && is_buddypress() ){
	$sidebar   = jannah_bp_get_page_data( 'tie_sidebar_post' );
	$is_sticky = jannah_bp_get_page_data( 'tie_sticky_sidebar' ) ? jannah_bp_get_page_data( 'tie_sticky_sidebar' ) : $is_sticky;
}
# bbPress ----------
elseif ( JANNAH_BBPRESS_IS_ACTIVE && is_bbpress() ){
	$sidebar = jannah_get_option( 'sidebar_bbpress' );
}
# Pages ----------
elseif( is_page() ){
	$sidebar   = jannah_get_object_option( 'sidebar_page', '', 'tie_sidebar_post' );
	$is_sticky = jannah_get_object_option( 'sticky_sidebar', '', 'tie_sticky_sidebar' );
}
# Posts ----------
elseif ( is_single() ){
	$sidebar   = jannah_get_object_option( 'sidebar_post', 'cat_sidebar', 'tie_sidebar_post' );
	$is_sticky = jannah_get_object_option( 'sticky_sidebar', 'cat_sticky_sidebar', 'tie_sticky_sidebar' );
}
# Categories ----------
elseif ( is_category() ){
	$sidebar   = jannah_get_object_option( 'sidebar_archive', 'cat_sidebar', '' );
	$is_sticky = jannah_get_object_option( 'sticky_sidebar', 'cat_sticky_sidebar', '' );
}
# All Archives ----------
else{
	$sidebar = jannah_get_option( 'sidebar_archive' );
}

# Default sidebar if there is no a custom sidebar ----------
if( empty( $sidebar ) || ( ! empty( $sidebar ) && ! jannah_is_registered_sidebar( $sidebar ) )){
	 $sidebar = 'primary-widget-area';
}

# Show the sidebar if contains Widgets ----------
if( is_active_sidebar( $sidebar ) ){

		$sidebar_class = 'sidebar tie-col-md-4 tie-col-xs-12 normal-side';

		if( $is_sticky && $is_sticky !== "no" ){
			$sidebar_class .= ' is-sticky';
		}
	?>

	<aside class="<?php echo esc_attr( $sidebar_class ) ?>" aria-label="<?php esc_html_e( 'Primary Sidebar', 'jannah' ); ?>">
		<div class="theiaStickySidebar">
			<?php dynamic_sidebar( sanitize_title( $sidebar ) ); ?>
		</div><!-- .theiaStickySidebar /-->
	</aside><!-- .sidebar /-->
	<?php
}
?>

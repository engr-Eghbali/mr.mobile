<?php
/**
 * Social functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





/*-----------------------------------------------------------------------------------*/
# Custom Classes for header
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_header_class' )){

	add_filter( 'jannah_header_class', 'jannah_header_class' );
	function jannah_header_class( $custom = '' ){

		# Custom Classes defined in the header.php file ----------
		$classes = explode( ' ', $custom );

		# Header Layout ----------
		$header_layout = jannah_get_option( 'header_layout', 3 );
		$classes[] = 'header-layout-'.$header_layout;

		# Main Nav Skin ----------
		$classes[] = jannah_get_option( 'main_nav_dark' ) ? 'main-nav-dark' : 'main-nav-light';

		# Main Nav position ----------
		$classes[] = jannah_get_option( 'main_nav_position' ) ? 'main-nav-above' : 'main-nav-below';

		# Boxed Layout ----------
		if( jannah_get_option( 'main_nav_layout' ) && $header_layout != 1 ){
			$classes[] = 'main-nav-boxed';
		}

		# Top Nav classes ----------
		if( jannah_get_option( 'top_nav' ) ){

			$classes[] = 'top-nav-active';

			# Top Nav Dark Skin ----------
			$classes[] = jannah_get_option( 'top_nav_dark' ) ? 'top-nav-dark' : 'top-nav-light';

			# Boxed Layout ----------
			$classes[] = jannah_get_option( 'top_nav_layout' ) ? 'top-nav-boxed' : '';

			# Check if the top nav is below the header ----------
			$classes[] = jannah_get_option( 'top_nav_position' ) ? 'top-nav-below' : 'top-nav-above';
		}


		# Header Shadow ----------
		$classes[] = jannah_get_option( 'header_disable_shadows' ) ? '' : 'has-shadow';

		# Top Nav Below the Main Nav ----------
		if( ! jannah_get_option( 'main_nav_position' ) && jannah_get_option( 'top_nav' ) && jannah_get_option( 'top_nav_position' ) ){
			$classes[] = 'top-nav-below-main-nav';
		}

		echo 'class="'. implode( ' ', array_filter( $classes ) ) .'"';
	}

}





/*-----------------------------------------------------------------------------------*/
# Custom Classes for body
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_body_class' )){

	add_filter( 'body_class', 'jannah_body_class' );
	function jannah_body_class( $classes ){

		# Theme layout ----------
		$theme_layout = jannah_get_object_option( 'theme_layout', 'cat_theme_layout', 'tie_theme_layout' );

		if( JANNAH_BUDDYPRESS_IS_ACTIVE && is_buddypress() && jannah_bp_get_page_data( 'tie_theme_layout' ) ){
			$theme_layout = jannah_bp_get_page_data( 'tie_theme_layout' );
		}

		if( $theme_layout == 'boxed' ){
			$classes[] = 'boxed-layout'; // Boxed
		}
		elseif( $theme_layout == 'framed' ){
			$classes[] = 'boxed-layout framed-layout'; // Framed
		}
		elseif( $theme_layout == 'border' ){
			$classes[] = 'border-layout'; // Border
		}


		# Site Width Class ----------
		if( strpos( jannah_get_option( 'site_width' ), '%' ) !== false ){
			$classes[] = 'is-percent-width';
		}


		# Wrapper Shadow ----------
		if( ! jannah_get_option( 'wrapper_disable_shadows' ) ){
			$classes[] = 'wrapper-has-shadow';
		}


		/*
		# Magazine Layout ----------
		if( jannah_get_option( 'boxes_style' ) ){
			$classes[] = 'magazine'.jannah_get_option( 'boxes_style' );
		}
		*/


		# Custom Body CLasses ----------
		if( jannah_get_option( 'body_class' ) ){
			$classes[] = jannah_get_option( 'body_class' );
		}


		# Enable Theme Dark Skin ----------
		if( jannah_get_option( 'dark_skin' ) ){
			$classes[] = 'dark-skin';
		}


		# Enable Images Lazy Load ----------
		if( jannah_get_option( 'lazy_load' ) ){
			$classes[] = 'is-lazyload';
		}


		# Disable the Post Format icon overlay ----------
		if( ! jannah_get_option( 'thumb_overlay' ) ){
			$classes[] = 'is-thumb-overlay-disabled';
		}

		# is-mobile or desktop ----------
		$classes[] = jannah_is_handheld() ? 'is-mobile' : 'is-desktop';


		# Page Builder Classes ----------
		if( is_page() && jannah_get_postdata( 'tie_builder_active' ) ){
			$classes[] = 'has-builder';

			if( jannah_get_postdata( 'tie_header_extend_bg' ) ){
				$classes[] = 'is-header-bg-extended';
			}
		}
		else{
			$sidebar_position = jannah_get_sidebar_position();

			$GLOBALS['jannah_has_sidebar'] = true;

			if( $sidebar_position == 'full-width' ){

				$GLOBALS['jannah_has_sidebar'] = false;

				# Set the Full width content_width size ----------
				$GLOBALS['content_width'] = 1220;

				# Show 4 products per row for WooCommerce ----------
				add_filter( 'loop_shop_columns', 'jannah_wc_full_width_loop_shop_columns', 99, 1 );
			}
			elseif( $sidebar_position == 'one-column-no-sidebar' ){
				$GLOBALS['jannah_has_sidebar'] = false;
			}

			$classes[] = $sidebar_position;


			# Posts and pages layout ----------
			if( is_single() ){

				# Post Layout ----------
				$post_layout = jannah_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' );
				$post_layout = ! empty( $post_layout ) ? $post_layout : 1;

				$post_layout_class = 'narrow-title-narrow-media';

				if( $post_layout == 3 ){
					$post_layout_class = 'wide-title-narrow-media';
				}
				elseif( $post_layout == 6 ){
					$post_layout_class = 'wide-media-narrow-title';
				}
				elseif( $post_layout == 7 ){
					$post_layout_class = 'full-width-title-full-width-media';
				}
				elseif( $post_layout == 8 ){
					$post_layout_class = 'centered-title-big-bg';
				}

				$classes[] = 'post-layout-' . $post_layout;
				$classes[] = $post_layout_class;
			}
			elseif( is_page() || ( JANNAH_BBPRESS_IS_ACTIVE && is_bbpress() ) ){
				$classes[] = 'post-layout-1';
			}

			# Mobile Share buttons ----------
			if( is_singular() && jannah_get_option( 'share_post_mobile' )){
				$classes[] = 'has-mobile-share';
			}

		}


		# Hide Hedaer and Footer ----------
		if( is_page() ){

			# Hide the header ----------
			if( jannah_get_postdata( 'tie_hide_header' )){
				$classes[] = 'without-header';
				add_filter('jannah_is_header_active', '__return_false');
			}

			# Hide the footer ----------
			if( jannah_get_postdata( 'tie_hide_footer' )){
				$classes[] = 'without-footer';
				add_filter('jannah_is_footer_active', '__return_false');
			}
		}


		# Mobile show more button ----------
		if( is_singular( 'post' ) && jannah_get_option( 'mobile_post_show_more' )){
			$classes[] = 'post-has-toggle';
		}


		# Hide some elements on mobiles ----------
		$mobile_elements = array(
			'banner_top',
			'banner_below_header',
			'banner_bottom',
			'breaking_news',
			'sidebars',
			'footer',
			'copyright',
			'breadcrumbs',
			'share_post_top',
			'share_post_bottom',
			'post_newsletter',
			'related',
			'post_authorbio',
			'post_nav',
			'back_top_button'
		);

		foreach ( $mobile_elements as $element ){
			if( jannah_get_option( 'mobile_hide_'.$element )){
				$classes[] = 'hide_' . $element;
			}
		}

		return $classes;
	}

}





/*-----------------------------------------------------------------------------------*/
# Get Sidebar Position
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_sidebar_position' )){

	function jannah_get_sidebar_position(){

		# 404 page is full width by default ----------
		if( is_404() ){
			$sidebar = 'full-width';
		}
		else{
			# Default Sidebar Position ----------
			$sidebar = 'sidebar-right has-sidebar';

			if( jannah_get_option( 'sidebar_pos' ) ){
				$sidebar_position = jannah_get_option( 'sidebar_pos' );
			}

			# WooCommerce sidebar position ----------
			if( JANNAH_WOOCOMMERCE_IS_ACTIVE && is_product() && jannah_get_option( 'woo_product_sidebar_pos' )){
				$sidebar_position = jannah_get_option( 'woo_product_sidebar_pos' );
			}

			# WooCommerce sidebar position ----------
			elseif( JANNAH_WOOCOMMERCE_IS_ACTIVE && is_woocommerce() && jannah_get_option( 'woo_sidebar_pos' )){
				$sidebar_position = jannah_get_option( 'woo_sidebar_pos' );
			}

			# buddyPress Sidebar Settings ----------
			elseif( JANNAH_BUDDYPRESS_IS_ACTIVE && is_buddypress() ){
				$sidebar_position = jannah_bp_get_page_data( 'tie_sidebar_pos' );
			}

			# bbPress Sidebar Settings ----------
			elseif( JANNAH_BBPRESS_IS_ACTIVE && is_bbpress() ){
				$sidebar_position = jannah_get_option( 'bbpress_sidebar_pos' );
			}

			# Custom Sidebar Position for posts, pages and categories ----------
			else{
				$sidebar_position = jannah_get_object_option( 'sidebar_pos', 'cat_sidebar_pos', 'tie_sidebar_pos' );
			}

			# Add the sidebar class ----------
			if( $sidebar_position == 'left' ){
				$sidebar = 'sidebar-left has-sidebar';
			}
			elseif( $sidebar_position == 'full' ){
				$sidebar = 'full-width';
			}
			elseif( $sidebar_position == 'one-column' ){
				$sidebar = 'one-column-no-sidebar';
			}
		}

		return $sidebar;
	}

}





/*-----------------------------------------------------------------------------------*/
# Get Post Classes
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_post_class' )){

	function jannah_get_post_class( $classes = false, $post_id = null, $standard = false ){


		if( $standard ){
 			$classes = join( ' ', get_post_class( $classes ));
 			$classes = str_replace( 'hentry', '', $classes );
		}


		$post_format = jannah_get_postdata( 'tie_post_head', false, $post_id );

		if( ! empty( $post_format )){

			if( ! empty( $classes )){
				$classes .= ' ';
			}

			$classes .= 'tie_'.$post_format;
		}

		if( ! empty( $classes )){
			return 'class="'.$classes.'"';
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# print Post Classes
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_post_class' )){

	function jannah_post_class( $classes = false, $post_id = null, $standard = false ){

		$classe = jannah_get_post_class( $classes, $post_id, $standard );

		if( ! empty( $classes ) ){
			echo ( $classe );
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Article Attributes
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_article_attr' )){

	function jannah_article_attr( $attrs = array() ){

		# Defaults ----------
		$attrs = wp_parse_args( $attrs, array(
			'id'        => 'id="the-post"',
			'class'     => jannah_get_post_class( 'container-wrapper post-content' ),
			// 'itemscope' => 'itemscope',
			// 'itemtype' 	=> 'itemtype="http://schema.org/'. $article_type .'"',
		));

		echo implode( ' ', array_filter( $attrs ) );
	}

}





/*-----------------------------------------------------------------------------------*/
# Comments
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_comment_form_before' )){

	add_action( 'comment_form_before', 'jannah_comment_form_before', 22 );
	function jannah_comment_form_before(){
		echo '<div id="add-comment-block" class="container-wrapper">';
	}

}


if( ! function_exists( 'jannah_comment_form_after' )){

	add_action( 'comment_form_after', 'jannah_comment_form_after', 11 );
	function jannah_comment_form_after(){
		echo '</div><!-- #add-comment-block /-->';
	}

}





/*-----------------------------------------------------------------------------------*/
# Main Content Column attributes
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_content_column_attr' )){

	function jannah_content_column_attr( $echo = true ){

		$columns_classes = 'tie-col-md-8 tie-col-xs-12';

		if( ! jannah_get_postdata( 'tie_builder_active' ) ){

			$sidebar_position = jannah_get_sidebar_position();

			if( $sidebar_position == 'full-width' ){
				$columns_classes = 'tie-col-md-12';
			}
		}


		$attr = apply_filters( 'jannah_content_column_attr', 'class="main-content '. $columns_classes .'" role="main"' );

		if( ! $echo ){
			return $attr;
		}

		echo ( $attr );
	}

}





/*-----------------------------------------------------------------------------------*/
# Before Content markup
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_before_main_content' )){

	add_action( 'jannah_before_main_content', 'jannah_before_main_content' );
	function jannah_before_main_content(){

		if( ( JANNAH_BUDDYPRESS_IS_ACTIVE && is_buddypress() ) || ( is_page() && jannah_get_postdata( 'tie_builder_active' ) )){
			return;
		}
		jannah_html_before_main_content();
	}

}


if( ! function_exists( 'jannah_html_before_main_content' )){

	function jannah_html_before_main_content(){

		echo '
			<div id="content" class="site-content container">
				<div class="tie-row main-content-row">
		';
	}

}





/*-----------------------------------------------------------------------------------*/
# After Content markup
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_after_main_content' )){

	add_action( 'jannah_after_main_content', 'jannah_after_main_content' );
	function jannah_after_main_content(){

		if( ( JANNAH_BUDDYPRESS_IS_ACTIVE && is_buddypress() ) || ( is_page() && jannah_get_postdata( 'tie_builder_active' ) )){
			return;
		}
		jannah_html_after_main_content();
	}

}

if( ! function_exists( 'jannah_html_after_main_content' )){

	function jannah_html_after_main_content(){
		echo '
				</div><!-- .main-content-row /-->
			</div><!-- #content /-->
		';
	}

}

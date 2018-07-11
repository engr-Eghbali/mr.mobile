<?php
/**
 * Open graph functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*-----------------------------------------------------------------------------------*/
# Open Graph Meta for posts
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_opengraph' ) ){

	add_action( 'wp_head', 'jannah_opengraph' );
	function jannah_opengraph(){

		# Check if single and og is active and there is no OG plugin is active ----------
		if( jannah_is_opengraph_active() || ! is_singular() || ! jannah_get_option( 'post_og_cards' )){
			return;
		}

		$post           = get_post();
		$og_title       = the_title_attribute( 'echo=0' ) . ' - ' . get_bloginfo('name') ;
		$og_description = esc_attr( apply_filters( 'jannah_exclude_content', $post->post_content ) );
		$og_type        = 'article';

		if( is_home() || is_front_page() ){
			$og_title       = get_bloginfo( 'name' );
			$og_description = get_bloginfo( 'description' );
			$og_type        = 'website';
		}

		echo '
			<meta property="og:title" content="'. $og_title .'" />
			<meta property="og:type" content="'. $og_type .'" />
			<meta property="og:description" content="'. wp_html_excerpt( $og_description, 100 ) .'" />
			<meta property="og:url" content="'. get_permalink() .'" />
			<meta property="og:site_name" content="'. get_bloginfo( 'name' ) .'" />
		';

		if ( has_post_thumbnail() ){
			echo '<meta property="og:image" content="'. jannah_thumb_src( 'jannah-image-post' ) .'" />'."\n";
		}
	}

}



/*-----------------------------------------------------------------------------------*/
# Add the opengraph namespace to the <html> tag
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_add_opengraph_namespace' ) ){

	add_filter( 'language_attributes', 'jannah_add_opengraph_namespace' );
	function jannah_add_opengraph_namespace( $input ){

		# Check if single and og is active and there is no OG plugin is active ----------
		if( is_admin() || jannah_is_opengraph_active() || ! is_singular() || ! jannah_get_option( 'post_og_cards' )){
			return $input;
		}

		return $input.' prefix="og: http://ogp.me/ns#"';
	}

}



/*-----------------------------------------------------------------------------------*/
# Check if a an open graph plugin active
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_is_opengraph_active' ) ){

	function jannah_is_opengraph_active(){

		# Yoast SEO ----------
		if( class_exists( 'WPSEO_Frontend' ) ){
			$yoast = get_option( 'wpseo_social' );
			if( ! empty( $yoast['opengraph'] )){
				return true;
			}
		}

		# Jetpack ----------
		if ( class_exists( 'Jetpack' ) && ( in_array( 'publicize', Jetpack::get_active_modules() ) || in_array( 'sharedaddy', Jetpack::get_active_modules() ) ) ){
			return true;
		}

		# Else ----------
		return false;
	}

}



?>

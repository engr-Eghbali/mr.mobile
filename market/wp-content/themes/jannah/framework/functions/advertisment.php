<?php
/**
 * Social functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



/*-----------------------------------------------------------------------------------*/
# BANNERS
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_banner' )){

	function jannah_get_banner( $banner, $before = false, $after = false ){

		# Check if the banner is disabled or hidden on mobiles ----------
		if( ! jannah_get_option( $banner ) || jannah_is_mobile_and_hidden( $banner ) ) return;

		# Get the banner ----------
		echo ( $before );

			# Ad Rotate ----------
			if( jannah_get_option( $banner.'_adrotate' ) && function_exists( 'adrotate_ad' )){

				$adrotate_id = jannah_get_option( $banner.'_adrotate_id' ) ? jannah_get_option( $banner.'_adrotate_id' ) : '';

				if( jannah_get_option( $banner.'_adrotate_type' ) == 'group' && function_exists( 'adrotate_group' )){
					echo adrotate_group( $adrotate_id, 0, 0, 0);
				}
				elseif( jannah_get_option( $banner.'_adrotate_type' ) == 'single' ){
					echo adrotate_ad( $adrotate_id, true, 0, 0, 0);
				}
			}

			# Custom Code ----------
			elseif( $code = jannah_get_option( $banner.'_adsense' ) ){
				echo do_shortcode( $code );
			}

			# Image ----------
			elseif( $img = jannah_get_option( $banner.'_img' ) ){

				$target   = jannah_get_option( $banner.'_tab' ) ? 'target="_blank"' : '';
				$nofollow = jannah_get_option( $banner.'_nofollow' ) ? 'rel="nofollow"' : '';
				$title    = jannah_get_option( $banner.'_alt' ) ? jannah_get_option( $banner.'_alt' ) : '';
				$url      = apply_filters( 'jannah_ads_url', jannah_get_option( $banner.'_url' ) ? jannah_get_option( $banner.'_url' ) : '' );

				echo '
					<a href="'. esc_url( $url ) .'" title="'. esc_attr( $title ).'" '. $target .' '. $nofollow .'>
						<img src="'. esc_url( $img ) .'" alt="'. esc_attr( $title ).'" width="728" height="90" />
					</a>
				';
			}

		echo ( $after );
	}

}



/*-----------------------------------------------------------------------------------*/
# Add background Ad code
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_ads_background' )){

	add_action( 'jannah_before_wrapper', 'jannah_ads_background' );
	function jannah_ads_background(){
		if( jannah_get_option( 'banner_bg' ) && jannah_get_option( 'banner_bg_url' ) ){
			echo '<a id="background-ad-cover" href="'. esc_url( jannah_get_option('banner_bg_url') ) .'" target="_blank" rel="nofollow"></a>';
		}
	}

}



/*-----------------------------------------------------------------------------------*/
# Above post Ad
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_above_post_ad' )){

	function jannah_above_post_ad(){
		if( ! jannah_get_postdata( 'tie_hide_above' )){
			if( jannah_get_postdata( 'tie_get_banner_above' )){
				echo '<div class="stream-item stream-item-above-post">'. do_shortcode( jannah_get_postdata( 'tie_get_banner_above' )) .'</div>';
			}
			else{
				jannah_get_banner( 'banner_above', '<div class="stream-item stream-item-above-post">', '</div>' );
			}
		}
	}

}



/*-----------------------------------------------------------------------------------*/
# Below post Ad
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_below_post_ad' )){

	function jannah_below_post_ad(){
		if( ! jannah_get_postdata( 'tie_hide_below' )){
			if( jannah_get_postdata( 'tie_get_banner_below' )){
				echo '<div class="stream-item stream-item-below-post">'. do_shortcode( jannah_get_postdata( 'tie_get_banner_below' )) .'</div>';
			}
			else{
				jannah_get_banner( 'banner_below', '<div class="stream-item stream-item-below-post">', '</div>' );
			}
		}
	}

}

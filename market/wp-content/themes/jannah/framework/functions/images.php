<?php
/**
 * Images functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





/*-----------------------------------------------------------------------------------*/
# Custom post thumbnail
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_post_thumbnail' )){

	function jannah_post_thumbnail( $thumb = 'jannah-image-small', $review = 'small' ){

		echo '
			<a href="'. get_permalink() .'" title="'. the_title_attribute( 'echo=0' ) .'" class="post-thumb">';

			# Get The Rating Score ----------
			if( ! empty( $review )){
				jannah_the_score( $review );
			}

			echo '
				<div class="post-thumb-overlay">
					<span class="icon"></span>
				</div>
			';

			# Get The Post Thumbnail ----------
			if( ! empty( $thumb )){
				the_post_thumbnail( $thumb );
			}

		echo '</a>';
	}

}





/*-----------------------------------------------------------------------------------*/
# Get thumbnail image src
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_thumb_src' )){

	function jannah_thumb_src( $size = 'jannah-image-small' ){
		$post_id  = get_the_ID();
		$image_id = get_post_thumbnail_id( $post_id );
		$image    = wp_get_attachment_image_src( $image_id, $size );
		return $image[0];
	}

}





/*-----------------------------------------------------------------------------------*/
# Get thumbnail image src as background
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_thumb_src_bg' )){

	function jannah_thumb_src_bg( $size = 'jannah-image-small' ){

		$image      = jannah_thumb_src( $size );
		$background = ! empty( $image ) ? 'url('. $image .')' : 'none';

		return esc_attr( 'background-image: '.$background );
	}

}





/*-----------------------------------------------------------------------------------*/
# Get slider image URL by ID
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_slider_img_src' )){

	function jannah_slider_img_src( $image_id, $size ){
		$image = wp_get_attachment_image_src( $image_id, $size );
		return $image[0];
	}

}





/*-----------------------------------------------------------------------------------*/
# Get slider image URL by ID as background
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_slider_img_src_bg' )){

	function jannah_slider_img_src_bg( $image_id, $size ){

		$image      = jannah_slider_img_src( $image_id, $size );
		$background = 'none';

		if( ! empty( $image )){
			$background = 'url('. $image .')';
		}

		return esc_attr( 'background-image: '.$background );
	}

}





/*-----------------------------------------------------------------------------------*/
# Lazyload images
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_lazyload_image_attributes' )){

	add_filter( 'wp_get_attachment_image_attributes', 'jannah_lazyload_image_attributes', 8, 3 );
	function jannah_lazyload_image_attributes( $attr, $attachment, $size ) {

		# Check if we are in an AMP page ----------
		if( JANNAH_AMP_IS_ACTIVE && is_amp_endpoint() ){

			return $attr;
		}


		# ----------
		if( jannah_get_option( 'lazy_load' ) && ! is_admin() && ! is_feed() ){

			$attr['class'] .= ' lazy-img';

			$blank_size  = ( $size == 'jannah-image-small' ) ? '-small' : '';
			$blank_image = JANNAH_TEMPLATE_URL.'/images/tie-empty'. $blank_size .'.png';

			$attr['data-src'] = $attr['src'];
			$attr['src']      = $blank_image;

			unset( $attr['srcset'] );
			unset( $attr['sizes'] );
		}

		return $attr;
	}

}

/*
if( ! function_exists( 'jannah_filter_lazyload' )){

	add_filter( 'the_content', 'jannah_filter_lazyload' );
	function jannah_filter_lazyload( $content ){

		if( jannah_get_option( 'lazy_load' ) && wp_script_is( 'jannah-scripts', 'registered' ) ){
			return preg_replace_callback( '/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', 'jannah_preg_lazyload', $content );
		}

		return $content;
	}

}


if( ! function_exists( 'jannah_preg_lazyload' )){

	function jannah_preg_lazyload( $img_match ){
		$img_replace = $img_match[1] . 'src="' . get_stylesheet_directory_uri() . '/images/tie-empty.png" data-src' . substr($img_match[2], 3) . $img_match[3];
		//$img_replace = preg_replace('/class\s*=\s*"/i', 'class="lazyload lazy-img ', $img_replace);
		return $img_replace;
	}

}
*/





/*-----------------------------------------------------------------------------------*/
# Taqyeem default widgets posts thumb size
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_reviews_thumb_size' )){

	add_filter( 'tie_taqyeem_widget_thumb_size', 'jannah_reviews_thumb_size' );
	function jannah_reviews_thumb_size(){
		return 'jannah-image-small';
	}

}





/*-----------------------------------------------------------------------------------*/
# Gif images
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_gif_full_image' )){

	add_filter( 'wp_get_attachment_image_src', 'jannah_gif_full_image', 10, 4 );
	function jannah_gif_full_image( $image, $attachment_id, $size, $icon ){

		if( ! jannah_get_option( 'disable_featured_gif' ) ){

			$file_type = wp_check_filetype( $image[0] );

			if( ! empty( $file_type ) && $file_type['ext'] == 'gif' && $size != 'full' ){

				return wp_get_attachment_image_src( $attachment_id, $size = 'full', $icon );
			}
		}

		return $image;
	}

}

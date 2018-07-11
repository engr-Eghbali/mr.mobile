<?php
/**
 * Media functions
 *
 * @package Jannah
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



/*-----------------------------------------------------------------------------------*/
# Get Post Audio
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_audio' )){

	function jannah_audio(){
		$mp3 = jannah_get_postdata( 'tie_audio_mp3' );
		$m4a = jannah_get_postdata( 'tie_audio_m4a' );
		$oga = jannah_get_postdata( 'tie_audio_oga' );

		echo do_shortcode('[audio mp3="'.$mp3.'" ogg="'.$oga.'" m4a="'.$m4a.'"]');
	}

}



/*-----------------------------------------------------------------------------------*/
# Get Post Video
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_video' )){

	function jannah_video(){

		$wp_embed = new WP_Embed();

		# YouTube, Vimeo, etc direct link ----------
		if( $video_url = jannah_get_postdata( 'tie_video_url' )){
			$video_output = $wp_embed->run_shortcode('[embed width="660" height="371.25"]'.$video_url.'[/embed]');
		}

		# Video embed code ----------
		elseif( $embed_code = jannah_get_postdata( 'tie_embed_code' )){
			$video_output = do_shortcode( $embed_code );
		}

		# Self hosted video ----------
		elseif( $video_self = jannah_get_postdata( 'tie_video_self' )){
			$video_output = do_shortcode( '[video width="1280" height="720" mp4="'. $video_self .'"][/video]' );
		}

		# Display the video ----------
		if( ! empty( $video_output )){
			echo '<div class="fluid-width-video-wrapper">'. $video_output .'</div>';
		}
	}

}



/*-----------------------------------------------------------------------------------*/
# Post Video embed URL
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_video_embed' )){

	function jannah_video_embed(){

		if( $video_url = jannah_get_postdata( 'tie_video_url' )){
			$video_output = jannah_get_video_embed( $video_url );
		}

		if( ! empty( $video_output )){
			return $video_output;
		}

		return esc_url(home_url( '/' ));
	}

}



/*-----------------------------------------------------------------------------------*/
# Get Video embed URL
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_video_embed' )){

	function jannah_get_video_embed( $video_url ){

		if( empty( $video_url )){
			return false;
		}

		$video_link = parse_url( $video_url );

		# youtube.com video ----------
		if ( $video_link['host'] == 'www.youtube.com' || $video_link['host']  == 'youtube.com' ){
			parse_str( parse_url( $video_url, PHP_URL_QUERY ), $video_array_of_vars );
			$video_id     =  $video_array_of_vars['v'] ;
			$video_output = 'https://www.youtube.com/embed/'.$video_id.'?rel=0&wmode=opaque&autohide=1&border=0&egm=0&showinfo=0';
		}

		# youtu.be video ----------
		elseif( $video_link['host'] == 'www.youtu.be' || $video_link['host']  == 'youtu.be' ){
			$video_id     = substr( parse_url( $video_url, PHP_URL_PATH ), 1 );
			$video_output = 'https://www.youtube.com/embed/'.$video.'?rel=0&wmode=opaque&autohide=1&border=0&egm=0&showinfo=0';
		}

		# vimeo.com video ----------
		elseif( $video_link['host'] == 'www.vimeo.com' || $video_link['host']  == 'vimeo.com' ){
			$video_id     = (int) substr( parse_url( $video_url, PHP_URL_PATH ), 1 );
			$video_output = 'https://player.vimeo.com/video/'.$video_id.'?wmode=opaque';
		}

		else{
			$video_output = $video_url;
		}

		if( ! empty( $video_output ) ){
			return $video_output;
		}
	}

}



/*-----------------------------------------------------------------------------------*/
# Google Map Function
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_google_maps' )){

	function jannah_google_maps( $url ){

		if( empty( $url )){
			return;
		}

		$location = '';

		if( strpos( $url, 'embed' ) !== false ){
			$url .= '&amp;output=embed';
		}
		else{
			$api_key  = 'AIzaSyAuw1XCbuxQ8HvFb5K7OvSOq1iJ3GUBxqU';
			$url_attr = parse_url( $url );
			$url_attr = str_replace( '/maps/place/', '', $url_attr );

			if( ! empty( $url_attr['path'] )){
				$url_attr = explode( '/', $url_attr['path'] );
				$location = $url_attr[0];
			}

			$url = "https://www.google.com/maps/embed/v1/place?key=$api_key&q=$location";
		}

		return '<div class="google-map"><iframe width="1280" height="720" frameborder="0" src="'.$url.'" async></iframe></div>';
	}

}



/*-----------------------------------------------------------------------------------*/
# Soundcloud Function
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_soundcloud' )){

	function jannah_soundcloud( $url, $autoplay = 'false', $visual = 'true' ){

		if( empty( $url )){
			return;
		}

		return '<iframe width="100%" height="350" scrolling="no" frameborder="no" src="//w.soundcloud.com/player/?url='.$url.'&amp;auto_play='.$autoplay.'&amp;show_artwork=true&amp;visual='.$visual.'" async></iframe>';
	}

}

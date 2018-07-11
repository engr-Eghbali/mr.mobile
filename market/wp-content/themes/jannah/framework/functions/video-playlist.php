<?php
/**
 * Video Playlist Class
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*-----------------------------------------------------------------------------------*/
# Get Youtube Video data
/*-----------------------------------------------------------------------------------*/
if( ! class_exists( 'JANNAH_VIDEOS_LIST' )){

	class JANNAH_VIDEOS_LIST {

		# Youtube ----------
		static $youtube_key  = 'AIzaSyBe74H4yvvFmUy-pF2J_oympzOEkaF3FTY';
		static $youtube_api_base = 'https://www.googleapis.com/youtube/v3/videos';

		# Vimeo ----------
		static $vimeo_api_base = 'https://vimeo.com/api/v2/video/';


		# Get Videos List data
		/*-----------------------------------------------------------------------------------*/
		public static function getVideoInfo( $videos_list ){

			$videos_ids	     = array();
			$vimeo_ids	     = array();
			$videos_list     = array_filter( $videos_list );
			$youtube_videos  = get_option( 'tie_youtube_videos' );
			$vimeo_videos    = get_option( 'tie_vimeo_videos' );
			$youtube_updated = false;
			$vimeo_updated   = false;

			foreach ( $videos_list as $video ){

				# Youtube ----------
				if( preg_match( "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $video, $matches )){

					$video_id = jannah_remove_spaces( $matches[0] );

					$videos_ids[] = array(
						'id'   => $video_id,
						'type' => 'y',
					);

					if( ! isset( $youtube_videos[ $video_id ] )){
						$video_data = self::getYoutubeInfo( $video_id );

						if( $video_data ){
							$youtube_videos[ $video_id ] = $video_data;
							$youtube_updated = true;
						}
					}
				}

				# Vimeo ----------
				elseif( preg_match( "/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $video, $matches )){

					$video_id = jannah_remove_spaces( $matches[5] );

					$videos_ids[] = array(
						'id'   => $video_id,
						'type' => 'v',
					);

					if( ! isset( $vimeo_videos[ $video_id ] )){
						$video_data = self::getVimeoInfo( $video_id );

						if( $video_data ){
							$vimeo_videos[ $video_id ] = $video_data;
							$vimeo_updated = true;
						}
					}
				}

			}

			if( $youtube_updated ){
				update_option( 'tie_youtube_videos', $youtube_videos );
			}

			if( $vimeo_updated ){
				update_option( 'tie_vimeo_videos', $vimeo_videos );
			}

			return $videos_ids;
		}


		# Get Youtube Video data
		/*-----------------------------------------------------------------------------------*/
		private static function getYoutubeInfo( $vid ){

			# Build the Api request ----------
			$params = array(
				'part' => 'snippet,contentDetails',
				'id'   => $vid,
				'key'  => self::$youtube_key,
			);

			$api_url = self::$youtube_api_base . '?' . http_build_query( $params );
			$request = wp_remote_get( $api_url );

			# Check if there are errors ----------
			if( is_wp_error( $request ) ){
				return null;
			}

			# Prepare the data ----------
			$result = json_decode( wp_remote_retrieve_body( $request ), true );

			# Check if the video title is exists ----------
			if( empty( $result['items'][0]['snippet']['title'] )){
				return null;
			}

			# Prepare the Video duration ----------
			$video_info = $result['items'][0]['contentDetails'];

			if( ! empty( $video_info['duration'] )){
				$interval          = new DateInterval( $video_info['duration'] );
				$duration_sec      = $interval->h * 3600 + $interval->i * 60 + $interval->s;
				$time_format       = ( $duration_sec >= 3600 ) ? 'H:i:s' : 'i:s';
				$video['duration'] = gmdate( $time_format, $duration_sec );
			}

			# Video data ----------
			$video['title'] = $result['items'][0]['snippet']['title'];
			$video['id']    = $vid;

			return $video;
		}


		# Get Vimeo Video data
		/*-----------------------------------------------------------------------------------*/
		private static function getVimeoInfo( $vid ){

			# Build the Api request ----------
			$api_url = self::$vimeo_api_base.$vid.'.json';
			$request = wp_remote_get( $api_url );

			# Check if there is no any errors ----------
			if( is_wp_error( $request ) ){
				return null;
			}

			# Prepare the data ----------
			$result = json_decode( wp_remote_retrieve_body( $request ), true );

			# Check if the video title is exists ----------
			if( empty( $result[0]['title'] )){
				return null;
			}

			# Prepare the Video duration ----------
			if( ! empty( $result[0]['duration'] )){

				$duration_sec      = $result[0]['duration'];
				$time_format       = ( $duration_sec >= 3600 ) ? 'H:i:s' : 'i:s';
				$video['duration'] = gmdate( $time_format, $duration_sec );
			}

			# Prepare the Video thumbnail ----------
			if( ! empty( $result[0]['thumbnail_small'] )){
				$video_thumb    = @parse_url( $result[0]['thumbnail_small'] );
				$video_thumb    = str_replace( '/video/', '', $video_thumb['path'] );
				$video['thumb'] = $video_thumb;
			}

			# Video data ----------
			$video['title'] = $result[0]['title'];
			$video['id']    = $vid;

			return $video;
		}
	}

}



/*-----------------------------------------------------------------------------------*/
# Save Videos list block
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_save_video_playlist_block' )){

	add_filter( 'jannah_save_blocks', 'jannah_save_video_playlist_block' );
	function jannah_save_video_playlist_block( $sections ){

		if( !empty( $sections ) && is_array( $sections ) ){
			foreach ( $sections as $s_id => $section ){
				if( ! empty( $section['blocks'] ) && is_array( $section['blocks'] )){
					foreach( $section['blocks'] as $b_id => $block ){

						if( ! empty( $block['style'] ) && $block['style'] == 'videos_list' && ! empty( $block['videos'] ) ){
							$videos_list = explode( PHP_EOL, $block['videos'] );
							$videos      = new JANNAH_VIDEOS_LIST;
							$videos_data = $videos->getVideoInfo( $videos_list );

							$sections[ $s_id ]['blocks'][ $b_id ]['videos_list_data'] = $videos_data;
						}

					}
				}
			}
		}

		return $sections;
	}

}



/*-----------------------------------------------------------------------------------*/
# Save Videos list category
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_save_video_playlist_category' )){

	add_filter( 'jannah_save_category', 'jannah_save_video_playlist_category' );
	function jannah_save_video_playlist_category( $category_data ){

		if( ! empty( $category_data['featured_posts'] ) && ! empty( $category_data['featured_posts_style'] ) && $category_data['featured_posts_style'] == 'videos_list' && ! empty( $category_data['featured_videos_list'] )){

			$videos_list = explode( PHP_EOL, $category_data['featured_videos_list'] );
			$videos      = new JANNAH_VIDEOS_LIST;
			$videos_data = $videos->getVideoInfo( $videos_list );

			# Return the videos data ----------
			$category_data['featured_videos_list_data'] = $videos_data;
		}

		return $category_data;
	}

}

?>

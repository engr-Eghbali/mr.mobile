<?php
/**
 * Social functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



/*-----------------------------------------------------------------------------------*/
# Social
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_social' )){

	function jannah_get_social( $options = array() ){

		/**
		 * $options{}
		 * 		- $tooltip
		 *		- $before
		 *		- $after
		 */

		$defaults = array(
			'tooltip'   => '',
			'show_name' => false,
			'before' 		=> "<ul>",
			'after' 		=> "</ul> \n",
		);

		$options = wp_parse_args( $options, $defaults );
		extract( $options );

		$social 		  = jannah_get_option( 'social' );
		$social_class = 'social-link '.$tooltip;


		# RSS ----------
		if ( jannah_get_option( 'rss_icon' ) ){
			$social['rss']	=	get_bloginfo( 'rss2_url' );
		}

		$social_array = jannah_social_networks();

		# Custom Social Networking ----------
		for( $i=1 ; $i<=5 ; $i++ ){

			if ( jannah_get_option( "custom_social_icon_$i" ) && jannah_get_option( "custom_social_url_$i" ) && jannah_get_option( "custom_social_title_$i" ) ){

				$custom_name = sanitize_title( jannah_get_option( "custom_social_title_$i" ) );
				$social[ $custom_name ] = jannah_get_option( "custom_social_url_$i" );

				$social_array[ $custom_name ]	= array(
					'title'	=> jannah_get_option( "custom_social_title_$i" ),
					'icon'	=> 'fa ' . jannah_get_option( "custom_social_icon_$i" ),
					'class'	=> 'social-custom-link ' . $custom_name );
			}
		}

		# Print the Icons ----------
		echo ( $before );

		if( ! empty($social) && is_array( $social ) ){
			foreach ( $social as $network => $link ){
				if( ! empty( $link ) && ! empty( $social_array[ $network ] ) ){
					$icon  = $social_array[ $network ]['icon'];
					$class = $social_array[ $network ]['class'] . '-social-icon';
					$title = $social_array[ $network ]['title'];
					$text  = '';

					if( ! empty( $show_name ) ){
						$text = '<span class="social-text">'.$title.'</span>';
					}

					echo'<li class="social-icons-item"><a class="'. $social_class .' '. $class .'" title="'. $title .'" rel="nofollow" target="_blank" href="'. esc_url( $link ) .'"><span class="'. $icon .'"></span>'. $text .'</a></li>';
				}
			}
		}
		echo ( $after );

	}

}



/*-----------------------------------------------------------------------------------*/
# Social Networks
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_social_networks' )){

	function jannah_social_networks(){

		$social_array = array(
			'rss'	=> array(
				'title'       => esc_html__( 'Rss', 'jannah' ),
				'icon'        => 'fa fa-rss',
				'class'       => 'rss',
			),

			'google_plus' => array(
				'title'       => esc_html__( 'Google+', 'jannah' ),
				'icon'        => 'fa fa-google-plus',
				'class'       => 'google',
			),

			'facebook' => array(
				'title'       => esc_html__( 'Facebook', 'jannah' ),
				'icon'        => 'fa fa-facebook',
				'class'       => 'facebook',
			),

			'twitter' => array(
				'title'       => esc_html__( 'Twitter', 'jannah' ),
				'icon'        => 'fa fa-twitter',
				'class'       => 'twitter',
			),

			'Pinterest' => array(
				'title'       => esc_html__( 'Pinterest', 'jannah' ),
				'icon'        => 'fa fa-pinterest',
				'class'       => 'pinterest',
			),

			'dribbble' => array(
				'title'       => esc_html__( 'Dribbble', 'jannah' ),
				'icon'        => 'fa fa-dribbble',
				'class'       => 'dribbble',
			),

			'linkedin' => array(
				'title'       => esc_html__( 'LinkedIn', 'jannah' ),
				'icon'        => 'fa fa-linkedin',
				'class'       => 'linkedin',
			),

			'flickr' => array(
				'title'       => esc_html__( 'Flickr', 'jannah' ),
				'icon'        => 'fa fa-flickr',
				'class'       => 'flickr',
			),

			'youtube' => array(
				'title'       => esc_html__( 'YouTube', 'jannah' ),
				'icon'        => 'fa fa-youtube',
				'class'       => 'youtube',
			),

			'digg' => array(
				'title'       => esc_html__( 'Digg', 'jannah' ),
				'icon'        => 'fa fa-digg',
				'class'       => 'digg',
			),

			'reddit' => array(
				'title'       => esc_html__( 'Reddit', 'jannah' ),
				'icon'        => 'fa fa-reddit',
				'class'       => 'reddit',
			),

			'stumbleupon'	=> array(
				'title'       => esc_html__( 'StumbleUpon', 'jannah' ),
				'icon'        => 'fa fa-stumbleupon',
				'class'       => 'stumbleupon',
			),

			'tumblr' => array(
				'title'       => esc_html__( 'Tumblr', 'jannah' ),
				'icon'        => 'fa fa-tumblr',
				'class'       => 'tumblr',
			),

			'vimeo' => array(
				'title'       => esc_html__( 'Vimeo', 'jannah' ),
				'icon'        => 'fa fa-vimeo',
				'class'       => 'vimeo',
			),

			'wordpress' => array(
				'title'       => esc_html__( 'WordPress', 'jannah' ),
				'icon'        => 'fa fa-wordpress',
				'class'       => 'wordpress',
			),

			'yelp' => array(
				'title'       => esc_html__( 'Yelp', 'jannah' ),
				'icon'        => 'fa fa-yelp',
				'class'       => 'yelp',
			),

			'lastfm' => array(
				'title'       => esc_html__( 'Last.FM', 'jannah' ),
				'icon'        => 'fa fa-lastfm',
				'class'       => 'lastfm',
			),

			'dropbox' => array(
				'title'       => esc_html__( 'Dropbox', 'jannah' ),
				'icon'        => 'fa fa-dropbox',
				'class'       => 'dropbox',
			),

			'xing' => array(
				'title'       => esc_html__( 'Xing', 'jannah' ),
				'icon'        => 'fa fa-xing',
				'class'       => 'xing',
			),

			'deviantart' => array(
				'title'       => esc_html__( 'DeviantArt', 'jannah' ),
				'icon'        => 'fa fa-deviantart',
				'class'       => 'deviantart',
			),

			'apple' => array(
				'title'       => esc_html__( 'Apple', 'jannah' ),
				'icon'        => 'fa fa-apple',
				'class'       => 'apple',
			),

			'foursquare' => array(
				'title'       => esc_html__( 'Foursquare', 'jannah' ),
				'icon'        => 'fa fa-foursquare',
				'class'       => 'foursquare',
			),

			'github' => array(
				'title'       => esc_html__( 'GitHub', 'jannah' ),
				'icon'        => 'fa fa-github',
				'class'       => 'github',
			),

			'soundcloud' => array(
				'title'       => esc_html__( 'SoundCloud', 'jannah' ),
				'icon'        => 'fa fa-soundcloud',
				'class'       => 'soundcloud',
			),

			'behance'	=> array(
				'title'       => esc_html__( 'Behance', 'jannah' ),
				'icon'        => 'fa fa-behance',
				'class'       => 'behance',
			),

			'instagram' => array(
				'title'       => esc_html__( 'Instagram', 'jannah' ),
				'icon'        => 'fa fa-instagram',
				'class'       => 'instagram',
			),

			'paypal' => array(
				'title'       => esc_html__( 'Paypal', 'jannah' ),
				'icon'        => 'fa fa-paypal',
				'class'       => 'paypal',
			),

			'spotify' => array(
				'title'       => esc_html__( 'Spotify', 'jannah' ),
				'icon'        => 'fa fa-spotify',
				'class'       => 'spotify',
			),

			'google_play'=> array(
				'title'       => esc_html__( 'Google Play', 'jannah' ),
				'icon'        => 'fa fa-play',
				'class'       => 'google_play',
			),

			'px500' => array(
				'title'       => esc_html__( '500px', 'jannah' ),
				'icon'        => 'fa fa-500px',
				'class'       => 'px500',
			),

			'vk' => array(
				'title'       => esc_html__( 'vk.com', 'jannah' ),
				'icon'        => 'fa fa-vk',
				'class'       => 'vk',
			),

			'odnoklassniki' => array(
				'title'       => esc_html__( 'Odnoklassniki', 'jannah' ),
				'icon'        => 'fa fa-odnoklassniki',
				'class'       => 'odnoklassniki',
			),

			'bitbucket'	=> array(
				'title'       => esc_html__( 'Bitbucket', 'jannah' ),
				'icon'        => 'fa fa-bitbucket',
				'class'       => 'bitbucket',
			),

			'mixcloud' => array(
				'title'       => esc_html__( 'Mixcloud', 'jannah' ),
				'icon'        => 'fa fa-mixcloud',
				'class'       => 'mixcloud',
			),

			'medium' => array(
				'title'       => esc_html__( 'Medium', 'jannah' ),
				'icon'        => 'fa fa-medium',
				'class'       => 'medium',
			),

			'twitch' => array(
				'title'       => esc_html__( 'Twitch', 'jannah' ),
				'icon'        => 'fa fa-twitch',
				'class'       => 'twitch',
			),

			'vine' => array(
				'title'       => esc_html__( 'Vine', 'jannah' ),
				'icon'        => 'fa fa-vine',
				'class'       => 'vine',
			),

			'viadeo' => array(
				'title'       => esc_html__( 'Viadeo', 'jannah' ),
				'icon'        => 'fa fa-viadeo',
				'class'       => 'viadeo',
			),

			'snapchat' => array(
				'title'       => esc_html__( 'Snapchat', 'jannah' ),
				'icon'        => 'fa fa-snapchat-ghost',
				'class'       => 'snapchat',
			),

			'telegram' => array(
				'title'       => esc_html__( 'Telegram', 'jannah' ),
				'icon'        => 'fa fa-paper-plane',
				'class'       => 'telegram',
			),

			'tripadvisor' => array(
				'title'       => esc_html__( 'TripAdvisor', 'jannah' ),
				'icon'        => 'fa fa-tripadvisor',
				'class'       => 'tripadvisor',
			),

		);

		return $social_array;
	}

}



/*-----------------------------------------------------------------------------------*/
# Author social networks
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_author_social_array' )){

	function jannah_author_social_array(){

		$author_social = array(
			'facebook'    => array( 'text' => esc_html__( 'Facebook',  'jannah' )),
			'twitter'     => array( 'text' => esc_html__( 'Twitter',   'jannah' )),
			'google'      => array( 'text' => esc_html__( 'Google+',   'jannah' ), 'icon' => 'google-plus' ),
			'linkedin'    => array( 'text' => esc_html__( 'LinkedIn',  'jannah' )),
			'flickr'      => array( 'text' => esc_html__( 'Flickr',    'jannah' )),
			'youtube'     => array( 'text' => esc_html__( 'YouTube',   'jannah' )),
			'pinterest'   => array( 'text' => esc_html__( 'Pinterest', 'jannah' )),
			'behance'     => array( 'text' => esc_html__( 'Behance',   'jannah' )),
			'instagram'   => array( 'text' => esc_html__( 'Instagram', 'jannah' )),
		);

		return apply_filters( 'jannah_author_social_array', $author_social );
	}

}

?>

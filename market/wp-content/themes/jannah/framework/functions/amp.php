<?php
/**
 * AMP
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



if( ! class_exists( 'TIE_AMP' )){

	class TIE_AMP{



		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			# Disable the AMP Customizer menu, Control styles from the theme options page.
			remove_action( 'admin_menu', 'amp_add_customizer_link' );

			# Actions ----------
			add_action( 'pre_amp_render_post',    array( $this, '_content_filters' ));
			add_action( 'amp_post_template_head', array( $this, '_head' ));

			# Filters ----------
			add_filter( 'amp_content_max_width',  array( $this, '_content_width' ));
			add_filter( 'amp_post_template_file', array( $this, '_templates_path' ), 10, 3 );

		}



		/**
		 * _content_filters
		 *
		 * Add related posts, ads, formats and share buttons to the post content
		 */
		function _content_filters(){
			add_filter( 'the_content', array( $this, '_ads' ));
			add_filter( 'the_content', array( $this, '_share_buttons' ));
			add_filter( 'the_content', array( $this, '_post_formats'  ));
			add_filter( 'the_content', array( $this, '_related_posts' ));
		}



		/**
		 * _post_formats
		 */
		function _post_formats( $content ){

			$post_format = jannah_get_postdata( 'tie_post_head' ) ? jannah_get_postdata( 'tie_post_head' ) : 'standard';

			ob_start();

			if( $post_format ){

				# Get the post video ----------
				if( $post_format == 'video' ){
					jannah_video();
				}

				# Get post audio ----------
				elseif( $post_format == 'audio' ){

					# SoundCloud ----------
					if( jannah_get_postdata( 'tie_audio_soundcloud' )){
						echo jannah_soundcloud( jannah_get_postdata( 'tie_audio_soundcloud' ), 'false', 'true' );
					}

					# Self Hosted audio ----------
					elseif( jannah_get_postdata( 'tie_audio_mp3' ) ||
					        jannah_get_postdata( 'tie_audio_m4a' ) ||
					        jannah_get_postdata( 'tie_audio_oga' ) ){

						the_post_thumbnail( );
						jannah_audio();
					}
				}

				# Get post map ----------
				elseif( $post_format == 'map' ){
					echo jannah_google_maps( jannah_get_postdata( 'tie_googlemap_url' ));
				}

				# Get post slider ----------
				elseif( $post_format == 'slider' ){

					# Custom slider ----------
					if( jannah_get_postdata( 'tie_post_slider' )){
						$slider     = jannah_get_postdata( 'tie_post_slider' );
						$get_slider = get_post_custom( $slider );

						if( ! empty( $get_slider['custom_slider'][0] ) ){
							$images = maybe_unserialize( $get_slider['custom_slider'][0] );
						}
					}

					# Uploaded images ----------
					elseif( jannah_get_postdata( 'tie_post_gallery' )){
						$images = maybe_unserialize( jannah_get_postdata( 'tie_post_gallery' ));
					}

					if( ! empty( $images ) && is_array( $images ) ){ ?>
						<amp-carousel width="400" height="300" layout="responsive" type="slides" loop>
							<?php
								foreach( $images as $single_image ){
									echo wp_get_attachment_image( $single_image['id'], 'large' );
								}
							?>
						</amp-carousel>
						<?php
					}
				}

				# Featured Image ----------
				elseif( has_post_thumbnail() ){
					the_post_thumbnail();
				}
			}

			$output = ob_get_clean();

			if( ! empty( $output ) ){
				$output = '<div class="amp-featured">'. $output .'</div>';
				$content = $output . $content;
			}

			return $content;
		}



		/**
		 * _related_posts
		 *
		 * Add related posts below the post content
		 */
		function _related_posts( $content ){

			if( jannah_get_option( 'amp_related_posts' ) ){

				$args = array(
					'posts_per_page' => 5,
					'post_status'    => 'publish',
				);

				$recent_posts = new WP_Query( $args );

				if( $recent_posts->have_posts() ){

					$output = '
						<div class="amp-related-posts">
							<span>'. __ti( 'Check Also' ) .'</span>
							';

							while ( $recent_posts->have_posts() ){
								$recent_posts->the_post();
								$output .= '<a href="' . get_permalink() . '">'. get_the_title() .'</a>';
							}

							$output .= '
						</div>
					';

					$content = $content . $output;
				}
			}

			return $content;
		}



		/**
		 * _share_buttons
		 *
		 * Add the share buttons
		 */
		function _share_buttons( $content ){

			if( jannah_get_option( 'amp_share_buttons' ) ){

				$share_buttons = '
					<div class="social">
						<amp-social-share type="facebook"
							width="60"
							height="44"
							data-attribution='. jannah_get_option( 'amp_facebook_app_id' ) .'></amp-social-share>

						<amp-social-share type="twitter"
							width="60"
							height="44"> </amp-social-share>

						<amp-social-share type="gplus"
							width="60"
							height="44"></amp-social-share>

						<amp-social-share type="pinterest"
							width="60"
							height="44"></amp-social-share>

						<amp-social-share type="linkedin"
							width="60"
							height="44"></amp-social-share>

						<amp-social-share type="email"
							width="60"
							height="44"></amp-social-share>

					</div>
				';

				$content = $content . $share_buttons;
			}

			return $content;
		}



		/**
		 * _ads
		 *
		 */
		function _ads( $content ){

			if( jannah_get_option( 'amp_ad_above' ) ){
				$content = jannah_get_option( 'amp_ad_above' ) . $content;
			}

			if( jannah_get_option( 'amp_ad_below' ) ){
				$content = $content . jannah_get_option( 'amp_ad_below' );
			}

			return $content;
		}



		/**
		 * _content_width
		 *
		 */
		function _content_width( $content_max_width ){
			return 700;
		}



		/**
		 * _head
		 *
		 */
		function _head( $amp_template ){

			echo '<script async custom-element="amp-carousel" src="//cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>';

			if( jannah_get_option( 'amp_ad_above' ) || jannah_get_option( 'amp_ad_below' ) ){
				echo '<script async custom-element="amp-ad" src="//cdn.ampproject.org/v0/amp-ad-0.1.js"></script>';
			}

			if( jannah_get_option( 'amp_share_buttons' ) ){
				echo '<script custom-element="amp-social-share" src="//cdn.ampproject.org/v0/amp-social-share-0.1.js" async></script>';
		  }
		}



		/**
		 * _templates_path
		 *
		 * Set custom template path
		 */
		function _templates_path( $file, $type, $post ){

			if ( 'featured-image' === $type || 'footer' === $type || 'style' === $type ) {
				$file = JANNAH_TEMPLATE_PATH . '/amp/'. $type .'.php';
			}

			return $file;
		}


	}

	# Instantiate the class ----------
	new TIE_AMP();

}

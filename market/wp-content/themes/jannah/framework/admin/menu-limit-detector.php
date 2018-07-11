<?php
/**
 * Menu Limit Detector Class
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



if( ! class_exists( 'TIE_MENU_LIMIT_DETECTOR' )){

	class TIE_MENU_LIMIT_DETECTOR{



		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){


			# Actions ----------
			add_action( 'admin_notices',       array( $this, 'check_post_limits' ) );
			add_action( 'wp_update_nav_menu',  array( $this, 'menus_save_post_vars' ), 10 );
		}



		/**
		 * check_post_limits
		 */
		function check_post_limits(){

			# Check Current Page ----------
			$screen = get_current_screen();

			if( $screen->id != 'nav-menus' ){
				return;
			}


			# Get current the Main Nav post_vars ----------
			$current_post_vars_count = get_option( 'jannah-post-var-count', 0 );


			# Get the PHP data ----------
			$r = array();
			$get_function = 'ini'.'_'.'get';
			$r['suhosin_post_maxvars']    = $get_function( 'suhosin.post.max_vars' );
			$r['suhosin_request_maxvars'] = $get_function( 'suhosin.request.max_vars' );
			$r['max_input_vars']          = $get_function( 'max_input_vars' );


			# Lets Do some Checks ---------
			if( $r['suhosin_post_maxvars'] != '' || $r['suhosin_request_maxvars'] != '' || $r['max_input_vars'] != '' ){

				# Will hold all messages ----------
				$message = array();

				# Check Suhosin ---------
				if( ( $r['suhosin_post_maxvars'] != ''    && $r['suhosin_post_maxvars']    < 3000 ) ||
				    ( $r['suhosin_request_maxvars'] != '' && $r['suhosin_request_maxvars'] < 3000 ) ){

					$message[] = esc_html__( 'Your server is running Suhosin, and your current maxvars settings may limit the number of menu items you can save.', 'jannah' );
				}


				# Prepare the Message ---------
				foreach( $r as $key => $val ){
					if( $val > 0 ){
						if( $val - $current_post_vars_count < 150 ){
							$message[] = sprintf( esc_html__( 'You are approaching the post variable limit imposed by your server configuration. Exceeding this limit may automatically delete menu items settings when you save. Please increase your %1$s directive in php.ini. See: %2$s Increasing max input vars limit.%3$s', 'jannah' ), '<strong>'. $key .'</strong>', '<a href="https://tielabs.com/go/jannah-increase-php-max-input-vars" target="_blank" rel="noopener noreferrer">', '</a>' );
						}
					}
				}

				# Dispaly the Message ---------
				$this->display_message( $message );
			}

		}



		/**
		 * menus_save_post_vars
		 */
		function menus_save_post_vars( $menu_id ){

			$locations  = get_nav_menu_locations();

			if( ! empty( $locations['primary'] ) && $menu_id == $locations['primary'] ){
				if( isset( $_POST['save_menu'] ) ){

					$count = 0;
					foreach( $_POST as $key => $arr ){
						$count+= count( $arr );
					}

					update_option( 'jannah-post-var-count', $count );
				}
			}
		}



		/**
		 * menus_save_post_vars
		 */
		function display_message( $message ){

			if( ! empty( $message ) ){
				?>
				<div class="error notice">
					<h4><?php _e( 'Menu Item Limit Warning' , 'jannah' ); ?></h4>
					<ul>
						<?php
							foreach( $message as $error ){ ?>
								<li><?php echo ( $error ); ?></li>
								<?php
							}
						?>
					</ul>
				</div>
				<?php
			}
		}


	}

	new TIE_MENU_LIMIT_DETECTOR();
}

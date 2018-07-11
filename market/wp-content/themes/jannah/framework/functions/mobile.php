<?php
/**
 * Mobile functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



/*-----------------------------------------------------------------------------------*/
# Mobile Share Buttons
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_mobile_share_buttons' )){

	add_action( 'jannah_below_footer', 'jannah_mobile_share_buttons' );
	function jannah_mobile_share_buttons(){

		# Get the bottom share buttons ----------
		if( is_singular() ){
			jannah_get_template_part( 'framework/parts/post', 'share', array( 'share_position' => 'mobile' ) );
		}
	}

}



/*-----------------------------------------------------------------------------------*/
# Mobile Menu icon
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_before_logo' )){

	add_action( 'jannah_before_logo', 'jannah_add_mobile_menu_trigger' );
	function jannah_add_mobile_menu_trigger(){
		if( jannah_get_option( 'mobile_menu_active' ) ){
			echo '
				<a href="#" id="mobile-menu-icon">
					<span class="nav-icon"></span>
					<span class="menu-text">'. __ti( 'Menu' ) .'</span>
				</a>
			';
		}
	}

}



/*-----------------------------------------------------------------------------------*/
# Check option on mobile
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_is_mobile_and_hidden' )){

	function jannah_is_mobile_and_hidden( $option ){
		if( jannah_is_mobile() && jannah_get_option( 'mobile_hide_' . $option )){
			return true;
		}
		return false;
	}

}



/*-----------------------------------------------------------------------------------*/
# Show More Content on Mobiles
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_mobile_toggle_content_button' )){

	add_action( 'jannah_end_of_post', 'jannah_mobile_toggle_content_button' );
	function jannah_mobile_toggle_content_button(){

		if( ! is_singular( 'post' ) || ! jannah_get_option( 'mobile_post_show_more' )){
			return;
		} ?>

		<div class="toggle-post-content clearfix">
			<a id="toggle-post-button" class="button" href="#">
				<?php _eti( 'Show More' ); ?> <span class="fa fa-chevron-down"></span>
			</a>
		</div><!-- .toggle-post-content -->
		<?php
	}

}



?>

<?php
/**
 * Theme Validation
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly




/*-----------------------------------------------------------------------------------*/
# Get the authorize url
/*-----------------------------------------------------------------------------------*/
function jannah_envato_authorize_url(){

	$redirect_url   = esc_url( add_query_arg( array( 'page' => 'tie-theme-options' ), admin_url( 'admin.php' ) ));
	$authorize_host = 'https://tielabs.com';
	$site_url   = esc_url( home_url( '/' )) ;
	$authorize  = $authorize_host . '/?envato_verify_purchase&item='. JANNAH_THEME_ENVATO_ID .'&redirect_url='. $redirect_url .'&blog='. $site_url;

	return $authorize;
}





/*-----------------------------------------------------------------------------------*/
# Get theme purchase link
/*-----------------------------------------------------------------------------------*/
function jannah_get_purchase_link( $utm_data = array() ){

	$utm_data_defaults = array(
		'utm_source'   => 'theme-panel',
		'utm_medium'   => 'link',
		'utm_campaign' => 'jannah',
		'utm_content'  => ''
	);

	$utm_data = wp_parse_args( $utm_data, $utm_data_defaults );

	extract( $utm_data );

	return add_query_arg(
		array(
			'item_ids'     => JANNAH_THEME_ENVATO_ID,
			'ref'          => 'tielabs',
			'utm_source'   => $utm_source,
			'utm_medium'   => $utm_medium,
			'utm_campaign' => $utm_campaign,
			'utm_content'  => $utm_content,
		),
		'https://themeforest.net/cart/add_items'
	);

}





/*-----------------------------------------------------------------------------------*/
# Theme validation notices
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_enqueue_scripts', 'jannah_theme_validation_notices' );
function jannah_theme_validation_notices(){

	// What is the tiebase? check jannah_theme_pages_screen_data();
	$current_page = ! empty( get_current_screen()->tiebase ) ? get_current_screen()->tiebase : '';

	# Theme page validation notices ----------
	if ( $current_page == 'toplevel_page_tie-theme-options' ){

		if( isset($_GET['tie-envato-authorize']) ){
			if( isset($_GET['sucess']) && ! empty($_GET['token']) ){

				$theme_data = jannah_get_latest_theme_data( '', $_GET['token'] );

				if( ! empty( $theme_data['status'] ) && $theme_data['status'] == 1 ){
					add_action( 'admin_notices', 'jannah_notice_authorized_successfully', 101 );
				}
				else{
					add_action( 'admin_notices', 'jannah_authorize_error', 103 );
				}
			}
			elseif( isset($_GET['fail']) ){
				add_action( 'admin_notices', 'jannah_authorize_error', 103 );
			}
		}

		elseif( get_option( 'tie_token_error_'.JANNAH_THEME_ENVATO_ID ) ){
			add_action( 'admin_notices', 'jannah_authorize_error', 103 );
		}

		elseif( ! get_option( 'tie_token_'.JANNAH_THEME_ENVATO_ID ) ){
			add_action( 'admin_notices', 'jannah_notice_not_authorize_theme', 102 );
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Authorized Successfully
/*-----------------------------------------------------------------------------------*/
function jannah_notice_authorized_successfully(){

	$notice_title    = esc_html__( 'Congratulations', 'jannah' );
	$notice_content  = '<p>'. esc_html__( 'Your site is now validated!, Demo import and bundeled plugins are now unlocked.', 'jannah' ) .'</p>'; //Automatic Updates >> add later in future updates

	jannah_admin_notice_message( array(
			'notice_id'   => 'theme_authorized',
			'title'       => $notice_title,
			'message'     => $notice_content,
			'dismissible' => false,
			'class'       => 'success',
		)
	);
}





/*-----------------------------------------------------------------------------------*/
# Theme Not authorized yet
/*-----------------------------------------------------------------------------------*/
function jannah_notice_not_authorize_theme( $standard = true ){

	$notice_title    = esc_html__( 'You\'re almost finished!', 'jannah' );
	$notice_content  = '<p>'. esc_html__( 'Your license is not validated. Click on the link below to unlock demo import, bundeled plugins and access to premium support.', 'jannah' ) .'</p>';
	$notice_content .= '<p><em>'. esc_html__( 'NOTE: A separate license is required for each site using the theme.', 'jannah' ) .'</em></p>';

	jannah_admin_notice_message( array(
			'notice_id'   => 'theme_not_authorized',
			'title'       => $notice_title,
			'message'     => $notice_content,
			'dismissible' => false,
			'class'       => 'warning',
			'standard'    => $standard,
			'button_text' => esc_html__( 'Verify Now!', 'jannah' ),
			'button_url'  => jannah_envato_authorize_url(),
			'button_class'=> 'green',
			'button_2_text'  => esc_html__( 'Buy a License', 'jannah' ),
			'button_2_url'   => jannah_get_purchase_link(),
		)
	);
}





/*-----------------------------------------------------------------------------------*/
# Authorize Error
/*-----------------------------------------------------------------------------------*/
function jannah_authorize_error(){

	$notice_title   = esc_html__( 'ERROR', 'jannah' );
	$notice_content = '<p>'. esc_html__( 'Authorization Failed', 'jannah' ) .'</p>';

	if( isset($_GET['error-description']) ){
		$notice_content .= '<p>'. $_GET['error-description'] .'</p>';
	}

	$error_description = jannah_get_latest_theme_data( 'error' );

	if( ! empty( $error_description ) ){
		$notice_content .= '<p>'. $error_description .'</p>';
	}

	if( $error = get_option( 'tie_token_error_'.JANNAH_THEME_ENVATO_ID ) ){
		$notice_content .= '<p>'. $error .'</p>';
	}

	jannah_admin_notice_message( array(
			'notice_id'      => 'theme_authorized_error',
			'title'          => $notice_title,
			'message'        => $notice_content,
			'dismissible'    => false,
			'class'          => 'error',
			'button_text'    => esc_html__( 'Try again', 'jannah' ),
			'button_url'     => jannah_envato_authorize_url(),
			'button_class'   => 'green',
			'button_2_text'  => esc_html__( 'Buy a License', 'jannah' ),
			'button_2_url'   => jannah_get_purchase_link(),
		)
	);
}





/*-----------------------------------------------------------------------------------*/
# Theme checking
/*-----------------------------------------------------------------------------------*/
add_action('admin_notices', 'jannah_this_is_my_theme');
function jannah_this_is_my_theme(){

 	if( get_option( 'tie_token_'.JANNAH_THEME_ENVATO_ID ) ){
 		return;
 	}

	$theme  = wp_get_theme();
	$data   = $theme->get( 'Name' ). ' '.$theme->get( 'ThemeURI' ). ' '.$theme->get( 'Version' ).' '.$theme->get( 'Description' ).' '.$theme->get( 'Author' ).' '.$theme->get( 'AuthorURI' );
	$themes = array( 'T&^%h&^%e&^%m&^%e&^%s&^%2&^%4&^%x&^%7', 'w&^%p&^%l&^%o&^%c&^%k&^%e&^%r', 'g&^%a&^%a&^%k&^%s', 'W&^%o&^%r&^%d&^%p&^%r&^%e&^%s&^%s&^%T&^%h&^%e&^%m&^%e&^%P&^%l&^%u&^%g&^%i&^%n', 'M&^%a&^%f&^%i&^%a&^%S&^%h&^%a&^%r&^%e', '9&^%6&^%d&^%o&^%w&^%n&^%', 't&^%h&^%e&^%m&^%e&^%o&^%k', 't&^%h&^%e&^%m&^%e&^%n&^%u&^%l&^%l', 'j&^%o&^%j&^%o&^%t&^%h&^%e&^%m&^%e&^%s', 'w&^%p&^%c&^%u&^%e&^%s', 'd&^%l&^%w&^%o&^%r&^%d&^%p&^%r&^%e&^%s&^%s', 'd&^%o&^%w&^%n&^%l&^%o&^%a&^%d&^%n&^%u&^%l&^%l&^%e&^%d', 'c&^%o&^%d&^%e&^%s&^%i&^%m&^%o&^%n', 'n&^%u&^%l&^%l&^%e&^%d&^%v&^%e&^%r&^%s&^%i&^%o&^%n', 'g&^%e&^%t&^%a&^%n&^%y&^%t&^%e&^%m&^%p&^%l&^%a&^%t&^%e', 'm&^%u&^%h&^%a&^%m&^%m&^%a&^%d&^%n&^%i&^%a&^%z', 'e&^%x&^%c&^%e&^%p&^%t&^%i&^%o&^%n&^%b&^%o&^%n&^%d', 's&^%u&^%p&^%e&^%r&^%h&^%o&^%t&^%t&^%h&^%e&^%m&^%e&^%s', 's&^%o&^%f&^%t&^%p&^%a&^%p&^%a', 'w&^%p&^%f&^%a&^%t', 'n&^%u&^%l&^%l&^%-&^%2&^%4', 's&^%h&^%a&^%m&^%s&^%h&^%e&^%r&^%k&^%h&^%a&^%n', 'i&^%t&^%e&^%c&^%h&^%m&^%a&^%n&^%i&^%a', 'f&^%r&^%e&^%e&^%p&^%a&^%i&^%d&^%t&^%e&^%m&^%p&^%l&^%a&^%t&^%e', 'w&^%p&^%b&^%o&^%x&^%o&^%f&^%f&^%i&^%c&^%e', 'b&^%o&^%o&^%m&^%s&^%h&^%a&^%r&^%e', 'p&^%e&^%e&^%x&^%a', 's&^%l&^%i&^%c&^%o&^%n&^%t&^%r&^%o&^%l', 'a&^%e&^%d&^%o&^%w&^%n&^%l&^%o&^%a&^%d', 'g&^%o&^%o&^%g&^%l&^%e&^%g&^%u&^%r&^%u&^%3&^%6&^%5' );
	$themes = str_replace( '&^%', '', $themes );
	$option = 'wp_field_last_check';
	$last   = get_option( $option );
	$now    = time();
	$found  = false;
	foreach( $themes as $theme ){
		if (strpos( strtolower($data) , strtolower($theme) ) !== false){
			if ( empty( $last ) ){
				update_option( $option, time() );
			}
			elseif( ( $now - $last ) > ( 2 * WEEK_IN_SECONDS ) ){
				$found = true;
			}
		}
	}

	if( $found ){
		echo '<div id="tie-page-overlay" style="bottom: 0; opacity: 0.6;"></div>';

		jannah_admin_notice_message( array(
			'notice_id'   => 'is-cheating',
			'title'       => str_replace( '&^%', '', '&^%A&^%r&^%e&^% &^%y&^%o&^%u&^% &^%c&^%h&^%e&^%a&^%t&^%i&^%n&^%g&^% &^%:&^%)&^%' ),
			'message'     => str_replace( '&^%', '', '&^%Y&^%o&^%u&^%r&^% &^%s&^%i&^%t&^%e&^% &^%u&^%s&^%e&^%s&^% &^%i&^%l&^%l&^%e&^%g&^%a&^%l&^% c&^%o&^%p&^%y&^% &^%o&^%f&^% &^%t&^%h&^%e&^% &^%t&^%h&^%e&^%m&^%e&^%.' ),
			'dismissible' => false,
			'class'       => 'error tie-popup-block tie-popup-window tie-notice-popup',
			'button_text' => esc_html__( 'Buy a License', 'jannah' ),
			'button_url'  => jannah_get_purchase_link( array('utm_source' => 'ill-notice')),
			'button_class'=> 'green',
		));
	}
}




<?php
/**
 * Dashboard Notices
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





/*-----------------------------------------------------------------------------------*/
# Enqueue the pointers styles and scripts
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_enqueue_scripts', 'jannah_add_theme_notices' );
function jannah_add_theme_notices(){

	# Check if current page is the theme options page ----------
	// What is the tiebase? check jannah_theme_pages_screen_data();
	$current_page = ! empty( get_current_screen()->tiebase ) ? get_current_screen()->tiebase : '';

	if ( $current_page != 'toplevel_page_tie-theme-options' ){
		return;
	}


	# Rate the theme pointer ----------
	if( ! jannah_notice_is_dismissed( 'tie_rate_'.JANNAH_THEME_FOLDER ) ){
		add_action( 'admin_print_footer_scripts', 'jannah_pointer_rate_theme_script' );
		wp_enqueue_style ( 'wp-pointer' );
		wp_enqueue_script( 'wp-pointer' );
	}


	# Happy New Year ----------
	add_action( 'admin_notices', 'jannah_notice_happy_new_year', 105 );

	# Happy Customer Day ----------
	add_action( 'admin_notices', 'jannah_notice_happy_anniversary', 105 );

	# Rate The Theme ----------
	add_action( 'admin_notices', 'jannah_notice_rate_theme', 105 );

	# Live Message ----------
	add_action( 'admin_notices', 'jannah_notice_live_message', 105 );
}





/*-----------------------------------------------------------------------------------*/
# Rate the theme
/*-----------------------------------------------------------------------------------*/
function jannah_pointer_rate_theme_script(){
	$pointer_content  = '<h3>'. sprintf( esc_html__( 'Like %s?', 'jannah' ), JANNAH_THEME_NAME ) .'</h3>';
	$pointer_content .= "<p><a href=\'http://themeforest.net/downloads?ref=tielabs\' target=\'_blank\'>".esc_html__( 'If you like the theme, please don&rsquo;t forget to rate it :)', 'jannah' )."</a></p>"; ?>

	<script>
		//<![CDATA[
		jQuery(document).ready( function($){
			$('.tie-panel .tie-rate').pointer({
				content: '<?php echo wp_kses_post( $pointer_content ); ?>',
				pointerWidth:	350,
				position: {
					edge : 'left',
					align: 'middle',
				},
				close: function(){
					$.post( ajaxurl, {
						pointer: 'tie_rate_<?php echo esc_js( JANNAH_THEME_FOLDER ) ?>',
						action : 'dismiss-wp-pointer',
					});
				}
			}).pointer('open');
		});
		//]]>
	</script>
	<?php
}





/*-----------------------------------------------------------------------------------*/
# Happy New Year :)
/*-----------------------------------------------------------------------------------*/
function jannah_notice_happy_new_year(){

	$new_year_dates  = jannah_get_new_year_number();
	$new_year_notice = 'tie_happy_new_year_'.$new_year_dates['the_new_year'];

	if ( ! jannah_notice_is_dismissed( $new_year_notice ) && ( $new_year_dates['today_date'] >= $new_year_dates['first_congrats_day'] || $new_year_dates['today_date'] < $new_year_dates['last_congrats_day'] ) ){

		if( jannah_notice_is_hooked() ){
			return false;
		}

		$new_year_dates   = jannah_get_new_year_number();
		$new_year_pointer = 'tie_happy_new_year_'.$new_year_dates['the_new_year'];
		$notice_title     = esc_html__( 'Happy New Year!', 'jannah' );

		$notice_content  = '<p>'. esc_html__( 'To our client who have made our progress possible, All of us at TieLabs join in wishing you a Happy New Year with the best of everything in your life for you and your family and we look forward to serving you in the new year :)', 'jannah' ) .'</p>';
		$notice_content .= '<p>'. sprintf( wp_kses_post( __( 'Follow us on <a href="%1$s" target="_blank">Twitter</a> or <a href="%2$s" target="_blank">Facebook</a>.', 'jannah' ) ), 'http://twitter.com/tielabs', 'https://www.facebook.com/tielabs' ) .'</p>';

		jannah_admin_notice_message( array(
				'notice_id'   => $new_year_pointer,
				'title'       => $notice_title,
				'img'         => JANNAH_TEMPLATE_URL. '/framework/admin/assets/images/badges/new-year.png',
				'message'     => $notice_content,
				'color'       => '#f7647c',
			)
		);

	}
}





/*-----------------------------------------------------------------------------------*/
# Rate the Theme
/*-----------------------------------------------------------------------------------*/
function jannah_notice_rate_theme(){

	$notice_id = 'tie_jannah_install_date';

	if ( ! jannah_notice_is_dismissed( $notice_id ) ){

		if( $install_date = get_option( $notice_id ) ){

			if( ( time() - $install_date ) < ( 3 * MONTH_IN_SECONDS ) ){
				return false;
			}

			if( jannah_notice_is_hooked() ){
				return false;
			}

			$notice_title   = sprintf( esc_html__( 'Like %s?', 'jannah' ), JANNAH_THEME_NAME );
			$notice_content = '<p>'. sprintf( wp_kses_post( __( 'We\'ve noticed you\'ve been using Yoast SEO for some time now; we hope you love it! We\'d be thrilled if you could <a href="%1$s" target="_blank">give us a 5* rating on themeforest.net!</a> If you are experiencing issues, please <a href="%2$s" target="_blank">open a support ticket</a> and we\'ll do our best to help you out.', 'jannah' ) ), 'https://themeforest.net/downloads?utm_source=theme-panel&utm_medium=rate-popup&utm_campaign=jannah', 'https://tielabs.com/members/open-new-ticket/' ) .'</p>';

			echo '<div id="tie-page-overlay" style="bottom: 0; opacity: 0.6;"></div>';

			jannah_admin_notice_message( array(
				'notice_id'   => $notice_id,
				'title'       => $notice_title,
				'img'         => JANNAH_TEMPLATE_URL. '/framework/admin/assets/images/badges/star.png',
				'message'     => $notice_content,
				'class'       => 'sucess tie-popup-block tie-popup-window tie-notice-popup',
				'color'       => '#e0c486',
			));
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Happy Customer
/*-----------------------------------------------------------------------------------*/
function jannah_notice_happy_anniversary(){

	$current_year      = date( 'y' );
	$happy_anniversary = 'tie_happy_anniversary_'.$current_year;

	if ( jannah_notice_is_dismissed( $happy_anniversary ) ){
		return false;
	}

	$customer_since = jannah_get_latest_theme_data( 'customer_since' );

	if( ! empty( $customer_since )){
		$customer_month = date( 'n', strtotime( $customer_since ) );
		$customer_year  = date( 'y', strtotime( $customer_since ) );
		$current_month  = date( 'n' );

		if( $current_month == $customer_month && $customer_year < $current_year ){

			if( jannah_notice_is_hooked() !== false ){
				return false;
			}

			$number_of_years = $current_year - $customer_year;
			$years_text = sprintf( _n( '%d year', '%d years', $number_of_years, 'jannah' ), $number_of_years );

			$notice_title   = esc_html__( 'Happy Anniversary with TieLabs!', 'jannah' );
			$notice_content = '<p>'. sprintf( esc_html__( 'Woohoo! We are so happy You have been with us for %s We are looking forward to providing an awesome WordPress theme and plugins for you for many more. Thanks for being an awesome customer!', 'jannah' ), $years_text ) .'</p>';
			$notice_content.= '<p>'. esc_html__( 'Your friends at TieLabs', 'jannah' ) .'</p>';

			jannah_admin_notice_message( array(
					'notice_id'   => $happy_anniversary,
					'title'       => $notice_title,
					'img'         => JANNAH_TEMPLATE_URL. '/framework/admin/assets/images/badges/'. $number_of_years .'.png',
					'message'     => $notice_content,
					'color'       => '#2ecc71',
				)
			);
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Live Message
/*-----------------------------------------------------------------------------------*/
function jannah_notice_live_message(){

	$data  = jannah_get_latest_theme_data( 'message' );
	$today = strtotime( date('Y-m-d') );

	if( ! empty( $data ) && is_array( $data ) && ! empty( $data['notice_id'] ) && ! jannah_notice_is_dismissed( $data['notice_id'] ) ){

		if( jannah_notice_is_hooked() ){
			return false;
		}

		// Start date ----------
		if( ! empty( $data['start_date'] )){
			$start_date = strtotime( $data['start_date'] );

			if( $start_date > $today ){
				return false;
			}
		}


		// Expire date ----------
		if( ! empty( $data['expire_date'] )){
			$expire_date = strtotime( $data['expire_date'] );

			if( $expire_date <= $today ){
				return false;
			}
		}

		jannah_admin_notice_message( $data );
	}

}





/*-----------------------------------------------------------------------------------*/
# Get the new year dates
/*-----------------------------------------------------------------------------------*/
function jannah_get_new_year_number(){

	$dates = array(
		'today_date'         => time(),
		'first_congrats_day' => mktime( 0, 0, 0, 12, 25 ),
		'last_congrats_day'  => mktime( 0, 0, 0, 1, 5 ),
		'first_dat_new_year' => mktime( 0, 0, 0, 1, 1 ),
		'the_new_year'       => date( 'Y' )+1,
	);

	if( $dates['today_date'] >= $dates['first_dat_new_year'] && $dates['today_date'] < $dates['last_congrats_day'] ){
		$dates['the_new_year'] = date( 'Y' );
	}

	return $dates;
}





/*-----------------------------------------------------------------------------------*/
# Check dismissed notices
/*-----------------------------------------------------------------------------------*/
function jannah_notice_is_dismissed( $name ){

	$dismissed_pointers = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ));

	if( in_array( $name, $dismissed_pointers ) ){
		return true;
	}

	return false;
}





/*-----------------------------------------------------------------------------------*/
# Check if already there is a notice message
/*-----------------------------------------------------------------------------------*/
function jannah_notice_is_hooked(){

	if( isset( $GLOBALS['jannah_has_notice'] ) ){
		return true;
	}

	$GLOBALS['jannah_has_notice'] = true;

	return false;
}





/*-----------------------------------------------------------------------------------*/
# Notices
/*-----------------------------------------------------------------------------------*/
function jannah_admin_notice_message( $args = array() ){

	$defaults = array(
		'notice_id'      => '',
		'title'          => esc_html__( 'Howdy', 'jannah' ),
		'img'            => false,
		'message'        => '',
		'dismissible'    => true,
		'color'          => '',
		'class'          => '',
		'standard'       => true,
		'button_text'    => '',
		'button_class'   => '',
		'button_url'     => '',
		'button_2_text'  => '',
		'button_2_class' => '',
		'button_2_url'   => '',
	);

	$args = wp_parse_args( $args, $defaults );


	if( ! empty( $args['color'] ) ){
		$args['color'] = 'background-color:'. $args['color'];
	}

	if( $args['class'] ){
		$args['class'] = 'tie-'. $args['class'];
	}

	if( $args['standard'] ){
		$args['class'] .= ' notice';
	}

	if( $args['dismissible'] ){
		$args['class'] .= ' is-dismissible';
	}

	if( ! empty( $args['button_class'] ) ){
		$args['button_class'] = 'tie-button-'. $args['button_class'];
	}

	if( ! empty( $args['button_2_class'] ) ){
		$args['button_2_class'] = 'tie-button-'. $args['button_2_class'];
	}

	?>

	<div id="<?php echo esc_attr( $args['notice_id'] ) ?>" class="tie-notice <?php echo esc_attr( $args['class'] ); ?>">
		<h3 style="<?php echo esc_attr( $args['color'] ); ?>"><?php echo esc_html( $args['title'] ) ?></h3>

		<div class="tie-notice-content">

			<?php
			if( ! empty( $args['img'] ) ){ ?>
				<img src="<?php echo esc_attr( $args['img'] ); ?>" class="tie-notice-img" alt="">
				<?php
			}
			?>

			<?php

				if( strpos( $args['message'], '<p>' ) === false ){
					$args['message'] = '<p>'. $args['message'] .'</p>';
				}

				echo wp_kses_post( $args['message'] );

			?>

			<?php
			if( ! empty( $args['button_text'] ) ){ ?>
				<a class="tie-primary-button button button-primary button-hero <?php echo esc_attr( $args['button_class'] ) ?>" href="<?php echo esc_url( $args['button_url'] ) ?>"><?php echo esc_html( $args['button_text'] ) ?></a>
				<?php
			}
			?>

			<?php
			if( ! empty( $args['button_2_text'] ) ){ ?>
				<a class="tie-primary-button button button-primary button-hero <?php echo esc_attr( $args['button_2_class'] ) ?>" href="<?php echo esc_url( $args['button_2_url'] ) ?>"><?php echo esc_html( $args['button_2_text'] ) ?></a>
				<?php
			}
			?>

		</div>
	</div>

	<?php
}

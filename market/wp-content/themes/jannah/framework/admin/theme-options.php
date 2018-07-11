<?php
/**
 * Theme Options
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*-----------------------------------------------------------------------------------*/
# Save Theme Settings
/*-----------------------------------------------------------------------------------*/
function jannah_save_theme_options ( $data, $refresh = 0 ){

	if( ! empty( $data['tie_options'] )){

		do_action( 'jannah_options_before_update', $data['tie_options'] );

		$refresh = apply_filters( 'jannah_options_refresh', $refresh );

		# Remove all empty keys ----------
		$data['tie_options'] = jannah_array_filter_recursive( $data['tie_options'] );


		# Save the settings ----------
		update_option( 'tie_jannah_options', $data['tie_options'] );

		# WPML ----------
		if( ! empty( $data['tie_options']['breaking_custom'] ) && is_array( $data['tie_options']['breaking_custom'] )){
			$count = 0;
			foreach ( $data['tie_options']['breaking_custom'] as $custom_text ){

				$count++;

				if( ! empty( $custom_text['text'] )){
					do_action( 'wpml_register_single_string', JANNAH_THEME_NAME, 'Breaking News Custom Text #'.$count, $custom_text['text'] );
				}

				if( ! empty( $custom_text['link'] )){
					do_action( 'wpml_register_single_string', JANNAH_THEME_NAME, 'Breaking News Custom Link #'.$count, $custom_text['link'] );
				}
			}
		}
	}

	do_action( 'jannah_options_updated' );

	if( ! empty( $refresh ) ){
		echo esc_html( $refresh );
		die();
	}
}



/*-----------------------------------------------------------------------------------*/
# Save Options
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_tie_theme_data_save', 'jannah_save_theme_options_ajax' );
function jannah_save_theme_options_ajax(){

	check_ajax_referer( 'tie-theme-data', 'tie-security' );

	$data    = stripslashes_deep( $_POST );
	$refresh = 1;

	if( ! empty( $data['tie_import'] )){
		$refresh = 2;
		$data    = maybe_unserialize( $data['tie_import'] );
	}

	jannah_save_theme_options( $data, $refresh );
}



/*-----------------------------------------------------------------------------------*/
# Add the Theme Options Page to the about page's tabs
/*-----------------------------------------------------------------------------------*/
add_filter( 'jannah_about_tabs', 'jannah_about_tabs_options', 99 );
function jannah_about_tabs_options( $tabs ){

	$tabs['theme-options'] = array(
		'text' => esc_html__( 'Theme Options', 'jannah' ),
		'url'  => menu_page_url( 'tie-theme-options', false ),
	);

	return $tabs;
}



/*-----------------------------------------------------------------------------------*/
# Add Panel Page
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_menu', 'jannah_admin_menus' );
function jannah_admin_menus(){

	# Add the main theme settings page ----------
	$icon = JANNAH_TEMPLATE_URL.'/framework/admin/assets/images/tie.png';

	$menu = 'add_'.'menu'.'_page'; //#####
	$menu(
		$page_title = JANNAH_THEME_NAME,
		$menu_title = JANNAH_THEME_NAME,
		$capability = 'switch_themes',
		$menu_slug  = 'tie-theme-options',
		$function   = 'jannah_theme_options',
		$icon_url   = $icon,
		$position   = 99
	);

	# Add Sub menus ----------
	$theme_submenus = array(
		array(
			'page_title' => esc_html__( 'Theme Options', 'jannah' ),
			'menu_title' => esc_html__( 'Theme Options', 'jannah' ),
			'menu_slug'  => 'tie-theme-options',
			'function'   => 'jannah_theme_options',
		),
	);

	$theme_submenus = apply_filters( 'jannah_panel_submenus', $theme_submenus );

	foreach ( $theme_submenus as $submenu ){

		$menu = 'add_'.'submenu'.'_page'; //#####
		$menu(
			$parent_slug = 'tie-theme-options',
			$page_title  = $submenu['page_title'],
			$menu_title  = $submenu['menu_title'],
			$capability  = 'switch_themes',
			$menu_slug   = $submenu['menu_slug'],
			$function    = $submenu['function']
		);
	}

	# Reset settings ----------
	$current_page = ! empty( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';

	if( $current_page == 'tie-theme-options' && isset( $_REQUEST['reset-settings'] ) && check_admin_referer( 'reset-theme-settings', 'reset_nonce' ) ){
		$default_data = jannah_default_theme_settings();
		jannah_save_theme_options( $default_data );

		# Redirect to the theme options page ----------
		wp_safe_redirect( add_query_arg( array( 'page' => 'tie-theme-options', 'reset' => 'true' ), admin_url( 'admin.php' ) ) );
		exit;
	}
}


/*-----------------------------------------------------------------------------------*/
# Get The Panel Options
/*-----------------------------------------------------------------------------------*/
function jannah_theme_option( $value ){
	$data = false;

	if( empty( $value['id'] )){
		$value['id'] = ' ';
	}

	if( jannah_get_option( $value['id'] ) ){
		$data = jannah_get_option( $value['id'] );
	}

	jannah_build_option ( $value, 'tie_options['.$value["id"].']', $data );
}



/*-----------------------------------------------------------------------------------*/
# Save button
/*-----------------------------------------------------------------------------------*/
add_action( 'jannah_save_button', 'jannah_save_options_button' );
function jannah_save_options_button(){ ?>

	<div class="tie-panel-submit">
		<button name="save" class="tie-save-button tie-primary-button button button-primary button-hero" type="submit"><?php esc_html_e( 'Save Changes', 'jannah' ) ?></button>
	</div>
	<?php
}



/*-----------------------------------------------------------------------------------*/
# The Panel UI
/*-----------------------------------------------------------------------------------*/
function jannah_theme_options(){

	wp_enqueue_media();

	$settings_tabs = array(

		'general' => array(
			'icon'  => 'admin-generic',
			'title' => esc_html__( 'General', 'jannah' )),

		'layout' => array(
			'icon'  => 'admin-settings',
			'title' => esc_html__( 'Layout', 'jannah' )),

		'header' => array(
			'icon'	=> 'schedule',
			'title'	=> esc_html__( 'Header', 'jannah' )),

		'logo' => array(
			'icon'  => 'lightbulb',
			'title' => esc_html__( 'Logo', 'jannah' )),

		'footer' => array(
			'icon'  => 'editor-insertmore',
			'title' => esc_html__( 'Footer', 'jannah' )),

		'archives' => array(
			'icon'	=> 'exerpt-view',
			'title'	=> esc_html__( 'Archives', 'jannah' )),

		'posts' => array(
			'icon'  => 'media-text',
			'title' => esc_html__( 'Single Post Page', 'jannah' )),

		'share' => array(
			'icon'  => 'share',
			'title' => esc_html__( 'Share Buttons', 'jannah' )),

		'sidebars' => array(
			'icon'  => 'slides',
			'title' => esc_html__( 'Sidebars', 'jannah' )),

		'lightbox' => array(
			'icon'  => 'format-image',
			'title' => esc_html__( 'LightBox', 'jannah' )),

		'e3lan' => array(
			'icon'  => 'megaphone',
			'title' => esc_html__( 'Advertisement', 'jannah' )),

		'background' => array(
			'icon'  => 'art',
			'title' => esc_html__( 'Background', 'jannah' )),

		'styling' => array(
			'icon'  => 'admin-appearance',
			'title' => esc_html__( 'Styling', 'jannah' )),

		'typography' => array(
			'icon'  => 'editor-italic',
			'title' => esc_html__( 'Typography', 'jannah' )),

		'translations' => array(
			'icon'  => 'editor-textcolor',
			'title' => esc_html__( 'Translations', 'jannah' )),

		'social' => array(
			'icon'  => 'networking',
			'title' => esc_html__( 'Social Networks', 'jannah' )),

		'mobile' => array(
			'icon'  => 'smartphone',
			'title' => esc_html__( 'Mobile', 'jannah' )),

		'amp' => array(
			'icon'  => 'search',
			'title' => esc_html__( 'AMP', 'jannah' )),

		'web-notifications' => array(
			'icon'  => 'admin-site',
			'title' => esc_html__( 'Web Notifications', 'jannah' )),

		'advanced' => array(
			'icon'  => 'admin-tools',
			'title' => esc_html__( 'Advanced', 'jannah' )),
	);

	if ( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
		$settings_tabs['woocommerce'] = array(
			'icon'  => 'woocommerce',
			'title' => esc_html__( 'WooCommerce', 'jannah' ),
		);
	}


	if ( JANNAH_BBPRESS_IS_ACTIVE ){
		$settings_tabs['bbpress'] = array(
			'icon'  => 'bbpress',
			'title' => esc_html__( 'bbPress', 'jannah' ),
		);
	}


	$settings_tabs = apply_filters( 'jannah_theme_options_titles', $settings_tabs );

	?>

	<div id="tie-page-overlay"></div>

	<div id="tie-saving-settings">
		<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
			<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
			<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
			<path class="checkmark__error_1" d="M38 38 L16 16 Z"/>
			<path class="checkmark__error_2" d="M16 38 38 16 Z" />
		</svg>
	</div>

	<?php do_action( 'jannah_before_theme_panel' );?>

	<div class="tie-panel">

		<div class="tie-panel-tabs">
			<a href="http://tielabs.com/" target="_blank" class="tie-logo">
				<img class="tie-logo-normal" src="<?php echo JANNAH_TEMPLATE_URL .'/framework/admin/assets/images/tielabs-logo.png' ?>" alt="<?php esc_html_e( 'TieLabs', 'jannah' ) ?>" />
				<img class="tie-logo-mini" src="<?php echo JANNAH_TEMPLATE_URL .'/framework/admin/assets/images/tielabs-logo-mini.png' ?>" alt="<?php esc_html_e( 'TieLabs', 'jannah' ) ?>" />
			</a>

			<ul>
				<?php
					foreach( $settings_tabs as $tab => $settings ){

						$icon  = $settings['icon'];
						$title = $settings['title'];

						echo "
							<li class=\"tie-tabs tie-options-tab-$tab\">
								<a href=\"#tie-options-tab-$tab\">
									<span class=\"dashicons-before dashicons-$icon tie-icon-menu\"></span>
									$title
								</a>
							</li>
						";
					}
				?>

				<li class="tie-tabs tie-rate tie-not-tab"><a target="_blank" href="http://themeforest.net/downloads?ref=tielabs&utm_source=theme-panel&utm_medium=link&utm_campaign=jannah"><span class="dashicons-before dashicons-star-filled tie-icon-menu"></span><?php esc_html_e( 'Rate', 'jannah' ) ?> <?php echo JANNAH_THEME_NAME ?></a></li>
				<li class="tie-tabs tie-more tie-not-tab"><a target="_blank" href="http://themeforest.net/user/tielabs/portfolio?ref=tielabs&utm_source=theme-panel&utm_medium=link&utm_campaign=jannah"><span class="dashicons-before dashicons-smiley tie-icon-menu"></span><?php esc_html_e( 'More Themes', 'jannah' ) ?></a></li>
			</ul>
			<div class="clear"></div>
		</div> <!-- .tie-panel-tabs -->

		<div class="tie-panel-content">

			<div id="theme-options-search-wrap">
				<input id="theme-panel-search" type="text" placeholder="<?php esc_html_e( 'Search', 'jannah' ) ?>">
				<div id="theme-search-list-wrap" class="has-custom-scroll">
					<ul id="theme-search-list"></ul>
				</div>
			</div>


			<form action="/" name="tie_form" id="tie_form">

				<?php
				foreach( $settings_tabs as $tab => $settings ){

					echo "
					<!-- $tab Settings -->
					<div id=\"tie-options-tab-$tab\" class=\"tabs-wrap\">";

					get_template_part( 'framework/admin/theme-options/'.$tab );

					do_action( 'jannah_theme_options_tab_'.$tab );

					echo "</div>";

				}
				?>

				<?php wp_nonce_field( 'tie-theme-data', 'tie-security' ); ?>
				<input type="hidden" name="action" value="tie_theme_data_save" />

				<div class="tie-footer">
					<?php do_action( 'jannah_save_button' ); ?>
				</div>

			</form>

		</div><!-- .tie-panel-content -->
		<div class="clear"></div>
	</div><!-- .tie-panel -->
	<?php
}



/*-----------------------------------------------------------------------------------*/
# Share buttons
/*-----------------------------------------------------------------------------------*/
function jannah_get_share_buttons_options( $share_position = '' ){

	$position = ! empty( $share_position ) ? '_'.$share_position : '';

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Twitter', 'jannah' ),
			'id'     => 'share_twitter'.$position,
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Facebook', 'jannah' ),
			'id'   => 'share_facebook'.$position,
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Google+', 'jannah' ),
			'id'   => 'share_google'.$position,
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'LinkedIn', 'jannah' ),
			'id'   => 'share_linkedin'.$position,
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'StumbleUpon', 'jannah' ),
			'id'   => 'share_stumbleupon'.$position,
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Pinterest', 'jannah' ),
			'id'   => 'share_pinterest'.$position,
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Reddit', 'jannah' ),
			'id'   => 'share_reddit'.$position,
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Tumblr', 'jannah' ),
			'id'   => 'share_tumblr'.$position,
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'VKontakte', 'jannah' ),
			'id'   => 'share_vk'.$position,
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Odnoklassniki', 'jannah' ),
			'id'   => 'share_odnoklassniki'.$position,
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Pocket', 'jannah' ),
			'id'   => 'share_pocket'.$position,
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'WhatsApp', 'jannah' ),
			'id'   => 'share_whatsapp'.$position,
			'type' => 'checkbox',
			'hint' => ( $share_position != 'mobile' ) ? esc_html__( 'For Mobiles Only', 'jannah' ) : '',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Telegram', 'jannah' ),
			'id'   => 'share_telegram'.$position,
			'type' => 'checkbox',
			'hint' => ( $share_position != 'mobile' ) ? esc_html__( 'For Mobiles Only', 'jannah' ) : '',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Viber', 'jannah' ),
			'id'   => 'share_viber'.$position,
			'type' => 'checkbox',
			'hint' => ( $share_position != 'mobile' ) ? esc_html__( 'For Mobiles Only', 'jannah' ) : '',
		));

	if( $share_position != 'mobile' ){
		jannah_theme_option(
			array(
				'name' => esc_html__( 'Email', 'jannah' ),
				'id'   => 'share_email'.$position,
				'type' => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Print', 'jannah' ),
				'id'   => 'share_print'.$position,
				'type' => 'checkbox',
			));
	}

}

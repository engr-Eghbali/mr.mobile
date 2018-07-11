<?php
/**
 * Dashboard main file
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*-----------------------------------------------------------------------------------*/
# Custom Admin Bar Menus
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_bar_menu', 'jannah_add_to_admin_bar', 150 );
function jannah_add_to_admin_bar( $wp_admin_bar ){

	if ( jannah_get_option( 'theme_toolbar' ) && current_user_can( 'switch_themes' )){
		$wp_admin_bar->add_menu( array(
			'parent' => 0,
			'id'     => 'tiepanel',
			'title'  => JANNAH_THEME_NAME,
			'href'   => add_query_arg( array( 'page' => 'tie-theme-options' ), admin_url( 'admin.php' ) ),
		));
	}
}





/*-----------------------------------------------------------------------------------*/
# Rturn if current page is not ADMIN
/*-----------------------------------------------------------------------------------*/
if( ! is_admin() ){
	return;
}





/*-----------------------------------------------------------------------------------*/
# Arqam Lite Documentation URL
/*-----------------------------------------------------------------------------------*/
add_filter( 'arqam_lite_docs_url', 'jannah_arqam_lite_docs_url' );
function jannah_arqam_lite_docs_url( $url ) {
	return esc_url( 'https://jannah.helpscoutdocs.com/' );
}





/*-----------------------------------------------------------------------------------*/
# Include the requried files
/*-----------------------------------------------------------------------------------*/
locate_template( 'framework/admin/framework-validation.php',   true, true );
locate_template( 'framework/admin/menu-limit-detector.php',    true, true );
locate_template( 'framework/admin/framework-options.php',      true, true );
locate_template( 'framework/admin/framework-notices.php',      true, true );
locate_template( 'framework/admin/theme-options.php',          true, true );
locate_template( 'framework/admin/category-options.php',       true, true );
locate_template( 'framework/admin/posts-options.php',          true, true );
locate_template( 'framework/admin/page-builder.php',           true, true );
locate_template( 'framework/admin/page-builder-widgets.php',   true, true );
locate_template( 'framework/admin/demo-importer.php',          true, true );
locate_template( 'framework/admin/required-plugins.php',       true, true );
locate_template( 'framework/admin/update-notifier.php',        true, true );
locate_template( 'framework/admin/framework-welcome.php',      true, true );
locate_template( 'framework/admin/framework-system-status.php',true, true );





/*-----------------------------------------------------------------------------------*/
# Register main Scripts and Styles
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_enqueue_scripts', 'jannah_admin_enqueue_scripts' );
function jannah_admin_enqueue_scripts(){

	# Enqueue dashboard scripts and styles ----------
	wp_enqueue_script( 'tie-admin-scripts', JANNAH_TEMPLATE_URL .'/framework/admin/assets/tie.js',         array( 'jquery', 'jquery-ui-sortable', 'jquery-ui-draggable', 'wp-color-picker' ), JANNAH_DB_VERSION, false );
	wp_enqueue_style ( 'tie-admin-style',   JANNAH_TEMPLATE_URL.'/framework/admin/assets/style.css',       array(), JANNAH_DB_VERSION, 'all' );
	wp_enqueue_style ( 'tie-fontawesome',   JANNAH_TEMPLATE_URL.'/fonts/fontawesome/font-awesome.min.css', array(), JANNAH_DB_VERSION, 'all' );
  wp_enqueue_style ( 'wp-color-picker' );

	$tie_lang = array(
		'update' => esc_html__( 'Update', 'jannah' ),
		'search' => esc_html__( 'Search', 'jannah' ),
	);
	wp_localize_script( 'tie-admin-scripts', 'tieLang', $tie_lang );

}





/*-----------------------------------------------------------------------------------*/
# Install the default theme settings
/*-----------------------------------------------------------------------------------*/
add_action( 'after_switch_theme', 'jannah_install_theme', 1 );
function jannah_install_theme(){

	$default_data = jannah_default_theme_settings();

	# Save the default settings ----------
	if( ! get_option( 'tie_jannah_ver' ) && ! get_option( 'tie_jannah_options' ) ){

		# Store the default settings ----------
		jannah_save_theme_options( $default_data );

		# Store the DB theme's version ----------
		update_option( 'tie_jannah_ver', JANNAH_DB_VERSION );

		# Store the data of installing the theme temporarily
		update_option( 'tie_jannah_install_date', time() );
	}

	# WooCommerce ----------
	if( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
		$catalog = array(
			'width'  => '450',
			'height' => '600',
			'crop'   => 1,
		);

		$single = array(
			'width' 	=> '800',
			'height'	=> '1000',
			'crop'		=> 1,
		);

		$thumbnail = array(
			'width' 	=> '200',
			'height'	=> '200',
			'crop'		=> 1,
		);

		update_option( 'shop_catalog_image_size',   $catalog   );
		update_option( 'shop_single_image_size',    $single    );
		update_option( 'shop_thumbnail_image_size', $thumbnail );
	}

	# Redirect to the Welcome page ----------
	wp_safe_redirect( add_query_arg( array( 'page' => 'tie-theme-welcome' ), admin_url( 'admin.php' ) ));
}





/*-----------------------------------------------------------------------------------*/
# Default theme settings
/*-----------------------------------------------------------------------------------*/
function jannah_default_theme_settings(){

	$default_settings = array(
		'tie_options' => array(

			'site_width'                        => '1200px',

			# General Settings ----------
			'time_format'                       => 'modern',
			'breadcrumbs'                       => 'true',
			'breadcrumbs_delimiter'             => '&#47;',

			'structure_data'                    => 'true',
			'schema_type'                       => 'NewsArticle',

			# Layout ----------
			'theme_layout'                      => 'full',
			'boxes_style'                       => 1,
			'loader-icon'                       => 1,

			# Header ----------
			'header_layout'                     => '3',
			'main_nav'                          => 'true',
			'main_nav_dark'                     => 'true',
			'main_nav_layout'                   => 'true',
			'main-nav-components_search'       	=> 'true',
			'main-nav-components_live_search'   => 'true',
			'main-nav-components_search_layout' => 'default',
			'main-nav-components_social_layout' => 'compact',
			'stick_nav'                         => 'true',
			'sticky_behavior'                   => 'default',
			'top_nav'                           => 'true',
			'top_date'                          => 'true',
			'todaydate_format'                  => 'l, F j Y',
			'top-nav-area-1'                    => 'breaking',
			'breaking_effect'                   => 'reveal',
			'breaking_arrows'                   => 'true',
			'breaking_type'                     => 'category',
			'breaking_number'                   => 10,
			'top-nav-area-2'                    => 'components',
			'top-nav-components_slide_area'     => 'true',
			'top-nav-components_login'          => 'true',
			'top-nav-components_random'         => 'true',
			'top-nav-components_cart'           => 'true',

			# Logo ----------
			'logo_setting'                      => 'logo',

			# Footer ----------
			'footer_widgets_area_1'             => 'true',
			'footer_widgets_layout_area_1'      => 'footer-3c',
			'footer_widgets_area_2'             => 'true',
			'footer_widgets_layout_area_2'      => 'wide-left-3c',
			'copyright_area'                    => 'true',
			'footer_top'                        => 'true',
			'footer_social'                     => 'true',
			'footer_one'                        => '&copy; Copyright %year%, All Rights Reserved',

			# Mobile ----------
			'mobile_menu_active'                => 'true',
			'mobile_menu_search'                => 'true',
			'mobile_menu_social'                => 'true',
			'share_post_mobile'                 => 'true',
			'share_twitter_mobile'              => 'true',
			'share_facebook_mobile'             => 'true',
			'share_whatsapp_mobile'             => 'true',
			'share_telegram_mobile'             => 'true',

			# Aechives ----------
			'trim_type'                         => 'words',

			'blog_display'                      => 'excerpt',
			'blog_excerpt_length'               => 20,
			'blog_pagination'                   => 'next-prev',

			'category_display'                      => 'excerpt',
			'category_excerpt_length'           => 20,
			'category_pagination'                   => 'next-prev',

			'tag_display'                      => 'excerpt',
			'tag_excerpt_length'                => 20,
			'tag_pagination'                   => 'next-prev',

			'author_excerpt_length'             => 20,
			'search_excerpt_length'             => 20,
			'tag_desc'                          => 'true',
			'category_desc'                     => 'true',
			'author_bio'                        => 'true',
			'search_exclude_post_types'         => array( 'page' ),

			# Single post layout ----------
			'post_layout'                       => 1,
			'post_featured'                     => 'true',
			'image_lightbox'                    => 'true',
			'post_og_cards'                     => 'true',
			'reading_indicator'                 => 'true',
			'post_authorbio'                    => 'true',
			'post_cats'                         => 'true',
			'post_tags'                         => 'true',
			'post_meta'                         => 'true',
			'post_author'                       => 'true',
			'post_author_avatar'                => 'true',
			'post_date'                         => 'true',
			'post_comments'                     => 'true',
			'post_views'                        => 'true',
			'reading_time'                      => 'true',
			'post_newsletter_text'              => '
<h4>With Product You Purchase</h4>
<h3>Subscribe to our mailing list to get the new updates!</h3>
<p>Lorem ipsum dolor sit amet, consectetur.</p>',
			'related'                           => 'true',
			'related_number'                    => 3,
			'related_number_full'               => 4,
			'related_query'                     => 'category',
			'related_order'                     => 'rand',
			'check_also'                        => 'true',
			'check_also_position'               => 'right',
			'check_also_number'                 => 1,
			'check_also_query'                  => 'category',
			'check_also_order'                  => 'rand',

			# Share Posts ----------
			'select_share'                      => 'true',

			'share_style_top'                   => 'style_3',
			'share_center_top'                  => 'true',
			'share_twitter_top'                 => 'true',
			'share_facebook_top'                => 'true',
			'share_google_top'                  => 'true',
			'share_linkedin_top'                => 'true',
			'share_stumbleupon_top'             => 'true',

			'share_post_bottom'                 => 'true',
			'share_twitter'                     => 'true',
			'share_facebook'                    => 'true',
			'share_google'                      => 'true',
			'share_linkedin'                    => 'true',
			'share_stumbleupon'                 => 'true',
			'share_pinterest'                   => 'true',
			'share_reddit'                      => 'true',
			'share_tumblr'                      => 'true',
			'share_vk'                          => 'true',
			'share_email'                       => 'true',
			'share_print'                       => 'true',

			# Sidebar ----------
			'widgets_icon'                      => 'true',
			'sidebar_pos'                       => 'right',
			'sticky_sidebar'                    => 'true',

			# LightBox ----------
			'lightbox_all'                      => 'true',
			'lightbox_gallery'                  => 'true',
			'lightbox_skin'                     => 'dark',
			'lightbox_thumbs'                   => 'horizontal',
			'lightbox_arrows'                   => 'true',

			# Background ----------
			'background_pattern'                 => 'body-bg1',
			'background_dimmer_color'            => 'black',

			# Styling ----------
			'inline_css'                        => 'true',

			# Advanced ----------
			'tie_post_views'                    => 'theme',
			'views_meta_field'                  => 'tie_views',
			'notify_theme'                      => 'true',
		)
	);

	if( is_rtl() ){
		$default_settings['tie_options']['sidebar_pos']             = 'left';
		$default_settings['tie_options']['bbpress_sidebar_pos']     = 'left';
		$default_settings['tie_options']['woo_sidebar_pos']         = 'left';
		$default_settings['tie_options']['woo_product_sidebar_pos'] = 'left';

		$default_settings['tie_options']['typography_headings_font_source'] = 'fontfaceme';
		$default_settings['tie_options']['typography_headings_google_font'] = 'faceme#bein-normal';

		$default_settings['tie_options']['typography_menu_font_source'] = 'google';
		$default_settings['tie_options']['typography_menu_google_font'] = 'early#Noto Sans Kufi Arabic';

		$default_settings['tie_options']['typography_blockquote_font_source'] = 'google';
		$default_settings['tie_options']['typography_blockquote_google_font'] = 'early#Noto Kufi Arabic';

		$default_settings['tie_options']['typography_post_small_title_blocks']['weight'] = '500';
		$default_settings['tie_options']['typography_single_post_title']['line_height']  = '1.3';
	}
	else{
		$default_settings['tie_options']['typography_headings_font_source'] = 'google';
		$default_settings['tie_options']['typography_headings_google_font'] = 'Poppins';
		$default_settings['tie_options']['typography_headings_google_variants'] = array( 'regular', '500', '600', '700');
	}

	return $default_settings;
}





/*-----------------------------------------------------------------------------------*/
# Add user's social accounts
/*-----------------------------------------------------------------------------------*/
add_action( 'show_user_profile', 'jannah_user_profile_custom_options' );
add_action( 'edit_user_profile', 'jannah_user_profile_custom_options' );
function jannah_user_profile_custom_options( $user ){ ?>

	<h3><?php esc_html_e( 'Custom Author widget', 'jannah' ) ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="author_widget_content"><?php esc_html_e( 'Custom Author widget content', 'jannah' ) ?></label></th>
			<td>
				<textarea name="author_widget_content" id="author_widget_content" rows="5" cols="30"><?php echo esc_textarea( get_the_author_meta( 'author_widget_content', $user->ID ) ); ?></textarea>
				<br /><span class="description"><?php esc_html_e( 'Supports: Text, HTML and Shortcodes.', 'jannah' ) ?></span>
			</td>
		</tr>
	</table>

	<h3><?php esc_html_e( 'Social Networks', 'jannah' ) ?></h3>
	<table class="form-table">

		<?php

			$author_social = jannah_author_social_array();

			foreach ( $author_social as $network => $button ){ ?>

				<tr>
					<th><label for="<?php echo esc_attr( $network ) ?>"><?php echo esc_html( $button['text'] ) ?></label></th>
					<td>
						<input type="text" name="<?php echo esc_attr( $network ) ?>" id="<?php echo esc_attr( $network ) ?>" value="<?php echo esc_attr( get_the_author_meta( $network, $user->ID )); ?>" class="regular-text" /><br />
					</td>
				</tr>

				<?php
			}
		?>
	</table>
	<?php
}





/*-----------------------------------------------------------------------------------*/
# Save user's custom fields
/*-----------------------------------------------------------------------------------*/
add_action( 'personal_options_update',  'jannah_save_user_profile_custom_options' );
add_action( 'edit_user_profile_update', 'jannah_save_user_profile_custom_options' );
function jannah_save_user_profile_custom_options( $user_id ){

	if ( ! current_user_can( 'edit_user', $user_id )){
		return false;
	}

	update_user_meta( $user_id, 'author_widget_content', $_POST['author_widget_content'] );
	//update_user_meta( $user_id, 'author-cover-bg',       $_POST['author-cover-bg'] );

	# Save the social networks ----------
	$author_social = jannah_author_social_array();
	$author_social = apply_filters( 'jannah_author_social_array', $author_social );

	foreach ( $author_social as $network => $button ){
		update_user_meta( $user_id, $network, $_POST[ $network ] );
	}
}





/*-----------------------------------------------------------------------------------*/
# Get List of custom sliders
/*-----------------------------------------------------------------------------------*/
function jannah_get_custom_sliders( $label = false ){

	$sliders = array();

	if( ! empty( $label )){
		$sliders[] = esc_html__( '- Select a slider -', 'jannah' );
	}

	$args = array(
		'post_type'        => 'tie_slider',
		'post_status'      => 'publish',
		'posts_per_page'   => 500,
		'offset'           => 0,
		'no_found_rows'    => 1,
		'suppress_filters' => false,
		'no_found_rows'    => true,
	);

	$sliders_list = get_posts( $args );

	if( ! empty( $sliders_list ) && is_array( $sliders_list ) ){
		foreach ( $sliders_list as $slide ){
		   $sliders[ $slide->ID ] = $slide->post_title;
		}
	}

	return $sliders;
}





/*-----------------------------------------------------------------------------------*/
# Get all categories as array of ID and name
/*-----------------------------------------------------------------------------------*/
function jannah_get_categories_array( $label = false ){

	$categories = array();

	if( ! empty( $label )){
		$categories[] = esc_html__( '- Select a category -', 'jannah' );
	}

	$get_categories = get_categories( 'hide_empty=0' );

	if( ! empty( $get_categories ) && is_array( $get_categories ) ){
		foreach ( $get_categories as $category ){
			$categories[ $category->cat_ID ] = $category->cat_name;
		}
	}

	return $categories;
}





/*-----------------------------------------------------------------------------------*/
# Get all menus as array of ID and name
/*-----------------------------------------------------------------------------------*/
function jannah_get_menus_array( $label = false ){

	$menus = array();

	if( ! empty( $label )){
		$menus[] = esc_html__( '- Select a menu -', 'jannah' );
	}

	$get_menus = get_terms( array( 'taxonomy' => 'nav_menu', 'hide_empty' => false ) );

	if( ! empty( $get_menus )){
		foreach ( $get_menus as $menu ){
			$menus[ $menu->term_id ] = $menu->name;
		}
	}

	return $menus;
}





/*-----------------------------------------------------------------------------------*/
# Get List of custom Sidebars
/*-----------------------------------------------------------------------------------*/
function jannah_get_registered_sidebars(){
	global $wp_registered_sidebars;

	$sidebars      = array( '' => esc_html__( 'Default', 'jannah' ) );
	$sidebars_list = $wp_registered_sidebars;

	$custom_sidebars = jannah_get_option( 'sidebars' );
	if( ! empty( $custom_sidebars ) && is_array( $custom_sidebars )){
		foreach ( $custom_sidebars as $sidebar ){

			// Remove sanitized custom sidebars titles from the sidebars array.
			$sanitized_sidebar = sanitize_title( $sidebar );
			unset( $sidebars_list[ $sanitized_sidebar ] );

			// Add the Unsanitized custom sidebars titles to the array.
			$sidebars_list[ $sidebar ] = array( 'name' => $sidebar );
		}
	}


	if( ! empty( $sidebars_list ) && is_array( $sidebars_list )){
		foreach( $sidebars_list as $name => $sidebar ){
			$sidebars[ $name ] = $sidebar['name'];
		}
	}

	return $sidebars;
}





/*-----------------------------------------------------------------------------------*/
# Get all WooCommerce categories as array of ID and name
/*-----------------------------------------------------------------------------------*/
function jannah_get_products_categories_array( $label = false ){

	if( ! JANNAH_WOOCOMMERCE_IS_ACTIVE ){
		return;
	}

	$categories = array();

	if( ! empty( $label )){
		$categories = array( '' => esc_html__( '- Select a category -', 'jannah' ));
	}

	$get_categories = get_categories( array( 'hide_empty'	=> 0, 'taxonomy' => 'product_cat' ) );

	if( ! empty( $get_categories ) && is_array( $get_categories ) ){
		foreach ( $get_categories as $category ){
			$categories[ $category->cat_ID ] = $category->cat_name;
		}
	}

	return $categories;
}





/*-----------------------------------------------------------------------------------*/
# Get Latest version number
/*-----------------------------------------------------------------------------------*/
function jannah_get_latest_theme_data( $key = '', $token = false, $force_update = false, $update_files = false ){

	# Options and vars ----------
	$cache_field     = 'tie-data-'.JANNAH_THEME_FOLDER;
	$plugins_field   = 'tie-plugins-data-'.JANNAH_THEME_FOLDER;
	$token_key       = 'tie_token_'.JANNAH_THEME_ENVATO_ID;
	$token_error_key = 'tie_token_error_'.JANNAH_THEME_ENVATO_ID;
	$request_url     = 'http://tielabs.com/?envato_get_data';


	if( $update_files && ! get_transient( $plugins_field ) ){
		delete_transient( $cache_field );
	}

	# Debug ----------
	//delete_option( $token_key );
	//delete_transient( $cache_field );

	# Use the given $token and force update the TieLabs data from Envato ----------
	if( $token !== false ){
		delete_transient( $cache_field );
		$force_update = true;
	}
	# Get data by the stored token ----------
	else{
		$cached_data = get_transient( $cache_field );
		$token = get_option( $token_key );
	}


	# Get the Cached data ----------
	if( empty( $cached_data ) && ! empty( $token )){

		# Prepare the remote post ----------
		$response = wp_remote_post( $request_url, array(
			'body' => array(
				'tie_token'    => $token,
				'item_id'      => JANNAH_THEME_ENVATO_ID,
				'item_version' => get_option( 'tie_jannah_ver' ),
				'force_update' => $force_update,
				'update_files' => $update_files,

				'blog_url'       => esc_url(home_url( '/' )),
				'php_version'    => phpversion(),
				'theme_version'  => jannah_get_current_version(),
				'demo_installed' => get_option( 'tie_jannah_installed_demo' ),
			),
			'sslverify' => false,
		));


		# Check if it is a valid responce ----------
		if ( is_wp_error( $response ) || 200 !== $response['response']['code'] ){

			update_option( $token_error_key, $response['response']['code'] .': '. $response['response']['message'] );
		}
		else{
			$cached_data = wp_remote_retrieve_body( $response );
			$cached_data = json_decode( $cached_data, true );


			if( ! empty( $cached_data['status'] ) && $cached_data['status'] == 1 ){

				delete_option( $token_error_key );

				set_transient( $cache_field, $cached_data, 24 * HOUR_IN_SECONDS );
				update_option( $token_key, $token );

				if( $update_files ){
					set_transient( $plugins_field, 'true', HOUR_IN_SECONDS );
				}

			}
			else{

				if( isset( $cached_data['status'] ) && $cached_data['status'] == 0 ){
					update_option( $token_error_key, $cached_data['error'] );

					delete_option( $token_key );
					delete_transient( $cache_field );
				}
			}

		}

	}

	// Debug
	//var_dump( $cached_data );

	# return the data ----------
	if( ! empty( $cached_data )){

		if( ! empty( $key ) ){
			if( ! empty( $cached_data[ $key ] )){
				return $cached_data[ $key ];
			}
		}
		else{
			return $cached_data;
		}
	}


	return false;
}





/*-----------------------------------------------------------------------------------*/
# Remove Empty values from the Multi Dim Arrays
/*-----------------------------------------------------------------------------------*/
function jannah_array_filter_recursive( $input ){

	foreach ( $input as &$value ){

	  if( is_array( $value )){
      $value = jannah_array_filter_recursive($value);
	  }
	}

	return array_filter($input);
}





/*-----------------------------------------------------------------------------------*/
# Move the custom theme Mods to the Child theme
/*-----------------------------------------------------------------------------------*/
add_action( 'after_switch_theme', 'jannah_switch_theme_update_mods' );
function jannah_switch_theme_update_mods() {

	if ( is_child_theme() ) {

		$mods = get_option( 'theme_mods_' . get_option( 'template' ) );

		if ( false !== $mods ) {
			foreach ( (array) $mods as $mod => $value ) {
				set_theme_mod( $mod, $value );
			}
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Prune the WP Super Cache.
/*-----------------------------------------------------------------------------------*/
add_action( 'jannah_options_updated', 'jannah_clear_super_cache' );
function jannah_clear_super_cache() {

	if ( function_exists( 'prune_super_cache' ) ) {
		global $cache_path;

		prune_super_cache( $cache_path . 'supercache/', true );
		prune_super_cache( $cache_path, true );
	}
}





/*-----------------------------------------------------------------------------------*/
# Changing the base and the ID of the theme options page to Widgets!!!!
# We use this method to force the plugins to load their JS files so we cbe able
# to store it every time the user access the theme options page to be used later
# in the Page builder.
# Added: tiebase: so we can check if this is the theme options page.
/*-----------------------------------------------------------------------------------*/
add_action( 'load-toplevel_page_tie-theme-options',       'jannah_theme_pages_screen_data', 99 );
add_action( 'load-jannah_page_tie-theme-welcome',         'jannah_theme_pages_screen_data', 99 );
add_action( 'load-jannah_page_tie-system-status',         'jannah_theme_pages_screen_data', 99 );
add_action( 'load-jannah_page_tie-one-click-demo-import', 'jannah_theme_pages_screen_data', 99 );
function jannah_theme_pages_screen_data() {
	global $current_screen;

	$current_screen->base    = 'widgets';
	$current_screen->id      = 'widgets';
	$current_screen->tiebase = str_replace( 'load-', '', current_filter() );
}







/*-----------------------------------------------------------------------------------*/
# Welcome Page ARGS
/*-----------------------------------------------------------------------------------*/
add_filter( 'jannah_welcome_args', 'jannah_welcome_args' );
function jannah_welcome_args( $args ){

	$args['img']   = JANNAH_TEMPLATE_URL .'/framework/admin/assets/images/tielabs-logo-mini.png';
	$args['color'] = '#0088ff';
	$args['about'] = sprintf( esc_html__( 'You are awesome! Thanks for using our theme, %s is now installed and ready to use! Get ready to build something beautiful :)', 'jannah' ), JANNAH_THEME_NAME );

	return $args;
}





/*-----------------------------------------------------------------------------------*/
# Welcome Page contents
/*-----------------------------------------------------------------------------------*/
add_filter( 'jannah_welcome_splash_content', 'jannah_welcome_splash_content' );
function jannah_welcome_splash_content(){

	if( ! get_option( 'tie_token_'.JANNAH_THEME_ENVATO_ID ) ){
		jannah_notice_not_authorize_theme( false );
	} ?>

	<h2><?php printf( esc_html__( 'Need help? We\'re here %s', 'jannah' ), '&#x1F60A' ); ?></h2>

	<div class="changelog">

		<div class="under-the-hood">
			<div class="col">
				<p><?php printf( wp_kses_post( 'Jannah comes with 6 months of free support for every license you purchase. Support can be <a target="_blank" href="%1s">extended through subscriptions via ThemeForest</a>. All support is handled through our <a target="_blank" href="%2s">support center</a>. Below are all the resources we offer in our support center.', 'jannah' ), 'https://help.market.envato.com/hc/en-us/articles/207886473-Extending-and-Renewing-Item-Support', 'https://tielabs.com/help/' ); ?></p>
			</div>
		</div>

		<div class="under-the-hood three-col">
			<div class="col">
				<h3><span class="dashicons dashicons-sos"></span> <?php esc_html_e( 'Submit a Ticket', 'jannah' ); ?></h3>
				<p><?php esc_html_e( 'Need one-to-one assistance? Get in touch with our Support team.', 'jannah' ); ?></p>
				<a target="_blank" class="button button-primary button-hero" href="https://tielabs.com/members/open-new-ticket/"><?php esc_html_e( 'Submit a Ticket', 'jannah' ); ?></a>
			</div>

			<div class="col">
				<h3><span class="dashicons dashicons-book"></span> <?php esc_html_e( 'Knowledge Base', 'jannah' ); ?></h3>
				<p><?php esc_html_e( 'This is the place to go to reference different aspects of the theme.', 'jannah' ); ?></p>
				<a target="_blank" class="button button-primary button-hero" href="https://jannah.helpscoutdocs.com"><?php esc_html_e( 'Browse the Knowledge Base', 'jannah' ); ?></a>
			</div>

			<div class="col">
				<h3><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Troubleshooting', 'jannah' ); ?></h3>
				<p><?php esc_html_e( 'If something is not working as expected, Please try these common solutions.', 'jannah' ); ?></p>
				<a target="_blank" class="button button-primary button-hero" href="https://tielabs.com/help/troubleshooting/"><?php esc_html_e( 'Visit The Page', 'jannah' ); ?></a>
			</div>
		</div>
	</div>

	<hr />

	<ul id="follow-tielabs">
		<li class="follow-tielabs-fb">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=280065775530401";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-like" data-href="https://facebook.com/tielabs" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
		</li>

		<li class="follow-tielabs-twitter">
			<a href="https://twitter.com/tielabs" class="twitter-follow-button" data-size="large" data-show-count="false">Follow @tielabs</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
			<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		</li>
	</ul>

	<?php
}

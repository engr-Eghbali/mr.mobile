<?php
/**
 * Theme Notifier module
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if( ! jannah_get_option( 'notify_theme' )){
	return;
}


/*-----------------------------------------------------------------------------------*/
# Set custom menu for the updates
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_menu', 'jannah_update_notifier_menu', 11 );
function jannah_update_notifier_menu(){
	$latest_version  = jannah_get_latest_theme_data( 'version' );
	$current_version = jannah_get_current_version();

	if( ! empty( $current_version ) && version_compare( $latest_version, $current_version, '>' )){

		$menu = 'add_'.'submenu'.'_page'; //#####

		$menu(
			'tie-theme-options',
			JANNAH_THEME_NAME . esc_html__( 'Theme Updates', 'jannah' ),
			esc_html__( 'Update', 'jannah' ) . ' <span class="update-plugins tie-theme-update"><span class="update-count">'.$latest_version .'</span></span>',
			'administrator',
			'theme-update-notifier',
			'jannah_redirect_to_update_notifier'
		);

		add_filter( 'jannah_theme_options_titles', 'jannah_add_theme_updates_tab_title' );
		add_action( 'jannah_theme_options_tab_theme-updates', 'jannah_add_theme_updates_tab' );

	}
}



/*-----------------------------------------------------------------------------------*/
# Get Current Theme version
/*-----------------------------------------------------------------------------------*/
function jannah_get_current_version(){

	$theme = wp_get_theme();

	$current_theme_version = $theme->parent() ? $theme->parent()->get('Version') : $theme->get('Version');

	if( ! empty( $current_theme_version ) ){
		return $current_theme_version;
	}

	return false;
}


/*-----------------------------------------------------------------------------------*/
# Notifier Page
/*-----------------------------------------------------------------------------------*/
function jannah_redirect_to_update_notifier(){

	# Redirect to the Notifier page ----------
	$updater_tab = add_query_arg( array( 'page' => 'tie-theme-options#tie-options-tab-theme-updates-target' ), admin_url( 'admin.php' ));
	echo "<script>document.location.href='$updater_tab';</script>";

}



/*-----------------------------------------------------------------------------------*/
# Add new tab for the notifier in the theme options page
/*-----------------------------------------------------------------------------------*/
function jannah_add_theme_updates_tab_title( $settings_tabs ){

	$settings_tabs['theme-updates'] = array(
		'icon'  => 'update',
		'title' => esc_html__( 'Theme Update', 'jannah' ) . ' <span class="tie-theme-update"><span class="update-count">'.esc_html__( 'New', 'jannah' ).'</span></span>',
	);

	return $settings_tabs;
}



/*-----------------------------------------------------------------------------------*/
# Add new section for the notifier in the theme options page
/*-----------------------------------------------------------------------------------*/
function jannah_add_theme_updates_tab(){
	$latest_version  = jannah_get_latest_theme_data( 'version' );
	$current_version = jannah_get_current_version();

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'New Theme Update', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'text' => '<strong>'. sprintf( esc_html__( 'There is a new version of the %s theme available.', 'jannah' ), JANNAH_THEME_NAME ) .'</strong> '. sprintf( esc_html__( 'You have version %1$s installed. Update to version %2$s .', 'jannah' ), $current_version, $latest_version ),
			'type' => 'message',
		));

	?>
	<div class="tie-theme-updates-buttons">
		<a class="tie-primary-button button button-primary button-large" href="https://tielabs.com/changelogs/?id=19659555" target="_blank"><?php esc_html_e( 'View the ChangeLog Details', 'jannah' ) ?></a>
		<a class="tie-primary-button button button-secondary button-large" href="https://tielabs.com/go/update-themes" target="_blank"><?php esc_html_e( 'How Do I Update My Theme?', 'jannah' ) ?></a>
	</div>
<?php
}

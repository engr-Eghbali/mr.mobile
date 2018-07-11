<?php
/**
 * Jannah functions and definitions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



/*-----------------------------------------------------------------------------------*/
# Define Constants
/*-----------------------------------------------------------------------------------*/
define( 'JANNAH_DB_VERSION',            '1.0.1' );
define( 'JANNAH_THEME_NAME',            'Jannah' );
define( 'JANNAH_THEME_FOLDER',          'jannah' );
define( 'JANNAH_THEME_ENVATO_ID',       '19659555' );
define( 'JANNAH_TEMPLATE_PATH',         get_template_directory() );
define( 'JANNAH_TEMPLATE_URL',          get_template_directory_uri() );
define( 'JANNAH_BWPMINIFY_IS_ACTIVE',   class_exists( 'BWP_MINIFY' ) );
define( 'JANNAH_BBPRESS_IS_ACTIVE',     class_exists( 'bbPress' ) );
define( 'JANNAH_BUDDYPRESS_IS_ACTIVE',  class_exists( 'BuddyPress' ) );
define( 'JANNAH_LS_Sliders_IS_ACTIVE',  class_exists( 'LS_Sliders' ) );
define( 'JANNAH_REVSLIDER_IS_ACTIVE',   class_exists( 'RevSlider' ) );
define( 'JANNAH_WOOCOMMERCE_IS_ACTIVE', class_exists( 'WooCommerce' ) );
DEFINE( 'JANNAH_MPTIMETABLE_IS_ACTIVE', class_exists( 'Mp_Time_Table' ) );
define( 'JANNAH_AMP_IS_ACTIVE',					function_exists( 'amp_init' ) );
define( 'JANNAH_ARQAM_IS_ACTIVE',       function_exists( 'arqam_init' ) );
define( 'JANNAH_TAQYEEM_IS_ACTIVE',     function_exists( 'taqyeem_get_option' ) );
define( 'JANNAH_INSTANOW_IS_ACTIVE',    function_exists( 'tie_insta_media' ) );
define( 'JANNAH_EXTENSIONS_IS_ACTIVE',  function_exists( 'jannah_extensions_shortcodes_scripts' ) );



/*-----------------------------------------------------------------------------------*/
# Require Files
# With locate_template you can override these files with child theme it uses
# load_template() to include the files which uses require_once()
/*-----------------------------------------------------------------------------------*/
locate_template( 'framework/functions/theme-functions.php',        true, true );
locate_template( 'framework/functions/setup.php',                  true, true );
locate_template( 'framework/functions/advertisment.php',           true, true );
locate_template( 'framework/functions/ajax.php',                   true, true );
locate_template( 'framework/functions/amp.php',                    true, true );
locate_template( 'framework/functions/speeder.php',                true, true );
locate_template( 'framework/functions/styles-footer.php',          true, true );
locate_template( 'framework/functions/mobile.php',                 true, true );
locate_template( 'framework/functions/devices.php',                true, true );
locate_template( 'framework/functions/video-playlist.php',         true, true );
locate_template( 'framework/functions/mega-menus.php',             true, true );
locate_template( 'framework/functions/wp-helper-functions.php',    true, true );
locate_template( 'framework/functions/woocommerce.php',            true, true );
locate_template( 'framework/functions/translations.php',           true, true );
locate_template( 'framework/functions/pagenavi.php',               true, true );
locate_template( 'framework/functions/post-views.php',             true, true );
locate_template( 'framework/functions/breadcrumbs.php',            true, true );
locate_template( 'framework/functions/buddypress.php',             true, true );
locate_template( 'framework/functions/formating.php',              true, true );
locate_template( 'framework/functions/images.php',                 true, true );
locate_template( 'framework/functions/media.php',                  true, true );
locate_template( 'framework/functions/foxpush.php',                true, true );
locate_template( 'framework/functions/open-graph.php',             true, true );
locate_template( 'framework/functions/page-templates.php',         true, true );
locate_template( 'framework/functions/social.php',                 true, true );
locate_template( 'framework/functions/styling.php',                true, true );
locate_template( 'framework/widgets.php',                          true, true );
locate_template( 'framework/admin/updates.php',                    true, true );
locate_template( 'framework/admin/framework-admin.php',            true, true );
locate_template( 'framework/functions/backward-compatibility.php', true, true );



/*-----------------------------------------------------------------------------------*/
# Content Width
/*-----------------------------------------------------------------------------------*/
add_action( 'after_setup_theme', 'jannah_content_width', 0 );
function jannah_content_width() {
	$content_width = 708;
	$GLOBALS['content_width'] = apply_filters( 'jannah_content_width', $content_width );
}

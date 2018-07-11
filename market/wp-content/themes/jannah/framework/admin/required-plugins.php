<?php
/**
 * TGM activation plugin
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



if( ! class_exists( 'TIE_REQUIRED_PLUGINS' )){

	class TIE_REQUIRED_PLUGINS{


		public $menu_slug = 'tie-install-plugins';



		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			# Include the main tgm activation file ----------
			locate_template( 'framework/admin/inc/tgm/class-tgm-plugin-activation.php', true, true );

			add_action( 'tgmpa_register',        array( $this, '_register_plugins' ));
			add_filter( 'jannah_about_tabs',     array( $this, '_add_about_tabs'   ));
			add_filter( 'get_user_metadata',     array( $this, '_remove_notice'    ), 10, 4 );
			add_filter( 'tgmpa_admin_menu_args', array( $this, '_admin_menu_args'  ));
		}



		/**
		 * _register_plugins
		 *
		 */
		function _register_plugins(){

			# To get the installable plugins links ----------
			$update_files = false;
			if ( isset( $_GET['page'] ) && $_GET['page'] == 'tie-install-plugins' ){
				$update_files = true;
			}

			# Get the TieLabs API PLugins ----------
			if( get_option( 'tie_token_'.JANNAH_THEME_ENVATO_ID ) && jannah_get_latest_theme_data( 'plugins' ) ){
				$plugins = jannah_get_latest_theme_data( 'plugins', false, false, $update_files );

				# Remove the Arqam Lite Plugin if the Arqam Plugin is active ----------
				if( function_exists( 'arq_counters_data' )){
					unset( $plugins['arqam-lite'] );
				}

			}

			# Force Show the Install Plugins page if the $plugins is empty ----------
			else{
			  $plugins = array(
			    array(
			      'name'   => '-',
			      'slug'   => '-',
			      'source' => '-',
			    ),
			  );
			}


			# Run TGM ----------
			if( ! empty( $plugins ) && is_array( $plugins ) ){
				$config = array(
					'id'           => JANNAH_THEME_NAME,
					'default_path' => '',
					'menu'         => 'tie-install-plugins',
					'has_notices'  => true,
					'dismissable'  => true,
					'dismiss_msg'  => '',
					'is_automatic' => false,
					'message'      => '',
				);

				tgmpa( $plugins, $config );
			}
		}



		/**
		 * _add_about_tabs
		 *
		 * Add the Install Plugins Page to the about page's tabs
		 */
		function _add_about_tabs( $tabs ){

			$tabs['plugins'] = array(
				'text' => esc_html__( 'Install Plugins', 'jannah' ),
				'url'  => menu_page_url( $this->menu_slug, false ),
			);

			return $tabs;
		}



		/**
		 * _remove_notice
		 *
		 * Remove TGM notice for users without permissions to install/update plugins
		 */
		function _remove_notice( $val, $object_id, $meta_key, $single ){

			//if( $meta_key === 'tgmpa_dismissed_notice_'.JANNAH_THEME_NAME && ( ( ! current_user_can( 'switch_themes' ) || ! current_user_can( 'install_plugins' ) ) || ! get_option( 'tie_token_'.JANNAH_THEME_ENVATO_ID ) ) ){
			if( $meta_key === 'tgmpa_dismissed_notice_'.JANNAH_THEME_NAME ){
				return true;
			}

			return null;
		}



		/**
		 * _admin_menu_args
		 *
		 * Add the TGM plugin page to the theme menu
		 */
		function _admin_menu_args( $args ){
			$args['page_title']  = esc_html__( 'Install Bundled Plugins', 'jannah' );
			$args['parent_slug'] = 'admin';
			$args['capability']  = 'switch_themes';
			return $args;
		}

	}


	# Instantiate the class ----------
	new TIE_REQUIRED_PLUGINS();

}

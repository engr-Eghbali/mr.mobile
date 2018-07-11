<?php
/**
 * Speeder Class
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly




if( ! class_exists( 'TIE_THEME_SPEEDER' )){

	class TIE_THEME_SPEEDER{


		/**
		 * $cache_time
		 * transient exiration time
		 * @var int
		 */
		public $cache_time       = JANNAH_CACHE_HOURS;
		public $cache_key        = JANNAH_CACHE_KEY;
		public $menu_transient   = 'main-nav';
		public $transient_prefix = 'tie-cache';



		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			# Check if Cache option is enabled ----------
			if ( ! jannah_get_option( 'cache' ) || ( defined( 'WP_CACHE' ) && WP_CACHE ) ) return;

			# Get the Cached copy ----------
			add_filter( 'widget_display_callback',   array( $this, 'widget_display_callback' ), 10, 3 );
			add_filter( 'pre_wp_nav_menu',           array( $this, 'pre_wp_nav_menu'),          10, 2 );

			# Update the Cache ----------
			add_filter( 'wp_nav_menu',               array( $this, 'wp_nav_menu' ), 10, 2 );
			add_action( 'wp_footer',                 array( $this, '_store_main_cache' ));

			# Reset Cache ----------
			add_action( 'wp_update_nav_menu',        array( $this, 'transient_flusher' ));
			add_action( 'add_category',              array( $this, 'transient_flusher' ));
			add_action( 'delete_category',           array( $this, 'transient_flusher' ));
			add_action( 'edit_category',             array( $this, 'transient_flusher' ));
			add_action( 'edit_terms',                array( $this, 'transient_flusher' ));
			add_action( 'delete_term',               array( $this, 'transient_flusher' ));
			add_action( 'delete_attachment',         array( $this, 'transient_flusher' ));
			add_action( 'edit_attachment',           array( $this, 'transient_flusher' ));
			add_action( 'trashed_post',              array( $this, 'transient_flusher' ));
			add_action( 'untrashed_post',            array( $this, 'transient_flusher' ));
			add_action( 'deleted_post',              array( $this, 'transient_flusher' ));
			add_action( 'save_post',                 array( $this, 'transient_flusher' ));
			add_action( 'switch_theme',              array( $this, 'transient_flusher' ));
			add_action( 'upgrader_process_complete', array( $this, 'transient_flusher' ));
			add_action( 'deleted_comment',           array( $this, 'transient_flusher' ));
			add_action( 'untrashed_comment',         array( $this, 'transient_flusher' ));
			add_action( 'spammed_comment',           array( $this, 'transient_flusher' ));
			add_action( 'unspammed_comment',         array( $this, 'transient_flusher' ));
			add_action( 'wp_set_comment_status',     array( $this, 'transient_flusher' ));
			add_action( 'activated_plugin',          array( $this, 'transient_flusher' ));
			add_action( 'deactivated_plugin',        array( $this, 'transient_flusher' ));
			add_action( 'jannah_options_updated',    array( $this, 'transient_flusher' ));
			add_action( 'jannah_after_db_update',    array( $this, 'transient_flusher' ));
		}



		/**
		 * _store_main_cache
		 *
		 * Simple function to store the cache with one request
		 * Used for Breaking News and Widgets
		 *
		 */
		function _store_main_cache(){

			if ( ! empty( $GLOBALS[ $this->cache_key ] )){

				$new_data = $GLOBALS[ $this->cache_key ];
				if ( false !== ( $cached_data = get_transient( $this->cache_key ) ) ){
					$new_data = array_replace( $cached_data, $new_data );
				}

				$new_data = preg_replace( '/<!--(.|\s)*?-->/', '', $new_data );
				set_transient( $this->cache_key, $new_data, $this->cache_time );
			}
		}



		/**
		 * pre_wp_nav_menu
		 *
		 * Show the menu from cache
		 *
		 * @param  string|null $nav_menu    Nav menu output to short-circuit with.
		 * @param  object      $args        An object containing wp_nav_menu() arguments
		 * @return string|null
		 */
		function pre_wp_nav_menu( $nav_menu, $args ){

			if( $args->theme_location == 'primary' && ( is_home() || is_front_page() )){
				if ( false !== ( $cached_data = get_transient( $this->cache_key .'-'. $this->menu_transient) )){
					return $cached_data;
				}
			}

			return $nav_menu;
		}



		/**
		 * wp_nav_menu
		 *
		 * Store menu in cache
		 *
		 * @param  string $nav      The HTML content for the navigation menu.
		 * @param  object $args     An object containing wp_nav_menu() arguments
		 * @return string           The HTML content for the navigation menu.
		 */
		function wp_nav_menu( $nav, $args ){

			if( $args->theme_location == 'primary' && ! jannah_is_mobile() && ( is_home() || is_front_page() )){
				set_transient( $this->cache_key .'-'. $this->menu_transient, $nav, $this->cache_time );
			}

			return $nav;
		}



		/**
		 * get_widget_key
		 *
		 * Simple function to generate a unique id for the widget transient
		 * based on the widget's instance and arguments
		 *
		 * @param  array $instance widget instance
		 * @param  array $args widget arguments
		 * @return string md5 hash
		 */
		function get_widget_key( $instance, $args ){
			return 'WC-' . md5( serialize( array( $instance, $args ) ) );
		}



		/**
		 * widget_display_callback
		 *
		 * @param array     $instance The current widget instance's settings.
		 * @param WP_Widget $widget     The current widget instance.
		 * @param array     $args     An array of default widget arguments.
		 * @return mixed array|boolean
		 */
		function widget_display_callback( $instance, $widget, $args ){

			if ( false === $instance ){
				return $instance;
			}

			# check if we need to cache this widget? ----------
			$widgets = array(
				'categories',
				'tie-widget-categories',
				'nav_menu',
				'widget_tabs',
				'recent-posts',
				'recent-comments',
				'tie-slider-widget',
				'comments_avatar-widget',
				'posts-list-widget',
				'pages',
				'tag_cloud',
			);

			foreach ( $widgets as $widget_id ){
				if ( strpos( $args['widget_id'], $widget_id.'-' ) !== false ){
					$is_cache = true;

					// Don't cache random posts widget
					if( $widget_id == 'posts-list-widget-' && ( ! empty( $instance['posts_order'] ) && $instance['posts_order'] == 'rand' )){
						$is_cache = false;
					}
				}
			}

			if( empty( $is_cache )){
				return $instance;
			}


			# Create a uniqe transient ID for this widget instance ----------
			$widget_id = $this->get_widget_key( $instance, $args );

			# Get the "cached version of the widget" ----------
			if ( false !== ( $cached_data = get_transient( $this->cache_key ) ) ){
				if( isset( $cached_data[ $widget_id ] )){
					$cached_widget = $cached_data[ $widget_id ];
				}
			}

			# It wasn't there, so render the widget and save it as a transient ----------
			if( empty( $cached_widget )){
				ob_start();
				$widget->widget( $args, $instance );
				$cached_widget = ob_get_clean();
				$GLOBALS[ $this->cache_key ][ $widget_id ] = $cached_widget;
			}

			# Output the widget ----------
			echo ( $cached_widget );

			return false;
		}



		/**
		 * transient_flusher
		 *
		 * Reset the cache
		 *
		 */
		function transient_flusher(){
			global $wpdb;
			$sql = 'DELETE FROM ' . $wpdb->options . ' WHERE option_name LIKE "_transient_'. $this->transient_prefix .'%"';
			$wpdb->query( $sql );
		}

	}

	# Instantiate the class ----------
	new TIE_THEME_SPEEDER();

}

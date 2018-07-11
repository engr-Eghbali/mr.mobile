<?php
/**
 * Post views module
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*-----------------------------------------------------------------------------------*/
# Post Views Class
/*-----------------------------------------------------------------------------------*/
if( ! class_exists( 'TIE_POST_VIEWS' )){

	class TIE_POST_VIEWS{


		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			add_filter( 'jannah_views_meta_field',           array( $this, '_custom_views_meta_field' ));
			add_filter( 'manage_posts_columns',              array( $this, '_posts_column_views' ));
			add_filter( 'manage_edit-post_sortable_columns', array( $this, '_sort_postviews_column' ));

			add_action( 'wp_footer',                         array( $this, '_set_post_views' ));
			add_action( 'wp_enqueue_scripts',                array( $this, '_postview_cache_enqueue' ), 20 );
			add_action( 'manage_posts_custom_column',        array( $this, '_posts_custom_column_views' ), 5, 2 );
			add_action( 'wp_ajax_tie_postviews',             array( $this, '_increment_views' ));
			add_action( 'wp_ajax_nopriv_tie_postviews',      array( $this, '_increment_views' ));
			add_action( 'pre_get_posts',                     array( $this, '_sort_postviews' ));
		}


		/**
		 * _set_post_views
		 *
		 * Count number of views
		 */
		function _set_post_views(){

			# Run only if the post views option is set to THEME's post views module ----------
			if( jannah_get_option( 'tie_post_views' ) != 'theme' || ! is_single() ){
				return;
			}

			# Run only on the first page of the post ----------
			$page = get_query_var( 'paged', 1 );

			if( !jannah_get_option( 'post_views' ) || $page > 1  ){
				return false;
			}

			# Increase number of views +1 ----------
			$count     = 0;
			$post_id   = get_the_ID();
			$count_key = apply_filters( 'jannah_views_meta_field', 'tie_views' );
			$count     = (int) get_post_meta( $post_id, $count_key, true );

			if( ! defined( 'WP_CACHE' ) || ! WP_CACHE ){
				$count++;
				update_post_meta( $post_id, $count_key, (int)$count );
			}
		}


		/**
		 * _postview_cache_enqueue
		 *
		 * Calculate Post Views With WP_CACHE Enabled
		 */
		function _postview_cache_enqueue(){

			# Run only if the post views option is set to THEME's post views module ----------
			if( jannah_get_option( 'tie_post_views' ) != 'theme' ){
				return;
			}

			# Add the js code ----------
			if ( is_singular( 'post' ) && ( defined( 'WP_CACHE' ) && WP_CACHE ) && jannah_get_option( 'post_views' ) ){
				$cache_js = '
					jQuery.ajax({
						type : "GET",
						url  : "'. esc_url(admin_url('admin-ajax.php')) .'",
						data : "postviews_id='. get_the_ID() .'&action=tie_postviews",
						cache: !1
					});
				';

				jannah_add_inline_script( 'jannah-scripts', $cache_js );
			}
		}


		/**
		 * _increment_views
		 *
		 * Increment Post Views With WP_CACHE Enabled
		 */
		function _increment_views(){

			# Run only if the post views option is set to THEME's post views module ----------
			if( jannah_get_option( 'tie_post_views' ) != 'theme' ){
				return;
			}

			# Increase number of views +1 ----------
			if( ! empty( $_GET['postviews_id'] ) && jannah_get_option( 'post_views' ) && defined( 'WP_CACHE' ) && WP_CACHE ){
				$post_id = intval($_GET['postviews_id']);

				if( $post_id > 0 ){
					$count     = 0;
					$count_key = apply_filters( 'jannah_views_meta_field', 'tie_views' );
					$count     = (int) get_post_meta( $post_id, $count_key, true );

					$count++;
					update_post_meta( $post_id, $count_key, (int)$count );
					echo esc_html( $count );
				}
			}
			exit();
		}


		/**
		 * _custom_views_meta_field
		 *
		 * Custom meta_field name
		 */
		function _custom_views_meta_field( $field ){
			return jannah_get_option( 'views_meta_field' ) ? jannah_get_option( 'views_meta_field' ) : $field;
		}


		/**
		 * _posts_column_views
		 *
		 * Dashboared column title
		 */
		function _posts_column_views( $defaults ){

			if( jannah_get_option( 'tie_post_views' ) ){
				$defaults['tie_post_views'] = __ti( 'Views' );
			}

			return $defaults;
		}


		/**
		 * _posts_custom_column_views
		 *
		 * Dashboared column content
		 */
		function _posts_custom_column_views( $column_name, $id ){
			if( $column_name === 'tie_post_views' ){
				echo jannah_views( '', get_the_ID() );
			}
		}


		/**
		 * _sort_postviews_column
		 *
		 * Sort Post views column in the dashboared
		 */
		function _sort_postviews_column( $defaults ){
		  $defaults['tie_post_views'] = 'tie-views';
		  return $defaults;
		}


		/**
		 * _sort_postviews
		 *
		 * Sort Post views in the dashboared
		 */
		function _sort_postviews( $query ) {

		  if( !is_admin() ){
		  	return;
			}

		  $orderby   = $query->get('orderby');
			$count_key = apply_filters( 'jannah_views_meta_field', 'tie_views' );

		  if( $orderby == 'tie-views' ) {
				$query->set( 'meta_key', $count_key );
				$query->set( 'orderby',  'meta_value_num' );
		  }
		}


	}

	# Instantiate the class ----------
	new TIE_POST_VIEWS();

}



/*-----------------------------------------------------------------------------------*/
# Display number of views
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_views' )){

	function jannah_views( $text = '', $post_id = 0 ){

		# Return if thr post views module is disabled ----------
		if( ! jannah_get_option( 'tie_post_views' ) ){
			return;
		}

		if( empty( $post_id )){
			$post_id = get_the_ID();
		}

		$views_class = '';
		$count_key   = apply_filters( 'jannah_views_meta_field', 'tie_views' );
		$count       = get_post_meta( $post_id, $count_key, true );

		if( empty( $count ) ){
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, 0 );
			$formated = 0;
		}
		else{

			$formated = number_format_i18n( $count );

			if( $count > 5000 ){
				$views_class = 'very-hot';
			}
			elseif( $count > 2000 ){
				$views_class = 'hot';
			}
			elseif( $count > 500 ){
				$views_class = 'warm';
			}
		}

		return '<span class="meta-views meta-item '. $views_class .'"><span class="tie-icon-fire" aria-hidden="true"></span> '.$formated.' '.$text.'</span> ';
	}

}

?>

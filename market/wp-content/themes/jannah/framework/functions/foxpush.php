<?php
/**
 * FoxPush Functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly




/*-----------------------------------------------------------------------------------*/
# Disconnect FoxPush
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_disconnect_foxpush' )){

	add_action( 'wp_ajax_tie-disconnect-foxpush', 'jannah_disconnect_foxpush' );
	function jannah_disconnect_foxpush(){

		delete_option( 'jannah_foxpush_code' );
		die;
	}

}





/*-----------------------------------------------------------------------------------*/
# Connect FoxPush
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_foxpush_get_code' )){

	add_action( 'wp_ajax_tie-connect-foxpush', 'jannah_foxpush_get_code' );
	function jannah_foxpush_get_code( $data ){

		delete_option( 'jannah_foxpush_code' );

		if( empty( $_REQUEST['domain'] ) || empty( $_REQUEST['apiKey'] ) ){
			esc_html_e( 'The Domain and API Key fields are required.', 'jannah' );
			die;
		}

		$domain  = $_REQUEST['domain'];
		$api_key = $_REQUEST['apiKey'];

		$args = array(
			'headers'     => array(
				'FOXPUSH_DOMAIN' => $domain,
				'FOXPUSH_TOKEN'  => $api_key,
			),
			'sslverify' => false,
		);

		$api_url = 'https://api.foxpush.com/v1/publisher/code';
		$request = wp_remote_get( $api_url, $args );

		if ( is_wp_error( $request ) ) {
			echo esc_html( $request->get_error_message() );
			die;
		}

		$request = wp_remote_retrieve_body( $request );
		$request = json_decode( $request, true );

		if( ! empty( $request['user_code'] ) && ! empty( $request['subdomain'] ) ){
			$code = $request['subdomain'] .'_'. $request['user_code'];
			update_option( 'jannah_foxpush_code', $code );
			echo 1;
		}

		else{
			esc_html_e( 'ERROR', 'jannah' );
			if( ! empty( $request['error_message'] ) ){
				echo ': '. $request['error_message'];
			}
		}

		die;
	}

}





/*-----------------------------------------------------------------------------------*/
# Print FoxPush code
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_foxpush_embed_code' )){

	add_action( 'wp_footer', 'jannah_foxpush_embed_code' );
	function jannah_foxpush_embed_code(){

		$foxpush_domain = jannah_get_option( 'foxpush_domain' );
		$foxpush_apikey = jannah_get_option( 'foxpush_api' );
		$foxpush_code   = get_option( 'jannah_foxpush_code' );

		if( empty( $foxpush_domain ) || empty( $foxpush_apikey ) || empty( $foxpush_code ) ){
			return false;
		}

		$foxpush_code   = explode( '_', $foxpush_code );
		$foxpush_token  = $foxpush_code[1];
		$foxpush_domain = $foxpush_code[0];

		$code = "
			(function(){
			var foxscript = document.createElement('script');
			foxscript.src = '//js.foxpush.com/$foxpush_domain.js?v='+Math.random();
			foxscript.type = 'text/javascript';
			foxscript.async = 'true';
			var fox_s = document.getElementsByTagName('script')[0];
			fox_s.parentNode.insertBefore(foxscript, fox_s);})();
		";

		$code = apply_filters( 'jannah_foxpush_embedcode', $code );

		jannah_add_inline_script( 'jannah-scripts', $code );
	}

}





/*-----------------------------------------------------------------------------------*/
# FoxPush Statistics
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_foxpush_statistics' )){

	function jannah_foxpush_statistics( $type = 'chart' ){

		$foxpush_domain = jannah_get_option( 'foxpush_domain' );
		$foxpush_apikey = jannah_get_option( 'foxpush_api' );

		if( ! get_option( 'jannah_foxpush_code' ) || empty( $foxpush_domain ) || empty( $foxpush_apikey ) ){
			return false;
		}

		# Get stored data ----------
		if( $type == 'stats' ){
			$data = get_transient( 'jannah_foxpush_stats' );
			$api_path = 'stats';
		}
		else{
			$data = get_transient( 'jannah_foxpush_chart' );
			$api_path = 'daily_chart';
		}


		# Get new data ----------
		if( empty( $data )){

			$args = array(
				'headers'     => array(
					'FOXPUSH_DOMAIN' => jannah_remove_spaces( $foxpush_domain ),
					'FOXPUSH_TOKEN'  => jannah_remove_spaces( $foxpush_apikey ),
				)
			);

			add_filter( 'https_ssl_verify', '__return_false' );

			$api_url = 'https://api.foxpush.com/v1/publisher/'.$api_path;
			$request = wp_remote_get( $api_url , $args );
			$request = wp_remote_retrieve_body( $request );
			$request = json_decode( $request, true );


			# Store the new data ----------
			if( $type == 'stats' ){
				if( ! empty( $request['total_subscribers'] )){
					$data = $request;
					set_transient( 'jannah_foxpush_stats', $data, HOUR_IN_SECONDS );
				}
			}
			else{
				if( ! empty( $request['chart'] )){
					$data =  $request['chart'];
					set_transient( 'jannah_foxpush_chart', $data, HOUR_IN_SECONDS );
				}
			}
		}

		return ! empty( $data ) ? $data : '';
	}

}





/*-----------------------------------------------------------------------------------*/
# Check if the FoxPush files installed
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_foxpush_is_installed' )){

	function jannah_foxpush_is_installed(){

		if( file_exists( $_SERVER['DOCUMENT_ROOT'].'/foxpush_worker.js' )){
			return true;
		}

		return false;
	}

}

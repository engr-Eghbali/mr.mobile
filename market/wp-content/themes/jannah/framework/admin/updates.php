<?php
/**
 * Database updates
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if( get_option( 'tie_jannah_ver' ) ){

	if( version_compare( get_option( 'tie_jannah_ver' ), JANNAH_DB_VERSION, '<' ) ){

	  update_option( 'tie_jannah_ver', JANNAH_DB_VERSION );

	  do_action( 'jannah_after_db_update' );
	}

	/*
	$get_options = get_option( 'tie_jannah_options' );
	$get_options['copyright_area'] = 'true';
	update_option( 'tie_jannah_options', $get_options );
	*/

}

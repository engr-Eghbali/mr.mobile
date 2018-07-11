<?php
/**
 * The template for displaying the header
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>


<body id="tie-body" <?php body_class(); ?>>

<?php do_action( 'jannah_before_theme' ); ?>

<div class="background-overlay">

	<div id="tie-container" class="site tie-container">

		<?php do_action( 'jannah_before_wrapper' ); ?>

		<div id="tie-wrapper">

			<?php

				# Show the header if it is enabled ----------
				if( apply_filters( 'jannah_is_header_active', true ) ){
					get_template_part( 'framework/headers/header' );
				}


				do_action( 'jannah_before_main_content' );

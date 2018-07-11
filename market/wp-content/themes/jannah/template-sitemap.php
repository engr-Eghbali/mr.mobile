<?php
/**
 * Template Name: Sitemap Page
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_action( 'jannah_below_post_content', 'jannah_template_sitemap' );

get_template_part( 'page' );

?>

<?php
/**
 * Template Name: Authors List
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_action( 'jannah_below_post_content', 'jannah_template_get_authors' );

get_template_part( 'page' );

?>

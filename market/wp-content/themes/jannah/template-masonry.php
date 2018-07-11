<?php
/**
 * Template Name: Masonry Page
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_filter( 'body_class', 'jannah_template_masonry_custom_body_class' );

add_action( 'jannah_below_the_post', 'jannah_template_get_masonry' );

get_template_part( 'page' );
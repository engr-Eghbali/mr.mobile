<?php

	$category_id = $GLOBALS['category_id'];

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Post Layout', 'jannah' ),
			'type'  => 'header',
		));

	jannah_category_option(
		array(
			'id'      => 'cat_post_layout',
			'type'    => 'visual',
			'cat'     => $category_id,
			'columns' => 5,
			'toggle'  => array(
					'' => '',
					'4' => '#cat_featured_bg_title, #cat_featured_use_fea-item, #cat_featured_custom_bg-item',
					'5' => '#cat_featured_bg_title, #cat_featured_use_fea-item, #cat_featured_custom_bg-item',
					'8' => '#cat_featured_bg_title, #cat_featured_use_fea-item, #cat_featured_custom_bg-item, #cat_featured_bg_color-item',),
			'options' => array(
					''  => array( esc_html__( 'Default', 'jannah' ) => 'default.png' ),
					'1' => array( esc_html__( 'Layout', 'jannah' ).' #1' => 'post-layouts/1.png' ),
					'2' => array( esc_html__( 'Layout', 'jannah' ).' #2' => 'post-layouts/2.png' ),
					'3' => array( esc_html__( 'Layout', 'jannah' ).' #3' => 'post-layouts/3.png' ),
					'4' => array( esc_html__( 'Layout', 'jannah' ).' #4' => 'post-layouts/4.png' ),
					'5' => array( esc_html__( 'Layout', 'jannah' ).' #5' => 'post-layouts/5.png' ),
					'6' => array( esc_html__( 'Layout', 'jannah' ).' #6' => 'post-layouts/6.png' ),
					'7' => array( esc_html__( 'Layout', 'jannah' ).' #7' => 'post-layouts/7.png' ),
					'8' => array( esc_html__( 'Layout', 'jannah' ).' #8' => 'post-layouts/8.png' ),
			)));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Featured area background', 'jannah' ),
			'id'    => 'cat_featured_bg_title',
			'type'  => 'header',
			'class' => 'cat_post_layout',
		));

	jannah_category_option(
		array(
			'name'  => esc_html__( 'Use the featured image', 'jannah' ),
			'id'    => 'cat_featured_use_fea',
			'type'  => 'select',
			'cat'   => $category_id,
			'class' => 'cat_post_layout',
			'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Yes',     'jannah' ),
					'no'  => esc_html__( 'No',      'jannah' ),
			)));

	jannah_category_option(
		array(
			'name'     => esc_html__( 'Upload Custom Image', 'jannah' ),
			'id'       => 'cat_featured_custom_bg',
			'type'     => 'upload',
			'cat'      => $category_id,
			'pre_text' => esc_html__( '- OR -', 'jannah' ),
			'class'    => 'cat_post_layout',
		));

	jannah_category_option(
		array(
			'name'  => esc_html__( 'Background Color', 'jannah' ),
			'id'    => 'cat_featured_bg_color',
			'type'  => 'color',
			'cat'   => $category_id,
			'class' => 'cat_post_layout',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Post Format Settings', 'jannah' ),
			'type'  => 'header',
		));

	jannah_category_option(
		array(
			'name'    => esc_html__( 'Standard Post Format:', 'jannah' ) .' '. esc_html__( 'Show the featured image', 'jannah' ),
			'id'      => 'cat_post_featured',
			'type'    => 'select',
			'cat'     => $category_id,
			'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Yes',     'jannah' ),
					'no'  => esc_html__( 'No',      'jannah' ),
		)));

	jannah_category_option(
		array(
			'name'    => esc_html__( 'Image Post Format:', 'jannah' ) .' '. esc_html__( 'Uncropped featured image', 'jannah' ),
			'id'      => 'cat_image_uncropped',
			'type'    => 'select',
			'cat'     => $category_id,
			'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Yes',     'jannah' ),
					'no'  => esc_html__( 'No',      'jannah' ),
		)));

	jannah_category_option(
		array(
			'name'    => esc_html__( 'Image Post Format:', 'jannah' ) .' '. esc_html__( 'Featured image lightbox', 'jannah' ),
			'id'      => 'cat_image_lightbox',
			'type'    => 'select',
			'cat'     => $category_id,
			'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Yes',     'jannah' ),
					'no'  => esc_html__( 'No',      'jannah' ),
			)));
?>

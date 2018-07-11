<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Page Layout', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'id'      => 'tie_theme_layout',
			'type'    => 'visual',
			'columns' => 5,
			'options' => array(
				''       => array( esc_html__( 'Default', 'jannah' ) => 'default.png' ),
				'full'   => array( esc_html__( 'Full-Width', 'jannah' ) => 'layouts/layout-full.png'   ),
				'boxed'  => array( esc_html__( 'Boxed', 'jannah' )      => 'layouts/layout-boxed.png'  ),
				'framed' => array( esc_html__( 'Framed', 'jannah' )     => 'layouts/layout-framed.png' ),
				'border' => array( esc_html__( 'Bordered', 'jannah' )   => 'layouts/layout-border.png' ),
			)));


	if( get_post_type() == 'post' ){

		jannah_theme_option(
			array(
				'title' => esc_html__( 'Post Layout', 'jannah' ),
				'type'  => 'header',
			));

		jannah_custom_post_option(
			array(
				'id'      => 'tie_post_layout',
				'type'    => 'visual',
				'columns' => 5,
				'toggle'  => array(
					'' => '',
					'4' => '#tie_featured_bg_title, #tie_featured_use_fea-item, #tie_featured_custom_bg-item',
					'5' => '#tie_featured_bg_title, #tie_featured_use_fea-item, #tie_featured_custom_bg-item',
					'8' => '#tie_featured_bg_title, #tie_featured_use_fea-item, #tie_featured_custom_bg-item, #tie_featured_bg_color-item',),
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
				'id'    => 'tie_featured_bg_title',
				'type'  => 'header',
				'class' => 'tie_post_layout',
			));

		jannah_custom_post_option(
			array(
				'name'  => esc_html__( 'Use the featured image', 'jannah' ),
				'id'    => 'tie_featured_use_fea',
				'type'  => 'select',
				'class' => 'tie_post_layout',
				'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Yes',     'jannah' ),
					'no'  => esc_html__( 'No',      'jannah' ),
				)));

		jannah_custom_post_option(
			array(
				'name'     => esc_html__( 'Upload Custom Image', 'jannah' ),
				'id'       => 'tie_featured_custom_bg',
				'type'     => 'upload',
				'pre_text' => esc_html__( '- OR -', 'jannah' ),
				'class'    => 'tie_post_layout',
			));

		jannah_custom_post_option(
			array(
				'name'  => esc_html__( 'Background Color', 'jannah' ),
				'id'    => 'tie_featured_bg_color',
				'type'  => 'color',
				'class' => 'tie_post_layout',
			));

	}
?>

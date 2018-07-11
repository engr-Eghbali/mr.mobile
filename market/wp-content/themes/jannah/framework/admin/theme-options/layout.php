<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Layout', 'jannah' ),
			'type'  => 'tab-title',
		));


	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Site Width', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Site Width', 'jannah' ),
			'id'      => 'site_width',
			'type'    => 'text',
			'default' => '1200px',
			'hint'    => esc_html__( 'Controls the overall site width. In px or %, ex: 100% or 1170px.', 'jannah' ),
		));


	jannah_theme_option(
		array(
			'title' => esc_html__( 'Theme Layout', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'id'      => 'theme_layout',
			'type'    => 'visual',
			'options' => array(
				'full'   => array( esc_html__( 'Full-Width', 'jannah' ) => 'layouts/layout-full.png'   ),
				'boxed'  => array( esc_html__( 'Boxed', 'jannah' )      => 'layouts/layout-boxed.png'  ),
				'framed' => array( esc_html__( 'Framed', 'jannah' )     => 'layouts/layout-framed.png' ),
				'border' => array( esc_html__( 'Bordered', 'jannah' )   => 'layouts/layout-border.png' ),
			)));

/*
	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Magazine Style', 'jannah' ),
			'type'  => 'header',
		));


	jannah_theme_option(
		array(
			'id'      => 'boxes_style',
			'type'    => 'visual',
			'options' => array(
				'1'	=> array( esc_html__( 'Magazine', 'jannah' ) .' #1' => 'layouts/magazine-1.png' ),
				'2' => array( esc_html__( 'Magazine', 'jannah' ) .' #2' => 'layouts/magazine-2.png' ),
				'3' => array( esc_html__( 'Magazine', 'jannah' ) .' #3' => 'layouts/magazine-3.png' ),
			)));
	*/

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Loader Icon', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'id'      => 'loader-icon',
			'type'    => 'visual',
			'options' => array(
				'1'	=> 'ajax-loader-1.png',
				'2' => 'ajax-loader-2.png',
			)));

?>

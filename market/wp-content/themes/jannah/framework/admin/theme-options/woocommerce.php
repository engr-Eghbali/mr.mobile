<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'WooCommerce Settings', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'WooCommerce Settings', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Number of products per page', 'jannah' ),
			'id'   => 'products_pre_page',
			'type' => 'number',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Number of the related products', 'jannah' ),
			'id'   => 'related_products_number',
			'type' => 'number',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'WooCommerce Sidebar Position', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'id'      => 'woo_sidebar_pos',
			'type'    => 'visual',
			'options' => array(
				''      => array( esc_html__( 'Default', 'jannah' ) => 'default.png' ),
				'right'	=> array( esc_html__( 'Sidebar Right', 'jannah' ) => 'sidebars/sidebar-right.png' ),
				'left'	=> array( esc_html__( 'Sidebar Left', 'jannah' ) => 'sidebars/sidebar-left.png' ),
				'full'	=> array( esc_html__( 'Without Sidebar', 'jannah' ) => 'sidebars/sidebar-full-width.png' ),
			)));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'WooCommerce Product Page Sidebar Position', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'id'      => 'woo_product_sidebar_pos',
			'type'    => 'visual',
			'options' => array(
				''      => array( esc_html__( 'Default', 'jannah' ) => 'default.png' ),
				'right'	=> array( esc_html__( 'Sidebar Right', 'jannah' ) => 'sidebars/sidebar-right.png' ),
				'left'	=> array( esc_html__( 'Sidebar Left', 'jannah' ) => 'sidebars/sidebar-left.png' ),
				'full'	=> array( esc_html__( 'Without Sidebar', 'jannah' ) => 'sidebars/sidebar-full-width.png' ),
			)));

?>

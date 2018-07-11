<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'bbPress', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Sidebar Position', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'id'      => 'bbpress_sidebar_pos',
			'type'    => 'visual',
			'options' => array(
				''      => array( esc_html__( 'Default', 'jannah' ) => 'default.png' ),
				'right'	=> array( esc_html__( 'Sidebar Right', 'jannah' )   => 'sidebars/sidebar-right.png' ),
				'left'	=> array( esc_html__( 'Sidebar Left', 'jannah' )    => 'sidebars/sidebar-left.png' ),
				'full'	=> array( esc_html__( 'Without Sidebar', 'jannah' ) => 'sidebars/sidebar-full-width.png' ),
			)));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'bbPress Sidebar', 'jannah' ),
			'id'      => 'sidebar_bbpress',
			'type'    => 'select',
			'options' => jannah_get_registered_sidebars(),
		));

?>

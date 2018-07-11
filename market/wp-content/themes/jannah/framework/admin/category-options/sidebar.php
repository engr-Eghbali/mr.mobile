<?php

	$category_id = $GLOBALS['category_id'];

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Category Sidebar', 'jannah' ),
			'type'  => 'header',
		));

	jannah_category_option(
		array(
			'id'      => 'cat_sidebar_pos',
			'type'    => 'visual',
			'cat'     => $category_id,
			'columns' => 5,
			'options' => array(
					''           => array( esc_html__( 'Default', 'jannah' ) => 'default.png' ),
					'right'	     => array( esc_html__( 'Sidebar Right', 'jannah' ) => 'sidebars/sidebar-right.png' ),
					'left'	     => array( esc_html__( 'Sidebar Left', 'jannah' ) => 'sidebars/sidebar-left.png' ),
					'full'	     => array( esc_html__( 'Without Sidebar', 'jannah' ) => 'sidebars/sidebar-full-width.png' ),
					'one-column' => array( esc_html__( 'One Column', 'jannah' ) => 'sidebars/sidebar-one-column.png' ),
		)));

	jannah_category_option(
		array(
			'name'   => esc_html__( 'Sticky Sidebar', 'jannah' ),
			'id'     => 'cat_sticky_sidebar',
			'cat'    => $category_id,
			'type'   => 'select',
			'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Yes',     'jannah' ),
					'no'  => esc_html__( 'No',      'jannah' ),
		)));

	jannah_category_option(
		array(
			'name'    => esc_html__( 'Custom Sidebar', 'jannah' ),
			'id'      => 'cat_sidebar',
			'type'    => 'select',
			'cat'     => $category_id,
			'options' => jannah_get_registered_sidebars(),
		));

?>

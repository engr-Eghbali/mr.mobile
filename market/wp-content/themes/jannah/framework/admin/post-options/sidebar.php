<?php

	if( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
		if( get_the_ID() == wc_get_page_id( 'shop' ) ){

			jannah_theme_option(
				array(
					'text' => sprintf( wp_kses_post( __( 'Control WooCommerce sidebar settings from the theme options page &gt; <a href="%s">WooCommerce settings</a>.', 'jannah' )), admin_url( 'admin.php?page=tie-theme-options#tie-options-tab-woocommerce-target' ) ),
					'type' => 'message',
				));

				return;
		}
	}

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Sidebar Position', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'id'      => 'tie_sidebar_pos',
			'type'    => 'visual',
			'columns' => 5,
			'options' => array(
				''           => array( esc_html__( 'Default', 'jannah' ) => 'default.png' ),
				'right'	     => array( esc_html__( 'Sidebar Right', 'jannah' ) => 'sidebars/sidebar-right.png' ),
				'left'	     => array( esc_html__( 'Sidebar Left', 'jannah' ) => 'sidebars/sidebar-left.png' ),
				'full'	     => array( esc_html__( 'Without Sidebar', 'jannah' ) => 'sidebars/sidebar-full-width.png' ),
				'one-column' => array( esc_html__( 'One Column', 'jannah' ) => 'sidebars/sidebar-one-column.png' ),
		)));

	jannah_custom_post_option(
		array(
			'name'   => esc_html__( 'Sticky Sidebar', 'jannah' ),
			'id'     => 'tie_sticky_sidebar',
			'type'   => 'select',
			'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Yes',     'jannah' ),
					'no'  => esc_html__( 'No',      'jannah' ),
		)));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Custom Sidebar', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Choose Sidebar', 'jannah' ),
			'id'      => 'tie_sidebar_post',
			'type'    => 'select',
			'options' => jannah_get_registered_sidebars(),
		));

?>

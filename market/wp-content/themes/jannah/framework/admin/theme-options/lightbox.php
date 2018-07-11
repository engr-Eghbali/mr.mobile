<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Lightbox Settings', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Lightbox Settings', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Enable Lightbox Automatically', 'jannah' ),
			'hint' => esc_html__( 'Enable Lightbox automatically for all images linked to an image file in the post content area', 'jannah' ),
			'id'   => 'lightbox_all',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Lightbox for Galleries', 'jannah' ),
			'hint' => esc_html__( 'Enable Lightbox automatically for all images added via [gallery] shortcode in the content area', 'jannah' ),
			'id'   => 'lightbox_gallery',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Lightbox Skin', 'jannah' ),
			'id'      => 'lightbox_skin',
			'type'    => 'select',
			'options' => array(
				'dark'        => 'dark',
				'light'       => 'light',
				'smooth'      => 'smooth',
				'metro-black' => 'metro-black',
				'metro-white' => 'metro-white',
				'mac'         => 'mac',
			)));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Lightbox Thumbnail Position', 'jannah' ),
			'id'      => 'lightbox_thumbs',
			'type'    => 'radio',
			'options' => array(
				'vertical'   => esc_html__( 'Vertical',   'jannah' ),
				'horizontal' => esc_html__( 'Horizontal', 'jannah' ),
			)));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Show Lightbox Arrows', 'jannah' ),
			'id'   => 'lightbox_arrows',
			'type' => 'checkbox',
		));

?>

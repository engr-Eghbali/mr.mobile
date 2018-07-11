<?php

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Social Networks', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Social Networks', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'RSS', 'jannah' ),
			'id'   => 'rss_icon',
			'type' => 'checkbox',
		));


	$social_array	= jannah_social_networks();
	unset( $social_array['rss'] );

	foreach ( $social_array as $network => $data ){
		jannah_theme_option(
			array(
				'name' => $data['title'],
				'id'   => 'social',
				'key'  => $network,
				'type' => 'arrayText',
			));
	}

	for( $i = 1; $i <= 5; $i++ ){

		jannah_theme_option(
			array(
				'title' => esc_html__( 'Custom Social Network', 'jannah' ),
				'type'  => 'header',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Title', 'jannah' ),
				'id'   => 'custom_social_title_'.$i,
				'type' => 'text',
			));

		jannah_theme_option(
			array(
				'name'        => esc_html__( 'Icon', 'jannah' ),
				'id'          => 'custom_social_icon_'.$i,
				'hint'        => '<a href="'. esc_url( 'http://fontawesome.io/icons/' ) .'" target="_blank">'. esc_html__( 'Use the full Font Awesome icon name', 'jannah' ) .'</a>',
				'type'        => 'text',
				'placeholder' => 'fa fa-icon',
			));

		jannah_theme_option(
			array(
				'name'        => esc_html__( 'URL', 'jannah' ),
				'id'          => 'custom_social_url_'.$i,
				'placeholder' => 'https://',
				'type'        => 'text',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Color', 'jannah' ),
				'id'   => 'custom_social_color_'.$i,
				'type' => 'color',
			));
	}

?>

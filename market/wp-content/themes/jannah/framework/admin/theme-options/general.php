<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'General Settings', 'jannah' ),
			'type'  => 'tab-title',
		));


	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Time format', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Time format for blog posts', 'jannah' ),
			'id'      => 'time_format',
			'type'    => 'radio',
			'options' => array(
				'traditional' => esc_html__( 'Traditional', 'jannah' ),
				'modern'      => esc_html__( 'Time Ago Format', 'jannah' ),
				'none'        => esc_html__( 'Disable all', 'jannah' ),
			)));


	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Breadcrumbs Settings', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Breadcrumbs', 'jannah' ),
			'id'     => 'breadcrumbs',
			'toggle' => '#breadcrumbs_delimiter-item',
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Breadcrumbs Delimiter', 'jannah' ),
			'id'      => 'breadcrumbs_delimiter',
			'type'    => 'text',
			'default' => '&#47;',
		));


	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Trim Text Settings', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Trim text by', 'jannah' ),
			'id'      => 'trim_type',
			'type'		=> 'radio',
			'options'	=> array(
				'words' =>	esc_html__( 'Words', 'jannah' ) ,
				'chars'	=>	esc_html__( 'Characters', 'jannah' ),
			)));


	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Post format icon on hover', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Show the post format icon on hover?', 'jannah' ),
			'id'     => 'thumb_overlay',
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Custom Codes', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Header Code', 'jannah' ),
			'id'   => 'header_code',
			'hint' => esc_html__( 'Will add to the &lt;head&gt; tag. Useful if you need to add additional codes such as CSS or JS.', 'jannah' ),
			'type' => 'textarea',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Footer Code', 'jannah' ),
			'id'   => 'footer_code',
			'hint' => esc_html__( 'Will add to the footer before the closing  &lt;/body&gt; tag. Useful if you need to add Javascript.', 'jannah' ),
			'type' => 'textarea',
		));
?>

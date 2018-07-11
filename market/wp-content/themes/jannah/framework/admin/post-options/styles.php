<?php

	# Extend the background of the first section to cover the Header ----------
	echo '<div id="tie_header_extend_bg_option">';

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Header Background', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Extend the background of the first section to cover the Header', 'jannah' ),
			'id'   => 'tie_header_extend_bg',
			'type' => 'checkbox',
		));

	echo '</div>';


	jannah_theme_option(
		array(
			'title' => esc_html__( 'Primary Color', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Primary Color', 'jannah' ),
			'id'   => 'post_color',
			'type' => 'color',
	));

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Background', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'text'  => esc_html__( 'Bordered Layout supports plain background color only.', 'jannah' ),
			'type'  => 'message',
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'Background Color', 'jannah' ),
			'id'    => 'background_color',
			'type'  => 'color',
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'Background Color 2', 'jannah' ),
			'id'    => 'background_color_2',
			'type'  => 'color',
		));

	jannah_custom_post_option(
		array(
			'name'   => esc_html__( 'Background Image type', 'jannah' ),
			'id'     => 'background_type',
			'type'   => 'radio',
			'toggle' => array(
				''        => '',
				'pattern' => '#background_pattern-item',
				'image'   => '#background_image-item',),
			'options' => array(
				''        => esc_html__( 'None', 'jannah' ),
				'pattern' => esc_html__( 'Pattern', 'jannah' ),
				'image'   => esc_html__( 'Image', 'jannah' ),
			)));

	$patterns = array();
	for( $i=1 ; $i<=47 ; $i++ ){
		$patterns['body-bg'.$i]	=	'patterns/'.$i.'.png';
	}

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Background Pattern', 'jannah' ),
			'id'      => 'background_pattern',
			'type'    => 'visual',
			'class'   => 'background_type',
			'options' => $patterns,
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'Background Image', 'jannah' ),
			'id'    => 'background_image',
			'class' => 'background_type',
			'type'  => 'background',
		));

	jannah_theme_option(
		array(
			'type'  => 'header',
			'title' => esc_html__( 'Background Settings', 'jannah' ),
		));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Dots overlay layer', 'jannah' ),
			'id'   => 'background_dots',
			'type' => 'checkbox',
		));

	jannah_custom_post_option(
		array(
			'name'   => esc_html__( 'Background dimmer', 'jannah' ),
			'id'     => 'background_dimmer',
			'toggle' => '#background_dimmer_value-item, #background_dimmer_color-item',
			'type'   => 'checkbox',
		));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Background dimmer', 'jannah' ),
			'id'   => 'background_dimmer_value',
			'hint' => esc_html__( 'Value between 0 and 100 to dim background image. 0 - no dim, 100 - maximum dim.', 'jannah' ),
			'type' => 'number',
		));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Background dimmer color', 'jannah' ),
			'id'      => 'background_dimmer_color',
			'type'    => 'radio',
			'options'	=> array(
				'black' => esc_html__( 'Black', 'jannah' ),
				'white' => esc_html__( 'White', 'jannah' ),
			)));

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Custom CSS', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'text' => esc_html__( 'Paste your CSS code, do not include any tags or HTML in the field. Any custom CSS entered here will override the theme CSS. In some cases, the !important tag may be needed.', 'jannah' ),
			'type' => 'message',
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'Custom CSS', 'jannah' ),
			'id'    => 'tie_custom_css',
			'class' => 'tie-css',
			'type'  => 'textarea',
		));

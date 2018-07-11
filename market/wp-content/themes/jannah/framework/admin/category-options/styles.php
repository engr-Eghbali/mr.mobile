<?php

	$category_id = $GLOBALS['category_id'];

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Category Style', 'jannah' ),
			'type'  => 'header',
		));

	jannah_category_option(
		array(
			'name' => esc_html__( 'Primary Color', 'jannah' ),
			'id'   => 'cat_color',
			'cat'  => $category_id,
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

	jannah_category_option(
		array(
			'name'  => esc_html__( 'Background Color', 'jannah' ),
			'id'    => 'background_color',
			'type'  => 'color',
			'cat'   => $category_id,
		));

	jannah_category_option(
		array(
			'name'  => esc_html__( 'Background Color 2', 'jannah' ),
			'id'    => 'background_color_2',
			'type'  => 'color',
			'cat'   => $category_id,
		));

	jannah_category_option(
		array(
			'name'   => esc_html__( 'Background Image type', 'jannah' ),
			'id'     => 'background_type',
			'type'   => 'radio',
			'cat'    => $category_id,
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

	jannah_category_option(
		array(
			'name'    => esc_html__( 'Background Pattern', 'jannah' ),
			'id'      => 'background_pattern',
			'type'    => 'visual',
			'class'   => 'background_type',
			'options' => $patterns,
			'cat'     => $category_id,
		));

	jannah_category_option(
		array(
			'name'  => esc_html__( 'Background Image', 'jannah' ),
			'id'    => 'background_image',
			'class' => 'background_type',
			'type'  => 'background',
			'cat'   => $category_id,
		));

	jannah_theme_option(
		array(
			'type'  => 'header',
			'title' => esc_html__( 'Background Settings', 'jannah' ),
		));

	jannah_category_option(
		array(
			'name' => esc_html__( 'Dots overlay layer', 'jannah' ),
			'id'   => 'background_dots',
			'type' => 'checkbox',
			'cat'  => $category_id,
		));

	jannah_category_option(
		array(
			'name'   => esc_html__( 'Background dimmer', 'jannah' ),
			'id'     => 'background_dimmer',
			'toggle' => '#background_dimmer_value-item, #background_dimmer_color-item',
			'type'   => 'checkbox',
			'cat'  => $category_id,
		));

	jannah_category_option(
		array(
			'name' => esc_html__( 'Background dimmer', 'jannah' ),
			'id'   => 'background_dimmer_value',
			'hint' => esc_html__( 'Value between 0 and 100 to dim background image. 0 - no dim, 100 - maximum dim.', 'jannah' ),
			'type' => 'number',
			'cat'  => $category_id,
		));

	jannah_category_option(
		array(
			'name'    => esc_html__( 'Background dimmer color', 'jannah' ),
			'id'      => 'background_dimmer_color',
			'type'    => 'radio',
			'cat'     => $category_id,
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

	jannah_category_option(
		array(
			'name'  => esc_html__( 'Custom CSS', 'jannah' ),
			'id'    => 'cat_custom_css',
			'class' => 'tie-css',
			'type'  => 'textarea',
			'cat'   => $category_id,
		));
?>

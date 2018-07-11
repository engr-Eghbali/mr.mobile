<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Custom Logo', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'name'   => esc_html__( 'Custom Logo', 'jannah' ),
			'id'     => 'custom_logo',
			'toggle' => '#tie-post-logo-item',
			'type'   => 'checkbox',
		));

	echo '<div id="tie-post-logo-item">';

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Logo Settings', 'jannah' ),
			'id'      => 'logo_setting',
			'type'    => 'radio',
			'toggle'  => array(
				'logo'  => '#logo-item, #logo_retina-item, #logo_retina_width-item, #logo_retina_height-item',
				'title' => '#logo_text-item'),
			'options'	=> array(
				'logo'  => esc_html__( 'Image', 'jannah' ),
				'title' => esc_html__( 'Site Title', 'jannah' ),
			)));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Logo Text', 'jannah' ),
			'id'      => 'logo_text',
			'type'    => 'text',
			'class'   => 'logo_setting',
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'Logo Image', 'jannah' ),
			'id'    => 'logo',
			'type'  => 'upload',
			'class' => 'logo_setting',
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'Logo Image (Retina Version @2x)', 'jannah' ),
			'id'    => 'logo_retina',
			'type'  => 'upload',
			'class' => 'logo_setting',
			'hint'	=> esc_html__( 'Please choose an image file for the retina version of the logo. It should be 2x the size of main logo.', 'jannah' ),
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'Standard Logo Width for Retina Logo', 'jannah' ),
			'id'    => 'logo_retina_width',
			'type'  => 'number',
			'class' => 'logo_setting',
			'hint'  => esc_html__( 'If retina logo is uploaded, please enter the standard logo (1x) version width, do not enter the retina logo width.', 'jannah' ),
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'Standard Logo Height for Retina Logo', 'jannah' ),
			'id'    => 'logo_retina_height',
			'type'  => 'number',
			'class' => 'logo_setting',
			'hint'  => esc_html__( 'If retina logo is uploaded, please enter the standard logo (1x) version height, do not enter the retina logo height.', 'jannah' ),
		));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Logo Margin Top', 'jannah' ),
			'id'   => 'logo_margin',
			'type' => 'number',
			'hint' => esc_html__( 'Leave it empty to use the default value.', 'jannah' ) ));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Logo Margin Bottom', 'jannah' ),
			'id'   => 'logo_margin_bottom',
			'type' => 'number',
			'hint' => esc_html__( 'Leave it empty to use the default value.', 'jannah' ),
		));

	echo '</div>';
?>

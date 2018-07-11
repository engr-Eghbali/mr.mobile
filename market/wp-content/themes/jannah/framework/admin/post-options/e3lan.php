<?php

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Hide Above Banner', 'jannah' ),
			'id'   => 'tie_hide_above',
			'type' => 'checkbox',
	));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Custom Above Banner', 'jannah' ),
			'id'   => 'tie_get_banner_above',
			'type' => 'textarea',
	));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Hide Below Banner', 'jannah' ),
			'id'   => 'tie_hide_below',
			'type' => 'checkbox',
	));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Custom Below Banner', 'jannah' ),
			'id'   => 'tie_get_banner_below',
			'type' => 'textarea',
	));

?>

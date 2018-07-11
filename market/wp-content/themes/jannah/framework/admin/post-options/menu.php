<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Custom Menu', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Custom Menu', 'jannah' ),
			'id'      => 'tie_menu',
			'type'    => 'select',
			'options' => jannah_get_menus_array( true ),
		));

?>

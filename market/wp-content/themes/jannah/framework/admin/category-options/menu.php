<?php

	$category_id = $GLOBALS['category_id'];

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Custom Menu', 'jannah' ),
			'type'  => 'header',
		));

	jannah_category_option(
		array(
			'name'    => esc_html__( 'Custom Menu', 'jannah' ),
			'id'      => 'cat_menu',
			'type'    => 'select',
			'options' => jannah_get_menus_array( true ),
			'cat'     => $category_id,
		));

?>

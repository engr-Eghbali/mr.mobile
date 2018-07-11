<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Post Components', 'jannah' ),
			'type'  => 'header',
		));

	if( get_post_type() == 'post' ){

		jannah_custom_post_option(
			array(
				'name'    => esc_html__( 'Categories', 'jannah' ),
				'id'      => 'tie_hide_categories',
				'type'    => 'select',
				'options' => array(
						''    => esc_html__( 'Default', 'jannah' ),
						'yes' => esc_html__( 'Hide',    'jannah' ),
						'no'  => esc_html__( 'Show',    'jannah' ),
			)));

		jannah_custom_post_option(
			array(
				'name'    => esc_html__( 'Tags', 'jannah' ),
				'id'      => 'tie_hide_tags',
				'type'    => 'select',
				'options' => array(
						''    => esc_html__( 'Default', 'jannah' ),
						'yes' => esc_html__( 'Hide',    'jannah' ),
						'no'  => esc_html__( 'Show',    'jannah' ),
			)));

		jannah_custom_post_option(
			array(
				'name'    => esc_html__( 'Post Meta', 'jannah' ),
				'id'      => 'tie_hide_meta',
				'type'    => 'select',
				'options' => array(
						''    => esc_html__( 'Default', 'jannah' ),
						'yes' => esc_html__( 'Hide',    'jannah' ),
						'no'  => esc_html__( 'Show',    'jannah' ),
			)));

		jannah_custom_post_option(
			array(
				'name'    => esc_html__( 'Post Author box', 'jannah' ),
				'id'      => 'tie_hide_author',
				'type'    => 'select',
				'options' => array(
						''    => esc_html__( 'Default', 'jannah' ),
						'yes' => esc_html__( 'Hide',    'jannah' ),
						'no'  => esc_html__( 'Show',    'jannah' ),
			)));

		jannah_custom_post_option(
			array(
				'name'	  => esc_html__( 'Next/Prev posts', 'jannah' ),
				'id'		  => 'tie_hide_nav',
				'type'	  => 'select',
				'options' => array(
						''    => esc_html__( 'Default', 'jannah' ),
						'yes' => esc_html__( 'Hide',    'jannah' ),
						'no'  => esc_html__( 'Show',    'jannah' ),
			)));

		jannah_custom_post_option(
			array(
				'name'    => esc_html__( 'Newsletter', 'jannah' ),
				'id'      => 'tie_hide_newsletter',
				'type'    => 'select',
				'options' => array(
						''    => esc_html__( 'Default', 'jannah' ),
						'yes' => esc_html__( 'Hide',    'jannah' ),
						'no'  => esc_html__( 'Show',    'jannah' ),
			)));

		jannah_custom_post_option(
			array(
				'name'    => esc_html__( 'Related Posts', 'jannah' ),
				'id'      => 'tie_hide_related',
				'type'    => 'select',
				'options' => array(
						''    => esc_html__( 'Default', 'jannah' ),
						'yes' => esc_html__( 'Hide',    'jannah' ),
						'no'  => esc_html__( 'Show',    'jannah' ),
			)));

		jannah_custom_post_option(
			array(
				'name'    => esc_html__( 'Fly Check Also Box', 'jannah' ),
				'id'      => 'tie_hide_check_also',
				'type'    => 'select',
				'options' => array(
						''    => esc_html__( 'Default', 'jannah' ),
						'yes' => esc_html__( 'Hide',    'jannah' ),
						'no'  => esc_html__( 'Show',    'jannah' ),
			)));
	} // if posts

	jannah_custom_post_option(
		array(
			'name'	  => esc_html__( 'Above Post share Buttons', 'jannah' ),
			'id'		  => 'tie_hide_share_top',
			'type'	  => 'select',
			'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Hide',    'jannah' ),
					'no'  => esc_html__( 'Show',    'jannah' ),
		)));

	jannah_custom_post_option(
		array(
			'name'	  => esc_html__( 'Below Post Share Buttons', 'jannah' ),
			'id'		  => 'tie_hide_share_bottom',
			'type'	  => 'select',
			'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Hide',    'jannah' ),
					'no'  => esc_html__( 'Show',    'jannah' ),
		)));
?>

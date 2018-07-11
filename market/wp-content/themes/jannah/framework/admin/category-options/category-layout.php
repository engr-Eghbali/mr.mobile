<?php

	$category_id = $GLOBALS['category_id'];

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Category Layout', 'jannah' ),
			'type'  => 'header',
		));

	jannah_category_option(
		array(
			'id'      => 'category_layout',
			'type'    => 'visual',
			'cat'     => $category_id,
			'columns' => 8,
			'options' => array(
				''               => array( esc_html__( 'Default', 'jannah' ) => 'default.png' ),
				'excerpt'        => array( esc_html__( 'Classic', 'jannah' ) => 'archives/blog.png' ),
				'full_thumb'     => array( esc_html__( 'Large Thumbnail', 'jannah' ) => 'archives/full-thumb.png' ),
				'content'        => array( esc_html__( 'Content', 'jannah' ) => 'archives/content.png' ),
				'timeline'       => array( esc_html__( 'Timeline', 'jannah' ) => 'archives/timeline.png' ),
				'masonry'        => array( esc_html__( 'Masonry', 'jannah' ) .' #1' => 'archives/masonry.png' ),
				'overlay'        => array( esc_html__( 'Masonry', 'jannah' ) .' #2' => 'archives/overlay.png' ),
				'overlay-spaces' => array( esc_html__( 'Masonry', 'jannah' ) .' #3' => 'archives/overlay-spaces.png' ),
			)));

	jannah_category_option(
		array(
			'name' => esc_html__( 'Excerpt Length', 'jannah' ),
			'id'   => 'category_excerpt_length',
			'type' => 'number',
			'cat'  => $category_id,
		));

	jannah_category_option(
		array(
			'name'    => esc_html__( 'Pagination', 'jannah' ),
			'id'      => 'category_pagination',
			'type'    => 'radio',
			'cat'     => $category_id,
			'options' => array(
				''          => esc_html__( 'Default',           'jannah' ),
				'next-prev' => esc_html__( 'Next and Previous', 'jannah' ),
				'numeric'   => esc_html__( 'Numeric',           'jannah' ),
				'load-more' => esc_html__( 'Load More',         'jannah' ),
				'infinite'  => esc_html__( 'Infinite Scroll',   'jannah' ),
			)));

	jannah_category_option(
		array(
			'name'  => esc_html__( 'Media Icon Overlay', 'jannah' ),
			'id'    => 'category_media_overlay',
			'type'  => 'checkbox',
			'cat'   => $category_id,
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Page Layout', 'jannah' ),
			'type'  => 'header',
		));

	jannah_category_option(
		array(
			'id'      => 'cat_theme_layout',
			'type'    => 'visual',
			'cat'     => $category_id,
			'columns' => 5,
			'options' => array(
				''       => array( esc_html__( 'Default', 'jannah' ) => 'default.png' ),
				'full'   => array( esc_html__( 'Full-Width', 'jannah' ) => 'layouts/layout-full.png'   ),
				'boxed'  => array( esc_html__( 'Boxed', 'jannah' )      => 'layouts/layout-boxed.png'  ),
				'framed' => array( esc_html__( 'Framed', 'jannah' )     => 'layouts/layout-framed.png' ),
				'border' => array( esc_html__( 'Bordered', 'jannah' )   => 'layouts/layout-border.png' ),
			)));

?>

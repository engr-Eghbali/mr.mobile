<?php

jannah_theme_option(
	array(
		'title' => esc_html__( 'Archives Settings', 'jannah' ),
		'type'  => 'tab-title',
	));


# Default settings ----------
jannah_theme_option(
	array(
		'title' =>	esc_html__( 'Default layout settings', 'jannah' ),
		'type'  => 'header' ));

jannah_theme_option(
	array(
		'id'      => 'blog_display',
		'type'    => 'visual',
		'columns' => 7,
		'options' => array(
			'excerpt'        => array( esc_html__( 'Classic', 'jannah' ) => 'archives/blog.png' ),
			'full_thumb'     => array( esc_html__( 'Large Thumbnail', 'jannah' ) => 'archives/full-thumb.png' ),
			'content'        => array( esc_html__( 'Content', 'jannah' ) => 'archives/content.png' ),
			'timeline'       => array( esc_html__( 'Timeline', 'jannah' ) => 'archives/timeline.png' ),
			'masonry'        => array( esc_html__( 'Masonry', 'jannah' ).' #1' => 'archives/masonry.png' ),
			'overlay'        => array( esc_html__( 'Masonry', 'jannah' ).' #2' => 'archives/overlay.png' ),
			'overlay-spaces' => array( esc_html__( 'Masonry', 'jannah' ).' #3' => 'archives/overlay-spaces.png' ),
		)));

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Excerpt Length', 'jannah' ),
		'id'      => 'blog_excerpt_length',
		'type'    => 'number',
		'default' => 20,
	));

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Pagination', 'jannah' ),
		'id'      => 'blog_pagination',
		'type'    => 'radio',
		'options' => array(
			'next-prev' => esc_html__( 'Next and Previous', 'jannah' ),
			'numeric'   => esc_html__( 'Numeric',           'jannah' ),
			'load-more' => esc_html__( 'Load More',         'jannah' ),
			'infinite'  => esc_html__( 'Infinite Scroll',   'jannah' ),
		)));



# Category page settings ----------
jannah_theme_option(
	array(
		'title' => esc_html__( 'Category Page Settings', 'jannah' ),
		'type'  => 'header',
	));

jannah_theme_option(
	array(
		'id'      => 'category_layout',
		'type'    => 'visual',
		'columns' => 7,
		'options' => array(
			'excerpt'        => array( esc_html__( 'Classic', 'jannah' ) => 'archives/blog.png' ),
			'full_thumb'     => array( esc_html__( 'Large Thumbnail', 'jannah' ) => 'archives/full-thumb.png' ),
			'content'        => array( esc_html__( 'Content', 'jannah' ) => 'archives/content.png' ),
			'timeline'       => array( esc_html__( 'Timeline', 'jannah' ) => 'archives/timeline.png' ),
			'masonry'        => array( esc_html__( 'Masonry', 'jannah' ).' #1' => 'archives/masonry.png' ),
			'overlay'        => array( esc_html__( 'Masonry', 'jannah' ).' #2' => 'archives/overlay.png' ),
			'overlay-spaces' => array( esc_html__( 'Masonry', 'jannah' ).' #3' => 'archives/overlay-spaces.png' ),
		)));

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Excerpt Length', 'jannah' ),
		'id'      => 'category_excerpt_length',
		'type'    => 'number',
		'default' => 20,
	));

jannah_theme_option(
	array(
		'name' => esc_html__( 'Category Description', 'jannah' ),
		'id'   => 'category_desc',
		'type' => 'checkbox',
	));

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Pagination', 'jannah' ),
		'id'      => 'category_pagination',
		'type'    => 'radio',
		'options' => array(
			'next-prev' => esc_html__( 'Next and Previous', 'jannah' ),
			'numeric'   => esc_html__( 'Numeric',           'jannah' ),
			'load-more' => esc_html__( 'Load More',         'jannah' ),
			'infinite'  => esc_html__( 'Infinite Scroll',   'jannah' ),
		)));



# Tag page settings ----------
jannah_theme_option(
	array(
		'title' => esc_html__( 'Tag Page Settings', 'jannah' ),
		'type'  => 'header',
	));

jannah_theme_option(
	array(
		'id'      => 'tag_layout',
		'type'    => 'visual',
		'columns' => 7,
		'options' => array(
			'excerpt'        => array( esc_html__( 'Classic', 'jannah' ) => 'archives/blog.png' ),
			'full_thumb'     => array( esc_html__( 'Large Thumbnail', 'jannah' ) => 'archives/full-thumb.png' ),
			'content'        => array( esc_html__( 'Content', 'jannah' ) => 'archives/content.png' ),
			'timeline'       => array( esc_html__( 'Timeline', 'jannah' ) => 'archives/timeline.png' ),
			'masonry'        => array( esc_html__( 'Masonry', 'jannah' ).' #1' => 'archives/masonry.png' ),
			'overlay'        => array( esc_html__( 'Masonry', 'jannah' ).' #2' => 'archives/overlay.png' ),
			'overlay-spaces' => array( esc_html__( 'Masonry', 'jannah' ).' #3' => 'archives/overlay-spaces.png' ),
		)));

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Excerpt Length', 'jannah' ),
		'id'      => 'tag_excerpt_length',
		'type'    => 'number',
		'default' => 20,
	));

jannah_theme_option(
	array(
		'name' => esc_html__( 'Tag Description', 'jannah' ),
		'id'   => 'tag_desc',
		'type' => 'checkbox',
	));

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Pagination', 'jannah' ),
		'id'      => 'tag_pagination',
		'type'    => 'radio',
		'options' => array(
			'next-prev' => esc_html__( 'Next and Previous', 'jannah' ),
			'numeric'   => esc_html__( 'Numeric',           'jannah' ),
			'load-more' => esc_html__( 'Load More',         'jannah' ),
			'infinite'  => esc_html__( 'Infinite Scroll',   'jannah' ),
		)));



# Author page settings ----------
jannah_theme_option(
	array(
		'title' => esc_html__( 'Author Page Settings', 'jannah' ),
		'type'  => 'header',
	));

jannah_theme_option(
	array(
		'id'		=> 'author_layout',
		'type'    => 'visual',
		'columns' => 7,
		'options' => array(
			'excerpt'        => array( esc_html__( 'Classic', 'jannah' ) => 'archives/blog.png' ),
			'full_thumb'     => array( esc_html__( 'Large Thumbnail', 'jannah' ) => 'archives/full-thumb.png' ),
			'content'        => array( esc_html__( 'Content', 'jannah' ) => 'archives/content.png' ),
			'timeline'       => array( esc_html__( 'Timeline', 'jannah' ) => 'archives/timeline.png' ),
			'masonry'        => array( esc_html__( 'Masonry', 'jannah' ).' #1' => 'archives/masonry.png' ),
			'overlay'        => array( esc_html__( 'Masonry', 'jannah' ).' #2' => 'archives/overlay.png' ),
			'overlay-spaces' => array( esc_html__( 'Masonry', 'jannah' ).' #3' => 'archives/overlay-spaces.png' ),
		)));

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Excerpt Length', 'jannah' ),
		'id'      => 'author_excerpt_length',
		'type'    => 'number',
		'default' => 20,
	));

jannah_theme_option(
	array(
		'name' => esc_html__( 'Author Bio', 'jannah' ),
		'id'   => 'author_bio',
		'type' => 'checkbox',
	));

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Pagination', 'jannah' ),
		'id'      => 'author_pagination',
		'type'    => 'radio',
		'options' => array(
			'next-prev' => esc_html__( 'Next and Previous', 'jannah' ),
			'numeric'   => esc_html__( 'Numeric',           'jannah' ),
			'load-more' => esc_html__( 'Load More',         'jannah' ),
			'infinite'  => esc_html__( 'Infinite Scroll',   'jannah' ),
		)));



# Search page settings ----------
jannah_theme_option(
	array(
		'title' => esc_html__( 'Search Page Settings', 'jannah' ),
		'type'  => 'header',
	));

jannah_theme_option(
	array(
		'id'		=> 'search_layout',
		'type'    => 'visual',
		'columns' => 7,
		'options' => array(
			'excerpt'        => array( esc_html__( 'Classic', 'jannah' ) => 'archives/blog.png' ),
			'full_thumb'     => array( esc_html__( 'Large Thumbnail', 'jannah' ) => 'archives/full-thumb.png' ),
			'content'        => array( esc_html__( 'Content', 'jannah' ) => 'archives/content.png' ),
			'timeline'       => array( esc_html__( 'Timeline', 'jannah' ) => 'archives/timeline.png' ),
			'masonry'        => array( esc_html__( 'Masonry', 'jannah' ).' #1' => 'archives/masonry.png' ),
			'overlay'        => array( esc_html__( 'Masonry', 'jannah' ).' #2' => 'archives/overlay.png' ),
			'overlay-spaces' => array( esc_html__( 'Masonry', 'jannah' ).' #3' => 'archives/overlay-spaces.png' ),
		)));

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Excerpt Length', 'jannah' ),
		'id'      => 'search_excerpt_length',
		'type'    => 'number',
		'default' => 20,
	));

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Pagination', 'jannah' ),
		'id'      => 'search_pagination',
		'type'    => 'radio',
		'options' => array(
			'next-prev' => esc_html__( 'Next and Previous', 'jannah' ),
			'numeric'   => esc_html__( 'Numeric',           'jannah' ),
			'load-more' => esc_html__( 'Load More',         'jannah' ),
			'infinite'  => esc_html__( 'Infinite Scroll',   'jannah' ),
		)));

jannah_theme_option(
	array(
		'name' => esc_html__( 'Search in Category IDs', 'jannah' ),
		'id'   => 'search_cats',
		'hint' => esc_html__( 'Use minus sign (-) to exclude categories. Example: (1,4,-7) = search only in Category 1 & 4, and exclude Category 7.', 'jannah' ),
		'type' => 'text',
	));

$args = array(
	'public' => true,
	'exclude_from_search' => false,
);

$post_types = get_post_types( $args );
unset( $post_types['post'] );
unset( $post_types['attachment'] );

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Exclude post types from search', 'jannah' ),
		'id'      => 'search_exclude_post_types',
		'type'    => 'select-multiple',
		'options' => $post_types,
	));


?>

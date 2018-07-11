<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Single Post Page Settings', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Default Posts Layout', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'id'      => 'post_layout',
			'type'    => 'visual',
			'columns' => 4,
			'toggle'  => array(
				''  => '',
				'4' => '#featured_use_fea-item, #featured_custom_bg-item',
				'5' => '#featured_use_fea-item, #featured_custom_bg-item',
				'8' => '#featured_use_fea-item, #featured_custom_bg-item, #featured_bg_color-item',),
			'options' => array(
				'1' => array( esc_html__( 'Layout', 'jannah' ). ' #1' => 'post-layouts/1.png' ),
				'2' => array( esc_html__( 'Layout', 'jannah' ). ' #2' => 'post-layouts/2.png' ),
				'3' => array( esc_html__( 'Layout', 'jannah' ). ' #3' => 'post-layouts/3.png' ),
				'4' => array( esc_html__( 'Layout', 'jannah' ). ' #4' => 'post-layouts/4.png' ),
				'5' => array( esc_html__( 'Layout', 'jannah' ). ' #5' => 'post-layouts/5.png' ),
				'6' => array( esc_html__( 'Layout', 'jannah' ). ' #6' => 'post-layouts/6.png' ),
				'7' => array( esc_html__( 'Layout', 'jannah' ). ' #7' => 'post-layouts/7.png' ),
				'8' => array( esc_html__( 'Layout', 'jannah' ). ' #8' => 'post-layouts/8.png' ),
		)));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Use the featured image', 'jannah' ),
			'id'    => 'featured_use_fea',
			'type'  => 'checkbox',
			'class' => 'post_layout',
		));

	jannah_theme_option(
		array(
			'name'     => esc_html__( 'Upload Custom Image', 'jannah' ),
			'id'       => 'featured_custom_bg',
			'type'     => 'upload',
			'pre_text' => esc_html__( '- OR -', 'jannah' ),
			'class'    => 'post_layout',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Background Color', 'jannah' ),
			'id'    => 'featured_bg_color',
			'type'  => 'color',
			'class' => 'post_layout',
		));


	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Structure Data', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Enable', 'jannah' ),
			'id'     => 'structure_data',
			'toggle' => '#schema_type-item',
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Default Schema type', 'jannah' ),
			'id'      => 'schema_type',
			'type'    => 'radio',
			'options' => array(
				'NewsArticle'  => esc_html__( 'NewsArticle',  'jannah' ),
				'Article'      => esc_html__( 'Article',      'jannah' ),
				'BlogPosting'  => esc_html__( 'BlogPosting',  'jannah' ),
			)));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'General Settings', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Standard Post Format:', 'jannah' ) .' '. esc_html__( 'Show the featured image', 'jannah' ),
			'id'   => 'post_featured',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Image Post Format:', 'jannah' ) .' '. esc_html__( 'Uncropped featured image', 'jannah' ),
			'id'      => "image_uncropped",
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Image Post Format:', 'jannah' ) .' '. esc_html__( 'Featured image lightbox', 'jannah' ),
			'id'      => "image_lightbox",
			'type' => 'checkbox',
		));


	if( ! jannah_is_opengraph_active() ){
		jannah_theme_option(
			array(
				'name' => esc_html__( 'Open Graph meta', 'jannah' ),
				'id'   => 'post_og_cards',
				'type' => 'checkbox',
			));
	}

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Reading Position Indicator', 'jannah' ),
			'id'   => 'reading_indicator',
			'type' => 'checkbox',
		));



	jannah_theme_option(
		array(
			'name' => esc_html__( 'Post Author Box', 'jannah' ),
			'id'   => 'post_authorbio',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Next/Prev posts', 'jannah' ),
			'id'   => 'post_nav',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Post info Settings', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Categories', 'jannah' ),
			'id'   => 'post_cats',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Tags', 'jannah' ),
			'id'   => 'post_tags',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Post meta area', 'jannah' ),
			'id'     => 'post_meta',
			'toggle' => '#post_author-all-item, #post_date-item, #post_comments-item, #post_views-item, #reading_time-item',
			'type'   => 'checkbox',
		));

	echo '<div id="post_author-all-item">';
	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Author', 'jannah' ),
			'id'     => 'post_author',
			'toggle' => '#post_author_wrap-item',
			'type'   => 'checkbox',
		));

		echo '<div id="post_author_wrap-item">';
			jannah_theme_option(
				array(
					'name' => esc_html__( "Author's Avatar", 'jannah' ),
					'id'   => 'post_author_avatar',
					'type' => 'checkbox',
				));

			jannah_theme_option(
				array(
					'name' => esc_html__( 'Twitter Icon', 'jannah' ),
					'id'   => 'post_author_twitter',
					'type' => 'checkbox',
				));

			jannah_theme_option(
				array(
					'name' => esc_html__( 'Email Icon', 'jannah' ),
					'id'   => 'post_author_email',
					'type' => 'checkbox',
				));
		echo '</div>';
	echo '</div>';

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Date', 'jannah' ),
			'id'   => 'post_date',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Comments', 'jannah' ),
			'id'   => 'post_comments',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Views', 'jannah' ),
			'id'   => 'post_views',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Estimated reading time', 'jannah' ),
			'id'   => 'reading_time',
			'type' => 'checkbox',
		));

jannah_theme_option(
		array(
			'title' => esc_html__( 'Newsletter', 'jannah' ),
			'type'	=> 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Newsletter', 'jannah' ),
			'id'     => 'post_newsletter',
			'toggle' => '#post_newsletter_text-item, #post_newsletter_mailchimp-item, #post_newsletter_feedburner-item',
			'type'   => 'checkbox',
		));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Text above the Email input field', 'jannah' ),
				'id'   => 'post_newsletter_text',
				'hint' => esc_html__( 'Supports: Text, HTML and Shortcodes.', 'jannah' ),
				'type' => 'textarea',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'MailChimp Form Action URL', 'jannah' ),
				'id'   => 'post_newsletter_mailchimp',
				'type' => 'text',
			));

		jannah_theme_option(
			array(
				'name'     => esc_html__( 'Feedburner ID', 'jannah' ),
				'pre_text' => esc_html__( '- OR -', 'jannah' ),
				'id'       => 'post_newsletter_feedburner',
				'type'     => 'text',
			));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Related Posts', 'jannah' ),
			'type'	=> 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Related Posts', 'jannah' ),
			'id'     => 'related',
			'toggle' => '#related_number-item, #related_number_full-item, #related_query-item, #related_order-item, #related_title_length-item',
			'type'   => 'checkbox',
		));


	jannah_theme_option(
		array(
			'name' => esc_html__( 'Number of posts to show', 'jannah' ),
			'id'   => 'related_number',
			'type' => 'number',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Number of posts to show in Full width pages', 'jannah' ),
			'id'   => 'related_number_full',
			'type' => 'number',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Query Type', 'jannah' ),
			'id'      => 'related_query',
			'type'    => 'radio',
			'options' => array(
				'category' => esc_html__( 'Posts in the same Categories', 'jannah' ),
				'tag'      => esc_html__( 'Posts in the same Tags', 'jannah' ),
				'author'   => esc_html__( 'Posts by the same Author', 'jannah' ),
			)));


	//Post Order ----------
	$post_order = array(
		'latest'   => esc_html__( 'Recent Posts', 'jannah' ),
		'rand'     => esc_html__( 'Random Posts', 'jannah' ),
		'modified' => esc_html__( 'Last Modified Posts', 'jannah' ),
		'popular'  => esc_html__( 'Most Commented posts', 'jannah' ),
	);

	if( jannah_get_option( 'post_views' ) ){
		$post_order['views'] = esc_html__( 'Most Viewed posts', 'jannah' );
	}

	if( JANNAH_TAQYEEM_IS_ACTIVE ){
		$post_order['best'] = esc_html__( 'Best Reviews', 'jannah' );
	}

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Sort Order', 'jannah' ),
			'id'      => 'related_order',
			'type'    => 'select',
			'options' => $post_order,
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Title Length', 'jannah' ),
			'id'   => 'related_title_length',
			'type' => 'number',
		));


	jannah_theme_option(
		array(
			'title' => esc_html__( 'Fly Check Also Box', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Check Also', 'jannah' ),
			'id'     => 'check_also',
			'toggle' => '#check_also_position-item, #check_also_number-item, #check_also_query-item, #check_also_order-item, #check_also_title_length-item',
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Check Also Box Position', 'jannah' ),
			'id'      => 'check_also_position',
			'type'    => 'radio',
			'options' => array(
				'right'	=> esc_html__( 'Right',	'jannah' ),
				'left'	=> esc_html__( 'Left',	'jannah' ),
		)));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Query Type', 'jannah' ),
			'id'      => 'check_also_query',
			'type'    => 'radio',
			'options' => array(
				'category' => esc_html__( 'Posts in the same Categories',	'jannah' ),
				'tag'      => esc_html__( 'Posts in the same Tags', 'jannah' ),
				'author'   => esc_html__( 'Posts by the same Author', 'jannah' ),
			)));

		jannah_theme_option(
		array(
			'name'    => esc_html__( 'Sort Order', 'jannah' ),
			'id'      => 'check_also_order',
			'type'    => 'select',
			'options' => $post_order,
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Title Length', 'jannah' ),
			'id'      => 'check_also_title_length',
			'type'    => 'number',
		));

?>

<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Mobile Settings', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Mobile Settings', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Disable the Responsiveness', 'jannah' ),
			'id'   => 'disable_responsive',
			'hint' => esc_html__( 'This option works only on Tablets and Phones.', 'jannah' ),
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Mobile Menu', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Mobile Menu', 'jannah' ),
			'id'     => 'mobile_menu_active',
			'toggle' => '#mobile_menu_parent_link-item, #mobile_menu_search-item, #mobile_menu_social-item, #mobile_menu_top-item, #mobile_menu_icons-item',
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Parent items as links', 'jannah' ),
			'hint' => esc_html__( 'If disabled, parent menu items will only toggle child items.', 'jannah' ),
			'id'   => 'mobile_menu_parent_link',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Include the Top Menu items', 'jannah' ),
			'id'   => 'mobile_menu_top',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Show the icons', 'jannah' ),
			'id'   => 'mobile_menu_icons',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Search', 'jannah' ),
			'id'   => 'mobile_menu_search',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Social Icons', 'jannah' ),
			'id'   => 'mobile_menu_social',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Single Post Page', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Compact the post content and show more button', 'jannah' ),
			'id'   => 'mobile_post_show_more',
			'type' => 'checkbox',
		));


	# Mobile Elements ----------
	jannah_theme_option(
		array(
			'title' => esc_html__( 'Mobile Elements', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide header Ad', 'jannah' ),
			'id'   => 'mobile_hide_banner_top',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Below the header Ad', 'jannah' ),
			'id'   => 'mobile_hide_banner_below_header',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide above the footer Ad', 'jannah' ),
			'id'   => 'mobile_hide_banner_bottom',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Header Breaking News', 'jannah' ),
			'id'   => 'mobile_hide_breaking_news',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide all sidebars', 'jannah' ),
			'id'   => 'mobile_hide_sidebars',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Instagram Media Above Footer', 'jannah' ),
			'id'   => 'mobile_hide_footer_instagram',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Footer', 'jannah' ),
			'id'   => 'mobile_hide_footer',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide copyright area', 'jannah' ),
			'id'   => 'mobile_hide_copyright',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Breadcrumbs', 'jannah' ),
			'id'   => 'mobile_hide_breadcrumbs',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Above Post share Buttons', 'jannah' ),
			'id'   => 'mobile_hide_share_post_top',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Below Post share Buttons', 'jannah' ),
			'id'   => 'mobile_hide_share_post_bottom',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Below Post Newsletter', 'jannah' ),
			'id'   => 'mobile_hide_post_newsletter',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Below Post Related posts', 'jannah' ),
			'id'   => 'mobile_hide_related',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Below Post Author Box', 'jannah' ),
			'id'   => 'mobile_hide_post_authorbio',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Below Post Next/Prev posts', 'jannah' ),
			'id'   => 'mobile_hide_post_nav',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Hide Back to top button', 'jannah' ),
			'id'   => 'mobile_hide_back_top_button',
			'type' => 'checkbox',
		));


	# General share buttons settings ----------
	jannah_theme_option(
		array(
			'title' => esc_html__( 'Sticky Mobile Share Buttons', 'jannah' ),
			'type'  => 'header',
		));


	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Sticky Mobile Share Buttons', 'jannah' ),
			'id'     => 'share_post_mobile',
			'type'   => 'checkbox',
			'toggle' => '#mobile-share-buttons',
		));

	echo '<div id="mobile-share-buttons">';
		jannah_get_share_buttons_options( 'mobile' );
	echo '</div>'
?>

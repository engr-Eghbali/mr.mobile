<?php

jannah_theme_option(
	array(
		'title' =>	esc_html__( 'Share Settings', 'jannah' ),
		'type'  => 'tab-title',
	));


# General share buttons settings ----------
jannah_theme_option(
	array(
		'title' => esc_html__( 'General Settings', 'jannah' ),
		'type'  => 'header',
	));

jannah_theme_option(
	array(
		'name' => esc_html__( 'Share Buttons for Pages', 'jannah' ),
		'id'   => 'share_buttons_pages',
		'type' => 'checkbox',
	));

jannah_theme_option(
	array(
		'name' => esc_html__( "Use the post's Short Link", 'jannah' ),
		'id'   => 'share_shortlink',
		'type' => 'checkbox',
	));

jannah_theme_option(
	array(
		'name' => esc_html__( 'Twitter Username', 'jannah' ) . ' <small>'. esc_html__( '(optional)', 'jannah' ). '</small>',
		'id'   => 'share_twitter_username',
		'type' => 'text',
	));


# Above Posts share buttons ----------
jannah_theme_option(
	array(
		'title' => esc_html__( 'Above Post share Buttons', 'jannah' ),
		'type'  => 'header',
	));

jannah_theme_option(
	array(
		'name'   => esc_html__( 'Above Post share Buttons', 'jannah' ),
		'id'     => 'share_post_top',
		'type'   => 'checkbox',
		'toggle' => '#share-top-options',
	));

echo '<div id="share-top-options">';
	jannah_theme_option(
		array(
			'name' => esc_html__( 'Center the buttons', 'jannah' ),
			'id'   => 'share_center_top',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Show the share title', 'jannah' ),
			'id'   => 'share_title_top',
			'hint' => sprintf( esc_html__( 'You can change the "%s" text from the Translation tab.', 'jannah' ), __ti( 'Share' ) ),
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'	  => esc_html__( 'Share Buttons Style', 'jannah' ),
			'id'      => 'share_style_top',
			'type'    => 'visual',
			'options' => array(
				''        => 'share-1.png',
				'style_2' => 'share-2.png',
				'style_3' => 'share-3.png',
		)));

	jannah_get_share_buttons_options( 'top' );
echo '</div>';


# Below Posts share buttons ----------
jannah_theme_option(
	array(
		'title' => esc_html__( 'Below Post Share Buttons', 'jannah' ),
		'type'  => 'header',
	));

jannah_theme_option(
	array(
		'name'   => esc_html__( 'Below Post Share Buttons', 'jannah' ),
		'id'     => 'share_post_bottom',
		'type'   => 'checkbox',
		'toggle' => '#share-bottom-options',
	));

echo '<div id="share-bottom-options">';
	jannah_theme_option(
		array(
			'name' => esc_html__( 'Center the buttons', 'jannah' ),
			'id'   => 'share_center_bottom',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Show the share title', 'jannah' ),
			'id'   => 'share_title_bottom',
			'hint' => sprintf( esc_html__( 'You can change the "%s" text from the Translation tab.', 'jannah' ), __ti( 'Share' ) ),
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'	  => esc_html__( 'Share Buttons Style', 'jannah' ),
			'id'      => 'share_style_bottom',
			'type'    => 'visual',
			'options' => array(
				''        => 'share-1.png',
				'style_2' => 'share-2.png',
				'style_3' => 'share-3.png',
		)));

	jannah_get_share_buttons_options();
echo '</div>';


# General share buttons settings ----------
jannah_theme_option(
	array(
		'title' => esc_html__( 'Select and Share', 'jannah' ),
		'type'  => 'header',
	));

jannah_theme_option(
	array(
		'text' => esc_html__( 'When you double-click a word or highlight a few words, a small share icons are displayed. When you click an icon, a share modal will automatically launch, containing the text you selected along with a link to the post.', 'jannah' ),
		'type' => 'message',
	));

jannah_theme_option(
	array(
		'name'   => esc_html__( 'Select and Share', 'jannah' ),
		'id'     => 'select_share',
		'toggle' => '#select_share_twitter-item, #select_share_linkedin-item, #select_share_facebook-item, #facebook_app_id-item',
		'type'   => 'checkbox',
	));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Twitter', 'jannah' ),
			'id'     => 'select_share_twitter',
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'LinkedIn', 'jannah' ),
			'id'   => 'select_share_linkedin',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Facebook', 'jannah' ),
			'id'   => 'select_share_facebook',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Facebook APP ID', 'jannah' ),
			'id'   => 'facebook_app_id',
			'hint' => esc_html__( '(Required)', 'jannah' ),
			'type' => 'text',
		));

?>

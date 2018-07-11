<?php

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Footer Settings', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Instagram Footer Area', 'jannah' ),
			'type'  => 'header',
		));

	if( JANNAH_INSTANOW_IS_ACTIVE ){
		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Enable', 'jannah' ),
				'id'     => 'footer_instagram',
				'toggle' => '#footer_instagram_options',
				'type'   => 'checkbox',
			));

		echo '<div id="footer_instagram_options">';

		jannah_theme_option(
			array(
				'name'    => esc_html__( 'Media Source', 'jannah' ),
				'id'      => 'footer_instagram_source',
				'type'    => 'radio',
				'options' => array(
					'user'    => esc_html__( 'User Account',	'jannah' ),
					'hashtag' => esc_html__( 'Hash Tag', 'jannah' ),
				)));

		jannah_theme_option(
			array(
				'name'    => esc_html__( 'Enter the Username or the Hash Tag', 'jannah' ),
				'id'      => 'footer_instagram_source_id',
				'type'    => 'text',
			));

		jannah_theme_option(
			array(
				'name'    => esc_html__( 'Number of Rows', 'jannah' ),
				'id'      => 'footer_instagram_rows',
				'type'    => 'select',
				'options' => array(
					'1' => esc_html__( 'One Row',	'jannah' ),
					'2' => esc_html__( 'Two Rows', 'jannah' ),
				)));

		jannah_theme_option(
			array(
				'name'    => esc_html__( 'Link Media to', 'jannah' ),
				'id'      => 'footer_instagram_media_link',
				'type'    => 'select',
				'options' => array(
					'file' => esc_html__( 'Media File',	'jannah' ),
					'page' => esc_html__( 'Media Page on Instagram', 'jannah' ),
				)));

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Follow Us Button', 'jannah' ),
				'id'     => 'footer_instagram_button',
				'toggle' => '#footer_instagram_button_text-item, #footer_instagram_button_url-item',
				'type'   => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name'    => esc_html__( 'Follow Us Button Text', 'jannah' ),
				'id'      => 'footer_instagram_button_text',
				'type'    => 'text',
			));

		jannah_theme_option(
			array(
				'name'        => esc_html__( 'Follow Us Button URL', 'jannah' ),
				'id'          => 'footer_instagram_button_url',
				'placeholder' => 'https://',
				'type'        => 'text',
			));

		echo '</div>';

	}
	else{
		jannah_theme_option(
			array(
				'text' =>  wp_kses_post( sprintf( __( 'You need to install the <a href="%s">InstaNOW plugin</a> first.', 'jannah' ), add_query_arg( array( 'page' => 'tie-install-plugins' ), admin_url( 'admin.php' )) ) ),
				'type' => 'message',
			));
	}

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Footer Widgets layout', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'First Footer Widgets Area', 'jannah' ),
			'id'     => 'footer_widgets_area_1',
			'toggle' => '#footer_widgets_layout_area_1-item, #footer_widgets_border_area_1-item',
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Add border around the widgets area', 'jannah' ),
			'id'     => 'footer_widgets_border_area_1',
			'type'   => 'checkbox',
		));


	jannah_theme_option(
		array(
			'id'      => 'footer_widgets_layout_area_1',
			'type'    => 'visual',
			'options' => array(
				'footer-1c'      => 'footers/footer-1c.png',
				'footer-2c'      => 'footers/footer-2c.png',
				'narrow-wide-2c' => 'footers/footer-2c-narrow-wide.png',
				'wide-narrow-2c' => 'footers/footer-2c-wide-narrow.png',
				'footer-3c'      => 'footers/footer-3c.png',
				'wide-left-3c'   => 'footers/footer-3c-wide-left.png',
				'wide-right-3c'  => 'footers/footer-3c-wide-right.png',
				'footer-4c'      => 'footers/footer-4c.png',
			)));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Second Footer Widgets Area', 'jannah' ),
			'id'     => 'footer_widgets_area_2',
			'toggle' => '#footer_widgets_layout_area_2-item, #footer_widgets_border_area_2-item',
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Add border around the widgets area', 'jannah' ),
			'id'     => 'footer_widgets_border_area_2',
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'id'		=> 'footer_widgets_layout_area_2',
			'type'    => 'visual',
			'options' => array(
				'footer-1c'      => 'footers/footer-1c.png',
				'footer-2c'      => 'footers/footer-2c.png',
				'narrow-wide-2c' => 'footers/footer-2c-narrow-wide.png',
				'wide-narrow-2c' => 'footers/footer-2c-wide-narrow.png',
				'footer-3c'      => 'footers/footer-3c.png',
				'wide-left-3c'   => 'footers/footer-3c-wide-left.png',
				'wide-right-3c'  => 'footers/footer-3c-wide-right.png',
				'footer-4c'      => 'footers/footer-4c.png',
			)));

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Copyright Area', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Enable', 'jannah' ),
			'id'   => 'copyright_area',
			'type' => 'checkbox',
			'toggle' => '#copyright_area_options',
		));

	echo '<div id="copyright_area_options">';

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Centered Layout', 'jannah' ),
				'id'   => 'footer_centered',
				'type' => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Social Icons', 'jannah' ),
				'id'   => 'footer_social',
				'type' => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Footer Menu', 'jannah' ),
				'id'   => 'footer_menu',
				'type' => 'checkbox',
			));

		$footer_codes = '<strong>'. esc_html__( 'Variables', 'jannah' ) .'</strong> '.
			esc_html__( 'These tags can be included in the textarea above and will be replaced when a page is displayed.', 'jannah' ) .'
			<br />
			<strong>%year%</strong> : <em>'.esc_html__( 'Replaced with the current year.',      'jannah' ) .'</em><br />
			<strong>%site%</strong> : <em>'.esc_html__( "Replaced with The site's name.", 'jannah' ) .'</em><br />
			<strong>%url%</strong>  : <em>'.esc_html__( "Replaced with The site's URL.",  'jannah' ) .'</em>';

		jannah_theme_option(
			array(
				'name'  => esc_html__( 'Footer Text One', 'jannah' ),
				'id'    => 'footer_one',
				'hint'  => $footer_codes,
				'type'  => 'textarea',
			));

		jannah_theme_option(
			array(
				'name'  => esc_html__( 'Footer Text Two', 'jannah' ),
				'id'    => 'footer_two',
				'hint'  => $footer_codes,
				'type'  => 'textarea',
			));

	echo '</div>';

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Back to top button', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Back to top button', 'jannah' ),
			'id'   => 'footer_top',
			'type' => 'checkbox',
		));

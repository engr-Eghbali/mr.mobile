<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Advertisement Settings', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'text' => esc_html__( 'It is recommended to avoid using words like ad, ads, adv, advert, advertisement, banner, banners, sponsor, 300x250, 728x90, etc. in the image names or image path to avoid AdBlocks from blocking your Ad.', 'jannah' ),
			'type' => 'message',
		));

	jannah_theme_option(
		array(
			'title'   => esc_html__( 'Ad Blocker Detector', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Ad Blocker Detector', 'jannah' ),
			'id'     => 'ad_blocker_detector',
			'type'   => 'checkbox',
			'hint'   => esc_html__( 'Block the adblockers from browsing the site, till they turnoff the Ad Blocker', 'jannah' ),
		));

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Background Image Ad', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Full Page Takeover', 'jannah' ),
			'id'     => 'banner_bg',
			'toggle' => '#banner_bg_url-item, #banner_bg_img-item, #banner_bg_site_margin-item',
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Link', 'jannah' ),
			'id'   => 'banner_bg_url',
			'type' => 'text',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Background Image', 'jannah' ),
			'id'    => 'banner_bg_img',
			'type'  => 'background',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Site margin top', 'jannah' ),
			'id'    => 'banner_bg_site_margin',
			'type'  => 'number',
		));


	$theme_ads = array(
		'banner_top'          => esc_html__( 'Header Ad', 'jannah' ),
		'banner_bottom'       => esc_html__( 'Above Footer Ad', 'jannah' ),
		'banner_below_header' => esc_html__( 'Below the Header Ad', 'jannah' ),
		'banner_above'        => esc_html__( 'Above Article Ad', 'jannah' ),
		'banner_below'        => esc_html__( 'Below Article Ad', 'jannah' ),
	);

	foreach( $theme_ads as $ad => $name ){

		jannah_theme_option(
			array(
				'title' => $name,
				'type'  => 'header',
			));

		jannah_theme_option(
			array(
				'name'   => $name,
				'id'     => $ad,
				'type'   => 'checkbox',
				'toggle' => '#'.$ad.'_img-item, #'.$ad.'_url-item, #'.$ad.'_alt-item, #'.$ad.'_tab-item, #'.$ad.'_nofollow-item, #' .$ad. '_adsense-item, #'.$ad.'-adrotate-options',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Banner Image', 'jannah' ),
				'id'   => $ad.'_img',
				'type' => 'upload',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Banner Link', 'jannah' ),
				'id'   => $ad.'_url',
				'type' => 'text',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Alternative Text For The image', 'jannah' ),
				'id'   => $ad.'_alt',
				'type' => 'text',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Open The Link In a new Tab', 'jannah' ),
				'id'   => $ad.'_tab',
				'type' => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Nofollow?', 'jannah' ),
				'id'   => $ad.'_nofollow',
				'type' => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name'     => esc_html__( 'Custom Ad Code', 'jannah' ),
				'id'       => $ad.'_adsense',
				'pre_text' => esc_html__( '- OR -', 'jannah' ),
				'hint'     => esc_html__( 'Supports: Text, HTML and Shortcodes.', 'jannah' ),
				'type'     => 'textarea',
			));

		if( function_exists( 'adrotate_ad' )){

			echo '<div id="'.$ad.'-adrotate-options">';

			jannah_theme_option(
				array(
					'name'     => esc_html__( 'AdRotate', 'jannah' ),
					'id'       => $ad.'_adrotate',
					'pre_text' => esc_html__( '- OR -', 'jannah' ),
					'toggle'   => '#'.$ad.'_adrotate_type-item, #'.$ad.'_adrotate_id-item',
					'type'     => 'checkbox',
				));

			jannah_theme_option(
				array(
					'name'    => esc_html__( 'Type', 'jannah' ),
					'id'      => $ad.'_adrotate_type',
					'type'    => 'radio',
					'options' => array(
						'single' => esc_html__( 'Advert - Use Advert ID', 'jannah' ),
						'group'  => esc_html__( 'Group - Use group ID', 'jannah' ),
					)));

			jannah_theme_option(
				array(
					'name' => esc_html__( 'ID', 'jannah' ),
					'id'   => $ad.'_adrotate_id',
					'type' => 'number',
				));

			echo '</div>';
		}

	}

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Shortcodes Ads', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => '[ads1] '. esc_html__( 'Ad Shortcode', 'jannah' ),
			'id'   => 'ads1_shortcode',
			'type' => 'textarea',
		));

	jannah_theme_option(
		array(
			'name' => '[ads2] '. esc_html__( 'Ad Shortcode', 'jannah' ),
			'id'   => 'ads2_shortcode',
			'type' => 'textarea',
		));

	jannah_theme_option(
		array(
			'name' => '[ads3] '. esc_html__( 'Ad Shortcode', 'jannah' ),
			'id'   => 'ads3_shortcode',
			'type' => 'textarea',
		));

	jannah_theme_option(
		array(
			'name' => '[ads4] '. esc_html__( 'Ad Shortcode', 'jannah' ),
			'id'   => 'ads4_shortcode',
			'type' => 'textarea',
		));

	jannah_theme_option(
		array(
			'name' => '[ads5] '. esc_html__( 'Ad Shortcode', 'jannah' ),
			'id'   => 'ads5_shortcode',
			'type' => 'textarea',
		));

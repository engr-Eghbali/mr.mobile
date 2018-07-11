<?php

	# Styling Options ----------
	jannah_theme_option(
		array(
			'title' => esc_html__( 'Styling Settings', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Styling Settings', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Dark Skin', 'jannah' ),
			'id'   => 'dark_skin',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Lazy Load For Images', 'jannah' ),
			'id'   => 'lazy_load',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Apply custom styling by inline code', 'jannah' ),
			'hint' => esc_html__( 'check this option if you have problems with styling because of styling file rewrite permissions.', 'jannah' ),
			'id'   => 'inline_css',
			'type' => 'checkbox',
		));


	jannah_theme_option(
		array(
			'title' => esc_html__( 'Custom Body Classes', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Custom Body Classes', 'jannah' ),
			'id'   => 'body_class',
			'type' => 'text',
		));


	# Theme Skin and color ----------
	jannah_theme_option(
		array(
			'title' => esc_html__( 'Primary Color', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'	  => esc_html__( 'Predefined skins', 'jannah' ),
			'id'		  => '',
			'class'		=> 'predefined-skins',
			'type'	  => 'select',
			'options' => array(
				''            => esc_html__( 'Choose a Skin', 'jannah' ),
				'default'     => esc_html__( 'Default',       'jannah' ),
				'blue'        => esc_html__( 'Blue',          'jannah' ),
				'yellow'      => esc_html__( 'Yellow',        'jannah' ),
				'alizarin'    => esc_html__( 'Alizarin',      'jannah' ),
				'sand'        => esc_html__( 'Sand',          'jannah' ),
				'royal'       => esc_html__( 'Royal',         'jannah' ),
				'mint'        => esc_html__( 'Mint',          'jannah' ),
				'stylish_red' => esc_html__( 'Stylish Red',   'jannah' ),
				'twilight'    => esc_html__( 'Twilight',      'jannah' ),
				'coffee'      => esc_html__( 'Coffee',        'jannah' ),
				'ocean'       => esc_html__( 'Ocean',         'jannah' ),
				'cyan'        => esc_html__( 'Cyan',          'jannah' ),
				'facebook'    => esc_html__( 'Facebook',      'jannah' ),
				'sahifa'      => esc_html__( 'Sahifa',        'jannah' ),
				'mist'        => esc_html__( 'Mist',          'jannah' ),
				'serene'      => esc_html__( 'Serene',        'jannah' ),
				'fall'        => esc_html__( 'Fall',          'jannah' ),
			)));


		$skins = array(
			'blue' => array(
				'global_color'               => '#1b98e0',
				'secondry_nav_background'    => '#f5f5f5',
				'topbar_text_color'          => '#777777',
				'topbar_links_color'         => '#444444',
				'topbar_links_color_hover'   => '#1b98e0',
				'footer_background_color'    => '#444444',
				'footer_title_color'         => '#dddddd',
				'footer_text_color'          => '#aaaaaa',
				'copyright_background_color' => '#ffffff',
				'copyright_text_color'       => '#999999',
				'copyright_links_color'      => '#666666',
			),

			'yellow' => array(
				'global_color'               => '#f98d00',
				'secondry_nav_background'    => '#f5f5f5',
				'topbar_text_color'          => '#777777',
				'topbar_links_color'         => '#444444',
				'topbar_links_color_hover'   => '#f98d00',
				'main_nav_background'        => '#222222',
				'main_nav_text_color'        => '#f6f6f6',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#f98d00',
				'footer_background_color'    => '#f6f6f6',
				'footer_title_color'         => '#000000',
				'footer_text_color'          => '#666666',
				'footer_links_color'         => '#555555',
				'copyright_background_color' => '#ffffff',
				'copyright_text_color'       => '#999999',
				'copyright_links_color'      => '#666666',
				'copyright_links_color_hover'=> '#f98d00',
			),

			'alizarin' => array(
				'global_color'               => '#fe4641',
				'secondry_nav_background'    => '#333333',
				'topbar_text_color'          => '#aaaaaa',
				'topbar_links_color'         => '#ffffff',
				'topbar_links_color_hover'   => '#fe4641',
				'main_nav_background'        => '#333333',
				'main_nav_text_color'        => '#f6f6f6',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#fe4641',
				'footer_background_color'    => '#252525',
				'footer_title_color'         => '#ffffff',
				'footer_text_color'          => '#aaaaaa',
				'copyright_background_color' => '#181818',
				'copyright_text_color'       => '#66666',
				'copyright_links_color'      => '#fe4641',
			),

			'sand' => array(
				'global_color'               => '#daa48a',
				'secondry_nav_background'    => '#f7f7f7',
				'topbar_text_color'          => '#aaaaaa',
				'topbar_links_color'         => '#9ca7b7',
				'topbar_links_color_hover'   => '#daa48a',
				'main_nav_background'        => '#daa48a',
				'main_nav_text_color'        => '#f2f2f2',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#ca8f73',
				'footer_background_color'    => '#3f3f3f',
				'copyright_background_color' => '#3a3939',
			),

			'royal' => array(
				'global_color'               => '#921245',
				'secondry_nav_background'    => '#ffffff',
				'topbar_text_color'          => '#888888',
				'topbar_links_color'         => '#66525f',
				'topbar_links_color_hover'   => '#f4a641',
				'main_nav_background'        => '#921245',
				'main_nav_text_color'        => '#b39fac',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#f4a641',
				'footer_background_color'    => '#301c2a',
				'footer_links_color_hover'   => '#f4a641',
				'copyright_background_color' => '#2d1827',
				'copyright_links_color_hover'=> '#f4a641',
			),

			'mint' => array(
				'global_color'               => '#00bf80',
				'secondry_nav_background'    => '#eff0f1',
				'topbar_text_color'          => '#333333',
				'topbar_links_color'         => '#434955',
				'topbar_links_color_hover'   => '#00bf80',
				'main_nav_background'        => '#434955',
				'main_nav_text_color'        => '#ffffff',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#00bf80',
				'footer_background_color'    => '#434955',
				'footer_title_color'         => '#434955',
				'footer_text_color'          => '#bbbbbb',
				'copyright_background_color' => '#363a42',
			),

			'stylish_red' => array(
				'global_color'               => '#ff2b58',
				'secondry_nav_background'    => '#25282b',
				'topbar_text_color'          => '#aaaaaa',
				'topbar_links_color'         => '#ffffff',
				'topbar_links_color_hover'   => '#ff2b58',
				'main_nav_background'        => '#ff2b58',
				'main_nav_text_color'        => '#e8e8e8',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#333333',
			),

			'twilight' => array(
				'global_color'               => '#937cbf',
				'secondry_nav_background'    => '#21282e',
				'topbar_text_color'          => '#aaaaaa',
				'topbar_links_color'         => '#ffffff',
				'topbar_links_color_hover'   => '#ef4f91',
				'main_nav_background'        => '#1c2126',
				'main_nav_text_color'        => '#c79dd7',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#937cbf',
				'footer_background_color'    => '#1c2126',
				'copyright_background_color' => '#21282e',
			),

			'coffee' => array(
				'global_color'               => '#c7a589',
				'secondry_nav_background'    => '#46403c',
				'topbar_text_color'          => '#cdcbc9',
				'topbar_links_color'         => '#ddd6d0',
				'topbar_links_color_hover'   => '#c7a589',
				'main_nav_background'        => '#59524c',
				'main_nav_text_color'        => '#ddd6d0',
				'main_nav_links_color'       => '#cdcbc9',
				'main_nav_links_color_hover' => '#c7a589',
				'footer_background_color'    => '#59524c',
				'footer_text_color'          => '#bbbbbb',
				'copyright_background_color' => '#46403c',
			),

			'ocean' => array(
				'global_color'               => '#9ebaa0',
				'secondry_nav_background'    => '#839da4',
				'topbar_text_color'          => '#daeaea',
				'topbar_links_color'         => '#daeaea',
				'topbar_links_color_hover'   => '#ffffff',
				'main_nav_background'        => '#627c83',
				'main_nav_text_color'        => '#daeaea',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#9ebaa0',
				'footer_background_color'    => '#627c83',
				'footer_text_color'          => '#daeaea',
				'copyright_background_color' => '#5c757b',
				'copyright_text_color'       => '#daeaea',
				'copyright_links_color'      => '#daeaea',
				'copyright_links_color_hover'=> '#ffffff',
			),

			'cyan' => array(
				'global_color'               => '#32beeb',
				'secondry_nav_background'    => '#222222',
				'topbar_text_color'          => '#aaaaaa',
				'topbar_links_color'         => '#ffffff',
				'topbar_links_color_hover'   => '#32beeb',
				'main_nav_background'        => '#1a1a1a',
				'main_nav_text_color'        => '#aaaaaa',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#32beeb',
				'footer_background_color'    => '#222222',
				'copyright_background_color' => '#1a1a1a',
			),

			'facebook' => array(
				'global_color'               => '#3b5998',
				'secondry_nav_background'    => '#3b5998',
				'topbar_text_color'          => '#ffffff',
				'topbar_links_color'         => '#f6f7f9',
				'topbar_links_color_hover'   => '#ffffff',
				'main_nav_background'        => '#f6f7f9',
				'main_nav_text_color'        => '#4b4f56',
				'main_nav_links_color'       => '#365899',
				'main_nav_links_color_hover' => '#3b5998',
				'footer_background_color'    => '#f6f7f9',
				'footer_title_color'         => '#3b5998',
				'footer_text_color'          => '#1d2129',
				'footer_links_color'         => '#4b6dad',
				'footer_links_color_hover'   => '#3b5998',
				'copyright_background_color' => '#ffffff',
				'copyright_text_color'       => '#1d2129',
				'copyright_links_color'      => '#1d2129',
			),

			'sahifa' => array(
				'global_color'               => '#F88C00',
				'secondry_nav_background'    => '#fbfbfb',
				'topbar_text_color'          => '#838383',
				'topbar_links_color'         => '#838383',
				'topbar_links_color_hover'   => '#000000',
				'main_nav_background'        => '#2d2d2d',
				'main_nav_text_color'        => '#aaaaaa',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#F88C00',
				'footer_background_color'    => '#333333',
				'copyright_background_color' => '#2e2e2e',
			),

			'mist' => array(
				'global_color'               => '#2e323c',
				'secondry_nav_background'    => '#2a4150',
				'topbar_text_color'          => '#90b3bb',
				'topbar_links_color'         => '#ffffff',
				'topbar_links_color_hover'   => '#90b3bb',
				'main_nav_background'        => '#2e323c',
				'main_nav_text_color'        => '#aaaaaa',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#45405C',
				'footer_background_color'    => '#2e323c',
				'copyright_background_color' => '#2e323c',
			),

			'serene' => array(
				'global_color'               => '#fcad84',
				'secondry_nav_background'    => '#ecc7bf',
				'topbar_text_color'          => '#ffffff',
				'topbar_links_color'         => '#3c2e3d',
				'topbar_links_color_hover'   => '#ffffff',
				'main_nav_background'        => '#8acbc7',
				'main_nav_text_color'        => '#f1f1f1',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#d9e8e3',
				'footer_background_color'    => '#d9e8e3',
				'footer_title_color'         => '#333333',
				'footer_text_color'          => '#333333',
				'footer_links_color'         => '#58afa9',
				'footer_links_color_hover'   => '#fcad84',
				'copyright_background_color' => '#ffffff',
				'copyright_text_color'       => '#555555',
				'copyright_links_color'      => '#555555',
			),

			'fall' => array(
				'global_color'               => '#613942',
				'secondry_nav_background'    => '#e8dbcb',
				'topbar_text_color'          => '#444444',
				'topbar_links_color'         => '#444444',
				'topbar_links_color_hover'   => '#839973',
				'main_nav_background'        => '#36374b',
				'main_nav_text_color'        => '#e8dbcb',
				'main_nav_links_color'       => '#ffffff',
				'main_nav_links_color_hover' => '#839973',
				'footer_background_color'    => '#36374b',
				'footer_text_color'          => '#e8dbcb',
				'footer_links_color'         => '#ffffff',
				'footer_links_color_hover'   => '#e8dbcb',
				'copyright_background_color' => '#36374b',
				'copyright_text_color'       => '#ffffff',
				'copyright_links_color'      => '#ffffff',
				'copyright_links_color_hover'=> '#e8dbcb',
			),

		);

?>

	<script>var tie_skins = <?php echo wp_json_encode( $skins ) ?>;</script>



<?php
	jannah_theme_option(
		array(
			'name' => esc_html__( 'Custom Primary Color', 'jannah' ),
			'id'   => 'global_color',
			'type' => 'color',
		));


	# Body styles ----------
	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Body', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Disable Boxed/Framed Layout Shadows', 'jannah' ),
			'id'   => 'wrapper_disable_shadows',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Highlighted Text Color', 'jannah' ),
			'id'   => 'highlighted_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Links Text Color', 'jannah' ),
			'id'   => 'links_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Links text HOVER color', 'jannah' ),
			'id'   => 'links_color_hover',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Underline text links on hover', 'jannah' ),
			'id'   => 'underline_links_hover',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Borders Color', 'jannah' ),
			'id'   => 'borders_color',
			'type' => 'color',
		));

	# Secondary Nav ----------
	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Secondary Nav', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Background Color', 'jannah' ),
			'id'   => 'secondry_nav_background',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Text Color', 'jannah' ),
			'id'   => 'topbar_text_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Links Color', 'jannah' ),
			'id'   => 'topbar_links_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Links Color on mouse over', 'jannah' ),
			'id'   => 'topbar_links_color_hover',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Breaking news label background', 'jannah' ),
			'id'   => 'breaking_title_bg',
			'type' => 'color',
		));


	# Header ----------
	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Header', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Rainbow Line Above Header', 'jannah' ),
			'id'   => 'rainbow_header',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Background Color', 'jannah' ),
			'id'   => 'header_background_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Background Image', 'jannah' ),
			'id'   => 'header_background_img',
			'type' => 'background',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Disable Header Shadows', 'jannah' ),
			'id'   => 'header_disable_shadows',
			'type' => 'checkbox',
		));

	# Main Nav ----------
	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Main Navigation Styling', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Background Color', 'jannah' ),
			'id'   => 'main_nav_background',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Text Color', 'jannah' ),
			'id'   => 'main_nav_text_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Links Color', 'jannah' ),
			'id'   => 'main_nav_links_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Links Color on mouse over', 'jannah' ),
			'id'   => 'main_nav_links_color_hover',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Main Nav Border Top Color', 'jannah' ),
			'id'   => 'main_nav_border_top_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Main Nav Border Top Width', 'jannah' ),
			'id'   => 'main_nav_border_top_width',
			'type' => 'number',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Main Nav Border Bottom Color', 'jannah' ),
			'id'   => 'main_nav_border_bottom_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Main Nav Border Bottom Width', 'jannah' ),
			'id'   => 'main_nav_border_bottom_width',
			'type' => 'number',
		));



	# Main Content ----------
	jannah_theme_option(
		array(
			'type'	=> 'header',
			'title' =>	esc_html__( 'Main Content Styling', 'jannah' ),
		));

	jannah_theme_option(
		array(
			'name'	=> esc_html__( 'Background Color', 'jannah' ),
			'id'		=> 'main_content_bg_color',
			'type'	=> 'color',
		));

	jannah_theme_option(
		array(
			'name'	=> esc_html__( 'Background Image', 'jannah' ),
			'id'		=> 'main_content_bg_img',
			'type'	=> 'background',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'In Post Links Color', 'jannah' ),
			'id'   => 'post_links_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'In Post Links Color on mouse over', 'jannah' ),
			'id'   => 'post_links_color_hover',
			'type' => 'color',
		));


	# Footer ----------
	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Footer', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Background Color', 'jannah' ),
			'id'   => 'footer_background_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Background Image', 'jannah' ),
			'id'   => 'footer_background_img',
			'type' => 'background',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Footer Border Top', 'jannah' ),
			'id'   => 'footer_border_top',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Widgets Title color', 'jannah' ),
			'id'   => 'footer_title_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name'	=> esc_html__( 'Text Color', 'jannah' ),
			'id'		=> 'footer_text_color',
			'type'	=> 'color',
		));

	jannah_theme_option(
		array(
			'name'	=> esc_html__( 'Links Color', 'jannah' ),
			'id'		=> 'footer_links_color',
			'type'	=> 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Links Color on mouse over', 'jannah' ),
			'id'   => 'footer_links_color_hover',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Footer Margin Top', 'jannah' ),
			'id'   => 'footer_margin_top',
			'type' => 'number',
			'hint' => esc_html__( 'Leave it empty to use the default value.', 'jannah' ),
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Footer Padding Top', 'jannah' ),
			'id'   => 'footer_padding_top',
			'type' => 'number',
			'hint' => esc_html__( 'Leave it empty to use the default value.', 'jannah' ),
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Footer Padding Bottom', 'jannah' ),
			'id'   => 'footer_padding_bottom',
			'type' => 'number',
			'hint' => esc_html__( 'Leave it empty to use the default value.', 'jannah' ),
		));


	# Footer Bottom ----------
	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Copyright Area', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Background Color', 'jannah' ),
			'id'   => 'copyright_background_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Background Image', 'jannah' ),
			'id'   => 'copyright_background_img',
			'type' => 'background',
		));

	jannah_theme_option(
		array(
			'name'	=> esc_html__( 'Text Color', 'jannah' ),
			'id'		=> 'copyright_text_color',
			'type'	=> 'color',
		));

	jannah_theme_option(
		array(
			'name'	=> esc_html__( 'Links Color', 'jannah' ),
			'id'		=> 'copyright_links_color',
			'type'	=> 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Links Color on mouse over', 'jannah' ),
			'id'   => 'copyright_links_color_hover',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Mobile Menu', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Mobile Menu Icon', 'jannah' ),
			'id'   => 'mobile_menu_icon_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'links color', 'jannah' ),
			'id'   => 'mobile_menu_text_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Social Icons color', 'jannah' ),
			'id'   => 'mobile_menu_social_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Search Button color', 'jannah' ),
			'id'   => 'mobile_menu_search_color',
			'type' => 'color',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Mobile Menu Background', 'jannah' ),
			'id'     => 'mobile_menu_background_type',
			'type'   => 'radio',
			'toggle' => array(
				''         => '',
				'color'    => '#mobile_menu_background_color-item',
				'gradient' => '#mobile_menu_background_gradient_color_1-item, #mobile_menu_background_gradient_color_2-item',
				'image'    => '#mobile_menu_background_image-item',),
			'options' => array(
				''         => esc_html__( 'None', 'jannah' ),
				'color'    => esc_html__( 'Color', 'jannah' ),
				'gradient' => esc_html__( 'Gradient', 'jannah' ),
				'image'    => esc_html__( 'Image', 'jannah' ),
			)));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Background Color', 'jannah' ),
			'id'    => 'mobile_menu_background_color',
			'class' => 'mobile_menu_background_type',
			'type'  => 'color',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Background Gradient Color 1', 'jannah' ),
			'id'    => 'mobile_menu_background_gradient_color_1',
			'class' => 'mobile_menu_background_type',
			'type'  => 'color',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Background Gradient Color 2', 'jannah' ),
			'id'    => 'mobile_menu_background_gradient_color_2',
			'class' => 'mobile_menu_background_type',
			'type'  => 'color',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Background Image', 'jannah' ),
			'id'    => 'mobile_menu_background_image',
			'class' => 'mobile_menu_background_type',
			'type'  => 'background',
		));

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'Custom CSS', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'text' => esc_html__( 'Paste your CSS code, do not include any tags or HTML in the field. Any custom CSS entered here will override the theme CSS. In some cases, the !important tag may be needed.', 'jannah' ),
			'type' => 'message',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Custom CSS', 'jannah' ),
			'id'    => 'css',
			'class' => 'tie-css',
			'type'  => 'textarea',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Tablets', 'jannah' ) . '<br /><small>' . esc_html__( '768px - 1024px', 'jannah' ) .'</small>',
			'id'    => 'css_tablets',
			'class' => 'tie-css',
			'type'  => 'textarea',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Phones', 'jannah' ) . '<br /><small>' . esc_html__( '0 - 768px', 'jannah' ) .'</small>',
			'id'    => 'css_phones',
			'class' => 'tie-css',
			'type'  => 'textarea',
		));

?>

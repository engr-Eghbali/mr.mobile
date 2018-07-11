<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Accelerated Mobile Pages ', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'text' => esc_html__( "AMP is a Google-backed project with the aim of speeding up the delivery of content through the use of stripped down code known as AMP HTML, it is a way to build web pages for static content (pages that don't change based on user behaviour), that allows the pages to load (and pre-render in Google search) much faster than regular HTML.", 'jannah' ),
			'type' => 'message',
		));

	if( JANNAH_AMP_IS_ACTIVE ){

		echo '<br />';

		$amp_structure = '?amp=1';
		$amp_message   = esc_html__( "You may need to enable pretty permalinks if it isn't working.", 'jannah' );

		if( get_option( 'permalink_structure' ) ){
			$amp_structure = '/amp/';
			$amp_message   = '';
		}

		jannah_theme_option(
			array(
				'text' => sprintf( esc_html__( 'To access the AMP version go to any blog post and add %s to the end of the URL.', 'jannah' ), '<strong>'. $amp_structure .'</strong>' ) . $amp_message,
				'type' => 'message',
			));

		jannah_theme_option(
			array(
				'title' => esc_html__( 'Logo', 'jannah' ),
				'type'  => 'header',
			));

		jannah_theme_option(
			array(
				'name'  => esc_html__( 'Logo Image', 'jannah' ),
				'id'    => 'amp_logo',
				'type'  => 'upload',
			));

		jannah_theme_option(
			array(
				'title' => esc_html__( 'Post Settings', 'jannah' ),
				'type'  => 'header',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Related Posts', 'jannah' ),
				'id'   => 'amp_related_posts',
				'type' => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Share Buttons', 'jannah' ),
				'id'     => 'amp_share_buttons',
				'toggle' => '#amp_facebook_app_id-item',
				'type'   => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Facebook APP ID', 'jannah' ),
				'id'   => 'amp_facebook_app_id',
				'hint' => esc_html__( '(Required)', 'jannah' ),
				'type' => 'text',
			));

		jannah_theme_option(
			array(
				'title' => esc_html__( 'Footer Settings', 'jannah' ),
				'type'  => 'header',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Back to top button', 'jannah' ),
				'id'   => 'amp_back_to_top',
				'type' => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name'  => esc_html__( 'Footer Logo Image', 'jannah' ),
				'id'    => 'amp_footer_logo',
				'type'  => 'upload',
			));

		jannah_theme_option(
			array(
				'name'    => esc_html__( 'Footer Menu', 'jannah' ),
				'id'      => 'amp_footer_menu',
				'type'    => 'select',
				'options' => jannah_get_menus_array( true ),
			));

		$footer_codes = '<strong>'. esc_html__( 'Variables', 'jannah' ) .'</strong> '.
			esc_html__( 'These tags can be included in the textarea above and will be replaced when a page is displayed.', 'jannah' ) .'
			<br />
			<strong>%year%</strong> : <em>'.esc_html__( 'Replaced with the current year.',      'jannah' ) .'</em><br />
			<strong>%site%</strong> : <em>'.esc_html__( "Replaced with The site's name.", 'jannah' ) .'</em><br />
			<strong>%url%</strong>  : <em>'.esc_html__( "Replaced with The site's URL.",  'jannah' ) .'</em>';

		jannah_theme_option(
			array(
				'name'  => esc_html__( 'Copyright Text', 'jannah' ),
				'id'    => 'amp_footer_copyright',
				'hint'  => $footer_codes,
				'type'  => 'textarea',
			));

		jannah_theme_option(
			array(
				'title' => esc_html__( 'Advertisement', 'jannah' ),
				'type'  => 'header',
			));

		jannah_theme_option(
			array(
				'name'  => esc_html__( 'Above Content', 'jannah' ),
				'id'    => 'amp_ad_above',
				'hint'  => sprintf( wp_kses_post( __( 'Enter your Ad code, AMP pages support &lt;amp-ad&gt; tag only, <a href="%s" target="_blank">Click Here</a> For More info.', 'jannah' )), 'https://www.ampproject.org/docs/reference/extended/amp-ad.html' ),
				'type'  => 'textarea',
			));

		jannah_theme_option(
			array(
				'name'  => esc_html__( 'Below Content', 'jannah' ),
				'id'    => 'amp_ad_below',
				'hint'  => sprintf( wp_kses_post( __( 'Enter your Ad code, AMP pages support &lt;amp-ad&gt; tag only, <a href="%s" target="_blank">Click Here</a> For More info.', 'jannah' )), 'https://www.ampproject.org/docs/reference/extended/amp-ad.html' ),
				'type'  => 'textarea',
			));

		jannah_theme_option(
			array(
				'title' => esc_html__( 'Styling', 'jannah' ),
				'type'  => 'header',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Background Color', 'jannah' ),
				'id'   => 'amp_bg_color',
				'type' => 'color',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Header Background Color', 'jannah' ),
				'id'   => 'amp_header_color',
				'type' => 'color',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Title Color', 'jannah' ),
				'id'   => 'amp_title_color',
				'type' => 'color',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Post meta Color', 'jannah' ),
				'id'   => 'amp_meta_color',
				'type' => 'color',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Links color', 'jannah' ),
				'id'   => 'amp_links_color',
				'type' => 'color',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Footer color', 'jannah' ),
				'id'   => 'amp_footer_color',
				'type' => 'color',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Underline text links on hover', 'jannah' ),
				'id'   => 'amp_links_underline',
				'type' => 'checkbox',
			));
	}

	else{
		jannah_theme_option(
			array(
				'text' =>  wp_kses_post( sprintf( __( 'You need to install the <a href="%s">Automattic AMP plugin</a> first.', 'jannah' ), add_query_arg( array( 'page' => 'tie-install-plugins' ), admin_url( 'admin.php' )) ) ),
				'type' => 'error',
			));
		}

?>

<?php
/**
 * Theme's Scripts and Styles
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





/*-----------------------------------------------------------------------------------*/
# Setup Theme
/*-----------------------------------------------------------------------------------*/
add_action( 'after_setup_theme', 'jannah_theme_setup' );
function jannah_theme_setup(){

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'post-thumbnails' );

	//add_theme_support( 'buddypress' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-slider' );

	add_theme_support( 'Arqam_Lite' );


	# Post editor styles ----------
	add_editor_style( 'css/editor-style.css' );


	# Post Thumbnails ----------
	add_image_size( 'jannah-image-small', 220, 150, true );
	add_image_size( 'jannah-image-large', 390, 220, true );
	add_image_size( 'jannah-image-post',  780, 405, true );
	add_image_size( 'jannah-image-grid',  780, 500, true );
	add_image_size( 'jannah-image-full',  1170, 610,true );


	# Languages ----------
	load_theme_textdomain( 'jannah', JANNAH_TEMPLATE_PATH . '/languages' );


	# Theme Menus ----------
	register_nav_menus( array(
		'top-menu'    => esc_html__( 'Secondry Nav Menu', 'jannah' ),
		'primary'     => esc_html__( 'Main Nav Menu',     'jannah' ),
		'404-menu'    => esc_html__( '404 Page menu',     'jannah' ),
		'footer-menu' => esc_html__( 'Footer Navigation', 'jannah' ),
	));


	# Disable the default bbpress breadcrumb ----------
	add_filter( 'bbp_no_breadcrumb', '__return_true' );

}





/*-----------------------------------------------------------------------------------*/
# Register main Scripts and Styles
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_enqueue_scripts', 'jannah_enqueue_scripts', 20 );
function jannah_enqueue_scripts(){

	$min = jannah_get_option( 'minified_files' ) ? '.min' : '';

	# Scripts files ----------
	// Main Scripts file
	wp_enqueue_script( 'jannah-scripts', JANNAH_TEMPLATE_URL . '/js/scripts'. $min .'.js', array( 'jquery' ), false, true );

	// Sliders
	wp_register_script( 'jannah-sliders', JANNAH_TEMPLATE_URL . '/js/sliders'. $min .'.js', array( 'jquery' ), false, true );


	# CSS Files ----------
	// Main style.css file
	wp_enqueue_style( 'jannah-styles',  JANNAH_TEMPLATE_URL.'/css/style'. $min .'.css', array(), '', 'all' );

	// WooCommerce
	if ( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
		wp_enqueue_style( 'jannah-woocommerce', JANNAH_TEMPLATE_URL.'/css/woocommerce'. $min .'.css', array(), '', 'all' );
	}

	// bbPress css file
	if ( JANNAH_BBPRESS_IS_ACTIVE ){
		wp_enqueue_style( 'jannah-bbpress', JANNAH_TEMPLATE_URL.'/css/bbpress'. $min .'.css', array(), '', 'all' );

		wp_dequeue_style( 'bbp-default' );
		wp_dequeue_style( 'bbp-default-rtl' );
	}

	// Mp-Timetable css file
	if ( JANNAH_MPTIMETABLE_IS_ACTIVE ){
		wp_enqueue_style( 'jannah-mptt', JANNAH_TEMPLATE_URL.'/css/mptt'. $min .'.css', array(), '', 'all' );
	}

	// iLightBox css file
	$lightbox_skin = jannah_get_option( 'lightbox_skin', 'dark' );
	wp_enqueue_style( 'jannah-ilightbox-skin', JANNAH_TEMPLATE_URL . '/css/ilightbox/'.$lightbox_skin.'-skin/skin.css' );


	# IE ----------
	global $is_IE;

	if( $is_IE ) {

		preg_match( '/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches );
		if( count( $matches ) < 2 ){
  		preg_match( '/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches );
		}

		$version = $matches[1];

		// IE 10
		if( $version <= 11 ){
			wp_enqueue_style( 'jannah-ie-11-styles', JANNAH_TEMPLATE_URL .'/css/ie-lt-11.css', array(), '', 'all' );
			wp_enqueue_script( 'jannah-ie-scripts',   JANNAH_TEMPLATE_URL . '/js/ie.js', array( 'jquery' ), false, true );

		}
		// <= IE 10
		if ( $version < 10 ) {
			wp_enqueue_style( 'jannah-ie-10-styles', JANNAH_TEMPLATE_URL.'/css/ie-lt-10.css', array(), '', 'all' );
		}
	}


	# Queue Comments reply js ----------
	if ( is_singular() && comments_open() && get_option('thread_comments') ){
		wp_enqueue_script( 'comment-reply' );
	}


	# Inline Vars ----------
	$type_to_search = false;
	if( ( jannah_get_option( 'top_nav' )  && jannah_get_option( 'top-nav-components_search'  ) && jannah_get_option( 'top-nav-components_type_to_search'  )) || ( jannah_get_option( 'main_nav' ) && jannah_get_option( 'main-nav-components_search' ) && jannah_get_option( 'main-nav-components_type_to_search' )) ){
		$type_to_search = true;
  }


  # Reading Position Indicator ----------
  if( is_singular() && jannah_get_option( 'reading_indicator' ) ){
  	wp_enqueue_script( 'imagesloaded' );
  }


	$js_vars = array(
		'is_rtl'                => is_rtl(),
		'ajaxurl'               => esc_url(admin_url( 'admin-ajax.php' )),
		'mobile_menu_active'    => jannah_get_option( 'mobile_menu_active' ),
		'mobile_menu_top'       => jannah_get_option( 'mobile_menu_top' ),
		'mobile_menu_parent'    => jannah_get_option( 'mobile_menu_parent_link' ),
		'lightbox_all'          => jannah_get_option( 'lightbox_all' ),
		'lightbox_gallery'      => jannah_get_option( 'lightbox_gallery' ),
		'lightbox_skin'         => $lightbox_skin,
		'lightbox_thumb'        => jannah_get_option( 'lightbox_thumbs' ),
		'lightbox_arrows'       => jannah_get_option( 'lightbox_arrows' ),
		'is_singular'           => is_singular(),
		'reading_indicator'     => jannah_get_option( 'reading_indicator' ),
		'sticky_behavior'       => jannah_get_option( 'sticky_behavior' ),
		'lazyload'              => jannah_get_option( 'lazy_load' ),
		'select_share'          => jannah_get_option( 'select_share' ),
		'select_share_twitter'  => jannah_get_option( 'select_share_twitter' ),
		'select_share_facebook' => jannah_get_option( 'select_share_facebook' ),
		'select_share_linkedin' => jannah_get_option( 'select_share_linkedin' ),
		'facebook_app_id'       => jannah_get_option( 'facebook_app_id' ),
		'twitter_username'      => jannah_get_option( 'share_twitter_username' ),
		'is_buddypress_active'  => JANNAH_BUDDYPRESS_IS_ACTIVE,
		'ajax_loader'           => jannah_get_ajax_loader( false ),
		'type_to_search'        => $type_to_search,
		'ad_blocker_detector'   => jannah_get_option( 'ad_blocker_detector' ),
	);
	wp_localize_script( 'jquery', 'tie', $js_vars );


	# Taqyeem ----------
	if( JANNAH_TAQYEEM_IS_ACTIVE ){
		wp_dequeue_script( 'taqyeem-main' );

		wp_dequeue_style( 'taqyeem-style' );
		wp_enqueue_style( 'taqyeem-styles', JANNAH_TEMPLATE_URL.'/css/taqyeem'. $min .'.css' );

		if( ! is_admin() ){
			wp_dequeue_style( 'taqyeem-fontawesome' );
		}
	}

	# InstaNOW ----------
	wp_dequeue_style( 'tie-insta-ilightbox-skin' );

	# Prevent InstaNOW Plugin from loading IlightBox ----------
	add_filter( 'tie_instagram_force_avoid_ilightbox', '__return_false' );

	# Prevent TieLabs shortcodes plugin from loading its js and Css files ----------
	add_filter( 'tie_plugin_shortcodes_enqueue_assets', '__return_false' );

	# Remove Query Strings From Static Resources ----------
	if ( ! is_admin() ){
		add_filter( 'script_loader_src', 'jannah_remove_query_strings_1', 15, 1 );
		add_filter( 'style_loader_src',  'jannah_remove_query_strings_1', 15, 1 );
		add_filter( 'script_loader_src', 'jannah_remove_query_strings_2', 15, 1 );
		add_filter( 'style_loader_src',  'jannah_remove_query_strings_2', 15, 1 );
	}

}





/*-----------------------------------------------------------------------------------*/
# Meta Tags
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_site_head' ) ){

	add_action( 'wp_head', 'jannah_site_head', 5 );
	function jannah_site_head(){

		# Viewport meta tag ----------
		if( jannah_get_option( 'disable_responsive' )){
			echo '<meta name="viewport" content="width=1200" />';
		}
		else{
			echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';
		}

		# Theme-color in Chrome 39 for Android ----------
		$theme_color = jannah_get_object_option( 'global_color', 'cat_color', 'post_color' ) ? jannah_get_object_option( 'global_color', 'cat_color', 'post_color' ) : '#0088ff';
		echo "<meta name=\"theme-color\" content=\"$theme_color\" />";

		# Custom Header Code ----------
		echo jannah_get_option('header_code'), "\n";
	}

}





/*-----------------------------------------------------------------------------------*/
# Default fonts sections
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_fonts_sections' )){

	function jannah_fonts_sections(){

		$fonts_sections = array(
			'body'         => 'body',
			'headings'     => '.logo-text, h1, h2, h3, h4, h5, h6',
			'menu'         => '#main-nav .main-menu > ul > li > a',
			'blockquote'   => 'blockquote p',
		);

		return apply_filters( 'jannah_fonts_sections_array', $fonts_sections );
	}

}





/*-----------------------------------------------------------------------------------*/
# Styles
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_custom_styling' )){

	function jannah_get_custom_styling(){

		# Get the Fonts CSS ----------
		$out = jannah_insert_fonts_css();


		# Custom size, line height, weight, captelization ----------
		$text_sections = array(
			'body'                   => 'body',
			'site_title'             => '.logo-text',
			'top_menu'               => '#top-nav .top-menu > ul > li > a',
			'top_menu_sub'           => '#top-nav .top-menu > ul ul li a',
			'main_nav'               => '#main-nav .main-menu > ul > li > a',
			'main_nav_sub'           => '#main-nav .main-menu > ul ul li a',
			'mobile_menu'            => '#mobile-menu li a',
			'breaking_news'          => '.breaking .breaking-title',
			'breaking_news_posts'    => '.breaking-news li',
			'buttons'                => '.button, a.button, a.more-link, .entry a.more-link, input[type="submit"]',
			'breadcrumbs'            => '#breadcrumb',
			'post_cat_label'         => '.post-cat',
			'single_post_title'      => '.entry-header h1.entry-title',
			'post_title_blocks'      => '
						#tie-wrapper .mag-box:not(.scrolling-box):not(.big-post-left-box):not(.big-post-top-box):not(.half-box):not(.big-thumb-left-box):not(.miscellaneous-box) .post-title,
						#tie-wrapper .mag-box.big-post-left-box li:first-child .post-title,
						#tie-wrapper .mag-box.big-post-top-box li:first-child .post-title,
						#tie-wrapper .mag-box.half-box li:first-child .post-title,
						#tie-wrapper .mag-box.big-thumb-left-box li:first-child .post-title,
						#tie-wrapper .mag-box.miscellaneous-box li:first-child .post-title,
						#tie-wrapper .mag-box .thumb-title,
						#tie-wrapper .media-page-layout .thumb-title',
			'post_small_title_blocks'=> '
						#tie-wrapper .mag-box.big-post-left-box li:not(:first-child) .post-title,
						#tie-wrapper .mag-box.big-post-top-box li:not(:first-child) .post-title,
						#tie-wrapper .mag-box.half-box li:not(:first-child) .post-title,
						#tie-wrapper .mag-box.big-thumb-left-box li:not(:first-child) .post-title,
						#tie-wrapper .mag-box.miscellaneous-box li:not(:first-child) .post-title,
						#tie-wrapper .mag-box.scrolling-box .slide .post-title,
						#tie-wrapper .post-widget-body .post-title',
			'post_entry'             => '#the-post .entry-content',
			'blockquote'             => '#the-post blockquote',
			'boxes_title'            => '#tie-wrapper .mag-box-title h3',
			'widgets_title'          => '
						#tie-wrapper .widget-title h4,
						#tie-wrapper #comments-title,
						#tie-wrapper .comment-reply-title,
						#tie-wrapper .woocommerce-tabs .panel h2,
						#tie-wrapper .related.products h2,
						#tie-wrapper #bbpress-forums #new-post > fieldset.bbp-form > legend,
						#tie-wrapper .entry-content .review-box-header',
			'copyright'              => '#tie-wrapper .copyright-text',
			'footer_widgets_title'   => '#footer .widget-title h4',
			'post_heading_h1'        => '.entry h1',
			'post_heading_h2'        => '.entry h2',
			'post_heading_h3'        => '.entry h3',
			'post_heading_h4'        => '.entry h4',
			'post_heading_h5'        => '.entry h5',
			'post_heading_h6'        => '.entry h6',
		);

		foreach ( $text_sections as $option => $elements ){

			$text_styles = '';
			if( $section = jannah_get_option( 'typography_'.$option )){

				$text_styles .= ! empty( $section['size'] )        ? 'font-size: '. $section['size'] .'px;'         : '';
				$text_styles .= ! empty( $section['weight'] )      ? 'font-weight: '. $section['weight'] .';'       : '';
				$text_styles .= ! empty( $section['transform'] )   ? 'text-transform: '. $section['transform'] .';' : '';

				if( !empty( $section['line_height'] ) ){

					if( $option == 'main_nav' ){
						$out .= "\t".'#main-nav{line-height: '. $section['line_height'] .'em}'."\n";
					}
					elseif( $option == 'top_menu' ){
						$out .= "\t".'#top-nav{line-height: '. $section['line_height'] .'em}'."\n";
					}
					else{
						$text_styles .= 'line-height: '. $section['line_height'] .';';
					}
				}


				$out .= "\t".$elements.'{'. $text_styles .'}'."\n";
			}
		}



	/* ============================== Theme Colors ============================== */

		/* Main Colors
			 ===================================================*/

		# Theme Color ----------
		if( $color = jannah_get_object_option( 'global_color', 'cat_color', 'post_color' )){
			$out .= jannah_theme_color( $color );
		}


		# Custom Css Codes for posts and cats ----------
		$out .= jannah_get_object_option( false, 'cat_custom_css', 'tie_custom_css' );


		# Background ----------
		$out .= jannah_theme_background();


		# Highlighted Color ----------
		if( $color = jannah_get_option( 'highlighted_color' )){

			$bright = jannah_light_or_dark( $color );

			$out .="
			::-moz-selection{
				background-color: $color;
				color: $bright;
			}

			::selection{
				background-color: $color;
				color: $bright;
			}";
		}

		# Links Color ----------
		if( $color = jannah_get_option( 'links_color' )){
			$out .="
				a{
					color: $color;
				}
			";
		}

		# Links Color Hover ----------
		if( $color = jannah_get_option( 'links_color_hover' )){
			$out .="
				a:hover{
					color: $color;
				}
			";
		}

		# Links hover underline ----------
		if( jannah_get_option( 'underline_links_hover' )){
			$out .='
			#content a:hover{
				text-decoration: underline !important;
			}';
		}

		# Theme Main Borders ----------
		if( $color = jannah_get_option( 'borders_color' )){

			$out .="
				.container-wrapper,
				.mag-box-title,
				.section-title.default-style,
				.widget-title,
				#comments-title,
				.comment-reply-title,
				.woocommerce-tabs .panel h2,
				.related.products h2:first-child,
				.up-sells > h2,
				.entry .cross-sells > h2,
				.entry .cart_totals > h2,
				#bbpress-forums #new-post > fieldset.bbp-form > legend,
				.review-box-header,
				.mag-box .show-more-button,
				.woocommerce-tabs ul.tabs li a,
				.tabs-wrapper .tabs-menu li a,
				.social-statistics-widget .white-bg .social-icons-item a,
				textarea, input, select{
					border-color: $color !important;
				}

				#footer #footer-widgets-container .fullwidth-area .widget_tag_cloud .tagcloud a:not(:hover){
					background: transparent;

					-webkit-box-shadow: inset 0 0 0 3px $color;
					   -moz-box-shadow: inset 0 0 0 3px $color;
					     -o-box-shadow: inset 0 0 0 3px $color;
					        box-shadow: inset 0 0 0 3px $color;
				}
			";
		}




		/* Secondry nav
			 ===================================================*/

		if( $color = jannah_get_option( 'secondry_nav_background' )){
			$darker = jannah_adjust_color_brightness( $color, -30 );
			$bright = jannah_light_or_dark( $color, true );

			$out .="
			  #tie-wrapper #top-nav{
				  border-width: 0;
			  }

				#tie-wrapper #top-nav,
				#tie-wrapper #top-nav .top-menu ul,
				#tie-wrapper #top-nav .comp-sub-menu,
				#tie-wrapper #top-nav .ticker-content,
				#tie-wrapper #top-nav .ticker-swipe,
				.top-nav-boxed #top-nav .topbar-wrapper,
				.top-nav-dark.top-nav-boxed #top-nav .topbar-wrapper,
				.search-in-top-nav.autocomplete-suggestions{
					background-color : $color;
				}

				#tie-wrapper #top-nav *,
				#tie-wrapper #top-nav ul.components > li,
				#tie-wrapper #top-nav .comp-sub-menu,
				#tie-wrapper #top-nav .comp-sub-menu li{
					border-color: rgba( $bright, 0.1);
				}

				#tie-wrapper #top-nav .comp-sub-menu .button,
				#tie-wrapper #top-nav .comp-sub-menu .button.guest-btn{
					background-color: $darker;
				}

				#tie-wrapper #top-nav .comp-sub-menu .button,
				#tie-wrapper #top-nav .comp-sub-menu .button.guest-btn,
				.search-in-top-nav.autocomplete-suggestions{
					border-color: $darker;
				}

			";
		}



		# Secondry nav links ----------
		if( $color = jannah_get_option( 'topbar_links_color' )){

			$out .="
				#tie-wrapper #top-nav a,
				#tie-wrapper #top-nav .breaking .ticker a,
				#tie-wrapper #top-nav input,
				#tie-wrapper #top-nav ul.components button#search-submit,
				#tie-wrapper #top-nav ul.components button#search-submit .fa-spinner,
				#tie-wrapper #top-nav .top-menu li a,
				#tie-wrapper #top-nav .dropdown-social-icons li a span,
				#tie-wrapper #top-nav ul.components a.button:hover,
				#tie-wrapper #top-nav ul.components > li > a,
				#tie-wrapper #top-nav ul.components > li.social-icons-item .social-link:not(:hover) span,
				#tie-wrapper #top-nav .comp-sub-menu .button:hover,
				#tie-wrapper #top-nav .comp-sub-menu .button.guest-btn:hover,
				#tie-body .search-in-top-nav.autocomplete-suggestions a:not(.button){
					color: $color;
				}

				#tie-wrapper #top-nav input::-moz-placeholder{
					color: $color;
				}

				#tie-wrapper #top-nav input:-moz-placeholder{
					color: $color;
				}

				#tie-wrapper #top-nav input:-ms-input-placeholder{
					color: $color;
				}

				#tie-wrapper #top-nav input::-webkit-input-placeholder{
					color: $color;
				}

				#tie-wrapper #top-nav .top-menu .menu li.menu-item-has-children > a:before{
					border-top-color: $color;
				}

				#tie-wrapper #top-nav .top-menu .menu li li.menu-item-has-children > a:before{
					border-top-color: transparent;
					border-left-color: $color;
				}

				.rtl #tie-wrapper #top-nav .top-menu .menu li li.menu-item-has-children > a:before{
					border-left-color: transparent;
					border-right-color: $color;
				}
			";
		}



		# Secondry nav links on hover ----------
		if( $color = jannah_get_option( 'topbar_links_color_hover' )){

			$darker = jannah_adjust_color_brightness( $color, -30 );
			$bright = jannah_light_or_dark( $color );

			$out .="
				#tie-wrapper #top-nav .menu-counter-bubble,
				#tie-wrapper #top-nav .breaking-news-nav li:hover,
				#tie-wrapper #top-nav .comp-sub-menu .button:hover,
				#tie-wrapper #top-nav .comp-sub-menu .button.guest-btn:hover,
				#tie-wrapper #top-nav .comp-sub-menu .button.checkout-button,
				.search-in-top-nav.autocomplete-suggestions a.button{
					background-color: $color;
				}

				#tie-wrapper #top-nav a:hover,
				#tie-wrapper #top-nav .top-menu .menu a:hover,
				#tie-wrapper #top-nav .top-menu .menu li:hover > a,
				#tie-wrapper #top-nav .top-menu .menu > li.current-menu-item > a,
				#tie-wrapper #top-nav .top-menu .menu > li.current-menu-ancestor > a,
				#tie-wrapper #top-nav .top-menu .menu > li.current_page_parent > a,
				#tie-wrapper #top-nav .top-menu .menu > li.current-page-ancestor > a,
				#tie-wrapper #top-nav .top-menu .menu > li.current-post-ancestor > a,
				#tie-wrapper #top-nav .top-menu .menu > li.current-category-ancestor > a,
				#tie-wrapper #top-nav .breaking .ticker a:hover,
				#tie-wrapper #top-nav ul.components > li > a:hover,
				#tie-wrapper #top-nav ul.components > li:hover > a,
				#tie-wrapper #top-nav ul.components button#search-submit:hover,
				.search-in-top-nav.autocomplete-suggestions a:not(.button):hover{
					color: $color;
				}

				#tie-wrapper #top-nav .breaking-news-nav li:hover,
				#tie-wrapper #top-nav .comp-sub-menu .button:hover,
				#tie-wrapper #top-nav .comp-sub-menu .button.guest-btn:hover{
					border-color: $color;
				}

				#tie-wrapper #top-nav .top-menu .menu li.menu-item-has-children:hover > a:before{
					border-top-color: $color;
				}

				#tie-wrapper #top-nav .top-menu .menu li li.menu-item-has-children:hover > a:before{
					border-top-color: transparent;
					border-left-color: $color;
				}

				.rtl #tie-wrapper #top-nav .top-menu .menu li li.menu-item-has-children:hover > a:before{
					border-left-color: transparent;
					border-right-color: $color;
				}

				#tie-wrapper #top-nav .comp-sub-menu .button:hover,
				#tie-wrapper #top-nav .comp-sub-menu .button.guest-btn:hover,
				#tie-wrapper #top-nav .comp-sub-menu .button.checkout-button:hover,
				#tie-wrapper #top-nav .menu-counter-bubble,
				#theme-header #top-nav .breaking-news-nav li:hover,
				#tie-wrapper #top-nav ul.components a.button:hover,
				#tie-wrapper #top-nav ul.components a.button.guest-btn:hover,
				#tie-wrapper #top-nav .comp-sub-menu a.button.checkout-button,
				.search-in-top-nav.autocomplete-suggestions .widget-post-list a.button{
					color: $bright;
				}

				#tie-wrapper #theme-header #top-nav .comp-sub-menu .button.checkout-button:hover,
				#tie-body .search-in-top-nav.autocomplete-suggestions a.button:hover{
					background-color: $darker;
				}
			";
		}



		# Top-bar text ----------
		if( $color = jannah_get_option( 'topbar_text_color' )){

			$rgb   = jannah_get_rgb_color( $color );

			$out .="
				#tie-wrapper #top-nav,
				#tie-wrapper #top-nav .top-menu ul,
				#tie-wrapper #top-nav .comp-sub-menu,
				.search-in-top-nav.autocomplete-suggestions{
					color: $color;
				}

				.search-in-top-nav.autocomplete-suggestions .post-meta,
				.search-in-top-nav.autocomplete-suggestions .post-meta a:not(:hover){
					color: rgba( $rgb, 0.7);
				}
			";
		}



		# Breaking News label ----------
		if( $color = jannah_get_option( 'breaking_title_bg' )){

			$bright = jannah_light_or_dark( $color );

			$out .="
			.breaking-title{
				color: $bright;
			}

			.breaking .breaking-title:before{
				background-color: $color;
			}

			.breaking .breaking-title:after{
				border-top-color: $color;
			}";
		}


		/* Main nav
			 ===================================================*/

		if( $color = jannah_get_option( 'main_nav_background' )){

			$bright = jannah_light_or_dark( $color, true );
			$darker = jannah_adjust_color_brightness( $color, -30 );
			$rgb    = jannah_get_rgb_color( $color );

			$out .="
				#tie-wrapper #main-nav{
					background-color : $color;
					border-width: 0;
				}

				#tie-wrapper #main-nav.fixed-nav{
					background-color : rgba( $rgb , 0.95);
				}

				#main-nav .main-menu-wrapper,
				#tie-wrapper .main-nav-boxed #main-nav .main-menu-wrapper,
				#tie-wrapper #main-nav .main-menu .menu li > .sub-menu,
				#tie-wrapper #main-nav .main-menu .menu-sub-content,
				#tie-wrapper #main-nav .comp-sub-menu,
				#tie-body .search-in-main-nav.autocomplete-suggestions{
					background-color: $color;
				}

				#tie-wrapper #main-nav ul.components > li,
				#tie-wrapper #main-nav .comp-sub-menu,
				#tie-wrapper #main-nav .comp-sub-menu li,
				#tie-wrapper #main-nav .main-menu .menu li > .sub-menu > li > a,
				#tie-wrapper #main-nav .main-menu .menu-sub-content > li > a,
				#tie-wrapper #main-nav .main-menu li.mega-link-column > ul > li > a,
				#tie-wrapper #main-nav .main-menu .mega-recent-featured-list a,
				#tie-wrapper #main-nav .main-menu .mega-cat .mega-cat-more-links > li a,
				#tie-wrapper #main-nav .main-menu .cats-horizontal li a,
				#tie-wrapper .main-menu .mega-cat.menu-item-has-children .mega-cat-wrapper{
					border-color: rgba($bright, 0.07);
				}

				#tie-wrapper #main-nav .comp-sub-menu .button,
        #tie-wrapper #main-nav .comp-sub-menu .button.guest-btn,
				.search-in-main-nav.autocomplete-suggestions{
            border-color: $darker;
        }

				#tie-wrapper #main-nav .comp-sub-menu .button,
				#tie-wrapper #main-nav .comp-sub-menu .button.guest-btn{
					background-color: $darker;
				}

				#tie-wrapper #theme-header.main-nav-boxed #main-nav:not(.fixed-nav){
					background-color: transparent;
				}

				.main-nav-boxed.main-nav-light #main-nav .main-menu-wrapper{
			    border-width: 0;
				}

				.main-nav-boxed.main-nav-below.top-nav-below #main-nav .main-menu-wrapper{
			    border-bottom-width: 1px;
				}
			";
		}


		# Main nav links ----------
		if( $color = jannah_get_option( 'main_nav_links_color' )){

			$out .= "
				#tie-wrapper #main-nav .menu li.menu-item-has-children > a:before,
				#tie-wrapper #main-nav .main-menu .mega-menu > a:before{
					border-top-color: $color;
				}

				#tie-wrapper #main-nav .menu li.menu-item-has-children .menu-item-has-children > a:before,
				#tie-wrapper #main-nav .main-menu .mega-menu .menu-item-has-children > a:before{
					border-top-color: transparent;
					border-left-color: $color;
				}

				.rtl #tie-wrapper #main-nav .menu li.menu-item-has-children .menu-item-has-children > a:before,
				.rtl #tie-wrapper #main-nav .main-menu .mega-menu .menu-item-has-children > a:before{
					border-left-color: transparent;
					border-right-color: $color;
				}

				#tie-wrapper #main-nav .menu > li > a,
				#tie-wrapper #main-nav .menu-sub-content a,
				#tie-wrapper #main-nav .comp-sub-menu a:not(:hover),
				#tie-wrapper #main-nav .dropdown-social-icons li a span,
				#tie-wrapper #main-nav ul.components a.button:hover,
				#tie-wrapper #main-nav ul.components > li > a,
				#tie-wrapper #main-nav .comp-sub-menu .button:hover,
				.search-in-main-nav.autocomplete-suggestions a:not(.button){
					color: $color;
				}
			";
		}


		# Main nav Borders ----------
		if( jannah_get_option( 'main_nav_border_top_color' ) || jannah_get_option( 'main_nav_border_top_width' ) ||
			  jannah_get_option( 'main_nav_border_bottom_color' ) || jannah_get_option( 'main_nav_border_bottom_width' ) ){

			// Top
			$border_top_color = jannah_get_option( 'main_nav_border_top_color' ) ? 'border-top-color:'. jannah_get_option( 'main_nav_border_top_color' ) .' !important;'   : '';
			$border_top_width = jannah_get_option( 'main_nav_border_top_width' ) ? 'border-top-width:'. jannah_get_option( 'main_nav_border_top_width' ) .'px !important;' : '';

			// Bottom
			$border_bottom_color = jannah_get_option( 'main_nav_border_bottom_color' ) ? 'border-bottom-color:'. jannah_get_option( 'main_nav_border_bottom_color' ) .' !important;'   : '';
			$border_bottom_width = jannah_get_option( 'main_nav_border_bottom_width' ) ? 'border-bottom-width:'. jannah_get_option( 'main_nav_border_bottom_width' ) .'px !important;' : '';

			$out .= "
				#tie-wrapper #theme-header:not(.main-nav-boxed) #main-nav,
				#tie-wrapper .main-nav-boxed .main-menu-wrapper{
					$border_top_color
					$border_top_width
					$border_bottom_color
					$border_bottom_width
					border-right: 0 none;
					border-left : 0 none;
				}
			";

			if( jannah_get_option( 'main_nav_border_bottom_color' ) || jannah_get_option( 'main_nav_border_bottom_width' )){
				$out .= "
					#tie-wrapper .main-nav-boxed #main-nav.fixed-nav{
						box-shadow: none;
					}
				";
			}
		}


		# Main nav links on hover ----------
		if( $color = jannah_get_option( 'main_nav_links_color_hover' )){

			$darker = jannah_adjust_color_brightness( $color, -30 );
			$bright = jannah_light_or_dark( $color );

			$out .= "
				#tie-wrapper #main-nav .comp-sub-menu .button:hover,
				#tie-wrapper #main-nav .main-menu .menu > li.current-menu-item,
				#tie-wrapper #main-nav .main-menu .menu > li.current-menu-ancestor,
				#tie-wrapper #main-nav .main-menu .menu > li.current_page_parent,
				#tie-wrapper #main-nav .main-menu .menu > li.current-page-ancestor,
				#tie-wrapper #main-nav .main-menu .menu > li.current-post-ancestor,
				#tie-wrapper #main-nav .main-menu .menu > li.current-category-ancestor,
				#tie-wrapper #main-nav .main-menu .menu > li > .sub-menu,
				#tie-wrapper #main-nav .main-menu .menu > li > .menu-sub-content,
				#theme-header #main-nav .menu .mega-cat-sub-categories.cats-horizontal li a.is-active,
				#theme-header #main-nav .menu .mega-cat-sub-categories.cats-horizontal li a:hover{
					border-color: $color;
				}

				#tie-wrapper #main-nav .main-menu .menu > li.current-menu-item > a,
				#tie-wrapper #main-nav .main-menu .menu > li.current-menu-ancestor > a,
				#tie-wrapper #main-nav .main-menu .menu > li.current_page_parent > a,
				#tie-wrapper #main-nav .main-menu .menu > li.current-page-ancestor > a,
				#tie-wrapper #main-nav .main-menu .menu > li.current-post-ancestor > a,
				#tie-wrapper #main-nav .main-menu .menu > li.current-category-ancestor > a,
				#tie-wrapper #main-nav .main-menu .menu > li:hover > a,
				#tie-wrapper #main-nav .main-menu .menu > li > a:hover,
				#tie-wrapper #main-nav .main-menu ul li .mega-links-head:after,

				#tie-wrapper #main-nav .menu-counter-bubble,
				#tie-wrapper #theme-header #main-nav .comp-sub-menu .button:hover,
				#tie-wrapper #main-nav .comp-sub-menu .button.checkout-button,
				#theme-header #main-nav .menu .mega-cat-sub-categories.cats-horizontal li a.is-active,
				#theme-header #main-nav .menu .mega-cat-sub-categories.cats-horizontal li a:hover,
				.search-in-main-nav.autocomplete-suggestions a.button{
					background-color: $color;
				}

				#tie-wrapper #main-nav ul.components a:hover,
				#tie-wrapper #main-nav ul.components > li > a:hover,
				#tie-wrapper #main-nav ul.components > li:hover > a,
				#tie-wrapper #main-nav ul.components button#search-submit:hover,
				#tie-wrapper #main-nav .mega-cat-sub-categories.cats-vertical,
				#tie-wrapper #main-nav .cats-vertical li:hover a,
				#tie-wrapper #main-nav .cats-vertical li a.is-active,
				#tie-wrapper #main-nav .cats-vertical li a:hover,
				#tie-wrapper #main-nav .main-menu .mega-menu .post-meta a:hover,
				#tie-wrapper #main-nav .main-menu .menu .mega-cat-sub-categories.cats-vertical li a.is-active,
				#tie-wrapper #main-nav .main-menu .mega-menu .post-box-title a:hover,
				.search-in-main-nav.autocomplete-suggestions a:not(.button):hover,
				#main-nav .spinner-circle:after{
					color: $color;
				}

				#tie-wrapper #main-nav .main-menu .menu > li.current-menu-item > a,
				#tie-wrapper #main-nav .main-menu .menu > li.current-menu-ancestor > a,
				#tie-wrapper #main-nav .main-menu .menu > li.current_page_parent > a,
				#tie-wrapper #main-nav .main-menu .menu > li.current-page-ancestor > a,
				#tie-wrapper #main-nav .main-menu .menu > li.current-post-ancestor > a,
				#tie-wrapper #main-nav .main-menu .menu > li.current-category-ancestor > a,
				#tie-wrapper #main-nav .main-menu .menu > li:hover > a,
				#tie-wrapper #main-nav .main-menu .menu > li > a:hover,
				#tie-wrapper #main-nav ul.components a.button:hover,
				#tie-wrapper #main-nav .comp-sub-menu a.button.checkout-button,
				#tie-wrapper #main-nav ul.components a.button.guest-btn:hover,
				#tie-wrapper #main-nav .menu-counter-bubble,
				#theme-header #main-nav .menu .mega-cat-sub-categories.cats-horizontal li a.is-active,
				#theme-header #main-nav .menu .mega-cat-sub-categories.cats-horizontal li a:hover,
				.search-in-main-nav.autocomplete-suggestions .widget-post-list a.button{
					color: $bright;
				}

				#tie-wrapper #main-nav .menu > li.current-menu-item > a:before,
				#tie-wrapper #main-nav .menu > li.current-menu-ancestor > a:before,
				#tie-wrapper #main-nav .menu > li.current_page_parent > a:before,
				#tie-wrapper #main-nav .menu > li.current-page-ancestor > a:before,
				#tie-wrapper #main-nav .menu > li.current-post-ancestor > a:before,
				#tie-wrapper #main-nav .menu > li.current-category-ancestor > a:before,
				#tie-wrapper #theme-header #main-nav .menu > li > a:hover:before,
				#tie-wrapper #theme-header #main-nav .menu > li:hover > a:before{
					border-top-color: $bright;
				}

				.search-in-main-nav.autocomplete-suggestions a.button:hover,
				#tie-wrapper #theme-header #main-nav .comp-sub-menu .button.checkout-button:hover{
					background-color: $darker;
				}
			";
		}

		# Main Nav text ----------
		if( $color = jannah_get_option( 'main_nav_text_color' )){

			$rgb   = jannah_get_rgb_color( $color );

			$out .="
				#tie-wrapper #main-nav,
				#tie-wrapper #main-nav input,
				#tie-wrapper #main-nav ul.components button#search-submit,
				#tie-wrapper #main-nav ul.components button#search-submit .fa-spinner,
				#tie-wrapper #main-nav .comp-sub-menu,
				.search-in-main-nav.autocomplete-suggestions{
					color: $color;
				}

				#tie-wrapper #main-nav input::-moz-placeholder{
					color: $color;
				}

				#tie-wrapper #main-nav input:-moz-placeholder{
					color: $color;
				}

				#tie-wrapper #main-nav input:-ms-input-placeholder{
					color: $color;
				}

				#tie-wrapper #main-nav input::-webkit-input-placeholder{
					color: $color;
				}

				#tie-wrapper #main-nav .main-menu .mega-menu .post-meta,
				#tie-wrapper #main-nav .main-menu .mega-menu .post-meta a:not(:hover){
					color: rgba($rgb, 0.6);
				}

				.search-in-main-nav.autocomplete-suggestions .post-meta,
				.search-in-main-nav.autocomplete-suggestions .post-meta a:not(:hover){
						color: rgba($rgb, 0.7);
				}
			";
		}


	/* In Post links
			 ===================================================*/

		if( jannah_get_option( 'post_links_color' )){
			$out .='
			#the-post a{
				color: '. jannah_get_option( 'post_links_color' ) .' !important;
			}';
		}

		if( jannah_get_option( 'post_links_color_hover' )){
			$out .='
			#the-post a:hover{
				color: '. jannah_get_option( 'post_links_color_hover' ) .' !important;
			}';
		}



	/* Backgrounds
			 ===================================================*/

		$backround_areas = array(
			'header_background'    => '#tie-wrapper #theme-header',
			'main_content_bg'      => '#tie-container #tie-wrapper',
			'footer_background'    => '#footer',
			'copyright_background' => '#site-info',
			'banner_bg'            => '#background-ad-cover',
		);

		foreach ( $backround_areas as $area => $elements ){
			if( jannah_get_option( $area . '_color' ) || jannah_get_option( $area . '_img' )){

				$background_code  = jannah_get_option( $area . '_color' ) ? 'background-color: '. jannah_get_option( $area . '_color' ) .';' : '';
				$background_image = jannah_get_option( $area . '_img' );

				# Background Image ----------
				$background_code .= jannah_get_background_image_css( $background_image );

				if( ! empty( $background_code )){
					$out .=
					$elements .'{
						'. $background_code .'
					}';
				}
			}
		}

		# Text Logo color ----------
		if( jannah_get_option( 'header_background_color' )){
			$out .='
				#logo.text-logo a,
				#logo.text-logo a:hover{
					color: '. jannah_light_or_dark( jannah_get_option( 'header_background_color' ) ) .';
				}
			';
		}




	/* Footer area
			 ===================================================*/

		if( jannah_get_option( 'footer_margin_top' ) || jannah_get_option( 'footer_padding_bottom' ) ){

			$footer_margin_top     = jannah_get_option( 'footer_margin_top' ) ? 'margin-top: '. jannah_get_option( 'footer_margin_top' ) .'px;' : '';
			$footer_padding_bottom = jannah_get_option( 'footer_padding_bottom' ) ? 'padding-bottom: '. jannah_get_option( 'footer_padding_bottom' ) .'px;' : '';

			$out .="
				#footer{
					$footer_margin_top
					$footer_padding_bottom
				}
			";
		}

		if( jannah_get_option( 'footer_padding_top' )){
			$out .='
				#footer .footer-widget-area:first-child{
					padding-top: '. jannah_get_option( 'footer_padding_top' ) .'px !important;
				}
			';
		}


		if( jannah_get_option( 'footer_title_color' )){
			$out .='
				#footer-widgets-container .widget-title,
				#footer-widgets-container .widget-title a:not(:hover){
					color: '. jannah_get_option( 'footer_title_color' ) .';
				}
			';
		}

		if( $color = jannah_get_option( 'footer_background_color' )){

			$rgb    = jannah_get_rgb_color( $color );
			$darker = jannah_adjust_color_brightness( $color, -30 );
			$bright = jannah_light_or_dark( $color, true );

			$out .="
				#footer .posts-list-counter .posts-list-items li:before{
				  border-color: $color;
				}

				#footer .timeline-widget .date:before{
				  border-color: rgba($rgb, 0.8);
				}

				#footer-widgets-container .footer-boxed-widget-area,
				#footer-widgets-container textarea,
				#footer-widgets-container input:not([type=submit]),
				#footer-widgets-container select,
				#footer-widgets-container code,
				#footer-widgets-container kbd,
				#footer-widgets-container pre,
				#footer-widgets-container samp,
				#footer-widgets-container .latest-tweets-slider-widget .latest-tweets-slider .slider-nav li a:not(:hover),
				#footer-widgets-container .show-more-button,
				#footer-widgets-container .latest-tweets-widget .slider-links .slider-nav span,
				#footer .footer-boxed-widget-area{
				  border-color: rgba($bright, 0.1);
				}

				#footer.dark-skin .social-statistics-widget ul.white-bg li.social-icons-item a,
				#footer.dark-skin ul:not(.solid-social-icons) .social-icons-item a:not(:hover),
				#footer.dark-skin .widget_product_tag_cloud a,
				#footer.dark-skin .widget_tag_cloud .tagcloud a,
				#footer.dark-skin .post-tags a,
				#footer.dark-skin .widget_layered_nav_filters a{
					border-color: rgba($bright, 0.1) !important;
				}

				.dark-skin .social-statistics-widget ul.white-bg li.social-icons-item:before{
				  background: rgba($bright, 0.1);
				}

				#footer-widgets-container .widget-title,
				#footer.dark-skin .social-statistics-widget .white-bg .social-icons-item a span.followers span,
				.dark-skin .social-statistics-widget .circle-three-cols .social-icons-item a span{
				  color: rgba($bright, 0.8);
				}

				#footer-widgets-container .timeline-widget ul:before,
				#footer-widgets-container .timeline-widget .date:before,
				#footer.dark-skin .tabs-widget .tabs-wrapper .tabs-menu li a{
				  background-color: $darker;
				}
			";
		}


		if( $color = jannah_get_option( 'footer_text_color' )){

			$out .="
				#footer-widgets-container,
				#footer-widgets-container textarea,
				#footer-widgets-container input,
				#footer-widgets-container select,
				#footer-widgets-container .widget_categories li a:before,
				#footer-widgets-container .widget_product_categories li a:before,
				#footer-widgets-container .widget_archive li a:before,
				#footer-widgets-container .wp-caption .wp-caption-text,
				#footer-widgets-container .post-meta,
				#footer-widgets-container .timeline-widget ul li .date,
				#footer-widgets-container .subscribe-widget .subscribe-widget-content h3{
					color: $color;
				}

				#footer-widgets-container .meta-item,
				#footer-widgets-container .timeline-widget ul li .date{
					opacity: 0.8;
				}
			";
		}

		if( jannah_get_option( 'footer_links_color' )){
			$out .='
				#footer-widgets-container a:not(:hover){
					color: '. jannah_get_option( 'footer_links_color' ) .';
				}
			';
		}

		if( $color = jannah_get_option( 'footer_links_color_hover' )){

			$darker = jannah_adjust_color_brightness( $color, -30 );
			$bright = jannah_light_or_dark( $color );

			$out .="
				#footer-widgets-container a:hover,
				#footer-widgets-container .post-rating .stars-rating-active,
				#footer-widgets-container .latest-tweets-widget .twitter-icon-wrap span{
					color: $color;
				}

				#footer-widgets-container .digital-rating .pie-svg .circle_bar{
					stroke: $color;
				}

				#footer.dark-skin #instagram-link:before,
				#footer.dark-skin #instagram-link:after,
				#footer-widgets-container .widget.buddypress .item-options a.selected,
				#footer-widgets-container .widget.buddypress .item-options a.loading,
				#footer-widgets-container .slider-nav li > span:hover{
					border-color: $color;
				}

				#footer.dark-skin .tabs-widget .tabs-wrapper .tabs-menu li.is-active a,
				#footer.dark-skin .tabs-widget .tabs-wrapper .tabs-menu li a:hover,
				#footer-widgets-container .digital-rating-static strong,
				#footer-widgets-container .timeline-widget li:hover .date:before,
				#footer-widgets-container #wp-calendar #today,
				#footer-widgets-container .basecloud-bg::before,
				#footer-widgets-container .posts-list-counter .posts-list-items li:before,
				#footer-widgets-container .cat-counter span,
				#footer-widgets-container .widget-title:after,
				#footer-widgets-container .button,
				#footer-widgets-container a.button,
				#footer-widgets-container a.more-link,
				#footer-widgets-container .slider-links a.button,
				#footer-widgets-container input[type='submit'],
				#footer-widgets-container .widget.buddypress .item-options a.selected,
				#footer-widgets-container .widget.buddypress .item-options a.loading,
				#footer-widgets-container .slider-nav li > span:hover,
				#footer-widgets-container .fullwidth-area .widget_tag_cloud .tagcloud a:hover{
					background-color: $color;
					color: $bright;
				}

				#footer-widgets-container .widget.buddypress .item-options a.selected,
				#footer-widgets-container .widget.buddypress .item-options a.loading,
				#footer-widgets-container .slider-nav li > span:hover{
					color: $bright !important;
				}

				#footer-widgets-container .button:hover,
				#footer-widgets-container a.button:hover,
				#footer-widgets-container a.more-link:hover,
				#footer-widgets-container input[type='submit']:hover{
					background-color: $darker;
				}
			";
		}


	/* Copyright area
			 ===================================================*/

		if( jannah_get_option( 'copyright_background_color' )){
			$out .='
			#go-to-top{
				background: '. jannah_get_option( 'copyright_background_color' ) .';
			}';
		}

		if( jannah_get_option( 'copyright_text_color' )){
			$out .='
			#site-info,
			#site-info ul.social-icons li a span,
			#go-to-top{
				color: '. jannah_get_option( 'copyright_text_color' ) .';
			}';
		}

		if( jannah_get_option( 'copyright_links_color' )){
			$out .='
			#site-info a{
				color: '. jannah_get_option( 'copyright_links_color' ) .';
			}';
		}

		if( jannah_get_option( 'copyright_links_color_hover' )){
			$out .='
			#site-info a:hover{
				color: '. jannah_get_option( 'copyright_links_color_hover' ) .';
			}';
		}


		# Custom Social Networks colors ----------
		for( $i=1 ; $i<=5 ; $i++ ){
			if ( jannah_get_option( "custom_social_title_$i" ) && jannah_get_option( "custom_social_icon_$i" ) && jannah_get_option( "custom_social_url_$i" ) && jannah_get_option( "custom_social_color_$i" )){

				$color = jannah_get_option( "custom_social_color_$i" );
				$title = jannah_get_option( "custom_social_title_$i" );
				$title = sanitize_title( $title );

				$out .="
					.social-icons-item .$title-social-icon{
						background: $color !important;
					}

					.social-icons-item .$title-social-icon span{
						color: $color;
					}
				";
			}
		}


		# Colored Categories labels ----------
		$cats_options = get_option( 'tie_cats_options' );
		if( ! empty( $cats_options ) && is_array( $cats_options )){
			foreach ( $cats_options as $cat => $options){
				if( ! empty( $options['cat_color'] )){

					$cat_custom_color = $options['cat_color'];
					$bright_color = jannah_light_or_dark( $cat_custom_color);

					$out .='
						.tie-cat-'.$cat.', .tie-cat-item-'.$cat.' > span{
							background-color:'. $cat_custom_color .' !important;
							color:'. $bright_color .' !important;
						}

						.tie-cat-'.$cat.':after{
							border-top-color:'. $cat_custom_color .' !important;
						}
						.tie-cat-'.$cat.':hover{
							background-color:'. jannah_adjust_color_brightness( $cat_custom_color ) .' !important;
						}

						.tie-cat-'.$cat.':hover:after{
							border-top-color:'. jannah_adjust_color_brightness( $cat_custom_color ) .' !important;
						}
					';
				}
			}
		}


		# Arqam Plugin Custom colors ----------
		if( JANNAH_ARQAM_IS_ACTIVE ){
			$arqam_options = get_option( 'arq_options' );
			if( ! empty( $arqam_options['color'] ) && is_array( $arqam_options['color'] )){
				foreach ( $arqam_options['color'] as $social => $color ){
					if( ! empty( $color )){
						if( $social == '500px' ){
							$social = 'px500';
						}
						$out .= "
							.social-statistics-widget .solid-social-icons .social-icons-item .$social-social-icon{
								background-color: $color !important;
								border-color: $color !important;
							}
							.social-statistics-widget .$social-social-icon span.counter-icon{
								background-color: $color !important;
							}
						";
					}
				}
			}
		}

		# Take Over Ad top margin ----------
		if( jannah_get_option( 'banner_bg' ) && jannah_get_option( 'banner_bg_url' ) && jannah_get_option( 'banner_bg_site_margin' ) ){
			$out .= '
				@media (min-width: 992px){
					#tie-wrapper{
						margin-top: '. jannah_get_option( 'banner_bg_site_margin' ) .'px !important;
					}
				}
			';
		}

		# Site Width ----------
		if( jannah_get_option( 'site_width' ) && jannah_get_option( 'site_width' ) != '1200px' ){
			$out .= '
				@media (min-width: 1200px){
				.container{
						width: auto;
					}
				}
			';

			if( strpos( jannah_get_option( 'site_width' ), '%' ) !== false ){
				$out .= '
					@media (min-width: 992px){
						.container{
							max-width: '.jannah_get_option( 'site_width' ).';
						}
						body.boxed-layout #tie-wrapper,
						body.boxed-layout .fixed-nav{
							max-width: '.jannah_get_option( 'site_width' ).';
						}
						body.boxed-layout .container{
							width: 100%;
						}
					}
				 ';
			}
			else{
				$outer_width = str_replace( 'px', '', jannah_get_option( 'site_width' ) ) + 30;
				$out .= '
					body.boxed-layout #tie-wrapper,
					body.boxed-layout .fixed-nav{
						max-width: '.  $outer_width .'px;
					}
					@media (min-width: '.jannah_get_option( 'site_width' ).'){
						.container{
							max-width: '.jannah_get_option( 'site_width' ).';
						}
					}
				';
			}
		}


		# Mobile Menu Background ----------
		if( jannah_get_option( 'mobile_menu_active' ) ){

			if( jannah_get_option( 'mobile_menu_background_type' ) == 'color' ){
				if( jannah_get_option( 'mobile_menu_background_color' ) ){
					$mobile_bg = 'background-color: '. jannah_get_option( 'mobile_menu_background_color' ) .';';
					$out .='
						@media (max-width: 991px){
							.side-aside #mobile-menu .menu > li{
								border-color: rgba('.jannah_light_or_dark( jannah_get_option( 'mobile_menu_background_color' ), true ).',0.05);
							}
							.side-aside #mobile-search .search-field{
								background-color: rgba('. jannah_light_or_dark( jannah_get_option( 'mobile_menu_background_color' ), true).',0.05);
							}
						}
					';
				}
			}

			elseif( jannah_get_option( 'mobile_menu_background_type' ) == 'gradient' ){
				if( jannah_get_option( 'mobile_menu_background_gradient_color_1' ) &&  jannah_get_option( 'mobile_menu_background_gradient_color_2' ) ){
					$color1 = jannah_get_option( 'mobile_menu_background_gradient_color_1' );
					$color2 = jannah_get_option( 'mobile_menu_background_gradient_color_2' );

					$mobile_bg = '
						background: '. $color1 .';
						background: -webkit-linear-gradient(135deg, '. $color1 .', '. $color2 .' );
						background:    -moz-linear-gradient(135deg, '. $color1 .', '. $color2 .' );
						background:      -o-linear-gradient(135deg, '. $color1 .', '. $color2 .' );
						background:         linear-gradient(135deg, '. $color1 .', '. $color2 .' );
					';
				}
			}

			elseif ( jannah_get_option( 'mobile_menu_background_type' ) == 'image' ){
				if( jannah_get_option( 'mobile_menu_background_image' ) ){
					$background_image = jannah_get_option( 'mobile_menu_background_image' );
					$mobile_bg = jannah_get_background_image_css( $background_image );
				}
			}


			if( ! empty( $mobile_bg ) ){
				$out .='
					@media (max-width: 991px){
						.side-aside.dark-skin{
							'.$mobile_bg.'
						}
					}
				';
			}

			if( jannah_get_option( 'mobile_menu_icon_color' ) ){
				$out .='
					#mobile-menu-icon .menu-text{
						color: '. jannah_get_option( 'mobile_menu_icon_color' ) .'!important;
					}
					#mobile-menu-icon .nav-icon,
					#mobile-menu-icon .nav-icon:before,
					#mobile-menu-icon .nav-icon:after{
						background-color: '. jannah_get_option( 'mobile_menu_icon_color' ) .'!important;
					}
				';
			}

			if( jannah_get_option( 'mobile_menu_text_color' ) ){
				$out .='
					.side-aside #mobile-menu li a,
					.side-aside #mobile-menu .mobile-arrows,
					.side-aside #mobile-search .search-field{
						color: '. jannah_get_option( 'mobile_menu_text_color' ) .';
					}

					#mobile-search .search-field::-moz-placeholder {
						color: '. jannah_get_option( 'mobile_menu_text_color' ) .';
					}

					#mobile-search .search-field:-moz-placeholder {
						color: '. jannah_get_option( 'mobile_menu_text_color' ) .';
					}

					#mobile-search .search-field:-ms-input-placeholder {
						color: '. jannah_get_option( 'mobile_menu_text_color' ) .';
					}

					#mobile-search .search-field::-webkit-input-placeholder {
						color: '. jannah_get_option( 'mobile_menu_text_color' ) .';
					}

					@media (max-width: 991px){
						.tie-btn-close span{
							color: '. jannah_get_option( 'mobile_menu_text_color' ) .';
						}
					}
				';
			}

			if( jannah_get_option( 'mobile_menu_social_color' ) ){
				$out .='
					#mobile-social-icons .social-icons-item a:not(:hover) span{
						color: '. jannah_get_option( 'mobile_menu_social_color' ) .'!important;
					}
				';
			}

			if( jannah_get_option( 'mobile_menu_search_color' ) ){
				$search_color = jannah_get_option( 'mobile_menu_search_color' );
				$out .='
					#mobile-search .search-submit{
						background-color: '. $search_color .';
						color: '.jannah_light_or_dark( $search_color ).';
					}

					#mobile-search .search-submit:hover{
						background-color: '. jannah_adjust_color_brightness( $search_color ) .';
					}
				';
			}

		}


		# Post Title Poppins ----------
		$title_poppins = jannah_get_option( 'typography_headings_google_font' );
		if( ! empty( $title_poppins ) && $title_poppins == 'Poppins' && ! is_rtl() ){
			$out .='
				.wf-active .logo-text, .wf-active h1{
	    		letter-spacing: -0.06em;
	    		word-spacing: -0.04em;
				}
				.wf-active h2, .wf-active h3, .wf-active h4, .wf-active h5, .wf-active h6{
	    		letter-spacing: -.04em;
				}
			';
		}


		# Custom CSS codes ----------
		$out .= jannah_get_option( 'css' );
		$out .= jannah_custom_css_media_query( 'css_tablets', 1024, 768 );
		$out .= jannah_custom_css_media_query( 'css_phones', 768, 0 );


		# Prepare the CSS codes ----------
		$out = apply_filters( 'jannah_custom_css', $out );
		$out = jannah_minify_css( $out );

		return $out;
	}

}





/*-----------------------------------------------------------------------------------*/
# Custom Theme Color
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_theme_color' )){

	function jannah_theme_color( $color ){
		$dark_color = jannah_adjust_color_brightness( $color, -50 );
		$rgb_color  = jannah_get_rgb_color( $color );
		$bright     = jannah_light_or_dark( $color );


		/* Color ----------------------------------------*/
			// .brand-title is an extra class used to set the band color for special texts
		$skin = "
			.brand-title,
			a:hover,
			#tie-popup-search-submit,
			.post-rating .stars-rating-active,
			ul.components button#search-submit:hover,
			#logo.text-logo a,
			#tie-wrapper #top-nav a:hover,
			#tie-wrapper #top-nav .breaking a:hover,
			#tie-wrapper #main-nav ul.components a:hover,
			#theme-header #top-nav ul.components > li > a:hover,
			#theme-header #top-nav ul.components > li:hover > a,
			#theme-header #main-nav ul.components > li > a:hover,
			#theme-header #main-nav ul.components > li:hover > a,
			#top-nav .top-menu .menu > li.current-menu-item > a,
			#top-nav .top-menu .menu > li.current-menu-ancestor > a,
			#top-nav .top-menu .menu > li.current_page_parent > a,
			#top-nav .top-menu .menu > li.current-page-ancestor > a,
			#top-nav .top-menu .menu > li.current-post-ancestor > a,
			#top-nav .top-menu .menu > li.current-category-ancestor > a,
			#tie-wrapper #top-nav .top-menu .menu li:hover > a,
			#tie-wrapper #top-nav .top-menu .menu a:hover,
			#tie-wrapper #main-nav .main-menu .mega-menu .post-box-title a:hover,
			#tie-wrapper #main-nav .main-menu .menu .mega-cat-sub-categories.cats-vertical li:hover a,
			#tie-wrapper #main-nav .main-menu .menu .mega-cat-sub-categories.cats-vertical li a.is-active,
			.mag-box-title a,
			.mag-box .mag-box-options .mag-box-filter-links li > a.active,
			.mag-box .mag-box-options .mag-box-filter-links li:hover > a.active,
			.mag-box .mag-box-options .mag-box-filter-links .flexMenu-viewMore > a:hover,
			.mag-box .mag-box-options .mag-box-filter-links .flexMenu-viewMore:hover > a,
			.box-dark-skin.mag-box .posts-items > li .post-title a:hover,
			.dark-skin .mag-box .post-meta .post-rating .stars-rating-active span.fa,
			.box-dark-skin .post-meta .post-rating .stars-rating-active span.fa,
			#go-to-content:hover,
			.comment-list .comment-author .fn,
			.commentlist .comment-author .fn,
			blockquote::before,
			blockquote cite,
			blockquote.quote-simple p,
			.multiple-post-pages a:hover,
			#story-index li .is-current,
			.mag-box .mag-box-title,
			.dark-skin .mag-box.mag-box .mag-box-title,
			.box-dark-skin.mag-box .mag-box-title,
			.tabs-menu li.active > a,
			.tabs-menu li.is-active a,
			.latest-tweets-widget .twitter-icon-wrap span,
			.wide-next-prev-slider-wrapper .slider-nav li:hover span,
			.video-playlist-nav-wrapper .video-playlist-item .video-play-icon,
			#instagram-link:hover,
			.review-final-score h3,
			#mobile-menu-icon:hover .menu-text,
			.tabs-wrapper .tabs-menu li.active > a,
			.tabs-wrapper .tabs-menu li.is-active a,
			.entry a:not(:hover),
			#footer-widgets-container a:hover,
			#footer-widgets-container .post-rating .stars-rating-active,
			#footer-widgets-container .latest-tweets-widget .twitter-icon-wrap span,
			#site-info a:hover,
			.spinner-circle:after{
				color: $color;
			}
		";


		// To fix an overwrite issue ----------
		if( $main_nav_color = jannah_get_option( 'main_nav_links_color_hover' )){
			$skin .="
				#theme-header #main-nav .spinner-circle:after{
					color: $color;
				}
			";
		}


		/* Background-color -----------------------------*/
			//.magazine2 .container-wrapper.tie-weather-widget,
		$skin .="
			.button,
			a.button,
			a.more-link,
			.entry a.more-link,
			#tie-wrapper #theme-header .comp-sub-menu .button:hover,
			#tie-wrapper #theme-header .comp-sub-menu .button.guest-btn:hover,
			#tie-wrapper #theme-header .comp-sub-menu .button.checkout-button,
			#tie-wrapper #theme-header #main-nav .comp-sub-menu .button:hover,
			#tie-wrapper .breaking-news-nav li:hover,
			.dark-skin a.more-link:not(:hover),
			input[type='submit'],
			.post-cat,
			.digital-rating-static,
			.slider-nav li > span:hover,
			.pages-nav .next-prev li.current span,
			.pages-nav .pages-numbers li.current span,
			#tie-wrapper .mejs-container .mejs-controls,
			.spinner > div,
			#tie-wrapper #theme-header .menu-counter-bubble,
			#mobile-menu-icon:hover .nav-icon,
			#mobile-menu-icon:hover .nav-icon:before,
			#mobile-menu-icon:hover .nav-icon:after,
			#theme-header #main-nav .main-menu .menu > li.current-menu-item > a,
			#theme-header #main-nav .main-menu .menu > li.current-menu-ancestor > a,
			#theme-header #main-nav .main-menu .menu > li.current_page_parent > a,
			#theme-header #main-nav .main-menu .menu > li.current-page-ancestor > a,
			#theme-header #main-nav .main-menu .menu > li.current-post-ancestor > a,
			#theme-header #main-nav .main-menu .menu > li.current-category-ancestor > a,
			#theme-header #main-nav .main-menu .menu > li:hover > a,
			#theme-header #main-nav .main-menu .menu > li > a:hover,
			#tie-wrapper #main-nav .main-menu ul li .mega-links-head:after,
			#theme-header #main-nav .menu .mega-cat-sub-categories.cats-horizontal li a.is-active,
			#theme-header #main-nav .menu .mega-cat-sub-categories.cats-horizontal li a:hover,
			.main-nav-dark .main-menu .menu > li > a:hover,
			#mobile-menu-icon:hover .nav-icon,
			#mobile-menu-icon:hover .nav-icon:before,
			#mobile-menu-icon:hover .nav-icon:after,
			.mag-box .mag-box-options .mag-box-filter-links li a:hover,
			.slider-arrow-nav a:not(.pagination-disabled):hover,
			.comment-list .reply a:hover,
			.commentlist .reply a:hover,
			#reading-position-indicator,
			.multiple-post-pages > span,
			#story-index-icon,
			.posts-list-counter .posts-list-items li:before,
			.cat-counter span,
			.digital-rating-static strong,
			#wp-calendar #today,
			.basecloud-bg,
			.basecloud-bg::before,
			.basecloud-bg::after,
			.timeline-widget ul li a:hover .date:before,
			.cat-counter a + span,
			.video-playlist-nav-wrapper .playlist-title,
			.review-percentage .review-item span span,
			.slick-dots li.slick-active button,
			.slick-dots li button:hover,
			#footer.dark-skin .tabs-widget .tabs-wrapper .tabs-menu li.is-active a,
			#footer.dark-skin .tabs-widget .tabs-wrapper .tabs-menu li a:hover,
			#footer-widgets-container .digital-rating-static strong,
			#footer-widgets-container .timeline-widget li:hover .date:before,
			#footer-widgets-container #wp-calendar #today,
			#footer-widgets-container .basecloud-bg::before,
			#footer-widgets-container .posts-list-counter .posts-list-items li:before,
			#footer-widgets-container .cat-counter span,
			#footer-widgets-container .widget-title:after,
			#footer-widgets-container .button,
			#footer-widgets-container a.button,
			#footer-widgets-container a.more-link,
			#footer-widgets-container .slider-links a.button,
			#footer-widgets-container input[type='submit'],
			#footer-widgets-container .slider-nav li > span:hover,
			#footer-widgets-container .fullwidth-area .widget_tag_cloud .tagcloud a:hover,
			.mag-box .mag-box-title:after,
			.dark-skin .mag-box.mag-box .mag-box-title:after,
			.box-dark-skin.mag-box .mag-box-title:after,
			.wide-slider-nav-wrapper .slide:after,
			.demo_store,
			.demo #logo:after{
				background-color: $color;
				color: $bright;
			}
		";


		//.magazine3 .tabs-widget .tabs-wrapper .tabs-menu li a:hover,
		//.magazine3 .tabs-widget .tabs-wrapper .tabs-menu li.is-active a,
		$skin .="
			.tie-weather-widget,
			.side-aside.dark-skin .tabs-widget .tabs-wrapper .tabs-menu li a:hover,
			.side-aside.dark-skin .tabs-widget .tabs-wrapper .tabs-menu li.is-active a,
			#footer.dark-skin .tabs-widget .tabs-wrapper .tabs-menu li a:hover,
			#footer.dark-skin .tabs-widget .tabs-wrapper .tabs-menu li.is-active a{
				background-color: $color !important;
				color: $bright;
			}
		";


		/* border-color ---------------------------------*/
		$skin .="
			pre,
			code,
			.pages-nav .next-prev li.current span,
			.pages-nav .pages-numbers li.current span,
			#tie-wrapper .breaking-news-nav li:hover,
			#tie-wrapper #theme-header .comp-sub-menu .button:hover,
			#tie-wrapper #theme-header .comp-sub-menu .button.guest-btn:hover,
			.multiple-post-pages > span,
			.post-content-slideshow .slider-nav li span:hover,
			.latest-tweets-widget .slider-links .slider-nav li span:hover,
			.dark-skin .latest-tweets-widget .slider-links .slider-nav span:hover,
			#instagram-link:before,
			#instagram-link:after,
			.mag-box .mag-box-options .mag-box-filter-links li a:hover,
			.mag-box .mag-box-options .slider-arrow-nav a:not(.pagination-disabled):hover,
			#theme-header #main-nav .menu .mega-cat-sub-categories.cats-horizontal li a.is-active,
			#theme-header #main-nav .menu .mega-cat-sub-categories.cats-horizontal li a:hover,
			#footer.dark-skin #instagram-link:before,
			#footer.dark-skin #instagram-link:after,
			#footer-widgets-container .slider-nav li > span:hover,
			#theme-header #main-nav .main-menu .menu > li > .sub-menu,
			#theme-header #main-nav .main-menu .menu > li > .menu-sub-content{
				border-color: $color;
			}

			.post-cat:after,
			#tie-wrapper #top-nav .top-menu .menu li.menu-item-has-children:hover > a:before,
			.mag-box .mag-box-title:before,
			.dark-skin .mag-box.mag-box .mag-box-title:before,
			.box-dark-skin.mag-box .mag-box-title:before{
				border-top-color: $color;
			}

			#theme-header .main-menu .menu > li.current-menu-item > a:before,
			#theme-header .main-menu .menu > li.current-menu-ancestor > a:before,
			#theme-header .main-menu .menu > li.current_page_parent > a:before,
			#theme-header .main-menu .menu > li.current-page-ancestor > a:before,
			#theme-header .main-menu .menu > li.current-post-ancestor > a:before,
			#theme-header .main-menu .menu > li.current-category-ancestor > a:before,
			#theme-header #main-nav .main-menu .menu > li > a:hover:before,
			#theme-header #main-nav .main-menu .menu > li:hover > a:before{
				border-top-color: $bright;
			}

			#tie-wrapper #top-nav .top-menu .menu li li.menu-item-has-children:hover > a:before{
				border-left-color: $color;
				border-top-color: transparent;
			}

			.rtl #tie-wrapper #top-nav .top-menu .menu li li.menu-item-has-children:hover > a:before{
				border-right-color: $color;
				border-top-color: transparent;
			}

			#tie-wrapper #main-nav .main-menu .menu > li.current-menu-item,
			#tie-wrapper #main-nav .main-menu .menu > li.current-menu-ancestor,
			#tie-wrapper #main-nav .main-menu .menu > li.current_page_parent,
			#tie-wrapper #main-nav .main-menu .menu > li.current-page-ancestor,
			#tie-wrapper #main-nav .main-menu .menu > li.current-post-ancestor,
			#tie-wrapper #main-nav .main-menu .menu > li.current-category-ancestor{
				border-bottom-color: $color;
			}
		";

		/* Footer Border Top ---------------------------------*/
		if( jannah_get_option( 'footer_border_top' )){
			$skin .="
				#footer-widgets-container{
					border-top: 8px solid $color;
					-webkit-box-shadow: 0 -5px 0 rgba(0,0,0,0.07);
					   -moz-box-shadow: 0 -8px 0 rgba(0,0,0,0.07);
					        box-shadow: 0 -8px 0 rgba(0,0,0,0.07);
				}
			";
		}


		/* Misc ----------------------------------------------*/
		$skin .="
			::-moz-selection{
				background-color: $color;
				color: $bright;
			}

			::selection{
				background-color: $color;
				color: $bright;
			}

			.digital-rating .pie-svg .circle_bar,
			#footer-widgets-container .digital-rating .pie-svg .circle_bar{
				stroke: $color;
			}

			#reading-position-indicator{
				box-shadow: 0 0 10px rgba( $rgb_color, 0.7);
			}
		";


		/* Dark Color ----------------------------------------*/
		$skin .="
			#tie-popup-search-submit:hover,
			#logo.text-logo a:hover,
			.entry a:hover{
				color: $dark_color;
			}
		";


		/* Dark Background-color -----------------------------*/
		$skin .="
			.button:hover,
			a.button:hover,
			a.more-link:hover,
			.entry a.more-link:hover,
			input[type='submit']:hover,
			.post-cat:hover,
			#footer-widgets-container .button:hover,
			#footer-widgets-container a.button:hover,
			#footer-widgets-container a.more-link:hover,
			#footer-widgets-container input[type='submit']:hover{
				background-color: $dark_color;
			}

			.search-in-main-nav.autocomplete-suggestions a.button:hover,
			#tie-wrapper #theme-header #top-nav .comp-sub-menu .button.checkout-button:hover,
			#tie-wrapper #theme-header #main-nav .comp-sub-menu .button.checkout-button:hover{
				background-color: $dark_color;
				color: $bright;
			}

			#theme-header #main-nav .comp-sub-menu a.checkout-button:not(:hover),
			#theme-header #top-nav .comp-sub-menu a.checkout-button:not(:hover),
			.entry a.button{
				color: $bright;
			}

			#footer-widgets-container .slider-nav li > span:hover{
				color: $bright !important;
			}

			/* border-top-color -----------------------------*/
			.post-cat:hover:after{
				border-top-color: $dark_color;
			}

			@media (max-width: 1600px){
				#story-index ul{ background-color: $color; }
				#story-index ul li a, #story-index ul li .is-current{ color: $bright; }
			}
		";


		/* BuddyPress ----------------------------------------*/
		if ( JANNAH_BUDDYPRESS_IS_ACTIVE ){
			$skin .="
				#buddypress .activity-list li.load-more a:hover,
				#buddypress .activity-list li.load-newest a:hover,
				#buddypress #item-header #item-meta #latest-update a,
				#buddypress .item-list-tabs ul li a:hover,
				#buddypress .item-list-tabs ul li.selected a,
				#buddypress .item-list-tabs ul li.current a,
				#buddypress .item-list-tabs#subnav ul li a:hover,
				#buddypress .item-list-tabs#subnav ul li.selected a,
				#buddypress a.unfav:after,
				#buddypress a.message-action-unstar:after,
				#buddypress .profile .profile-fields .label{
					color: $color;
				}

				#buddypress .activity-meta a.button:hover,
				#buddypress table.sitewide-notices tr td:last-child a:hover,
				#buddypress table.sitewide-notices tr.alt td:last-child a:hover
				#profile-edit-form ul.button-nav li a:hover,
				#profile-edit-form ul.button-nav li.current a{
					color: $color !important;
				}

				#buddypress input[type=submit],
				#buddypress input[type=button],
				#buddypress button[type=submit],
				#buddypress a.button,
				#buddypress a#bp-delete-cover-image,
				#buddypress input[type=submit]:focus,
				#buddypress input[type=button]:focus,
				#buddypress button[type=submit]:focus,
				#buddypress .item-list-tabs ul li a span,
				#buddypress .profile .profile-fields .label:before,
				.widget.buddypress .item-options a.selected,
				.widget.buddypress .item-options a.loading,
				#footer-widgets-container .widget.buddypress .item-options a.selected,
				#footer-widgets-container .widget.buddypress .item-options a.loading{
					background-color: $color;
					color: $bright;
				}

				#buddypress .activity-meta a.button:hover,
				#buddypress .item-list-tabs#subnav ul li.selected a,
				.widget.buddypress .item-options a.selected,
				.widget.buddypress .item-options a.loading,
				#footer-widgets-container .widget.buddypress .item-options a.selected,
				#footer-widgets-container .widget.buddypress .item-options a.loading{
					border-color: $color;
				}

				#buddypress #whats-new:focus{
					border-color: $color !important;
				}

				#buddypress input[type=submit]:hover,
				#buddypress input[type=button]:hover,
				#buddypress button[type=submit]:hover,
				#buddypress a.button:hover,
				#buddypress a#bp-delete-cover-image:hover{
					background-color: $dark_color;
				}

				#footer-widgets-container .widget.buddypress .item-options a.selected,
				#footer-widgets-container .widget.buddypress .item-options a.loading{
					color: $bright !important;
				}
			";
		}


		/* WooCommerce ----------------------------------------*/
		if ( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
			$skin .="
				.woocommerce-tabs ul.tabs li.active a,
				.woocommerce-tabs ul.tabs li.is-active a,
				.woocommerce div.product span.price,
				.woocommerce div.product p.price,
				.woocommerce div.product div.summary .product_meta > span,
				.woocommerce div.product div.summary .product_meta > span a:hover,
				.woocommerce ul.products li.product .price ins,
				.woocommerce .woocommerce-pagination .page-numbers li a.current,
				.woocommerce .woocommerce-pagination .page-numbers li a:hover,
				.woocommerce .woocommerce-pagination .page-numbers li span.current,
				.woocommerce .woocommerce-pagination .page-numbers li span:hover,
				.woocommerce .widget_rating_filter ul li.chosen a,
				.woocommerce-MyAccount-navigation ul li.is-active a{
					color: $color;
				}

				.woocommerce span.new,
				.woocommerce a.button.alt,
				.woocommerce button.button.alt,
				.woocommerce input.button.alt,
				.woocommerce a.button.alt.disabled,
				.woocommerce a.button.alt:disabled,
				.woocommerce a.button.alt:disabled[disabled],
				.woocommerce a.button.alt.disabled:hover,
				.woocommerce a.button.alt:disabled:hover,
				.woocommerce a.button.alt:disabled[disabled]:hover,
				.woocommerce button.button.alt.disabled,
				.woocommerce button.button.alt:disabled,
				.woocommerce button.button.alt:disabled[disabled],
				.woocommerce button.button.alt.disabled:hover,
				.woocommerce button.button.alt:disabled:hover,
				.woocommerce button.button.alt:disabled[disabled]:hover,
				.woocommerce input.button.alt.disabled,
				.woocommerce input.button.alt:disabled,
				.woocommerce input.button.alt:disabled[disabled],
				.woocommerce input.button.alt.disabled:hover,
				.woocommerce input.button.alt:disabled:hover,
				.woocommerce input.button.alt:disabled[disabled]:hover,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-range{
					background-color: $color;
					color: $bright;
				}

				.woocommerce div.product #product-images-slider-nav .tie-slick-slider .slide.slick-current img{
					border-color: $color;
				}

				.woocommerce a.button:hover,
				.woocommerce button.button:hover,
				.woocommerce input.button:hover,
				.woocommerce a.button.alt:hover,
				.woocommerce button.button.alt:hover,
				.woocommerce input.button.alt:hover{
					background-color: $dark_color;
				}
			";

		}

		return $skin;
	}

}





/*-----------------------------------------------------------------------------------*/
# Set Sections Custom Styles
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_section_custom_styles' )){

	function jannah_section_custom_styles( $section ){

		if( ! empty( $section['settings']['section_id'] )){

			$section_css      = '';
			$section_styles   = array();
			$section_settings = $section['settings'];
			$section_id       = $section_settings['section_id'];

			$section_styles[] = isset( $section_settings['margin_top'] ) ? 'margin-top:'.$section_settings['margin_top'].'px;' : '';
			$section_styles[] = isset( $section_settings['margin_bottom'] ) ? 'margin-bottom:'.$section_settings['margin_bottom'].'px;' : '';

			$section_styles = implode( ' ', array_filter( $section_styles ) );

			if( ! empty( $section_styles )){
				$section_css .= "
					#$section_id{
						$section_styles
					}
				";
			}

			if( ! empty( $section_settings['section_title'] ) && ! empty( $section_settings['title'] ) && ! empty( $section_settings['title_color'] )){

				$color = $section_settings['title_color'];
				$selector = "#$section_id h2.section-title";

				if( ! empty( $section_settings['url'] ) ){

					$darker = jannah_adjust_color_brightness( $color );

					$section_css .= "
						$selector,
						$selector a{
							color: $color;
						}

						$selector a:hover{
							color: $darker;
						}
					";
				}
				else{
					$section_css .= "
						#$section_id h2.section-title{
							color: $color;
						}
					";
				}

				if( ! empty( $section_settings['title_style'] ) &&  $section_settings['title_style'] == 'centered' ){
					$section_css .= "
						$selector.centered-style:before,
						$selector.centered-style:after{
							background-color: $color;
						}
					";
				}
				else{
					$section_css .= "
						$selector.default-style:before{
							border-top-color: $color;
						}

						$selector.default-style:after{
							background-color: $color;
						}
					";
				}
			}

			if( ! empty( $section_css )){
				return jannah_minify_css( $section_css );
			}

		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Set Custom color for the blocks
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_block_custom_color' )){

	function jannah_block_custom_color( $block ){

		if( empty( $block['color'] )) return;

		$id_css = '#tie-' .$block['boxid'];
		$color  = $block['color'];
		$bright = jannah_light_or_dark( $color );
		$darker = jannah_adjust_color_brightness( $color );

		$background_hover_elements = $color_elements = $background_elements = '';

		if( $block['style'] == 'woocommerce' ){
			$color_elements            .= ", $id_css.woocommerce a:hover, $id_css.woocommerce ins";
			$background_elements       .= ", $id_css .button";
			$background_hover_elements .= ", $id_css .button:hover";
		}

		if( $block['style'] == 'scroll' || $block['style'] == 'scroll_2' || $block['style'] == 'woocommerce' ){
			$background_elements .= ", $id_css .slick-dots li.slick-active button, $id_css .slick-dots li button:hover";
		}

		$block_css = "
			$id_css .mag-box-title,
			$id_css .mag-box-options a.active,
			$id_css .stars-rating-active,
			$id_css .tabs-menu li.is-active a,
			$id_css .mag-box-options .slider-arrow-nav a:not(.pagination-disabled),
			$id_css .mag-box-options .mag-box-filter-links li a.active:hover,
			$id_css .mag-box-options .mag-box-filter-links .flexMenu-viewMore > a:hover,
			$id_css .mag-box-options .mag-box-filter-links .flexMenu-viewMore:hover > a,
			$id_css .pages-nav li a:hover,
			$id_css .show-more-button:hover,
			$id_css .entry a,
			$id_css .spinner-circle:after,
			$id_css .video-playlist-nav-wrapper .video-playlist-item .video-play-icon
			$color_elements{
				color: $color;
			}

			$id_css a:hover,
			$id_css a.block-more-button:hover{
				color: $darker;
			}

			$id_css .digital-rating-static,
			$id_css .spinner > div,
			$id_css .mag-box-title:after,
			$id_css .mag-box-options .slider-arrow-nav a:hover:not(.pagination-disabled),
			$id_css .mag-box-options .mag-box-filter-links li a:hover,
			$id_css .slick-dots li.slick-active button,
			$id_css .slick-dots li button:hover,
			$id_css li.current span
			$background_elements{
				background-color: $color;
			}

			$id_css a.more-link,
			$id_css .video-playlist-nav-wrapper .playlist-title,
			$id_css .breaking-title:before,
			$id_css .breaking-news-nav li:hover,
			$id_css .post-cat,
			$id_css .slider-nav li > span:hover{
				background-color: $color;
				color: $bright;
			}

			$id_css a.more-link:hover
			$background_hover_elements{
				background-color: $darker;
				color: $bright !important;
			}

			$id_css .circle_bar{
				stroke: $color;
			}

			$id_css .mag-box-title:before,
			$id_css .breaking-title:after,
			$id_css .post-cat:after{
				border-top-color: $color;
			}

			$id_css .mag-box-options .mag-box-filter-links li a:hover,
			$id_css .mag-box-options .slider-arrow-nav a:hover:not(.pagination-disabled){
				color: $bright;
			}

			$id_css .mag-box-options .slider-arrow-nav a:hover:not(.pagination-disabled),
			$id_css .mag-box-options .mag-box-filter-links li a:hover,
			$id_css li.current span,
			$id_css .breaking-news-nav li:hover{
				border-color: $color !important;
			}
		";


		/* Magazine 3 */
		/*
		if( jannah_get_option( 'boxes_style' ) == 3 ){
			$block_css .= "
				$id_css .tabs-widget .tabs-wrapper .tabs-menu li a:hover,
				$id_css .tabs-widget .tabs-wrapper .tabs-menu li.is-active a{
				  background-color: $color !important;
				  color: $bright;
				}
			";
		}
		*/

		return jannah_minify_css( $block_css );

	}

}

<?php


/*-----------------------------------------------------------------------------------*/
# Register Widgets
/*-----------------------------------------------------------------------------------*/
function jannah_is_registered_sidebar( $index ){
	global $wp_registered_sidebars;

	$index = sanitize_title( $index );
	return ! empty( $wp_registered_sidebars[ $index ] );
}



/*-----------------------------------------------------------------------------------*/
# Register Widgets
/*-----------------------------------------------------------------------------------*/
add_action( 'widgets_init', 'jannah_widgets_init' );
function jannah_widgets_init(){

	# Remove recent comments style ----------
	add_filter( 'show_recent_comments_widget_style', '__return_false' );


	# Widgets icon ----------
	$widget_icon = jannah_get_option( 'widgets_icon' ) ? '<span class="widget-title-icon fa"></span>' : '';


	# Widget HTML markup ----------
	$before_widget = '<div id="%1$s" class="container-wrapper widget %2$s">';
	$after_widget  = '</div><!-- .widget /-->';
	$before_title  = '<div class="widget-title"><h4>';
	$after_title   = '</h4>'.$widget_icon.'</div>';


	# Default Sidebar ----------
	register_sidebar( array(
		'id'            => 'primary-widget-area',
		'name'          => esc_html__( 'Primary Widget Area', 'jannah' ),
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	));

	# Slide Sidebar ----------
	register_sidebar( array(
		'id'            => 'slide-sidebar-area',
		'name'          => esc_html__( 'Slide Widget Area', 'jannah' ),
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	));

	# WooCommerce Sidebar ----------
	if ( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
		register_sidebar( array(
			'id'            => 'shop-widget-area',
			'name'          => esc_html__( 'Shop - For WooCommerce Pages', 'jannah' ),
			'description'   => esc_html__( 'This widget area uses in the WooCommerce pages.', 'jannah' ),
			'before_widget' => $before_widget,
			'after_widget'  => $after_widget,
			'before_title'  => $before_title,
			'after_title'   => $after_title,
		));
	}

	# Custom Sidebars ----------
	$sidebars = jannah_get_option( 'sidebars' );
	if( ! empty( $sidebars ) && is_array( $sidebars )){
		foreach ($sidebars as $sidebar){
			register_sidebar( array(
				'id' 			      => sanitize_title($sidebar),
				'name'          => $sidebar,
				'before_widget' => $before_widget,
				'after_widget' 	=> $after_widget,
				'before_title' 	=> $before_title,
				'after_title' 	=> $after_title,
			));
		}
	}

	# Footer Widgets ----------
	$fotter_widgets_areas = array(
		'area_1' => esc_html__( 'First Footer', 'jannah' ),
		'area_2' => esc_html__( 'Secound Footer', 'jannah' )
	);

	foreach( $fotter_widgets_areas as $name => $description ){

		if( jannah_get_option( 'footer_widgets_'.$name ) ){

			$footer_widgets = jannah_get_option( 'footer_widgets_layout_'.$name );

			# Footer Widgets Column 1 ----------
			register_sidebar( array(
				'id'            => 'first-footer-widget-'.$name,
				'name'          => $description. ' - '.esc_html__( '1st Column', 'jannah' ),
				'before_widget' => $before_widget,
				'after_widget'  => $after_widget,
				'before_title'  => $before_title,
				'after_title'   => $after_title,
			));


			# Footer Widgets Column 2 ----------
			if( $footer_widgets == 'footer-2c'      ||
				  $footer_widgets == 'narrow-wide-2c' ||
				  $footer_widgets == 'wide-narrow-2c' ||
				  $footer_widgets == 'footer-3c'      ||
				  $footer_widgets == 'wide-left-3c'   ||
				  $footer_widgets == 'wide-right-3c'  ||
				  $footer_widgets == 'footer-4c'      ){

						register_sidebar( array(
							'id' 			      => 'second-footer-widget-'.$name,
							'name'			    => $description. ' - '.esc_html__( '2d Column', 'jannah' ),
							'before_widget' => $before_widget,
							'after_widget'  => $after_widget,
							'before_title'  => $before_title,
							'after_title'   => $after_title,
						));
					}


			# Footer Widgets Column 3 ----------
			if( $footer_widgets == 'footer-3c'     ||
				  $footer_widgets == 'wide-left-3c'  ||
				  $footer_widgets == 'wide-right-3c' ||
				  $footer_widgets == 'footer-4c'     ){

						register_sidebar( array(
							'id'            => 'third-footer-widget-'.$name,
							'name'          => $description. ' - '.esc_html__( '3rd Column', 'jannah' ),
							'before_widget' => $before_widget,
							'after_widget'  => $after_widget,
							'before_title'  => $before_title,
							'after_title'   => $after_title,
						));
					}


			# Footer Widgets Column 4 ----------
			if( $footer_widgets == 'footer-4c' ){
				register_sidebar( array(
					'id'            => 'fourth-footer-widget-'.$name,
					'name'          => $description. ' - '.esc_html__( '4th Column', 'jannah' ),
					'before_widget' => $before_widget,
					'after_widget'  => $after_widget,
					'before_title'  => $before_title,
					'after_title'   => $after_title,
				));
			}

		}
	}


	$custom_widgets = get_option( 'tie_sidebars_widgets', array() );


	foreach ( $custom_widgets as $post_id => $sections ) {
		$i = 1;
		if( ! empty( $sections ) && is_array( $sections ) ){
			foreach ( $sections as $section => $widgets ) {
				register_sidebar(array(
					'name'          => get_the_title( $post_id ). ' - '. sprintf( esc_html__( 'Section #%s', 'jannah' ), $i ),
					'id'            => $section,
					'before_widget' => $before_widget,
					'after_widget'  => $after_widget,
					'before_title'  => $before_title,
					'after_title'   => $after_title,
				));

				$i++;
			}
		}
	}
}





/*-----------------------------------------------------------------------------------*/
# Import the theme Widgets
/*-----------------------------------------------------------------------------------*/
$theme_widgets = array(
	'ads',
	'tabs',
	'posts',
	'login',
	'about',
	'google',
	'flickr',
	'author',
	'social',
	'slider',
	'weather',
	'youtube',
	'twitter',
	'facebook',
	'text-html',
	'instagram',
	'newsletter',
	'soundcloud',
	'categories',
	/* 'videos-playlist', */
	'comments-avatar',
	'social-counters',
);

foreach ( $theme_widgets as $widget ){
	locate_template( "framework/widgets/$widget.php", true, true );
}

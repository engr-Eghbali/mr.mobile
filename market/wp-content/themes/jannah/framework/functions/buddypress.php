<?php

# Groups Single ----------
add_action( 'bp_before_group_body', 'jannah_bp_html_before_content' );
add_action( 'bp_after_group_body',  'jannah_bp_html_after_content' );

# Groups directory ----------
add_action( 'bp_before_directory_groups', 'jannah_bp_html_before_content' );
add_action( 'bp_after_directory_groups',  'jannah_bp_html_after_content' );

# Create Group ---------- +
add_action( 'bp_before_create_group_content_template', 'jannah_bp_html_before_content' );
add_action( 'bp_after_create_group_content_template',  'jannah_bp_html_after_content' );

# Activity directory ---------- +
add_action( 'bp_before_directory_activity_content', 'jannah_bp_html_before_content' );
add_action( 'bp_after_directory_activity_content',  'jannah_bp_html_after_content' );

# Members directory ----------
add_action( 'bp_before_directory_members', 'jannah_bp_html_before_content' );
add_action( 'bp_after_directory_members',  'jannah_bp_html_after_content' );

# Member single ----------
add_action( 'bp_before_member_body', 'jannah_bp_html_before_content' );
add_action( 'bp_after_member_body',  'jannah_bp_html_after_content' );

# Activation page ----------
add_action( 'bp_before_activation_page', 'jannah_bp_html_before_content' );
add_action( 'bp_after_activation_page',  'jannah_bp_html_after_content' );

# Register page ----------
add_action( 'bp_before_register_page', 'jannah_bp_html_before_content' );
add_action( 'bp_after_register_page',  'jannah_bp_html_after_content' );

# Blogs ---------- +
add_action( 'bp_before_directory_blogs', 'jannah_bp_html_before_content' );
add_action( 'bp_after_directory_blogs',  'jannah_bp_html_after_content' );





/*-----------------------------------------------------------------------------------*/
# Dequeue buddyPress Default Css files
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_bp_dequeue_css' )){

	add_action( 'wp_enqueue_scripts', 'jannah_bp_dequeue_css', 10 );
	function jannah_bp_dequeue_css(){

		if ( JANNAH_BUDDYPRESS_IS_ACTIVE ){
			wp_dequeue_style( 'bp-parent-css' );
			wp_dequeue_style( 'bp-parent-css-rtl' );
			wp_dequeue_style( 'bp-legacy-css' );
			wp_dequeue_style( 'bp-legacy-css-rtl' );
		}
	}

}



/*-----------------------------------------------------------------------------------*/
# Enqueue buddyPress Custom Css file
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_bp_enqueue_css' )){

	add_action( 'wp_enqueue_scripts', 'jannah_bp_enqueue_css', 9 );
	function jannah_bp_enqueue_css(){

		if ( JANNAH_BUDDYPRESS_IS_ACTIVE ){

			$min = jannah_get_option( 'minified_files' ) ? '.min' : '';

			# Register buddyPress css file ----------
			wp_enqueue_style( 'jannah-buddypress', JANNAH_TEMPLATE_URL.'/css/buddypress'. $min .'.css', array(), '', 'all' );
		}

	}

}



/*-----------------------------------------------------------------------------------*/
# BuddyPress Pages HTML markup | before content
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_bp_html_before_content' )){

	function jannah_bp_html_before_content(){
		jannah_html_before_main_content();
		echo'
			<div ' .jannah_content_column_attr( false ). '>
				<div class="container-wrapper">
		';
	}

}



/*-----------------------------------------------------------------------------------*/
# BuddyPress Pages HTML markup | after content
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_bp_html_after_content' )){

	function jannah_bp_html_after_content(){
		echo'
					<div class="clearfix"></div>
				</div><!-- .container-wrapper /-->
			</div><!-- .main-content /-->
		';

		get_sidebar();
		jannah_html_after_main_content();
	}

}



/*-----------------------------------------------------------------------------------*/
# BuddyPress Cover Image
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_bp_cover_image_css' )){

	add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', 'jannah_bp_cover_image_css', 10, 1 );
	add_filter( 'bp_before_groups_cover_image_settings_parse_args',   'jannah_bp_cover_image_css', 10, 1 );
	function jannah_bp_cover_image_css( $settings = array() ){

		$theme_handle = 'jannah-buddypress';

		$settings['callback']      = 'jannah_bp_cover_image_callback';
		$settings['theme_handle']  = $theme_handle;
		$settings['width']         = 1400;
		$settings['height']        = 440;
		$settings['default_cover'] = JANNAH_TEMPLATE_URL. '/images/default-cover-image.jpg';

		return $settings;
	}

}


if( ! function_exists( 'jannah_bp_cover_image_callback' )){

	function jannah_bp_cover_image_callback( $params = array() ){

		if ( empty( $params ) ){
			return;
		}

		$background_attr = '';
		if( $params['cover_image'] == JANNAH_TEMPLATE_URL. '/images/default-cover-image.jpg' ){
			$background_attr = '
	    	background-repeat: repeat !important;
	    	background-size: 400px !important;
	    ';
		}

		return '
			#buddypress #header-cover-image {
				background-image: url(' . $params['cover_image'] . ');
				'. $background_attr .'
			}
		';
	}

}



/*-----------------------------------------------------------------------------------*/
# BuddyPress current id
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_bp_current_page_id' )){

	function jannah_bp_current_page_id(){
		global $bp;

		if( bp_is_user() || bp_is_current_component( 'members' ) ){
			$buddypress_id = ! empty( $bp->pages->members->id ) ? $bp->pages->members->id : '';
		}
		elseif( bp_is_current_component( 'groups' ) ){
			$buddypress_id = ! empty( $bp->pages->groups->id ) ? $bp->pages->groups->id : '';
		}
		elseif( bp_is_current_component( 'activity' ) ){
			$buddypress_id = ! empty( $bp->pages->activity->id ) ? $bp->pages->activity->id : '';
		}

		if( ! empty( $buddypress_id )){
			return $buddypress_id;
		}

		return false;
	}

}



/*-----------------------------------------------------------------------------------*/
# Get BuddyPress custom option
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_bp_get_page_data' )){

	function jannah_bp_get_page_data( $key, $default = false ){

		$buddypress_id = jannah_bp_current_page_id();

		if( ! empty( $buddypress_id ) ){
			if( $value = get_post_meta( $buddypress_id, $key, $single = true )){
				return $value;
			}
			elseif( $default ){
				return $default;
			}
		}

		return false;
	}

}



/*-----------------------------------------------------------------------------------*/
# Get BuddyPress custom option
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_bp_get_notifications' )){

	function jannah_bp_get_notifications(){

		$notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), 'object' );
		$count         = ! empty( $notifications ) ? count( $notifications ) : 0;
		$menu_link     = trailingslashit( bp_loggedin_user_domain() . bp_get_notifications_slug() );
		$count         = (int) $count > 0 ? number_format_i18n( $count ) : '';

		$out_data = '<ul class="bp-notifications">';

		if ( ! empty( $notifications ) ){
			foreach ( (array) $notifications as $notification ){
				$out_data .= '<li id="'. $notification->id .'" class="notifications-item"><a href="'. $notification->href .'"><span class="fa fa-bell"></span> '. $notification->content .'</a></li>';
			}
		}
		else {
			$out_data .= '<li id="no-notifications" class="notifications-item"><a href="'. $menu_link .'"><span class="fa fa-bell-o"></span>  '. esc_html__( 'No new notifications', 'jannah' ) .'</a></li>';
		}

		$out_data .= '</ul>';

		return array(
			'data'  => $out_data,
			'count' => $count,
			'link'  => $menu_link,
		);
	}

}

?>

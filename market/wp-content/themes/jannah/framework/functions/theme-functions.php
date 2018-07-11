<?php
/**
 * Custom theme functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





/*-----------------------------------------------------------------------------------*/
# Get Theme Options
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_option' )){

	function jannah_get_option( $name, $default = false ){
		$get_options = get_option( 'tie_jannah_options' );

		if( ! empty( $get_options[ $name ] )){
			 return $get_options[ $name ];
		}
		elseif ( $default ){
			return $default;
		}

		return false;
	}

}





/*-----------------------------------------------------------------------------------*/
# Get Post custom option
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_postdata' )){

	function jannah_get_postdata( $key, $default = false, $post_id = null ){

		if( ! $post_id ){
			$post_id = get_the_ID();
		}

		if( $value = get_post_meta( $post_id, $key, $single = true )){
			return $value;
		}
		elseif( $default ){
			return $default;
		}

		return false;
	}

}





/*-----------------------------------------------------------------------------------*/
# Get Category custom option
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_category_option' )){

	function jannah_get_category_option( $key, $category_id = 0 ){

		if( is_category() && empty( $category_id )){
			$category_id = get_query_var('cat');
		}

		if( empty( $category_id )){
			return false;
		}

		$categories_options = get_option( 'tie_cats_options' );

		if( ! empty( $categories_options[ $category_id ][ $key ] )){
			return $categories_options[ $category_id ][ $key ];
		}

		return false;
	}

}





/*-----------------------------------------------------------------------------------*/
# Get custom option > post > primary category > theme options
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_object_option' )){

	function jannah_get_object_option( $key = false, $cat_key = false, $post_key = false ){

		# CHeck if the $cat_key or $post_key are empty ----------
		if( ! empty( $key ) ){
			$cat_key  = ! empty( $cat_key  ) ? $cat_key  : $key;
			$post_key = ! empty( $post_key ) ? $post_key : $key;
		}

		# Get Category options ----------
		if( is_category() ){
			$option = jannah_get_category_option( $cat_key );
		}

		# BuddyPress ----------
		elseif( JANNAH_BUDDYPRESS_IS_ACTIVE && is_buddypress() ){

			$option = jannah_bp_get_page_data( $post_key );
			$option = ( $option == 'default') ? '' : $option; //Compatability Sahifa
		}

		# Get Single options ----------
		elseif( is_singular() ){

			# Get the post option if exists ----------
			$option = jannah_get_postdata( $post_key );

			$option = ( $option == 'default') ? '' : $option; //Compatability Sahifa

			# Get the category option if the post option isn't exists ----------
			if( ( empty( $option ) || ( is_array( $option ) && ! array_filter( $option )) ) && is_singular( 'post' ) ){

				$category_id = jannah_get_primary_category_id();
				$option      = jannah_get_category_option( $cat_key, $category_id );
			}
		}

		# Get the global value ----------
		if( ( empty( $option ) || ( is_array( $option ) && ! array_filter( $option )) ) && ! empty( $key ) ){
			$option = jannah_get_option( $key );
		}

		if( ! empty( $option )){
			return $option;
		}

		return false;
	}

}





/*-----------------------------------------------------------------------------------*/
# Logo Args Function
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_logo_args' )){

	function jannah_logo_args(){

		$category_id    = 0;
		$is_logo_loaded = false;
		$logo_args      = array();

		# Custom BuddyPress logo ----------
		if( JANNAH_BUDDYPRESS_IS_ACTIVE && is_buddypress() ){

			if( jannah_bp_get_page_data( 'custom_logo' )){

				$logo_args['logo_type']          = jannah_bp_get_page_data( 'logo_setting' );
				$logo_args['logo_img']           = jannah_bp_get_page_data( 'logo' );
				$logo_args['logo_retina']        = jannah_bp_get_page_data( 'logo_retina' );
				$logo_args['logo_width']         = jannah_bp_get_page_data( 'logo_retina_width' );
				$logo_args['logo_height']        = jannah_bp_get_page_data( 'logo_retina_height' );
				$logo_args['logo_margin_top']    = jannah_bp_get_page_data( 'logo_margin' );
				$logo_args['logo_margin_bottom'] = jannah_bp_get_page_data( 'logo_margin_bottom' );
				$logo_args['logo_title']         = jannah_bp_get_page_data( 'logo_text', get_bloginfo() );

				$is_logo_loaded = true;
			}
		}

		# Custom post logo ----------
		elseif( is_singular() ){
			if( jannah_get_postdata( 'custom_logo' )){

				$logo_args['logo_type']          = jannah_get_postdata( 'logo_setting' );
				$logo_args['logo_img']           = jannah_get_postdata( 'logo' );
				$logo_args['logo_retina']        = jannah_get_postdata( 'logo_retina' );
				$logo_args['logo_width']         = jannah_get_postdata( 'logo_retina_width' );
				$logo_args['logo_height']        = jannah_get_postdata( 'logo_retina_height' );
				$logo_args['logo_margin_top']    = jannah_get_postdata( 'logo_margin' );
				$logo_args['logo_margin_bottom'] = jannah_get_postdata( 'logo_margin_bottom' );
				$logo_args['logo_title']         = jannah_get_postdata( 'logo_text', get_bloginfo() );

				$is_logo_loaded = true;
			}

			# Get the category option if the post option isn't exists ----------
			else{
				if( is_singular( 'post' ) ){
					$category_id = jannah_get_primary_category_id();
				}
			}
		}

		# Custom category logo or primary category logo for a single post ----------
		if( is_category() || ! empty( $category_id ) ){

			if( is_category() ){
				$category_id = get_query_var('cat');
			}

			if( jannah_get_category_option( 'custom_logo', $category_id )){

				$logo_args['logo_type']          = jannah_get_category_option( 'logo_setting',       $category_id );
				$logo_args['logo_img']           = jannah_get_category_option( 'logo',               $category_id );
				$logo_args['logo_retina']        = jannah_get_category_option( 'logo_retina',        $category_id );
				$logo_args['logo_width']         = jannah_get_category_option( 'logo_retina_width',  $category_id );
				$logo_args['logo_height']        = jannah_get_category_option( 'logo_retina_height', $category_id );
				$logo_args['logo_margin_top']    = jannah_get_category_option( 'logo_margin',        $category_id );
				$logo_args['logo_margin_bottom'] = jannah_get_category_option( 'logo_margin_bottom', $category_id );
				$logo_args['logo_title']         = jannah_get_category_option( 'logo_text',          $category_id ) ? jannah_get_category_option( 'logo_text', $category_id ) : get_cat_name( $category_id );

				$is_logo_loaded = true;
			}
		}

		# Get the theme default logo ----------
		if( ! $is_logo_loaded ){

			$logo_args['logo_type']          = jannah_get_option( 'logo_setting' );
			$logo_args['logo_img']           = jannah_get_option( 'logo' ) ? jannah_get_option( 'logo' ) : get_theme_file_uri( '/images/logo.png' );
			$logo_args['logo_width']         = jannah_get_option( 'logo_retina_width', 300 );
			$logo_args['logo_height']        = jannah_get_option( 'logo_retina_height', 49 );
			$logo_args['logo_margin_top']    = jannah_get_option( 'logo_margin' );
			$logo_args['logo_margin_bottom'] = jannah_get_option( 'logo_margin_bottom' );
			$logo_args['logo_title']         = jannah_get_option( 'logo_text' ) ? jannah_get_option( 'logo_text' ) : get_bloginfo();

			if( jannah_get_option( 'logo_retina' ) ){
				$logo_args['logo_retina'] = jannah_get_option( 'logo_retina' );
			}
			elseif( jannah_get_option( 'logo' ) ){
				$logo_args['logo_retina'] = jannah_get_option( 'logo' );
			}
			else{
				$logo_args['logo_retina'] = get_theme_file_uri( '/images/logo@2x.png' );
			}
		}

		return $logo_args;
	}

}





/*-----------------------------------------------------------------------------------*/
# Logo Function
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_logo' )){

	function jannah_logo(){

		$logo_url   = esc_url(home_url( '/' ));
		$logo_args  = jannah_logo_args();
		$logo_style = '';

		extract( $logo_args );


		# Logo Margin ----------
		if( ! empty( $logo_margin_top ) || ! empty( $logo_margin_bottom )){

			$logo_style = ' style="';

			# Margin top ----------
			if( ! empty( $logo_margin_top )){
				$logo_style .= 'margin-top: ' .$logo_margin_top. 'px; ';
			}

			# Margin bottom ----------
			if( ! empty( $logo_margin_bottom )){
				$logo_style .= 'margin-bottom: ' .$logo_margin_bottom. 'px;';
			}

			$logo_style .= '"';
		}

		# Logo Type : Title ----------
		if( $logo_type == 'title' ){

			# Logo Text ----------
			$logo_class = ' class="text-logo"';

			$logo_output =
				'<div class="logo-text">'. $logo_title .'</div>';
		}

		# Logo Type : Image ----------
		else{
			$logo_size 	= '';
			$logo_class	= '';

			# Logo Width and Height ----------
			if( $logo_width && $logo_height ){
				$logo_size = 'width="'. esc_attr( $logo_width ) .'" height="'. esc_attr( $logo_height ) .'" style="max-height:'. esc_attr( $logo_height ) .'px; width: auto;"';
			}

			if( $logo_retina ){

				# Logo Retina & Non Retina ----------
				$logo_output = '
					<img src="'. esc_attr( $logo_img ) .'" alt="'. esc_attr( $logo_title ) .'" class="logo_normal" '. $logo_size .'>
					<img src="'. esc_attr( $logo_retina ) .'" alt="'. esc_attr( $logo_title ) .'" class="logo_2x" '. $logo_size .'>
				';
			}
			else{

				# Logo Non Retina ----------
				$logo_output =
					'<img src="'. esc_attr( $logo_img ) .'" alt="'. esc_attr( $logo_title ) .'" '. $logo_size .'>';
			}
		}

		# H1 for the site title ----------
		if( is_home() || is_front_page() ){
			$logo_output .= '<h1 class="h1-off">'. $logo_title .'</h1>';
		}

		# Logo Output ----------
		echo "
			<div id=\"logo\"$logo_class$logo_style>
				<a title=\"$logo_title\" href=\"$logo_url\">
					$logo_output
				</a>
			</div><!-- #logo /-->
		";
	}

}





/*-----------------------------------------------------------------------------------*/
# Get score
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_score' )){

	function jannah_get_score( $size = 'small' ){

		if( ! JANNAH_TAQYEEM_IS_ACTIVE || ! jannah_get_postdata( 'taq_review_position' ) ){
			return;
		}

		$style         = jannah_get_postdata( 'taq_review_style' );
		$total_score   = jannah_get_postdata( 'taq_review_score', 0 );
		$review_output = '';

		$image_style = taqyeem_get_option( 'rating_image' ) ? taqyeem_get_option( 'rating_image' ) : 'stars';

		# Show the stars ----------
		if( $style == 'stars' ){

			# Small stars size ----------
			if( $size != 'small' ){
				$review_output .= '
					<div data-rate-val="'. $total_score. '%" class="post-rating image-'. $image_style .'">
						<div class="stars-rating-bg"></div><!-- .stars-rating-bg -->
						<div class="stars-rating-active">
							<div class="stars-rating-active-inner">
							</div><!--.stars-rating-active-inner /-->
						</div><!--.stars-rating-active /-->
					</div><!-- .post-rating -->
				';
			}
		}

		# Percentage and point style ----------
		else{

			$review_class = '';
			$percentage   = '';

			# Percentage ----------
			if( $style == 'percentage' ){
				$review_class = ' review-percentage';
				$post_score   = round( $total_score, 0 );
				$percentage   = '%';
			}

			# Points ----------
			else{
				$post_score = 0;
				if( $total_score != 0 ){
					$post_score = round( $total_score/10, 1 );
				}
			}


			if( $size != 'stars' ){

				if( $size == 'small' ){
					$review_output .= '<div class="digital-rating-static" data-rate-val="'. $total_score .'"><strong>'. $post_score . $percentage .'</strong></div>';
				}

				else{
					$review_output .= '
						<div class="digital-rating">
							<div data-score="'. $post_score .'" data-pct="'. $total_score .'" class="pie-wrap'. $review_class .'">
								<svg width="50" height="50" version="1.1" xmlns="https://www.w3.org/2000/svg" class="pie-svg">
									<circle r="22" cx="25" cy="25" fill="transparent" stroke-dasharray="144.44" stroke-dashoffset="0" class="circle_base"></circle>
									<circle r="22" cx="25" cy="25" fill="transparent" stroke-dasharray="144.44" stroke-dashoffset="0" class="circle_bar"></circle>
								</svg>
							</div>
						</div><!-- .digital-rating -->
					';
				}
			}
		}

		return $review_output;
	}

}





/*-----------------------------------------------------------------------------------*/
# Print the score
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_the_score' )){

	function jannah_the_score( $size = 'small' ){
		echo jannah_get_score( $size );
	}

}





/*-----------------------------------------------------------------------------------*/
# Exclude post types and categories From Search results
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_search_filters' )){

	add_filter( 'pre_get_posts', 'jannah_search_filters' );
	function jannah_search_filters( $query ){

		if( is_admin() ){
			return $query;
		}

		if( is_search() && $query->is_main_query() ){

			# Exclude Post types from search ----------
			if ( ($exclude_post_types = jannah_get_option( 'search_exclude_post_types' )) && is_array( $exclude_post_types ) ){

				$args = array(
					'public' => true,
					'exclude_from_search' => false,
				);

				$post_types = get_post_types( $args );

				foreach ( $exclude_post_types as $post_type ){
					unset( $post_types[ $post_type ] );
				}

				$query->set( 'post_type', $post_types );
			}

			# Exclude specific categoies from search ----------
			if ( jannah_get_option( 'search_cats' ) ){
				$query->set( 'cat', jannah_get_option( 'search_cats' ) );
			}
		}
		return $query;
	}

}





/*-----------------------------------------------------------------------------------*/
# Random article button
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_redirect_to_random_post' )){

	add_action( 'init', 'jannah_redirect_to_random_post' );
	function jannah_redirect_to_random_post(){

		if ( isset( $_GET['random-post'] )){

			$args = array(
				'posts_per_page'      => 1,
				'orderby'             => 'rand',
				'fields'              => 'ids',
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			);

			$random_post = new WP_Query ( $args );

			while ( $random_post->have_posts () ){
			  $random_post->the_post();
			  wp_redirect( get_permalink() );
			  exit;
			}
	 	}
	}

}





/*-----------------------------------------------------------------------------------*/
# Get the Primary category object
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_primary_category' )){

	function jannah_get_primary_category(){

		if( get_post_type() != 'post' ){
			return;
		}

		# Get the primary category ----------
		$category = (int) jannah_get_postdata( 'tie_primary_category' );

		if( ! empty( $category ) && _jannah_good_term_exists( $category, 'category' ) ){
			$get_the_category = _jannah_good_get_term_by( 'id', $category, 'category' );
			$primary_category = array( $get_the_category );
		}

		# Get the first assigned category ----------
		else{
			$get_the_category = get_the_category();
			$primary_category = array( $get_the_category[0] );
		}

		if( ! empty( $primary_category[0] )){
			return $primary_category;
		}

	}

}





/*-----------------------------------------------------------------------------------*/
# Get the Primary category id
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_primary_category_id' )){

	function jannah_get_primary_category_id(){

		$primary_category = jannah_get_primary_category();

		if( ! empty( $primary_category[0]->term_id )){
			return $primary_category[0]->term_id;
		}

		return false;
	}

}





/*-----------------------------------------------------------------------------------*/
# Get the post category HTML
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_category' )){

	function jannah_get_category( $before = false, $after = false, $primary = true ){

		if( get_post_type() != 'post'){
			return;
		}

		$output  = '';
		$output .= $before;

		# If the primary is true ----------
		if( ! empty( $primary )){
			$categories = jannah_get_primary_category();
		}

		# Show all post's categories ----------
		else{
			$categories = get_the_category();
		}

		# Display the categories ----------
		if( ! empty( $categories ) && is_array( $categories )){
			foreach ( $categories as $category ){
				$output .= '<a class="post-cat tie-cat-'.$category->term_id.'" href="' . esc_url( _jannah_good_get_term_link( $category->term_id, 'category' )) . '">' . $category->name.'</a>';
			}
		}

		return $output .= $after;
	}

}





/*-----------------------------------------------------------------------------------*/
# Print the post category HTML
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_the_category' )){

	function jannah_the_category( $before = false, $after = false, $primary = true ){
		echo jannah_get_category( $before, $after, $primary );
	}

}





/*-----------------------------------------------------------------------------------*/
# Change The Excerpt Length
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_excerpt' )){

	function jannah_get_excerpt( $limit ){

		add_filter( 'excerpt_length', 'jannah_excerpt_max_length', 999 );

		$excerpt   = get_the_excerpt();
		$trim_type = jannah_get_option( 'trim_type' );
		$limit     = ! empty( $limit ) ? $limit : 20;


		# For Chinese Language ----------
		if( $trim_type == 'chars' ){

			if ( function_exists( 'mb_substr' ) ) {
				return mb_substr( $excerpt, 0, $limit );
			}
			else {
				return substr( $excerpt, 0, $limit );
			}
		}
		else{
			return wp_trim_words( $excerpt, $limit, '&hellip;' );
		}
	}
}


if( ! function_exists( 'jannah_excerpt_max_length' )){

	function jannah_excerpt_max_length(){
		return 200;
	}

}





/*-----------------------------------------------------------------------------------*/
# Print the modified excerpt
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_the_excerpt' )){

	function jannah_the_excerpt( $limit ){
		echo jannah_get_excerpt( $limit );
	}

}





/*-----------------------------------------------------------------------------------*/
# Change The Title Length
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_title' )){

	function jannah_get_title( $limit = false ){

		$title = get_the_title();

		# Check if the post has title -----------
		if( $title == '' ){
			 $title = esc_html__( '(no title)', 'jannah' );
		}

		# If no limit return the original title -----------
		if( empty( $limit )){
			return $title;
		}

		# Get the rim type -----------
		$trim_type = jannah_get_option( 'trim_type' );

		# For Chinese Language ----------
		if( $trim_type == 'chars' ){

			if ( function_exists( 'mb_substr' ) ) {
				return mb_substr( $title, 0, $limit );
			}
			else {
				return substr( $title, 0, $limit );
			}
		}
		else{
			return wp_trim_words( $title, $limit, '&hellip;' );
		}

	}

}





/*-----------------------------------------------------------------------------------*/
# Print the modified title
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_the_title' )){

	function jannah_the_title( $limit = false ){
		echo jannah_get_title( $limit );
	}

}





/*-----------------------------------------------------------------------------------*/
# Get Post info section
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_post_meta' )){

	function jannah_get_post_meta( $args = '', $before = false, $after = false ){

		# For Posts only ----------
		if ( get_post_type() != 'post' ){
			return;
		}

		# Defaults ----------
		$args = wp_parse_args( $args, array(
			'author'	 => true,
			'date' 		 => true,
			'comments' => true,
			'views' 	 => true,
			'review' 	 => false,
			'avatar' 	 => false,
			'reading'  => false,
			'twitter'  => false,
			'email'    => false,
		));

		extract( $args );

		$user_id = get_the_author_meta( 'ID' );

		# Prepare the post info section ----------
		$post_meta = $before.'<div class="post-meta">';

		# Review score ----------
		if( ! empty( $review ) ){
			$post_meta .= jannah_get_score( 'stars' );
		}

		# Author ----------
		if( ! empty( $author ) ){

			# Show the author's avatar ----------
			if( ! empty( $avatar ) && get_option( 'show_avatars' ) ){
				$author_icon = '';

				$post_meta .= '
					<span class="meta-author-avatar">
						<a href="'. get_author_posts_url( $user_id ) .'">'.
							get_avatar( get_the_author_meta( 'user_email', $user_id ), 140 ).'
						</a>
					</span>
				';
			}

			# Show the author's default icon ----------
			else{
				$author_icon = '<span class="fa fa-user" aria-hidden="true"></span> ';
			}

			$post_meta .= '
				<span class="meta-author meta-item">'.
					'<a href="'. get_author_posts_url( $user_id ). '" class="author-name" title="'. get_the_author() .'">'. $author_icon . get_the_author() .'</a>
				</span>
			';

			# Twitter and Email Buttons ----------
			$author_twitter = get_the_author_meta( 'twitter', $user_id );
			if( ! empty( $twitter ) && ! empty( $author_twitter )){
				$post_meta .= '
					<a href="'. esc_url( $author_twitter ) .'" target="_blank">
						<span class="fa fa-twitter" aria-hidden="true"></span>
						<span class="screen-reader-text"></span>
					</a>
				';
			}

			$author_email = get_the_author_meta( 'email', $user_id );
			if( ! empty( $email ) && ! empty( $author_email ) ){
				$post_meta .= '
					<a href="mailto:'. $author_email .'" target="_blank">
						<span class="fa fa-envelope" aria-hidden="true"></span>
						<span class="screen-reader-text"></span>
					</a>
				';
			}

		}

		# Date  ----------
		if( ! empty( $date ) ){
			$post_meta .= jannah_get_time( true );
		}


		# Post info right area ----------
		if( ! empty( $comments ) || ! empty( $views ) || ! empty( $reading ) ){
			$post_meta .= '<div class="tie-alignright">';

			# Comments ----------
			if( ! empty( $comments ) ){
				$post_meta .= '<span class="meta-comment meta-item"><a href="'.get_comments_link().'"><span class="fa fa-comments" aria-hidden="true"></span> '. get_comments_number_text( '0', '1', '%' ) .'</a></span>';
			}

			# Number of views ----------
			if( ! empty( $views ) ){
				$post_meta .= jannah_views();
			}

			if( ! empty( $reading ) ){
				$post_meta .= jannah_reading_time();
			}

			$post_meta .= '</div>';
		}

		$post_meta .= '<div class="clearfix"></div></div><!-- .post-meta -->'.$after;

		return $post_meta;
	}

}





/*-----------------------------------------------------------------------------------*/
# Print the Post info section
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_the_post_meta' )){

	function jannah_the_post_meta( $args = '', $before = false, $after = false ){
		echo jannah_get_post_meta( $args, $before, $after );
	}

}





/*-----------------------------------------------------------------------------------*/
# Read More Functions
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_excerpt_more' )){

	add_filter( 'excerpt_more', 'jannah_excerpt_more' );
	function jannah_excerpt_more( $more ){
		return ' &hellip;';
	}

}





/*-----------------------------------------------------------------------------------*/
# Custom Quries
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_query' )){

	function jannah_query( $block = array() ){

		$args = array(
			'post_status'         => 'publish',
			'posts_per_page'      => 5,
			'ignore_sticky_posts' => true,
		);

		# Posts Number ----------
		if( ! empty( $block['number'] )){
			$args['posts_per_page'] = $block['number'];
		}


		# WooCommerce : Post Query ----------
		if( ! empty( $block['style'] ) && $block['style'] == 'woocommerce' ){

			if( ! empty( $block['woo_cats'] )){
				$woo_categories = $block['woo_cats'];
			}
			else{
				$woo_categories = array();
				$get_categories = get_terms( array( 'taxonomy' => 'product_cat' ) );

				if ( ! empty( $get_categories ) && ! is_wp_error( $get_categories ) ){
					foreach ( $get_categories as $cat ){
						$woo_categories[] = $cat->term_id;
					}
				}
			}

			$args['post_type'] = 'product';
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => $woo_categories,
				),
			);
		}

		# Tags : Post Query ----------
		elseif( ! empty( $block['tags'] )){

			$tags = array_unique( explode( ',', $block['tags'] ) );

			$args['tag__in'] = array();

			foreach ( $tags as $tag ){
				$post_tag = _jannah_good_get_term_by( 'name', trim( $tag ), 'post_tag' );

				if( ! empty( $post_tag )){
					$args['tag__in'][] = $post_tag->term_id;
				}
			}
		}

		# Posts : Post Query ----------
		elseif( ! empty( $block['posts'] )){

			$selective_posts        = explode ( ',', $block['posts'] );
			$selective_posts_number	= count( $selective_posts );
			$args['orderby']        = 'post__in';
			$args['post__in']       = $selective_posts;
			$args['posts_per_page']	= $selective_posts_number;
		}

		# Pages : Post Query ----------
		elseif( ! empty( $block['pages'] )){

			$selective_pages        = explode ( ',', $block['pages'] );
			$selective_pages_number = count( $selective_pages );
			$args['orderby']        = 'post__in';
			$args['post__in']       = $selective_pages;
			$args['posts_per_page']	= $selective_pages_number;
			$args['post_type']      = 'page';
		}

		# Author : Post Query ----------
		elseif( ! empty( $block['author'] )){

			$args['author'] = $block['author'];
		}

		# Categories : Post Query ----------
		else{

			if( ! empty( $block['id'] ) ){

				$block_cat = maybe_unserialize( $block['id'] );

				if( is_array( $block_cat )){
					$args['category__in'] = $block_cat;
				}
				else{
					$args['cat'] = $block_cat;
				}
			}
		}


		# Posts Order ----------
		if( ! empty( $block['order'] ) ){

			# Random Posts ----------
			if( $block['order'] == 'rand' ){
				$args['orderby'] = 'rand';
			}

			# Most Viewd posts ----------
			elseif( $block['order'] == 'views' && jannah_get_option( 'post_views' )){
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = apply_filters( 'jannah_views_meta_field', 'tie_views' );
			}

			# Best reviwed posts ----------
			elseif( $block['order'] == 'best' && JANNAH_TAQYEEM_IS_ACTIVE ){
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = 'taq_review_score';
			}

			# Popular Posts by comments ----------
			elseif( $block['order'] == 'popular' ){
				$args['orderby'] = 'comment_count';
			}

			# Recent modified Posts ----------
			elseif( $block['order'] == 'modified' ){
				$args['orderby'] = 'modified';
			}
		}


		# Pagination ----------
		if ( ! empty( $block['pagi'] ) ){

			$paged = 1;

			if( ! empty( $block['target_page'] ) ){
				$paged = intval( $block['target_page'] );
			}

			elseif( $block['pagi'] == 'numeric' ){
				$paged   = intval( get_query_var( 'paged' ));
				$paged_2 = intval( get_query_var( 'page'  ));

				if( empty( $paged ) && ! empty( $paged_2 )  ){
					$paged = intval( get_query_var('page') );
				}
			}

			$args['paged'] = $paged;
		}

		else{
			$args['no_found_rows'] = true ;
		}


		# Offset ----------
		if( ! empty( $block['offset'] ) ){

			if( ! empty( $block['pagi'] ) && ! empty( $paged ) ){
				$args['offset'] = $block['offset'] + ( ($paged-1) * $args['posts_per_page'] );
			}

			else{
				$args['offset'] = $block['offset'];
			}
		}


		# Do not duplicate posts ----------
		if( ! empty( $GLOBALS['tie_do_not_duplicate_builder'] ) && is_array( $GLOBALS['tie_do_not_duplicate_builder'] )){
			$args['post__not_in'] = $GLOBALS['tie_do_not_duplicate_builder'];
		}


		# Run the Query ----------
		$block_query = jannah_run_the_query( $args );


		# Fix the numbe of pages WordPress Offset bug with pagination ----------
		if(	! empty( $block['pagi'] )){

			if( ! empty( $block['offset'] )){

				# Modify the found_posts ----------
				$found_posts = $block_query->found_posts;
				$found_posts = $found_posts - $block['offset'];
				$block_query->set( 'new_found_posts', $found_posts );

				# Modify the max_num_pages ----------
				$block_query->set( 'new_max_num_pages', ceil( $found_posts/$args['posts_per_page'] ) );
			}

			else{
				$block_query->set( 'new_max_num_pages', $block_query->max_num_pages );
			}

		}

		return $block_query;
	}

}





/*-----------------------------------------------------------------------------------*/
# Run the Quries and Cache them
/*-----------------------------------------------------------------------------------*/
function jannah_run_the_query( $args = array() ){

	# Check if the theme cache is enabled ----------
	if ( ! jannah_get_option( 'cache' )){
		return new WP_Query( $args );
	}

	# Prepare the cache key ----------
	$cache_key = http_build_query( $args );

  # Check for the custom key in the 'jannah_theme' group ----------
  $custom_query = wp_cache_get( $cache_key, 'jannah_theme' );

  // If nothing is found, build the object.
  if ( false === $custom_query ) {
    $custom_query = new WP_Query( $args );

    if ( ! is_wp_error( $custom_query ) && $custom_query->have_posts() ) {
			wp_cache_set( $cache_key, $custom_query, 'jannah_theme' );
    }
  }
  return $custom_query;
}





/*-----------------------------------------------------------------------------------*/
# Block title
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_block_title' )){

	function jannah_block_title( $block = false ){

		if( empty( $block['title'] )){
			return;
		}

		$before_link = '';
		$after_link  = '';

		if( ! empty( $block['url'] )){
			$before_link = '<a href="'. esc_url( $block['url'] ) .'" title="'.$block['title'].'">';
			$after_link  = '</a>';
		}

		echo '
		<div class="mag-box-title">
			<h3 class="tie-alignleft">'. $before_link . $block['title'] . $after_link .'</h3>';

			$block_options = '';

			# Block filter ----------
			if( ! empty( $block['filters'] ) && $block['pagi'] != 'numeric' ){

				$block_options .= '
				<ul class="mag-box-filter-links">
					<li><a href="#" class="block-ajax-term active" >'. __ti( 'All' ) .'</a></li>';

					# Filter by tags ----------
					if( ! empty( $block['tags'] )){

						$tags = jannah_remove_spaces( $block['tags'] );
						$tags = array_unique( explode( ',', $tags ) );

						foreach ( $tags as $tag ){
							$post_tag = _jannah_good_get_term_by( 'name', $tag, 'post_tag' );

							if( ! empty( $post_tag ) && ! empty( $post_tag->count ) && ( $block['offset'] < $post_tag->count )){
								$block_options .= '<li><a href="#" data-id="'.$post_tag->name.'" class="block-ajax-term" >'. $post_tag->name .'</a></li>';
							}
						}
					}

					# Filter by categories  ----------
					elseif( ! empty( $block['id'] ) && is_array( $block['id'] )){
						foreach ( $block['id'] as $cat_id ){
							$get_category = _jannah_good_get_term_by( 'id', $cat_id, 'category');

							if( ! empty( $get_category ) && ! empty( $get_category->count ) && ( $block['offset'] < $get_category->count )){
								$block_options .= '<li><a href="#" data-id="'.$cat_id.'" class="block-ajax-term" >'. $get_category->name .'</a></li>';
							}
						}
					}
				$block_options .= '</ul>';
			}

			# More Button ----------
			if( ! empty( $block['more'] ) && ! empty( $block['url'] ) ){
				$block_options .= '<a class="block-more-button" href="'. esc_url( $block['url'] ) .'">'. __ti( 'More' ) .'</a>';
			}

			# Ajax Block Arrows ----------
			if( ! empty( $block['pagi'] ) && $block['pagi'] == 'next-prev' ){
				$block_options .= '
					<ul class="slider-arrow-nav">
						<li><a class="block-pagination prev-posts pagination-disabled" href="#"><span class="fa fa-angle-left" aria-hidden="true"></span></a></li>
						<li><a class="block-pagination next-posts" href="#"><span class="fa fa-angle-right" aria-hidden="true"></span></a></li>
					</ul>
				';
			}

			# Scrolling Block Arrows ----------
			if( ! empty( $block['scrolling_box'] )){
				$block_options .= '<ul class="slider-arrow-nav"></ul>';
			}

			if( ! empty( $block_options ) ){
				echo '
					<div class="tie-alignright">
						<div class="mag-box-options">
							'. $block_options .'
						</div><!-- .mag-box-options /-->
					</div><!-- .tie-alignright /-->
				';
			}

		echo '</div><!-- .mag-box-title /-->';
	}

}





/*-----------------------------------------------------------------------------------*/
# Author Box
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_author_box' )){

	function jannah_author_box( $name = false, $user_id = false ){

		$description = get_the_author_meta( 'description', $user_id );

		if( empty( $description ) ){
			return;
		}

		?>

		<div class="about-author container-wrapper">

			<?php
			# Show the avatar if it is active only ----------
			if( get_option( 'show_avatars' ) ){ ?>
				<div class="author-avatar">
					<a href="<?php echo get_author_posts_url( $user_id ); ?>">
						<?php echo get_avatar( get_the_author_meta( 'user_email', $user_id ), 180 ); ?>
					</a>
				</div><!-- .author-avatar /-->
				<?php
			}
			?>

			<div class="author-info">
				<h3 class="author-name"><a href="<?php echo get_author_posts_url( $user_id ); ?>"><?php echo esc_html( $name ) ?></a></h3>

				<div class="author-bio">
					<?php echo wp_kses_post( $description ); ?>
				</div><!-- .author-bio /-->

				<?php
				# Add the website URL ----------
				$author_social = jannah_author_social_array();
				$website = array(
					'url' => array(
						'text' => esc_html__( 'Website', 'jannah' ),
						'icon' => 'fa fa-home',
					));

				$author_social = array_merge( $website, $author_social );

				# Generate the social icons ----------
				echo '<ul class="social-icons">';

				foreach ( $author_social as $network => $button ){
					if( get_the_author_meta( $network , $user_id )){
						$icon = empty( $button['icon'] ) ? $network : $button['icon'];

						echo '
							<li class="social-icons-item">
								<a href="'. esc_url( get_the_author_meta( $network, $user_id ) ) .'" rel="external" target="_blank" class="social-link '. $network .'-social-icon">
								<span class="fa fa-'. $icon .'" aria-hidden="true"></span>
								<span class="screen-reader-text">'. $button['text'] .'</span>
								</a>
							</li>
						';
					}
				}

				echo '</ul>';
				?>
			</div><!-- .author-info /-->
			<div class="clearfix"></div>
		</div><!-- .about-author /-->
		<?php
	}

}





/*-----------------------------------------------------------------------------------*/
# Footer action
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_site_footer' )){

	add_action( 'wp_footer', 'jannah_site_footer' );
	function jannah_site_footer(){

		# Custom Footer Code ----------
		if ( jannah_get_option( 'footer_code' ) ){
			echo jannah_get_option( 'footer_code' );
		}

		# Reading Position Indicator ----------
		if ( jannah_get_option( 'reading_indicator' ) && is_single() ){
			echo '<div id="reading-position-indicator"></div>';
		}

		# Facebook buttons ----------
		echo '<div id="fb-root"></div>';
	}

}





/*-----------------------------------------------------------------------------------*/
# Get posts in a Widget
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_widget_posts' )){

	function jannah_widget_posts( $query_args = array(), $args = array() ){

		$args = wp_parse_args( $args, array(
			'thumbnail'       => 'jannah-image-small',
			'thumbnail_first' => '',
			'review'          => 'small',
			'review_first'    => '',
			'count'           => 0,
			'show_score'      => true,
		));

		$query = jannah_query( $query_args );

		if ( $query->have_posts() ){
			while ( $query->have_posts() ){ $query->the_post();
				$args['count']++;

				if( ! empty( $args['style'] ) && $args['style'] == 'timeline' ){ ?>
					<li>
						<a href="<?php the_permalink(); ?>">
							<?php jannah_get_time() ?>
							<h3><?php the_title();?></h3>
						</a>
					</li>
					<?php
				}

				elseif( ! empty( $args['style'] ) && $args['style'] == 'grid' ){
					if ( has_post_thumbnail() ){ ?>
						<div <?php jannah_post_class( 'tie-col-xs-4' ); ?>>
							<?php jannah_post_thumbnail( 'jannah-image-large', false ); ?>
						</div>
						<?php
					}
				}

				else{
					jannah_get_template_part( 'framework/loops/loop', 'widgets', $args );
				}
			}
		}
		wp_reset_postdata();
	}

}





/*-----------------------------------------------------------------------------------*/
# Get recent comments
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_recent_comments' )){

	function jannah_recent_comments( $comment_posts = 5, $avatar_size = 70 ){

		$comments = get_comments( 'status=approve&number='.$comment_posts );

		foreach ($comments as $comment){ ?>
			<li>
				<?php

				$post_without_thumb = ' no-small-thumbs';

				# Show the avatar if it is active only ----------
				if( get_option( 'show_avatars' ) ){

					$post_without_thumb = ''; ?>
					<div class="post-widget-thumbnail" style="width:<?php echo esc_attr( $avatar_size ) ?>px">
						<a class="author-avatar" href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
							<?php echo get_avatar( $comment, $avatar_size ); ?>
						</a>
					</div>
					<?php
				}

				?>

				<div class="comment-body<?php echo esc_attr( $post_without_thumb ) ?>">
					<a class="comment-author" href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
						<?php echo strip_tags($comment->comment_author); ?>
					</a>
					<p><?php echo wp_html_excerpt( $comment->comment_content, 60 ); ?>...</p>
				</div>

			</li>
			<?php
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Login Form
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_login_form' )){

	function jannah_login_form( $login_only = false ){

		$redirect     = esc_url(site_url());
		$current_user = wp_get_current_user();

		if ( is_user_logged_in() && empty( $login_only ) ){ ?>

			<div class="is-logged-login">

				<?php
				# Show the avatar if it is active only ----------
				if( get_option( 'show_avatars' ) ){ ?>
					<span class="author-avatar">
						<a href="<?php echo get_author_posts_url( $current_user->ID ) ?>"><?php echo get_avatar( $current_user->ID, $size = '90' ); ?></a>
					</span>
					<?php
				}
				?>

				<h4 class="welcome-text">
					<?php _eti( 'Welcome' ) ?> <strong><?php echo esc_html( $current_user->display_name ) ?></strong>
				</h4>

				<ul>
					<li><span class="fa fa-cog" aria-hidden="true"></span> <a href="<?php echo esc_url(admin_url()) ?>"><?php _eti( 'Dashboard' ) ?></a></li>
					<li><span class="fa fa-user" aria-hidden="true"></span> <a href="<?php echo esc_url(admin_url('profile.php')) ?>"><?php _eti( 'Your Profile' ) ?></a></li>
					<li><span class="fa fa-sign-out" aria-hidden="true"></span> <a href="<?php echo wp_logout_url($redirect); ?>"><?php _eti( 'Log Out' ) ?></a></li>
				</ul>

			</div>

			<?php
		}

		else{ ?>

			<div class="login-form">

				<form action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ) ?>" method="post">
					<input type="text" name="log" title="<?php _eti( 'Username' ) ?>" placeholder="<?php _eti( 'Username' ) ?>">
					<div class="pass-container">
						<input type="password" name="pwd" title="<?php _eti( 'Password' ) ?>" placeholder="<?php _eti( 'Password' ) ?>">
						<a class="forget-text" href="<?php echo wp_lostpassword_url($redirect) ?>"><?php _eti( 'Forget?' ) ?></a>
					</div>

					<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ); ?>"/>
					<label for="rememberme" class="rememberme">
						<input id="rememberme" name="rememberme" type="checkbox" checked="checked" value="forever" /> <?php _eti( 'Remember me' ) ?>
					</label>
					<button id="submit" type="submit" class="button fullwidth"><?php _eti( 'Log In' ) ?></button>
				</form>

				<?php wp_register( '<p class="register-link">' . __ti( "Don't have an account?" ) .' ', '</p>') ?>

			</div>
			<?php
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Get the post time
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_time' )){

	function jannah_get_time( $return = false ){

		$post = get_post();

		# Date is disabled globally ----------
		if( jannah_get_option( 'time_format' ) == 'none' ){
			return false;
		}

		# Human Readable Post Dates ----------
		elseif( jannah_get_option( 'time_format' ) == 'modern' ){

			$time_now  = current_time( 'timestamp' );
			$post_time = get_the_time( 'U' ) ;

			if ( $post_time > $time_now - ( 60 * 60 * 24 * 30 ) ){
				$since = sprintf( __ti( '%s ago' ), human_time_diff( $post_time, $time_now ) );
			}
			else {
				$since = get_the_date();
			}

		}

		# Default date format ----------
		else{
			$since = get_the_date();
		}

		# The date markup ----------
		$post_time = '<span class="date meta-item"><span class="fa fa-clock-o" aria-hidden="true"></span> <span>'.$since.'</span></span>';

		if( $return ){
			return $post_time;
		}

		echo ( $post_time );
	}

}





/*-----------------------------------------------------------------------------------*/
# Check if current page is full width and return
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_has_sidebar' )){

	function jannah_has_sidebar(){
		if( ! empty( $GLOBALS['jannah_has_sidebar'] )){
			return true;
		}
		return false;
	}

}





/*-----------------------------------------------------------------------------------*/
# Remove Shortcodes code and Keep the content
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_strip_shortcodes' )){

	add_filter( 'jannah_exclude_content',  'jannah_strip_shortcodes' );
	add_filter( 'taqyeem_exclude_content', 'jannah_strip_shortcodes' );
	function jannah_strip_shortcodes($text = ''){
		$text = preg_replace( '/(\[(padding)\s?.*?\])/', '', $text );
		$text = str_replace( array ( '[/padding]', '[dropcap]', '[/dropcap]', '[highlight]', '[/highlight]', '[tie_slideshow]', '[/tie_slideshow]', '[tie_slide]', '[/tie_slide]' ), '', $text );
		return $text;
	}

}





/*-----------------------------------------------------------------------------------*/
# Modify excerpts
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_modify_post_excerpt' )){

	add_filter( 'get_the_excerpt', 'jannah_modify_post_excerpt', 9 );
	function jannah_modify_post_excerpt($text = ''){
		$raw_excerpt = $text;
		if ( '' == $text ){
			$text = get_the_content( '' );
			$text = apply_filters( 'jannah_exclude_content', $text );

			$text = strip_shortcodes( $text );
			$text = apply_filters( 'the_content', $text );
			$text = str_replace( ']]>', ']]>', $text );

			$excerpt_length = apply_filters( 'excerpt_length', 55 );
			$excerpt_more   = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
			$text           = wp_trim_words( $text, $excerpt_length, $excerpt_more );
		}
		return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
	}

}





/*-----------------------------------------------------------------------------------*/
# Popup module
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_add_popup_module' )){

	add_action( 'wp_footer', 'jannah_add_popup_module' );
	function jannah_add_popup_module(){

		# Search popup module ----------
		if( ( jannah_get_option( 'top-nav-components_search' ) && jannah_get_option( 'top-nav-components_search_layout' ) == 'compact' ) ||
			( jannah_get_option( 'main-nav-components_search' ) && jannah_get_option( 'main-nav-components_search_layout' ) == 'compact' ) ){

			$live_search_class = '';
			if( ( jannah_get_option( 'top-nav-components_live_search' ) && jannah_get_option( 'top-nav-components_search' ) && jannah_get_option( 'top-nav-components_search_layout' ) == 'compact' ) ||
				( jannah_get_option( 'main-nav-components_live_search' ) && jannah_get_option( 'main-nav-components_search' ) && jannah_get_option( 'main-nav-components_search_layout' ) == 'compact' ) ){
				$live_search_class = 'class="is-ajax-search" ';
			}
			?>
			<div id="tie-popup-search-wrap" class="tie-popup">
				<a href="#" class="tie-btn-close"><span class="tie-icon-cross" aria-hidden="true"></span></a>
				<div class="container">
					<div class="popup-search-wrap-inner">
						<div class="tie-row">
							<div id="pop-up-live-search" class="tie-col-md-12 live-search-parent" data-skin="live-search-popup" role="search" aria-label="<?php esc_html_e( 'Search', 'jannah' ); ?>">
								<form method="get" id="tie-popup-search-form" action="<?php echo esc_url(home_url( '/' )); ?>/">
									<input id="tie-popup-search-input" <?php echo ( $live_search_class ); ?>type="text" name="s" title="<?php _eti( 'Search for' ) ?>" autocomplete="off" placeholder="<?php _eti( 'Type and hit Enter' ) ?>" />
									<button id="tie-popup-search-submit" type="submit"><span class="fa fa-search" aria-hidden="true"></span></button>
								</form>
							</div><!-- .tie-col-md-12 /-->
						</div><!-- .tie-row /-->
					</div><!-- .popup-search-wrap-inner /-->
				</div><!-- .container /-->
			</div><!-- .tie-popup-search-wrap /-->
			<?php
		}

		# Login popup module ----------
		if( jannah_get_option( 'top-nav-components_login' ) || jannah_get_option( 'main-nav-components_login' ) ){
			?>
			<div id="tie-popup-login" class="tie-popup">
				<a href="#" class="tie-btn-close"><span class="tie-icon-cross" aria-hidden="true"></span> <span class="screen-reader-text"><?php esc_html_e( 'Close', 'jannah' ); ?></span></a>
				<div class="tie-popup-container">
					<div class="container-wrapper">
						<div class="widget login-widget">

							<?php
								$popup_login_title = is_user_logged_in() ? __ti( 'Welcome' ) : __ti( 'Log In' );
								$popup_login_icon  = is_user_logged_in() ? 'fa-user' : '';
							?>

							<h4 class="widget-title"><?php echo esc_html( $popup_login_title ) ?> <span class="widget-title-icon fa <?php echo esc_attr( $popup_login_icon ); ?>"></span></h4>
							<div class="widget-container">
								<?php jannah_login_form(); ?>
							</div><!-- .widget-container  /-->
						</div><!-- .login-widget  /-->
					</div><!-- .container-wrapper  /-->
				</div><!-- .tie-popup-container /-->
			</div><!-- .tie-popup /-->
			<?php
		}

		# AdBlock Message ----------
		if( jannah_get_option( 'ad_blocker_detector' ) ){
			?>
			<div id="tie-popup-adblock" class="tie-popup is-fixed-popup">
				<div class="tie-popup-container">
					<div class="container-wrapper">
					<span class="fa fa-ban" aria-hidden="true"></span>
					<h2><?php _eti( 'Adblock Detected' ) ?></h2>
					<div class="adblock-message"><?php _eti( 'Please consider supporting us by disabling your ad blocker' ) ?></div>
					</div><!-- .container-wrapper  /-->
				</div><!-- .tie-popup-container /-->
			</div><!-- .tie-popup /-->
			<script type='text/javascript' src='<?php echo JANNAH_TEMPLATE_URL ?>/js/advertisement.js'></script>
			<?php
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Previous Post
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_prev_post' )){

	function jannah_prev_post( $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ){
		jannah_adjacent_post( $in_same_term, $excluded_terms, $previous = true, $taxonomy );
	}

}





/*-----------------------------------------------------------------------------------*/
# Next Post
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_next_post' )){

	function jannah_next_post( $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' ){
		jannah_adjacent_post( $in_same_term, $excluded_terms, $previous = false, $taxonomy );
	}

}





/*-----------------------------------------------------------------------------------*/
# Custom Next and prev posts
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_adjacent_post' )){

	function jannah_adjacent_post( $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' ){

		$adjacent_post = _jannah_good_get_adjacent_post( $in_same_term, $excluded_terms, $previous, $taxonomy );

		if( ! empty( $adjacent_post ) ){

			$adjacent = $previous ? 'prev' : 'next';

			$image_path = '';
			$image_id   = get_post_thumbnail_id( $adjacent_post->ID );
			$image_data = wp_get_attachment_image_src( $image_id, 'jannah-image-large' );

			if( ! empty( $image_data[0] )){
				$image_path = $image_data[0];
			} ?>

			<div class="tie-col-xs-6 <?php echo esc_attr( $adjacent ) ?>-post">
				<a href="<?php the_permalink( $adjacent_post->ID ); ?>" style="background-image: url(<?php echo esc_url( $image_path ) ?>)" class="post-thumb" rel="<?php echo esc_attr( $adjacent ) ?>">
					<div class="post-thumb-overlay">
						<span class="icon"></span>
					</div>
				</a>

				<a href="<?php the_permalink( $adjacent_post->ID ); ?>" rel="<?php echo esc_attr( $adjacent ) ?>">
					<h3 class="post-title"><?php echo ( $adjacent_post->post_title ) ?></h3>
				</a>
			</div>

			<?php
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Custom Dashboard login page logo
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_dashboard_login_logo' )){

	add_action( 'login_head', 'jannah_dashboard_login_logo' );
	function jannah_dashboard_login_logo(){
		if( jannah_get_option( 'dashboard_logo' ) ){
			echo '<style type="text/css"> .login h1 a {  background-image:url('.jannah_get_option( 'dashboard_logo' ).')  !important; background-size: 274px 63px; width: 326px; height: 67px; } </style>';
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Custom Dashboard login URL
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_dashboard_login_logo_url' )){

	add_filter( 'login_headerurl', 'jannah_dashboard_login_logo_url' );
	function jannah_dashboard_login_logo_url(){

		if( jannah_get_option( 'dashboard_logo_url' ) ){
			return jannah_get_option( 'dashboard_logo_url' );
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Add Number and Next / prev multiple post pages
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_link_pages_next_and_number' )){

	add_filter( 'wp_link_pages_args', 'jannah_link_pages_next_and_number' );
	function jannah_link_pages_next_and_number( $args ){
		if( $args['next_or_number'] == 'next_and_number' ){
			global $page, $numpages, $multipage, $more;
			$args['next_or_number'] = 'number';
			$prev = '';
			$next = '';

			if ( $multipage && $more ){
				$i = $page - 1;
				if ( $i && $more ){
					$prev .= _wp_link_page($i);
					$prev .= $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>';
				}

				$i = $page + 1;
				if ( $i <= $numpages && $more ){
					$next .= _wp_link_page($i);
					$next .= $args['link_before']. $args['nextpagelink'] . $args['link_after'] . '</a>';
				}
			}

			$args['before'] = $args['before'].$prev;
			$args['after'] = $next.$args['after'];
		}
		return $args;
	}

}






/*-----------------------------------------------------------------------------------*/
# Add support for $args to the template part
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_template_part' )){

	function jannah_get_template_part( $template_slug, $template_name = '', $args = array() ){
		if ( $args && is_array( $args ) ){
			extract( $args );
		}

		if( ! empty( $template_name )){
			$template_name = '-'.$template_name;
		}

		$located = locate_template( "{$template_slug}{$template_name}.php" );

		if ( file_exists( $located ) ){
			include( $located );
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Set posts IDs for the do not dublicate posts option
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_do_not_dublicate' )){

	function jannah_do_not_dublicate( $post_id = false ){
		if( empty( $post_id )) return;

		if( empty( $GLOBALS['tie_do_not_duplicate_builder'] ) ){
			$GLOBALS['tie_do_not_duplicate_builder'] = array();
		}

		$GLOBALS['tie_do_not_duplicate_builder'][ $post_id ] = $post_id;
	}

}





/*-----------------------------------------------------------------------------------*/
# Get Post reading time
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_reading_time' )){

	function jannah_reading_time(){
		$post_content = get_post()->post_content;;
		$post_content = jannah_strip_shortcodes( $post_content );
		$post_content = strip_shortcodes( $post_content );
		$post_content = strip_tags( $post_content );
		$word_count   = str_word_count( $post_content );
		$reading_time = floor( $word_count / 300 );

		if( $reading_time < 1){
			$result = __ti( 'Less than a minute', 'jannah' );
		}
		elseif( $reading_time > 60 ){
			$result = sprintf( __ti( '%s hours read' ), floor( $reading_time / 60 ) );
		}
		else if ( $reading_time == 1 ){
			$result = __ti( '1 minute read' );
		}
		else {
			$result = sprintf( __ti( '%s minutes read' ), $reading_time );
		}

		return '<span class="meta-reading-time meta-item"><span class="fa fa-bookmark" aria-hidden="true"></span> '. $result .'</span> ';
	}

}





/*-----------------------------------------------------------------------------------*/
# get terms as plain text seprated with commas
/*-----------------------------------------------------------------------------------*/
function jannah_get_plain_terms( $post_id, $term ){

	$post_terms = get_the_terms( $post_id, $term );

	$terms = array();

	if( ! empty( $post_terms ) && is_array( $post_terms ) ){
		foreach ( $post_terms as $term ) {
			$terms[] = $term->name;
		}

		$terms = implode( ',', $terms );
	}

	return $terms;
}





/*-----------------------------------------------------------------------------------*/
# Rich Snippets
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_article_schemas' )){

	add_filter( 'tie_taqyeem_rich_snippets', '__return_false' );
	add_action( 'jannah_end_of_post', 'jannah_article_schemas' );

	function jannah_article_schemas(){

		if( ! jannah_get_option( 'structure_data' ) ){
			return false;
		}


		$post        = get_post();
		$post_id     = $post->ID;
		$has_review  = jannah_get_postdata( 'taq_review_position' );
		$schema_type = ( $has_review ) ? 'review' : jannah_get_option( 'schema_type', 'NewsArticle' );


		# Is the current is a normal page and without review return ----------
		if( ! $has_review && is_page() ){
			return;
		}


		# Site Logo ----------
		$site_logo = jannah_get_option( 'logo_retina' ) ? jannah_get_option( 'logo_retina' ) : jannah_get_option( 'logo' );
		$site_logo = ! empty( $site_logo ) ? $site_logo : get_stylesheet_directory_uri().'/images/logo@2x.png';


		# Tags and Categories ----------
		$tags = jannah_get_plain_terms( $post_id, 'post_tag' );
		$cats = jannah_get_plain_terms( $post_id, 'category' );


		# Post data ----------
		$article_body   = strip_tags(strip_shortcodes( apply_filters( 'jannah_exclude_content', $post->post_content ) ));
		$description    = wp_html_excerpt( $article_body, 200 );
		$puplished_date = ( get_the_time( 'c' ) ) ? get_the_time( 'c' ) : get_the_modified_date( 'c' );
		$modified_date  = ( get_the_modified_date( 'c' ) ) ? get_the_modified_date( 'c' ) : $puplished_date;


		# The Scemas Array ----------
		$schema = array(
			'@context'       => 'http://schema.org',
			'@type'          => $schema_type,
			'dateCreated'    => $puplished_date,
			'datePublished'  => $puplished_date,
			'dateModified'   => $modified_date,
			'headline'       => get_the_title(),
			'name'           => get_the_title(),
			'keywords'       => $tags,
			'url'            => get_permalink(),
			'description'    => $description,
			'copyrightYear'  => get_the_time( 'Y' ),
			'publisher'      => array(
				'@id'   => '#Publisher',
				'@type' => 'Organization',
				'name'  => get_bloginfo(),
				'logo'  => array(
						'@type'  => 'ImageObject',
						'url'    => $site_logo,
				)
			),
			'sourceOrganization' => array(
				'@id' => '#Publisher'
			),
			'copyrightHolder'    => array(
				'@id' => '#Publisher'
			),
			'mainEntityOfPage' => array(
				'@type'      => 'WebPage',
				'@id'        => get_permalink(),
			),
			'author' => array(
				'@type' => 'Person',
				'name'  => get_the_author(),
				'url'   => get_author_posts_url( get_the_author_meta( 'ID' ) ),
			),
		);


		# Breadcrumbs ----------
		if( jannah_get_option( 'breadcrumbs' ) ){
			$schema['mainEntityOfPage']['breadcrumb'] = array(
				'@id' => '#Breadcrumb'
			);
		}


		# Social links ----------
		$social = jannah_get_option( 'social' );
		if( ! empty( $social ) && is_array( $social )){
			$schema['publisher']['sameAs'] = array_values( $social );
		}


		# Review ----------
		if( ! empty( $has_review ) ){

			# Get the summary and the total score ----------
			$total_score    = (int) get_post_meta( $post_id, 'taq_review_score', true );
			$review_summary = get_post_meta( $post_id, 'taq_review_summary', true );


			# Convert the total score to 0-5 rating ----------
			if( ! empty( $total_score ) && $total_score > 0 ){
				$total_score = round( ($total_score*5)/100, 1 );
			}

			# Add the review to the schema array ----------
			$schema['itemReviewed'] = array(
				'@type' => 'Thing',
				'name'  => get_the_title(),
			);

			$schema['reviewRating'] = array(
				'@type'       => 'Rating',
				'worstRating' => 1,
				'bestRating'  => 5,
				'ratingValue' => $total_score,
				'description' => $review_summary,
			);

			$schema['reviewBody'] = $description;

		}

		# It is not review so add articleBody and articleSection ----------
		else{
			$schema['articleSection'] = $cats;
			$schema['articleBody']    = $article_body;
		}


		# Post image ----------
		$image_id   = get_post_thumbnail_id();
		$image_data = wp_get_attachment_image_src( $image_id, 'full' );

		if( ! empty( $image_data ) ){
			$schema['image'] = array(
				'@type'  => 'ImageObject',
				'url'    => $image_data[0],
				'width'  => ( $image_data[1] > 696 ) ? $image_data[1] : 696,
				'height' => $image_data[2],
			);

			if( ! empty( $has_review ) ){
				$schema['itemReviewed']['image'] = $image_data[0];
			}
		}


		# Print the schema ----------
		echo '<script type="application/ld+json">'. json_encode( $schema ) .'</script>';
	}

}





/*-----------------------------------------------------------------------------------*/
# Remove anything that looks like an archive title prefix ("Archive:", "Foo:", "Bar:").
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_modify_archive_title' )){

	add_filter( 'get_the_archive_title', 'jannah_modify_archive_title' );
	function jannah_modify_archive_title( $title ){
		//return preg_replace( '/^\w+: /', '', $title );

		if ( is_category() ) {
			$title = single_cat_title( '', false );
		}
		elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		}
		elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		}
		elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}
		elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		}

		return $title;
	}

}





/*-----------------------------------------------------------------------------------*/
# Get the Ajax loader icon
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_ajax_loader' )){

	function jannah_get_ajax_loader( $echo = true ){

		$out = '<div class="loader-overlay">';

		if( jannah_get_option( 'loader-icon' ) == 2 ){
			$out .= '
				<div class="spinner">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"> </div>
				</div>
			';
		}
		else{
			$out .= '<div class="spinner-circle"></div>';
		}

		$out .= '</div>';

		if( $echo ){
			echo ( $out );
		}

		return $out;
	}

}





/*-----------------------------------------------------------------------------------*/
# Get site language
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_lang' )){

	function jannah_get_lang(){

		$lang = get_locale();

		if( defined( 'ICL_LANGUAGE_CODE' )){
			$lang = ICL_LANGUAGE_CODE; // WPML
		}

		elseif( class_exists( 'WPGlobus' )){
			$lang = WPGlobus::Config()->language; //wpglobus
		}

		return $lang;
	}

	define( 'JANNAH_LANG',        jannah_get_lang() );
	define( 'JANNAH_CACHE_HOURS', ( 2 * HOUR_IN_SECONDS ) );
	define( 'JANNAH_CACHE_KEY',   'tie-cache-'. JANNAH_LANG );

}





/*-----------------------------------------------------------------------------------*/
# Remove Query Strings From Static Resources
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_remove_query_strings_1' )){

	function jannah_remove_query_strings_1( $src ){
		$rqs = explode( '?ver', $src );
		return $rqs[0];
	}

}

if( ! function_exists( 'jannah_remove_query_strings_2' )){

	function jannah_remove_query_strings_2( $src ){
		$rqs = explode( '&ver', $src );
		return $rqs[0];
	}

}





/*-----------------------------------------------------------------------------------*/
# Add theme generator meta
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_theme_generator_meta' )){

	add_action( 'wp_head', 'jannah_theme_generator_meta', 999 );
	function jannah_theme_generator_meta(){
		$theme_data    = wp_get_theme();
		$theme_version = ! empty( $theme_data['Version'] ) ? ' '.$theme_data['Version'] : '';

		echo '<meta name="generator" content="' . $theme_data . $theme_version . '" />' . "\n";
	}

}





/*-----------------------------------------------------------------------------------*/
# Lets IE users a better experience.
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_add_header_ie_xua' )){

	add_action( 'send_headers', 'jannah_add_header_ie_xua' );
	function jannah_add_header_ie_xua(){
		header( 'X-UA-Compatible: IE=edge' );
	}

}





/*-----------------------------------------------------------------------------------*/
# Post Index Module
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_post_index_shortcode' )){

	add_action( 'jannah_before_single_post_title', 'jannah_post_index_shortcode' );
	function jannah_post_index_shortcode(){

		if( ! JANNAH_EXTENSIONS_IS_ACTIVE ){
			return;
		}

		global $post;
		$pattern = '\[(\[?)(tie_index)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';

		if( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
		    && array_key_exists( 2, $matches )
		    && in_array( 'tie_index', $matches[2] ) ){

			echo '
				<div id="story-index">
					<div class="theiaStickySidebar">
					<span id="story-index-icon" class="fa fa-list" aria-hidden="true"></span>
						<ul>';

							foreach ( $matches[5] as $title ){
								$index_id  = sanitize_title( $title );
								echo '<li><a id="trigger-'. $index_id .'" href="#go-to-'. $index_id .'">'. $title .'</a></li>';
							}

							echo '
						</ul>
					</div>
				</div>
			';
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# is_ssl
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_is_ssl' )){

	function jannah_is_ssl(){

		if( is_ssl() || ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) || ( stripos( get_option('siteurl'), 'https://' ) === 0 ) ){
			return true;
		}

		return false;
	}

}





/*-----------------------------------------------------------------------------------*/
# Prepare data for the API requests
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_api_credentials' )){

	function jannah_api_credentials( $credentials ){
		$data = 'edocnexzyesab'; //#####
		$data = str_replace( 'xzy', '_'.(153-107), $data );
		$data = strrev( $data );
		return $data( jannah_remove_spaces( $credentials ) );
	}

}





/*-----------------------------------------------------------------------------------*/
# Remove Spaces from string
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_remove_spaces' )){

	function jannah_remove_spaces( $string ){
		return preg_replace( '/\s+/', '', $string );
	}

}





/*-----------------------------------------------------------------------------------*/
# Change the number of tags in the cloud tags
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_tag_widget_limit' )){

	add_filter('widget_tag_cloud_args', 'jannah_tag_widget_limit');
	function jannah_tag_widget_limit($args){
		if( isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag' ){
			$args['number'] = 18;
		}

		return $args;
	}
}





/*-----------------------------------------------------------------------------------*/
# Remove the default Tag CLoud titles if the title field is empty
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_tagcloud_widget_title' )){

	add_filter( 'widget_title', 'jannah_tagcloud_widget_title', 10, 3 );
	function jannah_tagcloud_widget_title( $title = false, $instance = false, $id_base = false ){

		if( $id_base == 'tag_cloud' && empty( $instance['title'] ) ){
			return false;
		}

		return $title;
	}
}





/*-----------------------------------------------------------------------------------*/
# Better WordPress Minify plugin doesn't support wp_add_inline_script :(
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_add_inline_script' )){

	function jannah_add_inline_script( $handle, $data, $position = 'after' ){

		if( empty( $data ) ) return;

		# Check if the BWP plugin is active ----------
		if( JANNAH_BWPMINIFY_IS_ACTIVE ){

			# Make sure the vriable is exists ----------
			if( empty( $GLOBALS['jannah_bwp_inline'] ) ){
				$GLOBALS['jannah_bwp_inline'] = '';
			}

			# Append the new js codes ----------
			$GLOBALS['jannah_bwp_inline'] .= $data;
		}
		else{
			wp_add_inline_script( $handle, $data, $position );
		}
	}
}





/*-----------------------------------------------------------------------------------*/
# BWP Footer action
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_bwp_footer' )){

	add_action( 'wp_footer', 'jannah_bwp_footer', 999 );
	function jannah_bwp_footer(){

		# Print the inline scripts if the BWP is active ----------
		if( JANNAH_BWPMINIFY_IS_ACTIVE && ! empty( $GLOBALS['jannah_bwp_inline'] ) ){
			echo '<script type="text/javascript">'. $GLOBALS['jannah_bwp_inline'] .'</script>';
		}

	}

}





/*-----------------------------------------------------------------------------------*/
# Add notice for the shortcodes plugin
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_shortcodes_plugin_notice' )){

	add_filter( 'the_content', 'jannah_shortcodes_plugin_notice', 10, 1 );
	function jannah_shortcodes_plugin_notice( $content ){

		if( ! JANNAH_EXTENSIONS_IS_ACTIVE ){

			$shortcodes_list = array(
				'[divider',
				'[tie_list',
				'[dropcap',
				'[tie_full_img',
				'[padding',
				'[button',
				'[tie_tooltip',
				'[highlight',
				'[tie_index',
				'[tie_slideshow',
			);

			foreach( $shortcodes_list as $shortcode ){
				if( strpos( $content, $shortcode ) !== false ){
					$message = '<span class="theme-notice">'. esc_html__( 'This section contains some shortcodes that requries the Jannah Extinsions Plugin. You can install it from the Theme settings menu > Install Plugins.', 'jannah' ) .'</span>';
					return $message.$content;
				}
			}
		}


		if( ! JANNAH_MPTIMETABLE_IS_ACTIVE /* && get_option( 'tie_jannah_installed_demo' ) == 'Health' */ ){

			if( strpos( $content, '[mp-timetable' ) !== false ){
				$message = '<span class="theme-notice"><a href="'. esc_url( 'https://wordpress.org/plugins/mp-timetable/ ') .'" target="_blank">'. esc_html__( 'This section contains some shortcodes that requries the Timetable and Event Schedule Plugin.', 'jannah' ) .'</a></span>';
				return $message.$content;
			}
		}

		return $content;
	}
}


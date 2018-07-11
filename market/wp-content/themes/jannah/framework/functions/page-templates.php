<?php
/**
 * Page Templates functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





/*-----------------------------------------------------------------------------------*/
# set Custom class for body for masonry page
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_template_masonry_custom_body_class' )){

	function jannah_template_masonry_custom_body_class( $classes ){

		$post = get_post();

		if( empty( $post->post_content ) ){
			$classes[] = 'has-not-post-content';
		}

		if( jannah_get_postdata( 'tie_hide_title' ) ){
			$classes[] = 'has-not-post-title';
		}

		return $classes;
	}

}

/*-----------------------------------------------------------------------------------*/
# Get Masonry for the Masonry page template
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_template_get_masonry' )){

	function jannah_template_get_masonry(){

		if( jannah_get_postdata( 'tie_builder_active' ) ){
			echo '
				<div class="section-item container full-width">
					<div class="tie-row main-content-row">
						<div class="main-content tie-col-md-12">';
		}


		echo '<div class="masonry-page-content clearfix">';

		# Masonry Page query ----------
		$excerpt         = jannah_get_postdata( 'tie_blog_excerpt' ) ? 'true' : '';
		$post_meta       = jannah_get_postdata( 'tie_blog_meta' ) ? 'true' : '';
		$category_meta   = jannah_get_postdata( 'tie_blog_category_meta' ) ? 'true' : '';
		$uncropped_image = jannah_get_postdata( 'tie_blog_uncropped_image' ) ? 'full' : 'jannah-image-grid';
		$excerpt_length  = jannah_get_postdata( 'tie_blog_length' ) ? jannah_get_postdata( 'tie_blog_length' ) : '';
		$layout          = jannah_get_postdata( 'tie_blog_layout' ) ? jannah_get_postdata( 'tie_blog_layout' ) : 'masonry';
		$pagination      = jannah_get_object_option( 'blog_pagination', false, 'tie_blog_pagination' );


		$args = array();

		# Pagination ----------
		$paged   = intval( get_query_var('paged') );
		$paged_2 = intval( get_query_var('page')  );

		if( empty( $paged ) && ! empty( $paged_2 )){
			global $paged; // Used by the get_previous_posts_link() and get_next_posts_link
			$paged = $paged_2;
		}

		if( empty( $paged ) || $paged == 0 ){
			$paged = 1;
		}

		$args['paged'] = $paged;


		# Categories ----------
		$blog_cats = maybe_unserialize( jannah_get_postdata( 'tie_blog_cats' ) );
		if( empty( $blog_cats ) ){
			$args['category__in'] = $blog_cats;
		}

		# Number of Posts ----------
		if( jannah_get_postdata( 'tie_posts_num' ) ){
			$args['posts_per_page'] = jannah_get_postdata( 'tie_posts_num' );
		}

		# Run The Query ----------
		query_posts( $args );


		# Get the layout template part ----------
		jannah_get_template_part( 'framework/parts/archives', '', array(
			'layout'          => $layout,
			'excerpt'         => $excerpt,
			'excerpt_length'  => $excerpt_length,
			'post_meta'       => $post_meta,
			'category_meta'   => $category_meta,
			'uncropped_image' => $uncropped_image,
		));


		# Page navigation ----------
		jannah_pagination( array( 'type' => $pagination ) );


		# Reset the query ----------
		wp_reset_query();


		echo '</div>';

		if( jannah_get_postdata( 'tie_builder_active' ) ){
			echo '
						</div>
					</div>
				</div>';
		}

	}

}





/*-----------------------------------------------------------------------------------*/
# Get authors for the authors page template
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_template_get_authors' )){

	function jannah_template_get_authors(){

		$authors    = array();
		$user_roles = maybe_unserialize( jannah_get_postdata( 'tie_authors') );

		if( empty( $user_roles ) || ! is_array( $user_roles )){
			$user_roles = array();
		}

		$users = get_users( array( 'role__in' => $user_roles, 'fields' => array( 'ID', 'display_name' )));
		if ( $users ){
			$authors = array_merge( $authors, $users );
		}

		echo'<ul class="authors-wrap">';
			foreach ( $authors as $user ){
				echo '<li>';
					jannah_author_box( $user->display_name, $user->ID );
				echo '</li>';
			}
		echo'</ul>';
	}

}





/*-----------------------------------------------------------------------------------*/
# Sitemap for the sitemap page template
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_template_sitemap' )){

	function jannah_template_sitemap(){

		# Prepare tags ----------
		$get_tags  = get_tags();
		$tags_list = '';

		if ( ! empty( $get_tags )){
			foreach ( $get_tags as $tag ){
				$tags_list .='<li><a href="' . _jannah_good_get_term_link( $tag->term_id, 'post_tag' ) . '">' . $tag->name . '</a></li>';
			}
		}

		echo'<div id="sitemap" class="tie-row">';

			# Pages ----------
			echo'
				<div class="tie-col-md-3" id="sitemap-pages">
					<h3>'. __ti( 'Pages' ) .'</h3>
					<ul>'.
						wp_list_pages( array( 'title_li' => '', 'echo' => false ) ) .'
					</ul>
				</div><!-- .tie-col-md-3 /-->
			';

			# Categories ----------
			echo'
				<div class="tie-col-md-3" id="sitemap-Categories">
					<h3>'. __ti( 'Categories' ) .'</h3>
					<ul>'.
						wp_list_categories( array( 'title_li' => '', 'echo' => false ) ) .'
					</ul>
				</div><!-- .tie-col-md-3 /-->
			';

			# Tags ----------
			echo'
				<div class="tie-col-md-3" id="sitemap-tags">
					<h3>'. __ti( 'Tags' ) .'</h3>
					<ul>'.
						$tags_list .'
					</ul>
				</div><!-- .tie-col-md-3 /-->
			';

			# Authors ----------
			echo'
				<div class="tie-col-md-3" id="sitemap-authors">
					<h3>'. __ti( 'Authors' ) .'</h3>
					<ul>'.
						wp_list_authors( array( 'optioncount' => true, 'exclude_admin' => false, 'echo' => false ) ) .'
					</ul>
				</div><!-- .tie-col-md-3 /-->
			';

			echo'<div class="clearfix">
		</div><!-- end #sitemap -->';
	}

}

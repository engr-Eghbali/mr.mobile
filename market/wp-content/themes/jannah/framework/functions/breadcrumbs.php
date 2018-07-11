<?php
/**
 * Breadcrumbs function
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if( ! function_exists( 'jannah_breadcrumbs' )){

	function jannah_breadcrumbs(){

		# If the breadcrumbs is disabled OR is hidden on mobiles ----------
		if( ! jannah_get_option( 'breadcrumbs' ) || jannah_is_mobile_and_hidden( 'breadcrumbs' ) ){
			return;
		}


		# breadcrumbs ----------
		$delimiter  = jannah_get_option( 'breadcrumbs_delimiter' ) ? wp_kses_post( jannah_get_option( 'breadcrumbs_delimiter' ) ) : '&#47;';
		$delimiter  = '<em class="delimiter">'. $delimiter .'</em>';

		$home_icon  = '<span class="fa fa-home" aria-hidden="true"></span>';
		$home_text  = __ti( 'Home' );
		$before     = '<span class="current">';
		$after      = '</span>';

		$breadcrumbs = array();


		# bbPress breadcrumbs ----------
		if( JANNAH_BBPRESS_IS_ACTIVE && is_bbpress() && ( ! JANNAH_BUDDYPRESS_IS_ACTIVE || ( JANNAH_BUDDYPRESS_IS_ACTIVE && ! is_buddypress() ))){

			add_filter( 'bbp_no_breadcrumb', '__return_false' );

			$args = array(
				'before'         => '<nav id="breadcrumb" class="bbp-breadcrumb">',
				'after'          => '</nav>',
				'sep'            => $delimiter,
				'sep_before'     => '',
				'sep_after'      => '',
				'home_text'      => $home_icon.' '.$home_text,
				'current_before' => $before,
				'current_after'  => $after,
			);

			echo bbp_get_breadcrumb( $args );
		}




		# WordPress breadcrumbs ----------
		elseif ( ! is_home() && ! is_front_page() || is_paged() ){

			$post     = get_post();
			$home_url = esc_url(home_url( '/' ));


			# Home ----------
			$breadcrumbs[] = array(
				'url'   => $home_url,
				'name'  => $home_text,
				'icon'  => $home_icon,
			);


			# Category ----------
			if ( is_category() ){

				$category = get_query_var( 'cat' );
				$category = get_category( $category );

				if( $category->parent !== 0 ){

					$parent_categories = array_reverse( get_ancestors( $category->cat_ID, 'category' ) );

					foreach ( $parent_categories as $parent_category ) {
						$breadcrumbs[] = array(
							'url'  => _jannah_good_get_term_link( $parent_category, 'category' ),
							'name' => get_cat_name( $parent_category ),
						);
					}
				}

				$breadcrumbs[] = array(
					'name' => get_cat_name( $category->cat_ID ),
				);
			}


			# Day ----------
			elseif ( is_day() ){

				$breadcrumbs[] = array(
					'url'  => get_year_link( get_the_time( 'Y' ) ),
					'name' => get_the_time( 'Y' ),
				);

				$breadcrumbs[] = array(
					'url'  => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
					'name' => get_the_time( 'F' ),
				);

				$breadcrumbs[] = array(
					'name' => get_the_time( 'd' ),
				);
			}


			# Month ----------
			elseif ( is_month() ){

				$breadcrumbs[] = array(
					'url'  => get_year_link( get_the_time( 'Y' ) ),
					'name' => get_the_time( 'Y' ),
				);

				$breadcrumbs[] = array(
					'name' => get_the_time( 'F' ),
				);
			}


			# Year ----------
			elseif ( is_year() ){

				$breadcrumbs[] = array(
					'name' => get_the_time( 'Y' ),
				);
			}


			# Tag ----------
			elseif ( is_tag() ){

				$breadcrumbs[] = array(
					'name' => get_the_archive_title(),
				);
			}


			# Author ----------
			elseif ( is_author() ){

				$author = get_query_var( 'author' );
				$author = get_userdata($author);

				$breadcrumbs[] = array(
					'name' => $author->display_name,
				);
			}


			# Search ----------
			elseif ( is_search() ){

				$breadcrumbs[] = array(
					'name' => sprintf( __ti( 'Search Results for: %s' ),  get_search_query() ),
				);
			}


			# 404 ----------
			elseif ( is_404() ){

				$breadcrumbs[] = array(
					'name' => __ti( 'Nothing Found' ),
				);
			}


			# BuddyPress ----------
			elseif ( function_exists('bp_current_component') && bp_current_component() ){

				$breadcrumbs[] = array(
					'name' => get_the_title(),
				);
			}


			# Pages ----------
			elseif ( is_page() ){

				if ( $post->post_parent ){

					$parent_id   = $post->post_parent;
					$page_parents = array();

					while ( $parent_id ){
						$get_page  = get_page( $parent_id );
						$parent_id = $get_page->post_parent;

						$page_parents[] = array(
							'url'  => get_permalink( $get_page->ID ),
							'name' => get_the_title( $get_page->ID ),
						);
					}

					$page_parents = array_reverse( $page_parents );

					foreach( $page_parents as $single_page ){

						$breadcrumbs[] = array(
							'url'  => $single_page['url'],
							'name' => $single_page['name'],
						);
					}
				}

				$breadcrumbs[] = array(
					'name' => get_the_title(),
				);
			}


			# Attachment ----------
			elseif ( is_attachment() ){

				if( ! empty( $post->post_parent ) ){
					$parent = get_post( $post->post_parent );

					$breadcrumbs[] = array(
						'url'  => get_permalink( $parent ),
						'name' => $parent->post_title,
					);
				}

				$breadcrumbs[] = array(
					'name' => get_the_title(),
				);
			}


			# Single Posts ----------
			elseif ( is_singular() ){

				# Single Post ----------
				if ( get_post_type() == 'post' ){

					$category = jannah_get_primary_category_id();
					$category = get_category( $category );

					if( ! empty( $category ) ){

						if( $category->parent !== 0 ){
							$parent_categories = array_reverse( get_ancestors( $category->term_id, 'category' ) );

							foreach ( $parent_categories as $parent_category ) {
								$breadcrumbs[] = array(
									'url'  => _jannah_good_get_term_link( $parent_category, 'category' ),
									'name' => get_cat_name( $parent_category ),
								);
							}
						}

						$breadcrumbs[] = array(
							'url'  => _jannah_good_get_term_link( $category->term_id, 'category' ),
							'name' => get_cat_name( $category->term_id ),
						);
					}
				}

				# Custom Post type ----------
				else{
					$post_type = get_post_type_object( get_post_type() );
					$slug      = $post_type->rewrite;

					$breadcrumbs[] = array(
						'url'  => $home_url . '/' . $slug['slug'],
						'name' => $post_type->labels->singular_name,
					);
				}


				$breadcrumbs[] = array(
					'name' => get_the_title(),
				);
			}




			# Print the BreadCrumb
			if( ! empty( $breadcrumbs ) ){

				$cunter = 0;
				$breadcrumbs_schema = array(
					'@context'        => 'http://schema.org',
					'@type'           => 'BreadcrumbList',
					'@id'             => '#Breadcrumb',
					'itemListElement' => array(),
				);

				echo '<nav id="breadcrumb">';

					foreach( $breadcrumbs as $item ) {

						$cunter++;

						if( ! empty( $item['url'] )){
							$icon = ! empty( $item['icon'] ) ? $item['icon'] : '';
							echo '<a href="'. esc_url( $item['url'] ) .'">'. $icon .' '. $item['name'] .'</a>'. $delimiter;
						}
						else{
							echo ( $before . $item['name'] . $after );

							global $wp;
							$item['url'] = esc_url(home_url(add_query_arg(array(),$wp->request)));
						}

						$breadcrumbs_schema['itemListElement'][] = array(
							'@type'    => 'ListItem',
							'position' => $cunter,
							'item'     => array(
								'name' => str_replace( '<span class="fa fa-home" aria-hidden="true"></span> ', '', $item['name']),
								'@id'  => $item['url'],
							)
						);

					}

				echo '</nav>';

				if( jannah_get_option( 'structure_data' ) ){
					echo '<script type="application/ld+json">'. wp_json_encode( $breadcrumbs_schema ) .'</script>';
				}
			}


		}

		wp_reset_postdata();
	}

}
?>

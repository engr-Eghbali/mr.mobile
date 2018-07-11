<?php

if( (( jannah_get_option( 'check_also' ) && ! jannah_get_postdata( 'tie_hide_check_also' )) || ( jannah_get_postdata( 'tie_hide_check_also' ) == 'no' )) && is_single() && ! jannah_is_mobile() ):

	$post_id = get_the_id();

	$tie_do_not_duplicate = ! empty( $GLOBALS['tie_do_not_duplicate'] ) ? $GLOBALS['tie_do_not_duplicate'] : array( $post_id );

	# Post titles length ----------
	$title_length = jannah_get_option( 'check_also_title_length' ) ? jannah_get_option( 'check_also_title_length' ) : '';

	# Check Also Position ----------
	$check_also_position = jannah_get_option( 'check_also_position', 'right' );

	# Prepare the query ----------
	$query_type = jannah_get_option( 'check_also_query' );

	$args = array(
		'post__not_in'           => $tie_do_not_duplicate,
		'posts_per_page'         => 1,
		'no_found_rows'          => true,
		'post_status'            => 'publish',
		'ignore_sticky_posts'    => true,
		'update_post_term_cache' => false,
	);


	# Check also Posts order ----------
	if( $order = jannah_get_option( 'check_also_order' )){

		if( $order == 'rand' ){

			$args['orderby'] = 'rand';
		}
		elseif( $order == 'views' && jannah_get_option( 'post_views' )){

			$args['orderby']  = 'meta_value_num';
			$args['meta_key'] = apply_filters( 'jannah_views_meta_field', 'tie_views' );
		}
		elseif( $order == 'best' && JANNAH_TAQYEEM_IS_ACTIVE ){

			$args['orderby']  = 'meta_value_num';
			$args['meta_key'] = 'taq_review_score';
		}
		elseif( $order == 'popular' ){

			$args['orderby'] = 'comment_count';
		}
		elseif( $order == 'modified' ){

			$args['orderby'] = 'modified';
			$args['order']   = 'ASC';
		}
	}


	# Get Check also posts by author ----------
	if( $query_type == 'author' ){
		$args['author'] = get_the_author_meta( 'ID' );
	}

	# Get Check also posts by tags ----------
	elseif( $query_type == 'tag' ){
		$tags_ids  = array();
		$post_tags = get_the_terms( $post_id, 'post_tag' );

		if( ! empty( $post_tags ) ){
			foreach( $post_tags as $individual_tag ){
				$tags_ids[] = $individual_tag->term_id;
			}

			$args['tag__in'] = $tags_ids;
		}
	}

	# Get Check also posts by categories ----------
	else{
		$category_ids = array();
		$categories   = get_the_category( $post_id );

		foreach( $categories as $individual_category ){
			$category_ids[] = $individual_category->term_id;
		}

		$args['category__in'] = $category_ids;
	}


	# Get the posts ----------
	$check_also_query = new wp_query( $args );


	if( $check_also_query->have_posts() ): ?>

		<div id="check-also-box" class="container-wrapper check-also-<?php echo esc_attr( $check_also_position ) ?>">

			<div class="widget-title">
				<h4><?php _eti( 'Check Also' ); ?></h4>
				<a href="#" id="check-also-close">
					<span class="tie-icon-cross" aria-hidden="true"></span>
					<span class="screen-reader-text"><?php esc_html_e( 'Close', 'jannah' ); ?></span>
				</a>
			</div>

			<div class="related-posts-list">

			<?php

				while ( $check_also_query->have_posts() ):

					$check_also_query->the_post();
					$do_not_duplicate[] = get_the_ID(); ?>

					<div <?php jannah_post_class( 'check-also-post' ); ?>>

						<?php
							if ( has_post_thumbnail() ){
								jannah_post_thumbnail( 'jannah-image-large', false );
							}

							//Get the Post Meta info ----------
							jannah_the_post_meta( array( 'comments' => false, 'author' => false ) );
						?>

						<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php jannah_the_title( $title_length ); ?></a></h3>

					</div><!-- .related-item /-->

				<?php endwhile;?>

			</div><!-- .related-posts-list /-->
		</div><!-- #related-posts /-->

		<?php
	endif;

	wp_reset_postdata();

endif;
?>

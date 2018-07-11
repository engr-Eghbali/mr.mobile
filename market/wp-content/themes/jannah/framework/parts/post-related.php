<?php

if( ( jannah_get_option( 'related' ) && ! jannah_get_postdata( 'tie_hide_related' )) || ( jannah_get_postdata( 'tie_hide_related' ) == 'no' ) && is_single() ):

	# Check if the newsletter is hidden on mobiles ----------
	if( jannah_is_mobile_and_hidden( 'related' )) return;

	$class   = 'container-wrapper';
	$post_id = get_the_id();

	# Don't show current post in the related posts ----------
	$tie_do_not_duplicate = array( $post_id );

	# Post titles length ----------
	$title_length = jannah_get_option( 'related_title_length' ) ? jannah_get_option( 'related_title_length' ) : '';

	# Number of posts for the normal layout with sidebar ----------
	$related_number = jannah_get_option( 'related_number', 3 );

	# Number of posts for the Full width layout without sidebar ----------
	if( jannah_get_object_option( 'sidebar_pos', 'cat_sidebar_pos', 'tie_sidebar_pos' ) == 'full' ){
		$related_number = (int) jannah_get_option( 'related_number_full', 4 );
	}


	# For responsive layout add extra 1 post if the number is odd ----------
	if ( $related_number % 2 != 0 ){
		$related_number++;
		$extra_post = true;
	}


	# Prepare the query ----------
	$query_type = jannah_get_option('related_query');

	$args = array(
		'post__not_in'           => $tie_do_not_duplicate,
		'posts_per_page'         => $related_number,
		'no_found_rows'          => true,
		'post_status'            => 'publish',
		'ignore_sticky_posts'    => true,
		'update_post_term_cache' => false,
	);


	# Related Posts order ----------
	if( jannah_get_option('related_order') ){

		$order = jannah_get_option( 'related_order' );

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


	# Get related posts by author ----------
	if( $query_type == 'author' ){
		$args['author'] = get_the_author_meta( 'ID' );
	}

	# Get related posts by tags ----------
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

	# Get related posts by categories ----------
	else{
		$category_ids = array();
		$categories   = get_the_category( $post_id );

		foreach( $categories as $individual_category ){
			$category_ids[] = $individual_category->term_id;
		}

		$args['category__in'] = $category_ids;
	}

	# Get the posts ----------
	$related_query = new wp_query( $args );


	# For responsive layout add extra custom class for the extra post ----------
	if( ! empty( $extra_post ) && ! empty( $related_query->post_count ) && $related_query->post_count == $related_number ){
		$class .= ' has-extra-post';
	}

	if( $related_query->have_posts() ): ?>

		<div id="related-posts" class="<?php echo esc_attr( $class ) ?>">

			<div class="mag-box-title">
				<h3><?php _eti( 'Related Articles' ); ?></h3>
			</div>

			<div class="related-posts-list">

			<?php
				while ( $related_query->have_posts() ):

					$related_query->the_post();

					$tie_do_not_duplicate[] = get_the_ID(); ?>

					<div <?php jannah_post_class( 'related-item' ); ?>>

						<?php

							# Get the post thumbnail ----------
							if ( has_post_thumbnail() ){
								jannah_post_thumbnail( 'jannah-image-large', false );
							}

							# Get the Post Meta info ----------
							jannah_the_post_meta( array( 'comments' => false, 'author' => false ) );
						?>

						<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php jannah_the_title( $title_length ); ?></a></h3>

					</div><!-- .related-item /-->

				<?php endwhile;?>

			</div><!-- .related-posts-list /-->
		</div><!-- #related-posts /-->

		<?php
	endif;

	# Remove the Id of the extra post from the do not duplicate array ----------
	if( ! empty( $extra_post ) && ! empty( $related_query->post_count ) && $related_query->post_count == $related_number ){
		$the_extra_post = array_pop( $tie_do_not_duplicate );
	}

	# Add the do not duplicate array to the GLOBALS to use it in the flay check also template file ----------
	$GLOBALS['tie_do_not_duplicate'] = $tie_do_not_duplicate;

	wp_reset_postdata();

endif;
?>

<?php

$is_do_not_dublicate = false;


# Page builder slider ----------
if( ( is_page() || is_front_page() ) && jannah_get_postdata( 'tie_builder_active' )){

	# check if the do not duplicate option is enabled ----------
	$is_do_not_dublicate = jannah_get_postdata( 'tie_do_not_dublicate' ) ? true : false;
}

# Category slider ----------
elseif( is_category() ){
	$category_id = get_query_var( 'cat' );

	# Cache field key ----------
	$cache_key = JANNAH_CACHE_KEY .'-slider-cat-' . $category_id;

	$slider_settings = array(
		'slider'           => jannah_get_category_option( 'featured_posts_style' ),
		'featured_auto'    => jannah_get_category_option( 'featured_auto' ),
		'lsslider'         => jannah_get_category_option( 'lsslider' ),
		'revslider'        => jannah_get_category_option( 'revslider' ),
		'featured_posts'   => jannah_get_category_option( 'featured_posts' ),
		'title_length'     => jannah_get_category_option( 'featured_posts_title_length' ),
		'excerpt_length'   => jannah_get_category_option( 'featured_posts_excerpt_length' ),
		'show_date'        => jannah_get_category_option( 'featured_posts_date' ),
		'show_excerpt'     => jannah_get_category_option( 'featured_posts_excerpt' ),
		'show_category'    => jannah_get_category_option( 'featured_posts_category' ),
		'query_type'       => jannah_get_category_option( 'featured_posts_query' ),
		'custom_slider'    => jannah_get_category_option( 'featured_posts_custom' ),
		'posts_number'     => jannah_get_category_option( 'featured_posts_number' ),
		'offset'           => jannah_get_category_option( 'featured_posts_offset' ),
		'order'            => jannah_get_category_option( 'featured_posts_order' ),
		'colored_mask'     => jannah_get_category_option( 'featured_posts_colored_mask' ),
		'media_overlay'    => jannah_get_category_option( 'featured_posts_media_overlay' ),
		'playlist_title'   => jannah_get_category_option( 'featured_videos_list_title' ),
		'videos_data'      => jannah_get_category_option( 'featured_videos_list_data' ),
		'slider_id'        => 'category-videos',
		'dark_skin'        => true,
	);

}


if( ! empty( $slider_settings ) ){

	$slider_settings = wp_parse_args( $slider_settings, array(
		'slider'         => 1,
		'featured_auto'  => false,
		'lsslider'       => false,
		'revslider'      => false,
		'featured_posts' => false,
		'title_length'   => '',
		'excerpt_length' => 12,
		'show_date'      => false,
		'show_excerpt'   => false,
		'show_category'  => false,
		'query_type'     => false,
		'custom_slider'  => false,
		'posts_number'   => 10,
		'query_tags'     => false,
		//'query_posts'    => false,
		//'query_pages'    => false,
		'query_cats'     => false,
		'offset'         => false,
		'order'          => false,
		'colored_mask'   => false,
		'media_overlay'  => false,
		'playlist_title' => false,
		'videos_data'    => false,
		'slider_id'      => false,
		'dark_skin'      => false,
	));

	extract( $slider_settings );


	# Get the LayerSlider ----------
	if( $lsslider && JANNAH_LS_Sliders_IS_ACTIVE ){
		echo '<div class="third-party-slider">';
			layerslider( $lsslider );
		echo '</div>';
	}

	# Get the Revolution slider ----------
	elseif( $revslider && JANNAH_REVSLIDER_IS_ACTIVE ){
		echo '<div class="third-party-slider">';
			putRevSlider( $revslider );
		echo '</div>';
	}

	# Get the main slider ----------
	elseif( $featured_posts ){

		# Enqueue the Sliders Js file ----------
		wp_enqueue_script( 'jannah-sliders' );


		# Check the Cache ----------
		if( jannah_get_option( 'cache' ) && ! empty( $cache_key ) && false !== get_transient( $cache_key ) && ! ( defined( 'WP_CACHE' ) && WP_CACHE ) ){
			$cached_slider = get_transient( $cache_key );
		}

		else{

			ob_start();

			# Default Images Size ----------
			$image_size = 'jannah-image-grid';

			# Reset the posts counter ----------
			$count = 0;

			$slider_class = '';


			switch( $slider ){

				case 1:
					$slider_class = 'fullwidth-slider-wrapper wide-slider-wrapper';
					$image_size   = 'jannah-image-full';
					break;

				case 2:
					$slider_class = 'wide-slider-three-slids-wrapper wide-slider-wrapper';
					break;

				case 3:
					$slider_class = 'wide-next-prev-slider-wrapper wide-slider-wrapper';
					$image_size   = 'jannah-image-full';
					break;

				case 4:
					$slider_class = 'wide-slider-with-navfor-wrapper wide-slider-wrapper';
					$image_size   = 'jannah-image-full';
					break;

				case 5:
					$slider_class = 'boxed-slider-three-slides-wrapper boxed-slider';
					break;

				case 6:
					$slider_class = 'boxed-five-slides-slider boxed-slider';
					break;

				case 7:
					$slider_class = 'boxed-four-taller-slider boxed-slider';
					break;

				case 8:
					$slider_class = 'boxed-slider-wrapper boxed-slider';
					$image_size   = 'jannah-image-full';
					break;

				case 9:
					$slider_class = 'grid-2-big boxed-slider grid-slider-wrapper';
					break;

				case 10:
					$slider_class = 'grid-3-slides boxed-slider grid-slider-wrapper';
					break;

				case 11:
					$slider_class = 'grid-4-slides boxed-slider grid-slider-wrapper';
					break;

				case 12:
					$slider_class = 'grid-5-in-rows boxed-slider grid-slider-wrapper';
					break;

				case 13:
					$slider_class = 'grid-5-big-centerd boxed-slider grid-slider-wrapper';
					break;

				case 14:
					$slider_class = 'grid-5-first-big boxed-slider grid-slider-wrapper';
					break;

				case 15:
					$slider_class = 'grid-6-slides boxed-slider grid-slider-wrapper';
					break;

				case 16:
					$slider_class = 'grid-4-big-first-half-second boxed-slider grid-slider-wrapper';
					break;
			}

			# Slider query ----------
			$args         = array();
			$slider_items = array();


			if( ! empty( $query_type ) && $query_type == 'custom' ){
				$get_custom_slider = get_post_custom( $custom_slider );
				$slider_items      = ( ! empty( $get_custom_slider['custom_slider'][0] )) ? maybe_unserialize( $get_custom_slider['custom_slider'][0] ) : '';

				if( ! empty( $slider_items ) && is_array( $slider_items )){
					foreach ( $slider_items as $slide_id => $slide_item ){
						$slider_items[ $slide_id ]['slide_title']      = $slide_item['title'];
						$slider_items[ $slide_id ]['slide_title_attr'] = esc_html( $slide_item['title'] );
						$slider_items[ $slide_id ]['slide_image']      = 'style="'. jannah_slider_img_src_bg( $slide_item['id'], $image_size ) .'"';
						$slider_items[ $slide_id ]['slide_link']       = esc_url( $slide_item['link'] );

						if( $show_excerpt ){
							$slider_items[ $slide_id ]['slide_caption'] = '<div class="thumb-desc">'. $slide_item['caption'] .'</div><!-- .thumb-desc -->';
						}

					}
				}

			}
			else{

				$args['number'] = $posts_number;
				$args['offset'] = $offset;
				$args['order']  = $order;


				# If the current page is category ----------
				if( is_category() ){

					$args['id'] = $category_id;

					if( ! empty( $query_type ) && $query_type == 'random' ){
						$args['order'] = 'rand';
					}
				}

				# Block in the page builder ----------
				else{

					# Get posts by tags ----------
					if( ! empty( $query_type ) && $query_type == 'tags' ){
						$args['tags'] = $query_tags;
					}

					/*
					# Get Selective posts ----------
					elseif( $query_type == 'post' ){
						$args['posts'] = $query_posts;
					}

					# Get Selective Pages ----------
					elseif( $query_type == 'page' ){
						$args['pages'] = $query_pages;
					}
					*/

					# Get Posts by categories ----------
					elseif( $query_cats ){
						$args['id'] = $query_cats;
					}
				}

				# Run the Query ----------
				$slider_query = jannah_query( $args );

				while ( $slider_query->have_posts() ){

					# Get the post ID ----------
					$slider_query->the_post();
					$slider_post_id = get_the_ID();

					# Get the bakground image ----------
					//$background = jannah_get_option( 'lazy_load' ) ? 'data-src="'. jannah_thumb_src( $image_size ) .'"' : 'style="'. jannah_thumb_src_bg( $image_size ) .'"';
					$background = 'style="'. jannah_thumb_src_bg( $image_size ) .'"';

					# Add the slide data ----------
					$slider_items[ $slider_post_id ]['slide_title']      = jannah_get_title( $title_length );
					$slider_items[ $slider_post_id ]['slide_title_attr'] = the_title_attribute( 'echo=0' );
					$slider_items[ $slider_post_id ]['slide_image']      = $background;
					$slider_items[ $slider_post_id ]['slide_link']       = get_permalink();
					$slider_items[ $slider_post_id ]['slide_is_post']    = true;

					if( $show_date ){
						$slider_items[ $slider_post_id ]['slide_date'] = jannah_get_time( true );
					}

					if( $show_excerpt ){
						$slider_items[ $slider_post_id ]['slide_caption'] = '<div class="thumb-desc">'. jannah_get_excerpt( $excerpt_length ) .'</div><!-- .thumb-desc -->';
					}

					if( $show_category ){
						$slider_items[ $slider_post_id ]['slide_categories'] = jannah_get_category( '<h5 class="post-cat-wrap">', '</h5>');
					}

					# Do not duplicate posts ----------
					if( $is_do_not_dublicate ){
						jannah_do_not_dublicate( $slider_post_id );
					}
				}

				wp_reset_postdata();
			}

			# Colored Mask class ----------
			$slider_class .= $colored_mask ? ' slide-mask' : '';

			# slide class ----------
			$single_slide_class = ( $slider > 8 ) ? 'grid-item' : 'slide';

			# LazyLoad is enaled ----------
			if( jannah_get_option( 'lazy_load' ) ){
				$single_slide_class .= ' lazy-bg';
			}


			$slider_wrapper_class = '';

			# Media Overlay ----------
			if( $media_overlay && $query_type != 'custom' ){
				$slider_wrapper_class .= ' media-overlay';
			}

			# Video list parent box class ----------
			if( $slider == 'videos_list' ){
				$slider_wrapper_class .= ' tie-video-main-slider';

				if( $dark_skin ){
					$slider_wrapper_class .= ' box-dark-skin';
				}
			}

			# AutoPlay ----------
			$featured_auto_play = ( $featured_auto ) ? ' data-autoplay="true"' : '';

			# Common slider markup ----------
			$before_slider = '
				<div %1$s %2$s>
					<a href="%3$s" class="all-over-thumb-link"></a>
					<div class="thumb-overlay">';

						if( $media_overlay && $query_type != 'custom' ){
							$before_slider .= '
								<span class="icon"></span>
							';
						}

						$after_slider = '
					</div><!-- .thumb-overlay /-->
				</div><!-- .slide /-->
			';

			$slide_title_html = '
				<h2 class="thumb-title"><a href="%1$s" title="%2$s">%3$s</a></h2>
			'; ?>

			<section id="tie-<?php echo esc_attr( $slider_id ) ?>" class="slider-area mag-box<?php echo esc_attr( $slider_wrapper_class ) ?>">

				<?php

				# Video Play List ----------
				if( $slider == 'videos_list' ){

					if( $videos_data ){

						$args = array(
							'videos_data' => $videos_data,
		 					'title'       => $playlist_title,
		 					'id'          => $slider_id,
						);

						jannah_get_template_part( 'framework/parts/video-list', '', $args );
					}

				}
				else{ ?>

					<div id="tie-main-slider-<?php echo esc_attr( $slider .'-'.$slider_id ) ?>" class="tie-main-slider main-slider <?php echo esc_attr( $slider_class ) ?> tie-slick-slider-wrapper" data-slider-id="<?php echo esc_attr( $slider ) ?>" <?php echo ( $featured_auto_play ) ?>>

						<?php
							# Loader icon ----------
							jannah_get_ajax_loader();
						?>

						<div class="main-slider-wrapper">

							<?php

							if( $slider < 5 ): ?>

								<div class="container slider-main-container">
									<div class="tie-slick-slider">
										<ul class="slider-nav"></ul>

										<?php

											foreach ( $slider_items as $slider_post_id => $single_slide ){
												extract( $single_slide );
												$count++;

												$class = jannah_get_post_class( $single_slide_class . ' slide-id-'.$slider_post_id .' tie-slide-'.$count, $slider_post_id );

												printf( $before_slider, $slide_image, $class, $slide_link );

													echo '<div class="container">';

														if( $slider == 1 ){

															echo '<div class="thumb-content">';

																if( ! empty( $slide_categories ) ){
																	echo ( $slide_categories );
																}

																if( ! empty( $slide_is_post ) && ! empty( $slide_date ) ){
																	echo '<div class="thumb-meta">'. $slide_date .'</div>';
																}

																printf( $slide_title_html, $slide_link, $slide_title_attr, $slide_title );

															echo '</div> <!-- .thumb-content /-->';
														}

														elseif( $slider == 2 ){

															if( ! empty( $slide_categories ) ){
																echo ( $slide_categories );
															}

															echo '<div class="thumb-content">';

																if( ! empty( $slide_is_post ) && ! empty( $slide_date ) ){
																	echo '<div class="thumb-meta">'. $slide_date .'</div>';
																}

																printf( $slide_title_html, $slide_link, $slide_title_attr, $slide_title );

																if( ! empty( $slide_caption )){
																	echo ( $slide_caption );
																}

															echo '</div> <!-- .thumb-content /-->';

														}

														else{

															if( ! empty( $slide_categories ) ){
																echo ( $slide_categories );
															}

															echo '<div class="thumb-content">';

																printf( $slide_title_html, $slide_link, $slide_title_attr, $slide_title );

																if( ! empty( $slide_is_post ) && ! empty( $slide_date ) ){
																	echo '<div class="thumb-meta">'. $slide_date .'</div>';
																}

															echo '</div> <!-- .thumb-content /-->';
														}

													echo '</div><!-- .container -->';

												echo ( $after_slider );

												#  Reset the posts count after 6 posts ----------
												$count = ( $count == 6 ) ? 0 : $count;
											}
										?>

									</div><!-- .tie-slick-slider /-->
								</div><!-- .slider-main-container /-->

							<?php

							else:
								if( $slider != 8 && $slider < 9 ){

									echo '<ul class="slider-nav"></ul>';
								}?>

								<div class="container<?php echo esc_attr( $slider_id ) ?>">
									<div class="tie-slick-slider">

										<?php

											if( $slider >= 8 ){
												echo '<ul class="slider-nav"></ul>';
											}

											if( ! empty( $slider_items ) && is_array( $slider_items )){

												foreach ( $slider_items as $slider_post_id => $single_slide ){

													extract( $single_slide );
													$count++;

													$class = jannah_get_post_class( $single_slide_class . ' slide-id-'.$slider_post_id .' tie-slide-'.$count, $slider_post_id );

													printf( $before_slider, $slide_image, $class, $slide_link );


														if( $slider != 6 && ! empty( $slide_categories ) ){
															echo ( $slide_categories );
														}

														echo '<div class="thumb-content">';

															if( ! empty( $slide_is_post ) && ! empty( $slide_date ) ){
																echo '<div class="thumb-meta">'. $slide_date .'</div>';
															}

															printf( $slide_title_html, $slide_link, $slide_title_attr, $slide_title );

															if( $slider != 6 && ! empty( $slide_caption ) ){
																echo ( $slide_caption );
															}

														echo '</div> <!-- .thumb-content /-->';

													echo ( $after_slider );

													#  Reset the posts count after 6 posts ----------
													$count = ( $count == 6 ) ? 0 : $count;
												}
											}
										?>

									</div><!-- .tie-slick-slider /-->
								</div><!-- container /-->

							<?php endif; ?>

						</div><!-- .main-slider-wrapper  /-->
					</div><!-- .main-slider /-->

					<?php

					# Navigation of Slider 4 ----------
					if( $slider == 4 ): ?>

						<div class="wide-slider-nav-wrapper">
							<ul class="slider-nav"></ul>

							<div class="container">
								<div class="tie-row">
									<div class="tie-col-md-12">
										<div class="tie-slick-slider">

											<?php

												foreach ( $slider_items as $single_slide ):

													extract( $single_slide );
													$count ++; ?>

													<div class="slide tie-slide-<?php $count ?>">
														<div class="slide-overlay">

															<?php
																if( ! empty( $slide_is_post ) && ! empty( $slide_date ) ){
																	echo '<div class="thumb-meta">'. $slide_date .'</div>';
																}
															?>

															<h3 class="thumb-title"><?php echo  $slide_title ?></h3>

														</div>
													</div><!-- slide /-->

													<?php
													# Reset the posts count after 6 posts ----------
													 $count = ( $count == 6 ) ? 0 : $count;

												endforeach;
											?>

										</div><!-- .wide_slider_nav /-->
									</div><!-- .tie-col /-->
								</div><!-- .tie-row /-->
							</div><!-- .container /-->
						</div><!-- #wide-slider-nav-wrapper /-->
						<?php
					endif;

				} # else of the video playlist
			?>

		</section><!-- .slider-area -->

			<?php

			$cached_slider = ob_get_clean();

			if( jannah_get_option( 'cache' ) &&  ! empty( $cache_key ) ){
				set_transient( $cache_key, $cached_slider, JANNAH_CACHE_HOURS * HOUR_IN_SECONDS );
			}

		} //Else cache

		echo ( $cached_slider );
	}
}
?>

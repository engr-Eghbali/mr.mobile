<?php
/**
 * Page builder blocks
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly




if( $sections = jannah_get_postdata( 'tie_page_builder' )){
	$sections = maybe_unserialize( $sections );
}


# check if the do not duplicate option is enabled ----------
$is_do_not_dublicate = jannah_get_postdata( 'tie_do_not_dublicate' ) ? true : false;


if( ! empty( $sections ) && is_array( $sections ) ){

	$section_number = 0;

	foreach( $sections as $section ){

		$section['settings'] = ! empty( $section['settings'] ) ? $section['settings'] : array();

		$section_settings = wp_parse_args( $section['settings'], array(
			'section_title'      => '',
			'title'              => '',
			'url'                => '',
			'title_style'        => '',
			'title_color'        => '',
			'section_width'      => '',
			'custom_class'       => '',
			'dark_skin'          => '',
			'parallax'           => '',
			'parallax_effect'    => '',
			'background_img'     => '',
			'background_video'   => '',
			'background_color'   => '',
			'predefined_sidebar' => '',
			'sidebar_position'   => '',
			'sidebar_id'         => '',
			'section_id'         => '',
		));


		$classes          = array();
		$section_id       = $section_settings['section_id'];
		$section_styles   = array();
		$internal_class   = '';
		$section_video_bg = '';
		$parallax_options = '';
		$before_content   = '';
		$after_content    = '';
		$after_sidebar    = '';
		$container_open   = '';
		$container_close  = '';
		$outer_class      = '-full';
		$block_count      = 0;
		$is_tag_open      = false;
		$count_half_box   = 0;


		# Section Sidebar ----------
		$sidebar = 'full-width';
		$sidebar_position = $section_settings['sidebar_position'];

		if( $sidebar_position == 'left' ){
			$sidebar = 'sidebar-left has-sidebar';
		}
		elseif( $sidebar_position == 'right' ){
			$sidebar = 'sidebar-right has-sidebar';
		}

		$classes[] = $sidebar;


		# Section Width ----------
		if( ! $section_settings['section_width'] ){
			$classes[] = '';
			$internal_class = '-normal';
			$outer_class = ' normal-width';
		}


		# Section Number ----------
		$section_number++;

		if( $section_number == 1 ){
			$classes[] = 'is-first-section';
		}


		if( $sidebar == 'full-width' ){
			$container_open  = '
				<div class="container'. $internal_class .'">
					<div class="tie-row main-content-row">
						<div class="main-content tie-col-md-12">';

			$container_close = '
						</div><!-- .main-content /-->
					</div><!-- .main-content-row /-->
				</div><!-- .container /-->';

			if( $section_settings['section_width'] && ! empty( $section['blocks'] ) && is_array( $section['blocks'] )){
				 $blocks = $section['blocks'];
				 $first_block = array_values( $blocks );
				 $first_block = array_shift( $first_block );
				 if( ! empty( $first_block['style'] ) && ( $first_block['style'] == 'slider_1' || $first_block['style'] == 'slider_2' || $first_block['style'] == 'slider_3' || $first_block['style'] == 'slider_4' )){
					 $classes[] = 'first-block-is-full-width';
				 }
			}

		}
		else{
			$before_content = '
				<div class="container'. $internal_class .'">
					<div class="tie-row main-content-row">
						<div '. jannah_content_column_attr( false ) .'>';

			$after_content = '</div><!-- .main-content /-->';
			$after_sidebar = '
					</div><!-- .main-content-row -->
				</div><!-- .container /-->';
		}



		# Background ----------
		$section_bg_class = ' without-background';
		if( $section_settings['background_img'] || $section_settings['background_color'] || $section_settings['background_video'] || $section_settings['dark_skin'] ){

			$section_bg_class = ' has-background';

			# Section Dark Skin ----------
			if( $section_settings['dark_skin'] ){
				$classes[] = 'dark-skin';
			}

			if( $section_settings['background_color'] ){
				$section_styles[] = 'background-color: '. $section_settings['background_color'] .';';
			}

			if( $section_settings['background_video'] ){
				$section_video_bg = 'data-jarallax-video="'. $section_settings['background_video'] .'"';
				$classes[] = 'has-video-background';
			}
			elseif( $section_settings['background_img'] ){
				$section_styles[] = 'background-image: url( '. $section_settings['background_img'] .');';
			}

			if( $section_settings['parallax'] ){
				$classes[] = 'tie-parallax';

				$parallax_effect  = $section_settings['parallax_effect'] ? $section_settings['parallax_effect'] : 'scroll';
				$parallax_options = " data-jarallax='{\"type\":\"$parallax_effect\"}'";

			}
			else{
				$section_styles[] = 'background-size: cover;';
			}
		}

		$outer_class .= $section_bg_class;


		# Section Title Class ----------
		if( $section_settings['section_title'] && $section_settings['title'] ){
			$outer_class .= ' has-title';
		}

		# Section Custom Classes ----------
		if( $section_settings['custom_class'] ){
			$outer_class .= ' '.$section_settings['custom_class'];
		}

	?>

<div id="<?php echo esc_attr( $section_id ) ?>" class="section-wrapper container<?php echo esc_attr( $outer_class ) ?>">
	<div class="section-item <?php echo join( ' ', $classes ); ?>" style="<?php echo join( ' ', $section_styles ); ?>" <?php echo ( $section_video_bg.$parallax_options ) ?>>

		<?php

		# Section Title ----------
		if( $section_settings['section_title'] && $section_settings['title'] ){

			# Section title tags ----------
			$before_section_title = $section_settings['section_width'] ? '<div class="container">' : '';
			$after_section_title  = $section_settings['section_width'] ? '</div>' : '';

			# Url ----------
			$before_section_link = $section_settings['url'] ? '<a href="'. esc_url( $section_settings['url'] ) .'" title="'.esc_attr( $section_settings['title'] ).'">' : '';
			$after_section_link  = $section_settings['url'] ? '</a>' : '';

			# CLass ----------
			$title_class  = 'section-title ';
			$title_class .= $section_settings['title_style'] ? $section_settings['title_style'].'-style' : 'default-style';


			echo ( $before_section_title );
			echo '<h2 class="'. $title_class .'">';
			echo '<span class="the-section-title">' .$before_section_link . $section_settings['title'] . $after_section_link.'</span>';
			echo '</h2>';
			echo ( $after_section_title );
		}


		echo ( $before_content );


		# Get the Blocks ----------
		if( ! empty( $section['blocks'] ) && is_array( $section['blocks'] )){

			foreach( $section['blocks'] as $block ){

				# Reset variables
				/*-----------------------------------------------------------------------------------*/
				$count          = 0;
				$after	        = '';
				$style 	        = 'default';
				$block_class 	  = '';
				$before_items	  = '<ul class="posts-items posts-list-container">';
				$after_items	  = '</ul>';
				$excerpt_length = '';


				$block_count++;


				# Default Block settings
				/*-----------------------------------------------------------------------------------*/
				$block = wp_parse_args( $block, array(
					'style'            => 'default',
					'cat'              => '',
					'title'            => '',
					'order'            => 'latest',
					'woo_cats'         => '',
					'id'               => '',
					'tags'             => '',
					'custom_slider'    => '',
					'number'           => 5 ,
					'offset'           => '',
					'pagi'             => '',
					'color'            => '',
					'dark'             => '',
					'title_length'     => '',
					'excerpt'          => '',
					'excerpt_length'   => '',
					'thumb_first'      => '',
					'thumb_small'      => '',
					'thumb_all'        => '',
					'more'             => '',
					'post_meta'        => '',
					'media_overlay'    => '',
					'read_more'        => '',
					'filters'          => '',
					'custom_content'   => '',
					'ad_img'           => '',
					'ad_url'           => '',
					'ad_alt'           => '',
					'ad_target'        => '',
					'ad_nofollow'      => '',
					'ad_code'          => '',
					'colored_mask'     => '',
					'animate_auto'     => '',
					'posts_category'   => '',
					'videos_list_data' => '',
					'breaking_effect'  => '',
					'breaking_arrows'  => '',
					'lsslider'         => '',
					'revslider'        => '',
					'boxid'            => '',
				));

				# Set the $style variable
				/*-----------------------------------------------------------------------------------*/
				if( ! empty( $block['style'] ) ){
					$style = $block['style'];
				}


				# Check the box id
				/*-----------------------------------------------------------------------------------*/
				if( ! empty( $block['boxid'] ) ){
					$block['boxid'] = str_replace( '-', '_', $block['boxid'] );
				}


				# The Block is a SLIDER
				/*-----------------------------------------------------------------------------------*/
				if( ( strpos( $style, 'slider_' ) !== false ) || $style == 'videos_list' || $style == 'lsslider' || $style == 'revslider' ){

					$slider = str_replace( 'slider_', '', $style );

					if( $block_count != 1 && $is_tag_open && $slider <= 4){
						echo ( $container_close );
						$is_tag_open = false;
					}

					if( ( $slider > 4 || $slider == 'videos_list' ) && ! $is_tag_open ){
						echo ( $container_open );
						$is_tag_open = true;
					}

					$query_type = 'cat';

					if( ! empty( $block['custom_slider'] ) ){
						$query_type = 'custom';
					}
					elseif( ! empty( $block['tags'] )){
						$query_type = 'tags';
					}

					jannah_get_template_part( 'framework/parts/featured', '', array(
						'slider_settings'  => array(
							'slider'         => $slider,
							'featured_posts' => true,
							'featured_auto'  => $block['animate_auto'],
							'lsslider'       => $block['lsslider'],
							'revslider'      => $block['revslider'],
							'title_length'   => $block['title_length'],
							'excerpt_length' => $block['excerpt_length'],
							'show_date'      => $block['post_meta'],
							'show_excerpt'   => $block['excerpt'],
							'show_category'  => $block['posts_category'],
							'query_type'     => $query_type,
							'custom_slider'  => $block['custom_slider'],
							'posts_number'   => $block['number'],
							'query_tags'     => $block['tags'],
							'query_cats'     => $block['id'],
							'offset'         => $block['offset'],
							'order'          => $block['order'],
							'colored_mask'   => $block['colored_mask'],
							'media_overlay'  => $block['media_overlay'],
							'bg_color'       => false,
							'bg_image'       => false,
							'bg_parallax'    => false,
							'playlist_title' => $block['title'],
							'videos_data'    => $block['videos_list_data'],
							'slider_id'      => $block['boxid'],
							'dark_skin'      => $block['dark'],
						)
					));

				}


				# The Block is NOT a SLIDER
				/*-----------------------------------------------------------------------------------*/
				else{

					if( ! $is_tag_open ){
						echo ( $container_open );
						$is_tag_open = true;
					}

					# Blocks settings
					/*-----------------------------------------------------------------------------------*/
					switch ( $style ){

						/**
						 * Block Style: Default
						 * Loop Template: loop-default.php
						 */
						case 'default':
							$block_class = 'wide-post-box top-news-box';
							break;


						/**
						 * Block Style: Big
						 * Loop Template: loop-default.php
						 */
						case 'big':
							$block_class 	= 'big-posts-box';
							$style 				= 'default';
							break;


						/**
						 * Block Style: full_thumb
						 * Loop Template: loop-full_thumb.php
						 */
						case 'full_thumb':
				 			$excerpt_length = 75;
				 			$block_class 		= 'full-width-img-news-box';
				 			break;


				 		/**
						 * Block Style: full-thumb
						 * Loop Template: loop-full-thumb.php
						 */
						case 'overlay-title':
				 			$excerpt_length = 75;
				 			$block_class 		= 'full-width-img-news-box full-overlay-title';
				 			break;


						/**
						 * Block Style: li
						 * Loop Template: loop-large_first.php
						 */
						case 'li':
						 	$excerpt_length = 35;
							$block_class 		= 'big-post-left-box';
							$style 					= 'large_first';
							break;


						/**
						 * Block Style: 1c
						 * Loop Template: loop-large_first.php
						 */
						case '1c':
						 	$excerpt_length = 15;
							$block_class 		= 'big-post-top-box';
							$style 					= 'large_first';
							break;


						/**
						 * Block Style: 2c
						 * Loop Template: loop-large_first.php
						 */
						case '2c':
						 	$excerpt_length = 20;
							$block_class 		= 'tie-col-sm-6 half-box';
							$style 					= 'large_first';
							break;


						/**
						 * Block Style: 1c
						 * Loop Template: loop-big_thumb.php
						 */
						case 'big_thumb':
							$block_class = 'big-post-left-box big-thumb-left-box';
							break;


						/**
						 * Block Style: Grid
						 * Loop Template: loop-grid.php
						 */
						case 'grid':
							$block_class 				 = 'news-gallery';
							$before_items 			 = '<ul class="news-gallery-items posts-list-container">';
							$block['number'] 		 = 13;
							$block['ajax_class'] = 'news-gallery-items';
							break;


						/**
						 * Block Style: Row
						 * Loop Template: loop-grid.php
						 */
						case 'row':
							$block_class 	       = 'news-gallery news-grid';
							$before_items	       = '<ul class="news-gallery-items">';
							$style 				       = 'grid';
							$block['ajax_class'] = 'news-gallery-items';
							break;


						/**
						 * Block Style: Scroll
						 * Loop Template: loop-scroll.php
						 */
						case 'scroll':
							$block_class 						= 'scrolling-box';
							$before_items 					= jannah_get_ajax_loader(false) .'<div class="scrolling-slider scrolling-box-slider">';
							$after_items 						= '</div>';
							$block['pagi'] 					= false;
							$block['filters'] 			= false;
							$block['scrolling_box'] = true;
							break;


						/**
						 * Block Style: Scroll2
						 * Loop Template: loop-scroll.php
						 */
						case 'scroll_2':
							$block_class 						= 'scrolling-box scroll-2-box';
							$before_items 					= jannah_get_ajax_loader(false) .'<div class="scrolling-slider">';
							$after_items 						= '</div>';
							$block['pagi']					= false;
							$block['filters'] 			= false;
							$block['scrolling_box'] = true;
							break;


						/**
						 * Block Style: Mini
						 * Loop Template: loop-mini.php
						 */
						case 'mini':
							$excerpt_length	= 12;
							$block_class 		= 'mini-posts-box';
							break;


						/**
						 * Block Style: Content
						 * Loop Template: loop-content.php
						 */
						case 'content':
							$block_class = 'full-width-img-news-box';
							break;


						/**
						 * Block Style: Timeline
						 * Loop Template: loop-timeline.php
						 */
						case 'timeline':
							$excerpt_length           = 15;
							$block_class 	          	= 'wide-post-box timeline-box';
							$block['order']           = false;
							$GLOBALS['timeline_time'] = false;
							break;


						/**
						 * Block Style: first_big
						 * Loop Template: loop-large_above.php
						 */
						case 'first_big':
							$block_class 	= 'miscellaneous-box';
							$style 				= 'large_above';
							break;


						/**
						 * Block Style: Slider
						 * Loop Template: loop-slider.php
						 */
						case 'slider':
							$block_class	= 'category-featured-posts';
							break;


						/**
						 * Block Style: Slider
						 * Loop Template: loop-slider.php
						 */
						case 'breaking':
							$block_class	= 'breaking-news-outer';
							break;


						/**
						 * Block Style: Tabs
						 */
						case 'tabs':
							$block_class	= 'tabs-container-wrapper tabs-box container-wrapper';
							break;


						/**
						 * Block Style: Ad
						 */
						case 'ad':
							$block_class = 'stream-item-mag stream-item';
							break;


						/**
						 * Block Style: Ad_50
						 */
						case 'ad_50':
							$block_class = 'stream-item-mag stream-item tie-col-sm-6 half-box';
							break;


						/**
						 * Block Style: Code
						 */
						case 'code':
							$block['pagi']    = false;
							$block['filters'] = false;
							$block_class      = 'block-custom-content';
							break;


						/**
						 * Block Style: Code_50
						 */
						case 'code_50':
							$block['pagi']    = false;
							$block['filters'] = false;
							$block_class      = 'block-custom-content-50 tie-col-sm-6 half-box';
							break;


						/**
						 * Block Style: woocommerce
						 */
						case 'woocommerce':
							//$block_class = 'scrolling-box latest-poroducts-box latest-poroducts-slider-box woocommerce';
							$block_class         = 'latest-poroducts-box latest-poroducts-normal-box woocommerce';
							$block_ul_class      = '';
							$block['filters']    = false;
							$block['ajax_class'] = 'products';

							if( $sidebar == 'full-width' ){
								add_filter( 'loop_shop_columns', 'jannah_wc_full_width_loop_shop_columns', 99, 1 );
							}
							else{
								remove_filter( 'loop_shop_columns', 'jannah_wc_full_width_loop_shop_columns', 99, 1 );
							}

							break;


						/**
						 * Block Style: woocommerce-slider
						 */
						case 'woocommerce-slider':
							$block_class 						= 'scrolling-box latest-poroducts-box latest-poroducts-slider-box woocommerce';
							$block_ul_class 				= ' scrolling-slider';
							$block['style'] 				= 'woocommerce';
							$block['pagi']					= false;
							$block['filters'] 			= false;
							$block['scrolling_box'] = true;
							break;


						default:
							$style = false;
							break;
					}



					# Content Only without wrapper
					/*-----------------------------------------------------------------------------------*/
					if( ! empty( $block['content_only'] ) ){
						$block_class .= ' content-only';
					}


					# Dark Skin Class
					/*-----------------------------------------------------------------------------------*/
					if( ! empty( $block['dark'] ) ){
						$block_class .= ' box-dark-skin dark-skin';
					}


					# Media Overlay Class
					/*-----------------------------------------------------------------------------------*/
					if( ! empty( $block['media_overlay'] ) ){
						$block_class .= ' media-overlay';
					}


					# Custom Excerpt Length
					/*-----------------------------------------------------------------------------------*/
					if( empty( $block['excerpt_length'] ) ){
						$block['excerpt_length'] = $excerpt_length;
					}


					# Classes for the 50% blocks
					/*-----------------------------------------------------------------------------------*/
					if( $block['style'] == '2c' || $block['style'] == 'ad_50' || $block['style'] == 'code_50' ){

						$count_half_box++;
						if( $count_half_box == 2 ){

							$block_class .= ' second-half-box';
							$after = '<div class="clearfix half-box-clearfix"></div>';

							//Reset the 2 columns counter ----------
							$count_half_box = 0;
						}
					}
					else{
						$count_half_box = 0;
					}


					# Prevent Taqyeem from displaying the review box in the content block
					/*-----------------------------------------------------------------------------------*/
					remove_filter( 'the_content', 'taqyeem_insert_review' );


					# Get the block query
					/*-----------------------------------------------------------------------------------*/
					$block_query = jannah_query( $block );

					$pagination_data = ! empty( $block['pagi'] ) ? ' data-current="1"' : '';
					?>


				<div id="tie-<?php echo esc_attr( $block['boxid'] ) ?>" class="mag-box <?php echo esc_attr( $block_class ) ?>"<?php echo ( $pagination_data ) ?>>
				<?php


			if( ! empty( $style ) ):

				/*-----------------------------------------------------------------------------------*/
				# Tabs Block
				/*-----------------------------------------------------------------------------------*/
				if( $style == 'tabs' ):

					$home_tabs = empty( $block['cat'] ) ? array() : $block['cat']; ?>

					<div class="tabs-widget">
						<div class="tabs-wrapper">

							<?php

							echo '<ul class="tabs-menu">';
							foreach ( $home_tabs as $cat ){
								echo'<li><a href="#cat-tab-'. $block['boxid'] .'-'. $cat .'">'. get_the_category_by_ID( $cat ) .'</a></li>';
							}
							echo '</ul>';

							$block['number'] = empty( $block['number'] ) ? 5 : $block['number'];

							$cat_num = 0;
							foreach ( $home_tabs as $cat ):

								$count = 0;
								$cat_num ++;

								// Do not duplicate posts ----------
								$tie_do_not_duplicate_builder = '';
								if( ! empty( $GLOBALS['tie_do_not_duplicate_builder'] ) && is_array( $GLOBALS['tie_do_not_duplicate_builder'] )){
									$tie_do_not_duplicate_builder = $GLOBALS['tie_do_not_duplicate_builder'];
								}

								$args = array(
									'cat'									=> $cat,
									'posts_per_page'			=> $block['number'],
									'no_found_rows'				=> true,
									'ignore_sticky_posts'	=> true,
									'post__not_in'	      => $tie_do_not_duplicate_builder,
									'no_found_rows'       => true,
								);

								$cat_query = new WP_Query( $args ); ?>

								<div id="cat-tab-<?php echo esc_attr( $block['boxid'] .'-'. $cat ) ?>" class="tab-content tab-wrap-<?php echo esc_attr( $cat_num ); ?>">
									<div class="tab-content-wrap">
										<div class="mag-box big-post-left-box">
											<div class="container-wrapper">
												<div class="mag-box-container">

												<?php
													if( $cat_query->have_posts() ){
														echo ( $before_items );
															while ( $cat_query->have_posts() ){

																$cat_query->the_post();
																$count++;

																$b_args = array(
																	'block' => $block,
																	'count' => $count,
																);
																jannah_get_template_part( 'framework/loops/loop', 'large_first', $b_args );

																# Do not dublicate posts ----------
																if( $is_do_not_dublicate ){
																	jannah_do_not_dublicate( $post->ID );
																}
															}
														echo ( $after_items );
													}
												?>

												</div><!-- .mag-box-container /-->
											</div><!-- .container-wrapper /-->
										</div><!-- .mag-box /-->
									</div><!-- .tab-content-wrap /-->
								</div><!-- .tab-content /-->
							<?php endforeach; ?>
						</div><!-- .tabs-wrapper-animated /-->
					</div><!-- .tabs-widget /-->
			    <?php





				/*-----------------------------------------------------------------------------------*/
				# Breeaking News
				/*-----------------------------------------------------------------------------------*/
				elseif( $style == 'breaking' ):

					jannah_get_template_part( 'framework/parts/breaking-news', '', array(
						'type'            => 'block',
						'breaking_id'     => $block['boxid'],
						'breaking_title'  => $block['title'],
						'breaking_effect' => $block['breaking_effect'],
						'breaking_arrows' => $block['breaking_arrows'],
						'breaking_type'   => '',
						'breaking_block'  => $block,
					));





				/*-----------------------------------------------------------------------------------*/
				# Ad and Ad 50% Block
				/*-----------------------------------------------------------------------------------*/
				elseif( $style == 'ad' || $style == 'ad_50' ):
					?>

					<div class="container-wrapper">

						<?php

						#Get the Ad banner Image ----------
						if( ! empty( $block['ad_img'] ) ){

							$ad_image = $block['ad_img'];
							$target 	= empty( $block['ad_target'] ) ? ''   : esc_attr( ' target="_blank"' );
							$nofollow = empty( $block['ad_nofollow'] ) ? '' : esc_attr( ' rel="nofollow"'  );
							$url      = apply_filters( 'jannah_ads_url', empty( $block['ad_url'] ) ? '' : esc_url( $block['ad_url'] ) );
							$alt 		  = empty( $block['ad_alt'] ) ? '' : esc_attr( $block['ad_alt'] );

							echo "
							<a href=\"$url\" title=\"$alt\"$target$nofollow>
								<img src=\"$ad_image\" alt=\"$alt\" width=\"728\" height=\"90\">
							</a>";
						}

						# Get the Ad Custom Code ----------
						elseif( ! empty( $block['ad_code'] ) ){
							echo do_shortcode( $block['ad_code'] );
						}

						?>

					</div><!-- .container-wrapper /-->
				<?php





				/*-----------------------------------------------------------------------------------*/
				# All Other blocks
				/*-----------------------------------------------------------------------------------*/
				else: ?>

					<div class="container-wrapper">

						<?php
						# Get The Blcok Title ----------
						jannah_block_title( $block );
						?>

						<div class="mag-box-container">

							<?php
							# Ad and Ad 50% Block
							/*-----------------------------------------------------------------------------------*/
							if( $style == 'code' || $style == 'code_50' ){

								# Get the custom content code and apply the content filters ----------
								if( ! empty( $block['custom_content'] ) ){
									echo '
										<div class="entry">'. apply_filters( 'the_content', $block['custom_content'] ) . '</div>
										<div class="clearfix"></div>
									';

								}
							}

							# WooCommerce Block
							/*-----------------------------------------------------------------------------------*/
							elseif( ( $style == 'woocommerce' || $style == 'woocommerce-slider' ) ){

								if( JANNAH_WOOCOMMERCE_IS_ACTIVE ){

									if( $style == 'woocommerce-slider'){
										jannah_get_ajax_loader();
									}

									echo '<ul class="products'. $block_ul_class .'">';

									if ( $block_query->have_posts() ){
										while ( $block_query->have_posts() ):
											$block_query->the_post();
											woocommerce_get_template_part( 'content', 'product' );
										endwhile;
									}
									else {
										_eti( 'No products found' );
									}

									echo '</ul>';
								}
								else{
									echo'<span class="theme-notice">'. esc_html__( 'This Block requires the WooCoomerce plugin.', 'jannah' ) .'</span>';
								}

							}

							# Posts Blocks
							/*-----------------------------------------------------------------------------------*/
							else{

								if( $block_query->have_posts() ){
									echo ( $before_items );
									while ( $block_query->have_posts() ){

										$block_query->the_post();
										$count++;

										$b_args = array(
											'block' => $block,
											'count' => $count,
										);
										jannah_get_template_part( 'framework/loops/loop', $style, $b_args );

										# Do not dublicate posts ----------
										if( $is_do_not_dublicate ){
											jannah_do_not_dublicate(  $post->ID );
										}
									}
									echo ( $after_items );
								}
							}
							?>

						</div><!-- .mag-box-container /-->


							<?php
							if ( ! empty( $block['pagi'] ) && $block_query->max_num_pages > 1 ){

								# Numeric Pagination ----------
								if( $block['pagi'] == 'numeric' ){
									jannah_pagination( array( 'query' => $block_query, 'type' => 'numeric' ) );
								}

								# Show more button Pagination ----------
								elseif( $block['pagi'] == 'show-more' ){
									echo'<a class="block-pagination next-posts show-more-button" data-text="'. __ti( 'Show More' ) .'">'. __ti( 'Show More' ) .'</a>';
								}

								# Load more button Pagination ----------
								elseif( $block['pagi'] == 'load-more' ){
									echo '<a class="block-pagination next-posts show-more-button load-more-button" data-text="'. __ti( 'Load More' ) .'">'. __ti( 'Load More' ) .'</a>';
								}
							}
							?>

					</div><!-- .container-wrapper /-->

				<?php endif; ?>

			</div><!-- .mag-box /-->

			<?php
				# Block Js Variable ----------
				if( ( ! empty( $block['pagi'] ) && $block['pagi'] != 'numeric' ) || ! empty( $block['filters'] ) ){
					$unwanted_keys 			= array(
						'title'   => '',
						'style'   => '',
						'url'     => '',
						'color'   => '',
						'ad_img'  => '',
						'ad_url'  => '',
						'ad_alt'  => '',
						'ad_code' => '',
						'videos'  => '',
						'boxid'   => '',
						'custom_content'   => '',
						'videos_list_data' => '',
					);
					$js_block 					= array_filter( $block );
					$js_block 					= array_diff_key( $js_block, $unwanted_keys );
					$js_block['style']	= $style; ?>

					<script>var js_tie_<?php echo esc_js($block['boxid']) ?> = <?php echo wp_json_encode( $js_block ) ?>;</script>

					<?php
				}

			endif;

				echo ( $after );

			} // else | it is not a slider
		} // Foreach
	} // if

	?>

		<?php echo ( $after_content ); ?>

			<?php
			if( ! empty( $sidebar_position ) && $sidebar_position != 'full'):

				if( ! empty( $section['settings']['predefined_sidebar'] ) ){
					if( ! empty( $section['settings']['sidebar_id'] ) ){
						$sidebar = $section['settings']['sidebar_id'];
					}
					else{
						$sidebar = jannah_get_option( 'sidebar_page' );

						# Default sidebar if there is no a custom sidebar ----------
						if( empty( $sidebar ) || ( ! empty( $sidebar ) && ! jannah_is_registered_sidebar( $sidebar ) )){
							 $sidebar = 'primary-widget-area';
						}
					}
				}
				else{
					$sidebar = $section_id;
				}


				# Show the sidebar if contains Widgets ----------
				if( is_active_sidebar( $sidebar ) ){

					$sidebar_class = 'sidebar tie-col-md-4 tie-col-xs-12 normal-side';

					if( ! empty( $section_settings['sticky_sidebar'] )){
						$sidebar_class .= ' is-sticky';
					}
				?>

					<aside class="<?php echo esc_attr( $sidebar_class ); ?>" aria-label="<?php esc_html_e( 'Primary Sidebar', 'jannah' ); ?>">
						<div class="theiaStickySidebar">
							<?php dynamic_sidebar( $sidebar ); ?>
						</div><!-- .theiaStickySidebar /-->
					</aside><!-- .sidebar /-->
				<?php
				}
			endif;
			?>

			<?php echo ( $after_sidebar ); ?>

			<?php
				if( $is_tag_open ){
					echo ( $container_close );
					$is_tag_open = false;
				}
			?>
	</div><!-- .section-item /-->
</div><!-- .<?php echo esc_attr( $section_id ) ?> /-->

	<?php
} // Foreach

	wp_reset_postdata();
}

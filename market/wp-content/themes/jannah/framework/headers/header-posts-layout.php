<?php

# Get the post layout ----------
if ( is_singular('post') ){

	# Post Layout ----------
	if( jannah_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' ) ){

		$post_layout = jannah_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' );
		$post_layout = ! empty( $post_layout ) ? $post_layout : 1;

		# Post title area ----------
		if( $post_layout == 3 || $post_layout == 7 ){
			echo '
				<div class="container">
					<div class="container-wrapper fullwidth-entry-title">';
						get_template_part( 'framework/parts/post', 'head' );
						echo '
					</div>
				</div>
			';
		}
		elseif( $post_layout == 4 || $post_layout == 5 || $post_layout == 8 ){

			# Normal Width layout ----------
			$before_featured     = $after_featured = '';
			$featured_area_class = 'full-width-area tie-parallax';
			$inner_featured_1    = '<div class="container">';
			$inner_featured_2    = '</div><!-- .container /-->';
			$bg_overlay_effect   =  '<div class="thumb-overlay"></div>';

			# Full Width layout ----------
			if( $post_layout == 5 ){
				$featured_area_class = 'container-wrapper tie-parallax';
				$before_featured     = '<div class="container">';
				$after_featured      = '</div><!-- .container /-->';
				$inner_featured_1    = $inner_featured_2 = '';
			}

			# Get the custom featured area bg ----------
			if( jannah_get_object_option( 'featured_custom_bg', 'cat_featured_custom_bg', 'tie_featured_custom_bg' ) ){
				$featured_img = jannah_get_object_option( 'featured_custom_bg', 'cat_featured_custom_bg', 'tie_featured_custom_bg' );
			}
			elseif( jannah_get_object_option( 'featured_use_fea', 'cat_featured_use_fea', 'tie_featured_use_fea' ) && has_post_thumbnail() ){
				$featured_img = jannah_thumb_src( 'full' );
			}

			$featured_bg = ! empty( $featured_img ) ? 'style="background-image: url('. $featured_img .')"' : '';


			if( $post_layout == 8 && ! empty( $featured_img ) ){

				$featured_color = jannah_get_object_option( 'featured_bg_color', 'cat_featured_bg_color', 'tie_featured_bg_color' );
				$featured_color = ! empty( $featured_color ) ? $featured_color : '';

				echo'
					<style scoped type="text/css">
						#tie-container,
						#tie-wrapper{
							background-color: '. $featured_color .';
							background-image: url('. $featured_img .');
						}
					</style>
				';

				$bg_overlay_effect   = '';
				$featured_bg         = '';
				$featured_area_class = 'full-width-area';
			}

			echo
				$before_featured.
				'<div '.$featured_bg.' class="fullwidth-entry-title single-big-img '. $featured_area_class .'">'
					.$bg_overlay_effect
					.$inner_featured_1;
					get_template_part( 'framework/parts/post', 'head' );
					echo
					$inner_featured_2 .'
					</div><!-- .single-big-img /-->
				'.$after_featured;
		}

		# Post featured area ----------
		if( $post_layout == 6 || $post_layout == 7 ){

			$before_featured = $after_featured = '';

			if( jannah_get_postdata( 'tie_post_head' ) != 'slider' && jannah_get_postdata( 'tie_post_head' ) != 'map' ){
				$before_featured = '<div class="container">';
				$after_featured  = '</div><!-- .container /-->';
			}

			echo ( $before_featured );
				get_template_part( 'framework/parts/post', 'featured' );
			echo ( $after_featured );
		}
	}
}

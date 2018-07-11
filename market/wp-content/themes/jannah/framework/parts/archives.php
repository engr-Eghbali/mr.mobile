<?php



# Prepare the posts settings ----------
	$b_args = array(
		'uncropped_image' => isset( $uncropped_image ) ? $uncropped_image : 'jannah-image-grid',
		'category_meta'   => isset( $category_meta ) ? $category_meta : true,
		'post_meta'       => isset( $post_meta ) ? $post_meta : true,
		'excerpt'         => isset( $excerpt ) ? $excerpt : true,
		'excerpt_length'  => isset( $excerpt_length ) ? $excerpt_length : true,
		'read_more'       => isset( $read_more ) ? $read_more : true,
		'title_length'    => 0
	);

	$settings = str_replace( '"', '\'', wp_json_encode( $b_args ));



	# Overlay & Overlay with Spaces
	/*-----------------------------------------------------------------------------------*/
	if( $layout == 'overlay' || $layout == 'overlay-spaces' || $layout == 'masonry' ){

		if( $layout == 'overlay-spaces' ){
			$before = '<div id="media-page-layout" class="masonry-grid-wrapper media-page-layout masonry-with-spaces">';
			$layout = 'overlay'; // to overwride overlay-spaces
		}
		elseif( $layout == 'masonry' ){
			$before = '<div class="masonry-grid-wrapper masonry-with-spaces">';
		}
		else{
			$before = '<div id="media-page-layout" class="masonry-grid-wrapper media-page-layout masonry-without-spaces">';
		}

		# Loader icon ----------
		if( $layout == 'overlay' ){
			$before .= jannah_get_ajax_loader( false );
		}

				$before .= '
				<div id="masonry-grid" data-layout="'. $layout .'" data-settings="'. $settings .'">';


						$after = '
					<div class="grid-sizer"></div>
					<div class="gutter-sizer"></div>
				</div><!-- #masonry-grid /-->
			</div><!-- .masonry-grid-wrapper /-->';

		# Load the masonry.js library ----------
		wp_enqueue_script( 'jquery-masonry' );

		$masonry_js = "
			jQuery(window).load(function(){
				jQuery('#masonry-grid').masonry('layout');
			})
		";

		jannah_add_inline_script( 'jquery-masonry', $masonry_js );
	}





	# All other layouts have the same HTML structure except Class
	/*-----------------------------------------------------------------------------------*/
	else{

		# Full Thumb Layout ----------
		if( $layout == 'full_thumb' ){
			$class = 'full-width-img-news-box';
		}

		# Content Layout ----------
		elseif( $layout == 'content' ){
			$class = 'full-width-img-news-box';
		}

		# TimeLine Layout ----------
		elseif( $layout == 'timeline' ){
			$class = 'wide-post-box timeline-box';
		}

		# Default Layout ----------
		else{
			$layout = 'default';
			$class  = 'wide-post-box';
		}

		# Media Overlay ----------
		$class .= ! empty( $media_overlay ) ? ' media-overlay' : '';


		# HTML Markup ----------
		$before = '
			<div class="mag-box '. $class .'">
				<div class="container-wrapper">
					<div class="mag-box-container">
						<ul id="posts-container" data-layout="'. $layout .'" data-settings="'. $settings .'" class="posts-items">';
							$after = '
						</ul><!-- #posts-container /-->
					</div><!-- .mag-box-container /-->
				</div><!-- .container-wrapper /-->
			</div><!-- .mag-box /-->
		';

	}



	# Get the layout template
	/*-----------------------------------------------------------------------------------*/
	echo ( $before );

	while ( have_posts() ) : the_post();

		jannah_get_template_part( 'framework/loops/loop', $layout, array( 'block' => $b_args ) );

	endwhile;

	echo ( $after );

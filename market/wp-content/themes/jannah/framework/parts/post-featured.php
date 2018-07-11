<?php

$post_format = jannah_get_postdata( 'tie_post_head' ) ? jannah_get_postdata( 'tie_post_head' ) : 'standard';

if( $post_format ){ // $post_format == 'standard' and no feature image

	$before = '<div class="featured-area">';
	$after  = '</div><!-- .featured-area /-->';


	# Get Post Layout --------
	$post_layout = jannah_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' );
	$post_layout = ! empty( $post_layout ) ? $post_layout : 1;


	# Get the post thumbnail size ----------
	$size = ( jannah_get_object_option( 'sidebar_pos', 'cat_sidebar_pos', 'tie_sidebar_pos' ) == 'full' ) ? 'jannah-image-full' : 'jannah-image-post';

	if( $post_layout == 6 || $post_layout == 7 ){
		$size = 'jannah-image-full';
	}


	# Get the post video ----------
	if( $post_format == 'video' ){

		echo ( $before );
			jannah_video();
		echo ( $after );
	}


	# Get post audio ----------
	elseif( $post_format == 'audio' ){

		# SoundCloud ----------
		if( jannah_get_postdata( 'tie_audio_soundcloud' )){

			echo ( $before );
				echo jannah_soundcloud( jannah_get_postdata( 'tie_audio_soundcloud' ), 'false', 'true' );
			echo ( $after );
		}

		# Self Hosted audio ----------
		elseif( jannah_get_postdata( 'tie_audio_mp3' ) ||
		        jannah_get_postdata( 'tie_audio_m4a' ) ||
		        jannah_get_postdata( 'tie_audio_oga' ) ){

			echo ( $before );
				the_post_thumbnail( $size );
				jannah_audio();
			echo ( $after );
		}
	}


	# Get post map ----------
	elseif( $post_format == 'map' ){

		echo ( $before );
			echo jannah_google_maps( jannah_get_postdata( 'tie_googlemap_url' ));
		echo ( $after );
	}

	# Get post featured image ----------
	elseif( $post_format == 'thumb' ||
		    ( $post_format == 'standard' && ( jannah_get_object_option( 'post_featured', 'cat_post_featured', 'tie_post_featured' ) && jannah_get_object_option( 'post_featured', 'cat_post_featured', 'tie_post_featured' ) != 'no' ))){

		if( has_post_thumbnail() ){

			# Uncropped featured image ----------
			if( jannah_get_object_option( 'image_uncropped', 'cat_image_uncropped', 'tie_image_uncropped' )){
				$size = 'full';
			}

			# Featured image Lightbox ----------
			$lightbox_before = '';
			$lightbox_after  = '';

			if( $post_format == 'thumb' && jannah_get_object_option( 'image_lightbox', 'cat_image_lightbox', 'tie_image_lightbox' ) && jannah_get_object_option( 'image_lightbox', 'cat_image_lightbox', 'tie_image_lightbox' ) != 'no' ){
				$lightbox_url    = jannah_thumb_src( 'full' );
				$lightbox_before = '<a href="'. $lightbox_url .'" class="lightbox-enabled">';
				$lightbox_after  = '</a><!-- .lightbox-enabled /-->';
			}

			# Display the featured image ----------
			echo ( $before );
				echo '<figure class="single-featured-image">';
					echo ( $lightbox_before );
						the_post_thumbnail( $size );
					echo ( $lightbox_after );

					# Featured image caption ----------
					$thumb_caption = get_post( get_post_thumbnail_id() );
					if( ! empty( $thumb_caption->post_excerpt )){
						echo '
							<figcaption class="single-caption-text">
								<span class="fa fa-camera" aria-hidden="true"></span> '.
								$thumb_caption->post_excerpt .'
							</figcaption>
						';
					}
				echo '</figure>';
			echo ( $after );
		}
	}


	# Get post slider ----------
	elseif( $post_format == 'slider' ){

		# Enqueue the Sliders Js file ----------
		wp_enqueue_script( 'jannah-sliders' );


		if( $post_layout == 6 || $post_layout == 7 ){
			$size      = 'full';
			$slider_id = 'tie-post-fullwidth-gallery';
			$class     = '';
			$data_attr = '';

			$post_slider = "
				jQuery(document).ready(function(){
					jQuery('#tie-post-fullwidth-gallery .tie-slick-slider').slick({
						infinite     : true,
						rtl          : is_RTL,
						slide        : '.slide',
						centerMode   : true,
						variableWidth: true,
						appendArrows : '#tie-post-fullwidth-gallery .slider-nav',
						prevArrow    : '<li><span class=\"fa fa-angle-left\"></span></li>',
						nextArrow    : '<li><span class=\"fa fa-angle-right\"></span></li>'
					});
					jQuery('#tie-post-fullwidth-gallery .slide').velocity('transition.slideUpIn',{stagger: 200});
					jQuery('#tie-post-fullwidth-gallery').find('.loader-overlay').remove();
				});
			";

			jannah_add_inline_script( 'jannah-sliders', $post_slider );
		}
		else{
			$slider_id = 'tie-post-normal-gallery';
			$class     = ' tie-slick-slider-wrapper';
			$data_attr = 'data-slider-id="10"';
		}

		# Custom slider ----------
		if( jannah_get_postdata( 'tie_post_slider' )){
			$slider     = jannah_get_postdata( 'tie_post_slider' );
			$get_slider = get_post_custom( $slider );

			if( ! empty( $get_slider['custom_slider'][0] ) ){
				$images = maybe_unserialize( $get_slider['custom_slider'][0] );
			}
		}

		# Uploaded images ----------
		elseif( jannah_get_postdata( 'tie_post_gallery' )){
			$images = maybe_unserialize( jannah_get_postdata( 'tie_post_gallery' ));
		}

		if( ! empty( $images ) && is_array( $images ) ){

			echo ( $before ); ?>

			<div id="<?php echo esc_attr( $slider_id ) ?>" class="post-gallery<?php echo esc_attr( $class ) ?>" <?php echo ( $data_attr ) ?>>

				<?php
					# Loader icon ----------
					jannah_get_ajax_loader();
				?>

				<div class="tie-slick-slider">
					<ul class="slider-nav"></ul>
					<?php

					foreach( $images as $single_image ):
						$image = wp_get_attachment_image_src( $single_image['id'], $size ); ?>

						<div class="slide">
							<div class="thumb-overlay">
								<div class="thumb-content">

									<?php

									# Get the image title ----------
									if( ! empty( $single_image['title'] )){
										$title = $single_image['title'];
									}
									else{
										$title = get_post_field( 'post_content', $single_image['id'] );
									}

									if( ! empty( $title ) ){
										echo '<h3 class="thumb-title">'. $title .'</h3>';
									}

									# Get the image description ----------
									if( ! empty( $single_image['caption'] )){
										echo '<div class="thumb-desc">'. $single_image['caption'] .'</div>';
									}

									?>

								</div><!-- .thumb-content /-->
							</div><!-- .thumb-overlay /-->

							<?php

							$link_before = $link_after = '';
							if( ! empty( $single_image['link'] )){
								$link_before = '<a href="'. esc_url( $single_image['link'] ) .'">';
								$link_after  = '</a>';
							}

							echo
								$link_before.
									'<img src="'. esc_attr( $image[0] ) .'" width="'. esc_attr( $image[1] ) .'" height="'. esc_attr( $image[2] ) .'" alt="'. esc_attr($title) .'">'.
								$link_after;

							?>

						</div><!-- .slide /-->
						<?php
					endforeach;
					?>
				</div><!-- .tie-slick-slider /-->
			</div><!-- .post-gallery /-->
			<?php
			echo ( $after );

		}
	} // Post Format type if

}
?>

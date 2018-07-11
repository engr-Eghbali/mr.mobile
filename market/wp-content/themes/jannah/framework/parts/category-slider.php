<?php

if( is_category() && jannah_get_category_option( 'featured_posts' )){

	# Category Settings ----------
	$slider           = jannah_get_category_option( 'featured_posts_style' );
	$background_color = jannah_get_category_option( 'featured_posts_color' );
	$background_img   = jannah_get_category_option( 'featured_posts_bg' );
	$background_video = jannah_get_category_option( 'featured_posts_bg_video' );
	$parallax         = jannah_get_category_option( 'featured_posts_parallax' );
	$parallax_effect  = jannah_get_category_option( 'featured_posts_parallax_effect' );


	$section_styles = array();

	$classes = array(
		'full-width',
		'is-first-section',
	);

	$outer_class      = '';
	$section_video_bg = '';
	$parallax_options = '';


	# Background ----------
	$section_bg_class = ' without-background';

	if( $background_img || $background_color || $background_video ){

		$section_bg_class = ' has-background';

		if( $background_color ){
			$section_styles[] = 'background-color: '. $background_color .';';
		}

		if( $background_video ){
			$section_video_bg = 'data-jarallax-video="'. $background_video .'"';
			$classes[] = 'has-video-background';
		}
		elseif( $background_img ){
			$section_styles[] = 'background-image: url( '. $background_img .');';
		}

		if( $parallax ){
			$classes[] = 'tie-parallax';

			$parallax_effect  = $parallax_effect ? $parallax_effect : 'scroll';
			$parallax_options = " data-jarallax='{\"type\":\"$parallax_effect\"}'";

		}
		else{
			$section_styles[] = 'background-size: cover;';
		}
	}


	$outer_class .= $section_bg_class;

	if( $slider < 5 && $slider != 'videos_list' ){
		$classes[] = 'first-block-is-full-width';
	}

	?>
		<div id="category-slider" class="section-wrapper container-full <?php echo esc_attr( $outer_class ) ?>">
			<div class="section-item <?php echo join( ' ', $classes ); ?>" style="<?php echo join( ' ', $section_styles ); ?>" <?php echo ( $section_video_bg.$parallax_options ) ?>>

				<?php

					if( $slider > 4 || $slider == 'videos_list' ) echo '<div class="container">';

					get_template_part('framework/parts/featured');

					if( $slider > 4 ) echo '</div>';
				?>

			</div><!-- .section-item /-->
		</div><!-- #category-slider /-->
	<?php
}

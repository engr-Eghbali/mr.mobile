<?php

	$category_id = $GLOBALS['category_id'];

	$sliders_list = jannah_get_custom_sliders( true );

	jannah_theme_option(
		array(
			'title' => esc_html__( 'TieLabs Slider', 'jannah' ),
			'type'  => 'header',
		));

	jannah_category_option(
		array(
			'name'   => esc_html__( 'Enable', 'jannah' ),
			'id'     => 'featured_posts',
			'toggle' => '#main-slider-options',
			'type'   => 'checkbox',
			'cat'     => $category_id,
		));


	$current_slider = jannah_get_category_option( 'featured_posts_style', $category_id );
	$current_slider = ! empty( $current_slider ) ? $current_slider : 1 ;

?>

<div id="main-slider-options" style="display: none;" class="slider_<?php echo esc_attr( $current_slider )?>-container">

	<?php

		$main_slider_styles = array();

		$slider_path = 'blocks/block-';
		for( $slider = 1; $slider <= 16; $slider++ ){

			$slide_class 	= 'slider_'.$slider;
			$slide_img 		= $slider_path.'slider_'.$slider.'.png';

			$main_slider_styles[ $slider ] = array( sprintf( esc_html__( 'Slider #%s', 'jannah' ), $slider ) => array( $slide_class => $slide_img ) );
		}

		$main_slider_styles['videos_list'] = array( esc_html__( 'Videos Playlist', 'jannah' ) => array( 'video_play_list' => $slider_path. 'videos_list.png' ) );


		jannah_category_option(
			array(
				'id'      => 'featured_posts_style',
				'type'    => 'visual',
				'cat'     => $category_id,
				'options' => $main_slider_styles,
			));

		jannah_category_option(
			array(
				'name'    =>  esc_html__( 'Number of posts to show', 'jannah' ),
				'id'      => 'featured_posts_number',
				'class'   => 'featured-posts',
				'default' => 10,
				'type'    => 'number',
				'cat'     => $category_id,
			));

		jannah_category_option(
			array(
				'name'   => esc_html__( 'Query Type', 'jannah' ),
				'id'     => 'featured_posts_query',
				'class'  => 'featured-posts',
				'type'   => 'radio',
				'cat'     => $category_id,
				'toggle' => array(
						'recent' => '',
						'random' => '',
						'custom' => '#featured_posts_custom-item' ),
				'options' => array(
						'recent' => esc_html__( 'Recent Posts', 'jannah' ),
						'random' => esc_html__( 'Random Posts', 'jannah' ),
						'custom' => esc_html__( 'Custom Slider', 'jannah' ),
				)));

		echo '<div class="featured-posts-options">';

		jannah_category_option(
			array(
				'name'    => esc_html__( 'Custom Slider', 'jannah' ),
				'id'      => 'featured_posts_custom',
				'class'   => 'featured_posts_query',
				'type'    => 'select',
				'cat'     => $category_id,
				'options' => $sliders_list,
			));

		echo '</div>';

		jannah_category_option(
			array(
				'name'  => esc_html__( 'Colored Mask', 'jannah' ),
				'id'    => 'featured_posts_colored_mask',
				'class' => 'featured-posts',
				'type'  => 'checkbox',
				'cat'   => $category_id,
			));

		jannah_category_option(
			array(
				'name'  => esc_html__( 'Media Icon Overlay', 'jannah' ),
				'id'    => 'featured_posts_media_overlay',
				'class' => 'featured-posts',
				'type'  => 'checkbox',
				'cat'   => $category_id,
			));

		jannah_category_option(
			array(
				'name'  =>  esc_html__( 'Animate Automatically', 'jannah' ),
				'id'    => 'featured_auto',
				'class' => 'featured-posts',
				'type'  => 'checkbox',
				'cat'   => $category_id,
			));

		jannah_category_option(
			array(
				'name'  => esc_html__( 'Title Length', 'jannah' ),
				'id'    => 'featured_posts_title_length',
				'class'	=> 'featured-posts',
				'type'  => 'number',
				'cat'   => $category_id,
			));


		echo '<div class="excerpt-options featured-posts-options">';
			jannah_category_option(
				array(
					'name'   => esc_html__( 'Posts Excerpt', 'jannah' ),
					'id'     => 'featured_posts_excerpt',
					'type'   => 'checkbox',
					'toggle' => '#featured_posts_excerpt_length-item',
					'cat'    => $category_id,
				));

			jannah_category_option(
				array(
					'name'  => esc_html__( 'Posts Excerpt Length', 'jannah' ),
					'id'    => 'featured_posts_excerpt_length',
					'type'  => 'number',
					'cat'   => $category_id,
				));
		echo '</div>';


		jannah_category_option(
			array(
				'name'  => esc_html__( 'Post Primary Category', 'jannah' ),
				'id'    => 'featured_posts_category',
				'class'	=> 'slider-category-option featured-posts',
				'type'  => 'checkbox',
				'cat'   => $category_id,
			));

		jannah_category_option(
			array(
				'name'  => esc_html__( 'Post Puplished date', 'jannah' ),
				'id'    => 'featured_posts_date',
				'class'	=> 'featured-posts',
				'type'  => 'checkbox',
				'cat'   => $category_id,
			));

		jannah_category_option(
			array(
				'name'  => esc_html__( 'Playlist title', 'jannah' ),
				'id'    => 'featured_videos_list_title',
				'class' => 'featured-videos',
				'type'	=> 'text',
				'cat'   => $category_id,
			));

		jannah_category_option(
			array(
				'name'  => esc_html__( 'Videos List', 'jannah' ),
				'hint'  => esc_html__( 'Enter each video url in a seprated line.', 'jannah' ) . ' <strong>' . esc_html__( 'Supports: YouTube and Vimeo videos only.', 'jannah' ).'</strong>',
				'id'    => 'featured_videos_list',
				'class' => 'featured-videos',
				'type'  => 'textarea',
				'cat'   => $category_id,
			));

		jannah_category_option(
			array(
				'name' => esc_html__( 'Background Color', 'jannah' ),
				'id'   => 'featured_posts_color',
				'type' => 'color',
				'cat'  => $category_id,
			));

		jannah_category_option(
			array(
				'name' => esc_html__( 'Background Image', 'jannah' ),
				'id'   => 'featured_posts_bg',
				'type' => 'upload',
				'cat'  => $category_id,
			));

		jannah_category_option(
			array(
				'name' => esc_html__( 'Background Video', 'jannah' ),
				'id'   => 'featured_posts_bg_video',
				'type' => 'text',
				'cat'  => $category_id,
			));

		jannah_category_option(
			array(
				'name'   => esc_html__( 'Parallax', 'jannah' ),
				'id'     => 'featured_posts_parallax',
				'type'   => 'checkbox',
				'toggle' => '#featured_posts_parallax_effect-item',
				'cat'    => $category_id,
			));

		jannah_category_option(
			array(
				'name' => esc_html__( 'Parallax Effect', 'jannah' ),
				'id'   => 'featured_posts_parallax_effect',
				'type' => 'select',
				'cat'  => $category_id,
				'options' => array(
					'scroll'         => esc_html__( 'Scroll', 'jannah' ),
					'scale'          => esc_html__( 'Scale', 'jannah' ),
					'opacity'        => esc_html__( 'Opacity', 'jannah' ),
					'scroll-opacity' => esc_html__( 'Scroll + Opacity', 'jannah' ),
					'scale-opacity'  => esc_html__( 'Scale + Opacity', 'jannah' ),
			)));
	?>
</div><!-- #main-slider-options /-->

<?php


	# Revolution Slider ----------
	if( JANNAH_REVSLIDER_IS_ACTIVE ){

		jannah_theme_option(
			array(
				'title' => esc_html__( 'Revolution Slider', 'jannah' ),
				'type'  => 'header',
			));

		$rev_slider = new RevSlider();
		$rev_slider = $rev_slider->getArrSlidersShort();

		if( ! empty( $rev_slider ) && is_array( $rev_slider )){

			$arrSliders = array( '' => esc_html__( 'Disable', 'jannah' ) );

			foreach( $rev_slider as $id => $item ){
				$name = empty( $item ) ? esc_html__( 'Unnamed', 'jannah' ) : $item;
				$arrSliders[ $id ] = $name . ' | #' .$id;
			}

			jannah_theme_option(
				array(
					'text' => esc_html__( 'Will override the sliders above.', 'jannah' ),
					'type' => 'message',
				));

			jannah_category_option(
				array(
					'name'    => esc_html__( 'Choose Slider', 'jannah' ),
					'id'      => 'revslider',
					'type'    => 'select',
					'cat'     => $category_id,
					'options' => $arrSliders,
				));
		}
		else{

			jannah_theme_option(
				array(
					'text' => esc_html__( 'No sliders found, Please create a slider.', 'jannah' ),
					'type' => 'error',
				));
		}
	}


	# LayerSlider ----------
	if( JANNAH_LS_Sliders_IS_ACTIVE ){

		jannah_theme_option(
			array(
				'title' => esc_html__( 'LayerSlider', 'jannah' ),
				'type'  => 'header',
			));

		$ls_sliders = LS_Sliders::find(array('limit' => 100));

		if( ! empty( $ls_sliders ) && is_array( $ls_sliders ) ){

			jannah_theme_option(
				array(
					'text' => esc_html__( 'Will override the sliders above.', 'jannah' ),
					'type' => 'message',
				));

			$arrSliders = array( '' => esc_html__( 'Disable', 'jannah' ) );

			foreach( $ls_sliders as $item ){
				$name = empty( $item['name'] ) ? esc_html__( 'Unnamed', 'jannah' ) : $item['name'];
				$arrSliders[ $item['id'] ] = $name . ' | #' .$item['id'];
			}

			jannah_category_option(
				array(
					'name'    => esc_html__( 'Choose Slider', 'jannah' ),
					'id'      => 'lsslider',
					'type'    => 'select',
					'cat'     => $category_id,
					'options' => $arrSliders,
				));

		}
		else{

			jannah_theme_option(
				array(
					'text' => esc_html__( 'No sliders found, Please create a slider.', 'jannah' ),
					'type' => 'error',
				));
		}
	}

?>

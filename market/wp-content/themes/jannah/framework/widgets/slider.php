<?php

if( ! class_exists( 'TIE_SLIDER_WIDGET' )){

	/**
	 * Widget API: TIE_SLIDER_WIDGET class
	 */
	 class TIE_SLIDER_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops 	= array( 'classname' => 'tie-slider-widget' );
			parent::__construct( 'tie-slider-widget', JANNAH_THEME_NAME .' - '.esc_html__( 'Slider', 'jannah'), $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$no_of_posts   = isset( $instance['no_of_posts'] ) ? $instance['no_of_posts'] : 5;
			$custom_slider = isset( $instance['custom_slider'] ) ? $instance['custom_slider'] : '';
			$posts_order   = isset( $instance['posts_order'] ) ? $instance['posts_order'] : 'latest';
			$cats_id       = '';

			if( ! empty( $instance['cats_id'] )){
				$cats_id = explode ( ',', $instance['cats_id'] );
			}

			if( ! empty( $instance['slider_only'] )){
				$args['before_widget'] = '<div id="'. $args['widget_id'] .'" class="widget container-wrapper tie-slider-widget widget-content-only">';
				$args['after_widget']  = '</div>';
				$instance['title']     = '';
			}

			# Enqueue the Sliders Js file ----------
			wp_enqueue_script( 'jannah-sliders' );


			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			?>

			<div class="main-slider boxed-slider boxed-five-slides-slider slider-in-widget">

				<?php
					# Loader icon ----------
					jannah_get_ajax_loader();
				?>

				<div class="main-slider-wrapper">
					<ul class="slider-nav"></ul>
					<div class="container">
						<div class="tie-slick-slider">

						<?php

							if( empty( $custom_slider ) ):

								$quert_args = array(
									'number' => $no_of_posts,
									'order'  => $posts_order,
									'id'     => $cats_id
								);

								$slider_query = jannah_query( $quert_args );

								if( $slider_query->have_posts() ):
									while ( $slider_query->have_posts() ):  $slider_query->the_post(); ?>
										<div style="<?php echo jannah_thumb_src_bg( 'jannah-image-post' ) ?>" class="slide">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="all-over-thumb-link"></a>
											<div class="thumb-overlay">
												<div class="thumb-content">
													<?php jannah_the_post_meta( array( 'author' => false, 'comments' => false, 'views' => false ), '<div class="thumb-meta">', '</div>' ); ?>
													<h3 class="thumb-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
												</div><!-- .thumb-content -->
											</div><!-- .thumb-overlay -->
										</div><!-- .slide /-->
										<?php
									endwhile;
	 							endif;

	 						else:

								$custom = get_post_custom( $custom_slider );
								$slider = maybe_unserialize( $custom['custom_slider'][0] );
								$number = count($slider);

								if( ! empty( $slider ) ):

									foreach( $slider as $slide ): ?>

										<div style="background-image: url(<?php echo  jannah_slider_img_src( $slide['id'] , 'tie-large' ) ?>)" class="slide">
											<div class="tie-slide-overlay-bg"></div>

											<?php if( ! empty( $slide['link'] ) ): ?>
												<a href="<?php  echo esc_attr( $slide['link'] ) ?>" class="all-over-thumb-link">
											<?php endif; ?>

											<div class="thumb-overlay">
												<?php if( ! empty( $slide['title'] ) ): ?>
													<div class="thumb-content">
														<h3 class="thumb-title"><?php echo esc_html( $slide['title'] ); ?></h3>
													</div>
												<?php endif; ?>
											</div>

											<?php if( ! empty( $slide['link'] ) ):?>
												</a>
											<?php endif; ?>

										</div><!-- .slide /-->

										<?php
									endforeach;
								endif;
							endif;
						?>
						</div><!-- .tie-slick-slider /-->
					</div><!-- .container /-->
				</div><!-- .main-slider-wrapper /-->
			</div><!-- #main-slider /-->
		<?php
			wp_reset_postdata();

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                  = $old_instance;
			$instance['title']         = sanitize_text_field( $new_instance['title'] );
			$instance['no_of_posts']   = $new_instance['no_of_posts'];
			$instance['custom_slider'] = $new_instance['custom_slider'];
			$instance['slider_only']   = $new_instance['slider_only'];
			$instance['posts_order']   = $new_instance['posts_order'];
			$instance['cats_id']       = implode( ',', $new_instance['cats_id'] );
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => esc_html__( 'Featured Posts', 'jannah') ,'no_of_posts' => '5', 'cats_id' => '1' );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title         = isset( $instance['title'] ) ? esc_attr( $instance['title']) : '';
			$no_of_posts   = isset( $instance['no_of_posts'] ) ? esc_attr( $instance['no_of_posts']) : 5;
			$slider_only   = isset( $instance['slider_only'] ) ? esc_attr( $instance['slider_only']) : '';
			$custom_slider = isset( $instance['custom_slider'] ) ? esc_attr( $instance['custom_slider']) : '';
			$posts_order   = isset( $instance['posts_order'] ) ? esc_attr( $instance['posts_order']) : '';
			$cats_id       = array();

			if( ! empty( $instance['cats_id'] )){
				$cats_id = explode ( ',', $instance['cats_id'] );
			}

			//Post Order ----------
			$post_order = array(
				'latest'   => esc_html__( 'Recent Posts', 'jannah' ),
				'rand'     => esc_html__( 'Random Posts', 'jannah' ),
				'modified' => esc_html__( 'Last Modified Posts', 'jannah' ),
				'popular'  => esc_html__( 'Most Commented posts', 'jannah' ),
			);

			if( jannah_get_option( 'post_views' ) ){
				$post_order['views'] = esc_html__( 'Most Viewed posts', 'jannah' );
			}

			if( JANNAH_TAQYEEM_IS_ACTIVE ){
				$post_order['best'] = esc_html__( 'Best Reviews', 'jannah' );
			}


			$sliders    = jannah_get_custom_sliders( true );
			$categories = jannah_get_categories_array();

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'jannah' ) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'slider_only' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slider_only' ) ); ?>" value="true" <?php checked( $slider_only, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'slider_only' ) ); ?>"><?php esc_html_e( 'Show the Slider only?', 'jannah') ?></label>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'no_of_posts' ) ); ?>"><?php esc_html_e( 'Number of posts to show', 'jannah' ) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'no_of_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no_of_posts' ) ); ?>" value="<?php echo esc_attr( $no_of_posts ) ?>" type="number" step="1" min="1" size="3" class="tiny-text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cats_id' ) ); ?>"><?php esc_html_e( 'Categories', 'jannah') ?></label>
				<select multiple="multiple" id="<?php echo esc_attr( $this->get_field_id( 'cats_id' ) ); ?>[]" name="<?php echo esc_attr( $this->get_field_name( 'cats_id' ) ); ?>[]" class="widefat">
					<?php foreach ($categories as $key => $option){ ?>
					<option value="<?php echo esc_attr( $key ) ?>" <?php if ( in_array( $key , $cats_id ) ){ echo ' selected="selected"' ; } ?>><?php echo esc_html( $option ); ?></option>
					<?php } ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>"><?php esc_html_e( 'Posts order:', 'jannah' ) ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_order' ) ); ?>" class="widefat">
					<?php
						foreach( $post_order as $order => $text ){ ?>
							<option value="<?php echo esc_attr( $order ) ?>" <?php selected( $posts_order, $order ); ?>><?php echo esc_html( $text ) ?></option>
							<?php
						}
					?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'custom_slider' ) ); ?>"><strong><?php esc_html_e( '- OR -', 'jannah') ?></strong> <?php esc_html_e( 'Custom Slider', 'jannah' ) ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'custom_slider' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_slider' ) ); ?>" class="widefat">
					<?php foreach ($sliders as $key => $option){ ?>
					<option value="<?php echo esc_attr( $key ) ?>" <?php selected( $custom_slider, $key ) ?>><?php echo esc_attr( $option ); ?></option>
					<?php } ?>
				</select>
			</p>
		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_slider_widget_register' );
	function tie_slider_widget_register(){
		register_widget( 'TIE_SLIDER_WIDGET' );
	}

}
?>

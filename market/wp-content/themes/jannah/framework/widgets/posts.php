<?php

if( ! class_exists( 'TIE_POSTS_LIST' )){

	/**
	 * Widget API: TIE_Posts_List class
	 */
	 class TIE_POSTS_LIST extends WP_Widget {


		public function __construct(){
			$widget_ops = array( 'classname' => 'posts-list' );
			parent::__construct( 'posts-list-widget', JANNAH_THEME_NAME .' - '. esc_html__( 'Posts list', 'jannah'), $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			# Query arguments ----------
			$style_args    = array();
			$no_of_posts   = isset( $instance['no_of_posts'] ) ? $instance['no_of_posts'] : 5;
			$offset        = isset( $instance['offset'] ) ? $instance['offset'] : '';
			$posts_order   = isset( $instance['posts_order'] ) ? $instance['posts_order'] : 'latest';
			$class         = isset( $instance['media_overlay'] ) ? 'media-overlay ' : '';
			$cats_id       = empty( $instance['cats_id'] ) ? '' : explode ( ',', $instance['cats_id'] );
			$before_posts  = '<ul class="posts-list-items">';
			$after_posts   = '</ul>';

			$query_args = array(
				'number' => $no_of_posts,
				'offset' => $offset,
				'order'  => $posts_order,
				'id'     => $cats_id,
			);

			# Style ----------
			$layouts = array(
				1  => '',
				2  => 'timeline-widget',
				3  => 'posts-list-big-first',
				4  => 'posts-list-bigs',
				5  => 'posts-list-half-posts',
				6  => 'posts-pictures-widget',
				7  => 'posts-list-counter',
			);

			if( ! empty( $instance['style'] ) && ! empty( $layouts[ $instance['style'] ] )){
				$class .= $layouts[ $instance['style'] ];

				if( $instance['style'] == 2 ){
					$style_args['style'] = 'timeline';
				}

				elseif( $instance['style'] == 3 ){
					$style_args['thumbnail_first'] = 'jannah-image-large';
					$style_args['review_first']    = 'large';
				}

				elseif( $instance['style'] == 4 ){
					$style_args['thumbnail']  = 'jannah-image-large';
					$style_args['review']     = 'large';
					$style_args['show_score'] = false;
				}

				elseif( $instance['style'] == 5 ){
					$style_args['thumbnail'] = 'jannah-image-large';
				}

				elseif( $instance['style'] == 6 ){
					$style_args['style'] = 'grid';
					$before_posts = '<div class="tie-row">';
					$after_posts  = '</div>';
				}
			}

			# Print the widget ----------
			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			echo '<div class="'. $class .'">';
				echo ( $before_posts );

					jannah_widget_posts( $query_args, $style_args );

				echo ( $after_posts );
			echo "</div>";

			echo ( $args['after_widget'] );
		}


		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                  = $old_instance;
			$instance['title']         = sanitize_text_field( $new_instance['title'] );
			$instance['no_of_posts']   = $new_instance['no_of_posts'];
			$instance['posts_order']   = $new_instance['posts_order'];
			$instance['offset']        = $new_instance['offset'];
			$instance['media_overlay'] = $new_instance['media_overlay'];
			$instance['cats_id']       = implode( ',', $new_instance['cats_id'] );
			$instance['style']         = $new_instance['style'];
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' =>esc_html__('Recent Posts', 'jannah') , 'no_of_posts' => '5', 'posts_order' => 'latest' );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title         = isset( $instance['title'] ) ? $instance['title'] : '';
			$no_of_posts   = isset( $instance['no_of_posts'] ) ? $instance['no_of_posts'] : 5;
			$offset        = isset( $instance['offset'] ) ? $instance['offset'] : '';
			$posts_order   = isset( $instance['posts_order'] ) ? $instance['posts_order'] : 'latest';
			$style         = isset( $instance['style'] ) ? $instance['style'] : 1;
			$media_overlay = isset( $instance['media_overlay'] ) ? 'true' : '';
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

			$categories = jannah_get_categories_array();

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'jannah') ?></label>
				<input id="<?php echo esc_attr(  $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
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
				<label for="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>"><?php esc_html_e( 'Posts order:', 'jannah') ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_order' ) ); ?>" class="widefat">
					<?php
						foreach( $post_order as $order => $text ){ ?>
							<option value="<?php echo esc_attr( $order ) ?>" <?php selected( $posts_order, $order ); ?>><?php echo esc_attr( $text ) ?></option>
							<?php
						}
					?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'no_of_posts' ) ); ?>"><?php esc_html_e( 'Number of posts to show', 'jannah') ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'no_of_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no_of_posts' ) ); ?>" value="<?php echo esc_attr( $no_of_posts ) ?>" type="number" step="1" min="1" size="3" class="tiny-text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Offset - number of posts to pass over', 'jannah' ) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" value="<?php echo esc_attr( $offset ) ?>" type="number" step="1" min="1" size="3" class="tiny-text" />
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'media_overlay' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_overlay' ) ); ?>" value="true" <?php checked( $media_overlay, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'media_overlay' ) ); ?>"><?php esc_html_e( 'Media Icon Overlay', 'jannah') ?></label>
			</p>

			<div class="tie-styles-list-widget">
				<p>
					<label><?php esc_html_e( 'Style:', 'jannah') ?></label>

					<br class="clear">

					<?php
						for ( $i=1; $i < 8; $i++ ){ ?>
							<label>
								<input name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" type="radio" value="<?php echo esc_attr( $i ) ?>" <?php echo checked( $style, $i ) ?>> <img src="<?php echo JANNAH_TEMPLATE_URL .'/framework/admin/assets/images/widgets/posts-'.$i.'.png'; ?>" />
							</label>
							<?php
						}
					?>
				</p>
			</div>
		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_posts_list_register' );
	function tie_posts_list_register(){
		register_widget( 'TIE_POSTS_LIST' );
	}

}
?>

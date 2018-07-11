<?php

if( ! class_exists( 'TIE_VIDEOS_PLAYLIST_WIDGET' )){

	/**
	 * Widget API: TIE_VIDEOS_PLAYLIST_WIDGET class
	 */
	 class TIE_VIDEOS_PLAYLIST_WIDGET extends WP_Widget {


		public function __construct(){
			parent::__construct( 'video-playlist', JANNAH_THEME_NAME .' - '.esc_html__( 'Videos Playlist', 'jannah' ));
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo ( $args['before_widget'] );
			?>
				<div class="widget video-playlist-widget<?php if($instance['dark_skin']) echo' box-dark-skin'; ?>">

					<?php
					if( ! empty( $instance['videos_list_data'] ) ){

						$v_args = array(
							'videos_data' => $instance['videos_list_data'],
		 					'title'       => $instance['title'],
		 					'id'          => $args['widget_id']
						);

						get_template_part( 'framework/parts/video-list', '', $v_args );
					}
					?>

				</div><!-- .widget /-->

			<?php
			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance 				       = $old_instance;
			$instance['title'] 		   = sanitize_text_field( $new_instance['title'] );
			$instance['dark_skin']   = $new_instance['dark_skin'];
			$instance['videos_list'] = $new_instance['videos_list'];

			if( ! empty( $instance['videos_list'] ) ){

				$videos_list    = explode( PHP_EOL, $instance['videos_list'] );
				$videos         = new jannah_VIDEOS_LIST;
				$videos_data    = $videos->getVideoInfo( $videos_list );

				// Store the videos data ----------
				$instance['videos_list_data'] = $videos_data;
			}

			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' =>esc_html__( 'Featured Videos', 'jannah') );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title       = isset( $instance['title'] )       ? $instance['title'] : '';
			$videos_list = isset( $instance['videos_list'] ) ? $instance['videos_list'] : '';
			$dark_skin   = isset( $instance['dark_skin'] )   ? $instance['dark_skin'] : '';

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'jannah' ) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ) ?>" class="widefat" type="text" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'videos_list' ) ); ?>"><?php esc_html_e( 'Videos List:', 'jannah' ) ?></label>
				<textarea id="<?php echo esc_attr(  $this->get_field_id( 'videos_list' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'videos_list' ) ); ?>" class="widefat" rows="5" ><?php echo esc_textarea( $videos_list ); ?></textarea>
				<small><?php echo esc_html__( 'Enter each video URL in a seprated line.', 'jannah' ) . ' <br /><strong>' . esc_html__( 'Supports: YouTube and Vimeo videos only.', 'jannah' ).'</strong>' ?></small>

			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'dark_skin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dark_skin' ) ); ?>" value="true" <?php checked( $dark_skin, 'true' ); ?> type="checkbox" />
						<label for="<?php echo esc_attr( $this->get_field_id( 'dark_skin' ) ); ?>"><?php esc_html_e( 'Dark Skin', 'jannah' ) ?></label>
			</p>

		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	/*
	add_action( 'widgets_init', 'tie_videos_playlist_widget_register' );
	function tie_videos_playlist_widget_register(){
		register_widget( 'TIE_VIDEOS_PLAYLIST_WIDGET' );
	}
	*/
}
?>

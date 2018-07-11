<?php

if( ! class_exists( 'TIE_SOUNDCLOUD_WIDGET' )){

	/**
	 * Widget API: TIE_SOUNDCLOUD_WIDGET class
	 */
	 class TIE_SOUNDCLOUD_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops 	= array( 'classname' => 'soundcloud-widget'  );
			parent::__construct( 'tie-soundcloud-widget', JANNAH_THEME_NAME .' - '.esc_html__( 'SoundCloud', 'jannah') , $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			// Get the widget settings ----------
			$url  = empty( $instance['url'] ) ? '' : $instance['url'];
			$play = empty( $instance['autoplay'] ) ? 'false' : 'true';


			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			echo jannah_soundcloud( $url, $play, true );
			echo ( $args['after_widget'] );

		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){

			$instance = $old_instance;
			$instance['title']    = strip_tags( $new_instance['title'] );
			$instance['url']      = $new_instance['url'] ;
			$instance['autoplay'] = $new_instance['autoplay'];
			return $instance;

		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => esc_html__( 'SoundCloud', 'jannah' ) );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title    = isset( $instance['title'] ) ? $instance['title'] : '';
			$url      = isset( $instance['url'] )   ? $instance['url'] : '';
			$autoplay = isset( $instance['autoplay'] ) ? $instance['autoplay'] : ''; ?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'jannah') ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ) ?>" class="widefat" type="text" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_html_e( 'URL', 'jannah') ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" value="<?php echo esc_attr( $url ) ?>" type="text" class="widefat" />
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); ?>" value="true" <?php checked( $autoplay, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"><?php esc_html_e( 'Autoplay?', 'jannah') ?></label>
			</p>
		  <?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_soundcloud_widget_register' );
	function tie_soundcloud_widget_register(){
		register_widget( 'TIE_SOUNDCLOUD_WIDGET' );
	}

}
?>

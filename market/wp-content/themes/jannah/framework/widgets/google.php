<?php

if( ! class_exists( 'TIE_GOOGLE_WIDGET' )){

	/**
	 * Widget API: TIE_GOOGLE_WIDGET class
	 */
	 class TIE_GOOGLE_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops 	= array( 'classname' => 'google-widget' );
			parent::__construct( 'google-widget', JANNAH_THEME_NAME .' - '. esc_html__( 'Google+ page', 'jannah'), $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			//Youtube Widget
			if( ! empty( $instance['page_url'] ) ){ ?>

				<div class="google-box">
					<!-- Google +1 script -->
					<script>
					  (function(){
						var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
						po.src = '//apis.google.com/js/plusone.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>
					<!-- Link blog to Google+ page -->
					<a style='display: block; height: 0;' href="<?php echo esc_url( $instance['page_url'] ) ?>" rel="publisher">&nbsp;</a>
					<!-- Google +1 Page badge -->
					<g:plus href="<?php echo esc_url( $instance['page_url'] ) ?>" height="131" width="280" theme="light"></g:plus>

				</div>

				<?php
			}

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance             = $old_instance;
			$instance['title']    = sanitize_text_field( $new_instance['title'] );
			$instance['page_url'] = $new_instance['page_url'];
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' =>esc_html__( 'Follow us on Google+', 'jannah') );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title    = isset( $instance['title'] )    ? $instance['title'] : '';
			$page_url = isset( $instance['page_url'] ) ? $instance['page_url'] : '';

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'jannah') ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>"><?php esc_html_e( 'Page URL:', 'jannah') ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_url' ) ); ?>" value="<?php echo esc_attr( $page_url ); ?>" class="widefat" type="text" />
			</p>

		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_google_widget_register' );
	function tie_google_widget_register(){
		register_widget( 'TIE_GOOGLE_WIDGET' );
	}

}
?>

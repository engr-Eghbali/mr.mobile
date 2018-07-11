<?php

if( ! class_exists( 'TIE_INSTAGRAM_WIDGET' )){

	/**
	 * Widget API: TIE_INSTAGRAM_WIDGET class
	 */
	 class TIE_INSTAGRAM_WIDGET extends WP_Widget {


		public function __construct(){
			parent::__construct( 'tie-instagram-theme', JANNAH_THEME_NAME .' - '.esc_html__( 'Instagram', 'jannah' ) );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo ( $args['before_widget'] );

			if ( ! empty( $instance['title'] ) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			# Instagram feed ----------
			if( JANNAH_INSTANOW_IS_ACTIVE ){

				if( get_option( 'instanow_access_token' ) ){
					$media_source = ! empty( $instance['media_source'] ) ? $instance['media_source'] : 'user';
					$media_link   = ! empty( $instance['media_link'] )   ? $instance['media_link']   : 'file';
					$source_id    = ! empty( $instance['source_id'] )    ? $instance['source_id']    : '';
					$media_number = ! empty( $instance['media_number'] ) ? $instance['media_number'] : 9;
					$button_text  = ! empty( $instance['button_text'] )  ? $instance['button_text']  : '';
					$button_url   = ! empty( $instance['button_url'] )   ? $instance['button_url']   : '';

					$insta_settings = array(
						'media_source'   => $media_source,
						'hashtag'        => $source_id,
						'username'       => $source_id,
						'box_style'      => 'lite',
						'instagram_logo' => false,
						'new_window'     => 'true',
						'nofollow'       => 'true',
						'credit'         => false,
						'hashtag_info'   => false,
						'account_info'   => false,
						'media_number'   => $media_number,
						'link'           => $media_link,
						'media_layout'   => 'grid',
						'columns_number' => 3,
						'flat'           => 'true',
					);

					tie_insta_media( $insta_settings );

					if( ! empty( $button_text )){?>
						<a target="_blank" href="<?php echo esc_url( $button_url ) ?>" class="button dark-btn fullwidth"><?php echo esc_html( $button_text ); ?></a>
						<?php
					}
				}

				else{
					echo'<span class="theme-notice">'. esc_html__( 'Go to the InstaNow Settings page to connect your account to the Instagram API.', 'jannah' ) .'</span>';
				}
			}

			else{
				echo'<span class="theme-notice">'. esc_html__( 'This section requries the InstaNOW Plugin. You can install it from the Theme settings menu > Install Plugins.', 'jannah' ) .'</span>';
			}


			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                 = $old_instance;
			$instance['title']        = sanitize_text_field( $new_instance['title'] );
			$instance['media_source'] = $new_instance['media_source'];
			$instance['media_link']   = $new_instance['media_link'];
			$instance['source_id']    = $new_instance['source_id'];
			$instance['media_number'] = $new_instance['media_number'];
			$instance['button_text']  = $new_instance['button_text'];
			$instance['button_url']   = $new_instance['button_url'];
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' =>esc_html__( 'Follow Us', 'jannah'), 'media_number' => 9, 'media_link' => 'file', 'media_source' => 'user' );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title        = isset( $instance['title'] )        ? $instance['title'] : '';
			$media_source = isset( $instance['media_source'] ) ? $instance['media_source'] : 'user';
			$media_link   = isset( $instance['media_link'] )   ? $instance['media_link'] : 'file';
			$source_id    = isset( $instance['source_id'] )    ? $instance['source_id'] : '';
			$media_number = isset( $instance['media_number'] ) ? $instance['media_number'] : 9;
			$button_text  = isset( $instance['button_text'] )  ? $instance['button_text'] : '';
			$button_url   = isset( $instance['button_url'] )   ? $instance['button_url'] : '';

			if( JANNAH_INSTANOW_IS_ACTIVE ){ ?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'jannah') ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'media_source' ) ); ?>"><?php esc_html_e( 'Media Source', 'jannah') ?></label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'media_source' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_source' ) ); ?>" class="widefat">
						<option value="user" <?php selected( $media_source, 'user' ); ?>><?php esc_html_e( 'User Account', 'jannah') ?></option>
						<option value="hashtag" <?php selected( $media_source, 'hashtag' ); ?>><?php esc_html_e( 'Hash Tag', 'jannah') ?></option>
					</select>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'source_id' ) ); ?>"><?php esc_html_e( 'Enter the Username or the Hash Tag', 'jannah') ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'source_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'source_id' ) ); ?>" value="<?php echo esc_attr( $source_id ); ?>" class="widefat" type="text" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'media_link' ) ); ?>"><?php esc_html_e( 'Link Media to', 'jannah') ?></label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'media_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_link' ) ); ?>" class="widefat">
						<option value="file" <?php selected( $media_link, 'file' ); ?>><?php esc_html_e( 'Media File', 'jannah') ?></option>
						<option value="page" <?php selected( $media_link, 'page' ); ?>><?php esc_html_e( 'Media Page on Instagram', 'jannah') ?></option>
					</select>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'media_number' ) ); ?>"><?php esc_html_e( 'Number of Media Items', 'jannah') ?></label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'media_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_number' ) ); ?>" class="widefat">
						<?php for ($i=3; $i <= 18 ; $i++){ ?>
							<option value="<?php echo esc_attr( $i ); ?>" <?php selected( $media_number, $i ); ?>><?php echo intval( $i ); ?></option>
							<?php
						} ?>
					</select>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Follow Us Button Text', 'jannah') ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" value="<?php echo esc_attr( $button_text ); ?>" class="widefat" type="text" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"><?php esc_html_e( 'Follow Us Button URL', 'jannah') ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_url' ) ); ?>" value="<?php echo esc_attr( $button_url ); ?>" class="widefat" type="text" />
				</p>
		<?php
		}
		else{
			jannah_theme_option(
				array(
					'text' =>  wp_kses_post( sprintf( __( 'You need to install the <a href="%s">InstaNOW plugin</a> first.', 'jannah' ), add_query_arg( array( 'page' => 'tie-install-plugins' ), admin_url( 'admin.php' )) ) ),
					'type' => 'message',
				));
			}
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_instagram_widget_register' );
	function tie_instagram_widget_register(){
		register_widget( 'TIE_INSTAGRAM_WIDGET' );
	}

}
?>

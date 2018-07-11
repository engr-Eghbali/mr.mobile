<?php

if( ! class_exists( 'TIE_NEWSLETTER_WIDGET' )){

	/**
	 * Widget API: TIE_NEWSLETTER_WIDGET class
	 */
	 class TIE_NEWSLETTER_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops = array( 'classname' => 'subscribe-widget' );
			parent::__construct( 'tie-newsletter', JANNAH_THEME_NAME .' - '.esc_html__( 'Newsletter', 'jannah' ) , $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$text = isset( $instance['text'] ) ? $instance['text'] : '';

			# WPML ----------
			$text = apply_filters( 'wpml_translate_single_string', $text, JANNAH_THEME_NAME, 'widget_content_'.$this->id );

			echo ( $args['before_widget'] );


			# Title ----------
			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			# Show Icon ----------
			if( ! empty( $instance['show_icon'] )){ ?>
				<span class="fa fa-envelope newsletter-icon" aria-hidden="true"></span>
				<?php
			}

			# Text ----------
			if( ! empty( $text ) ){ ?>
				<div class="subscribe-widget-content">
					<?php echo do_shortcode( $text ) ?>
				</div>
				<?php
			}

			if( ! empty( $instance['feedburner'] )){ ?>

				<form action="https://feedburner.google.com/fb/a/mailverify" method="post" class="subscribe-form" target="popupwindow" onsubmit="window.open('https://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr( $instance['feedburner'] ); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
					<label class="screen-reader-text" for="email"><?php _eti( 'Enter your Email address' ); ?></label>
					<input class="subscribe-input required email" type="text" id="email" name="email" placeholder="<?php _eti( 'Enter your Email address' ); ?>">
					<input type="hidden" value="<?php echo esc_attr( $instance['feedburner'] ); ?>" name="uri">
					<input type="hidden" name="loc" value="en_US">
					<input class="button subscribe-submit" type="submit" name="submit" value="<?php _eti( 'Subscribe' ) ; ?>">
				</form>
				<?php
			}

			elseif( ! empty( $instance['mailchimp'] )){ ?>
				<div id="mc_embed_signup-<?php echo esc_attr( $args['widget_id'] ) ?>">
					<form action="<?php echo esc_attr( $instance['mailchimp'] ) ?>" method="post" id="mc-embedded-subscribe-form-<?php echo esc_attr( $args['widget_id'] ) ?>" name="mc-embedded-subscribe-form" class="subscribe-form validate" target="_blank" novalidate>
							<div class="mc-field-group">
								<label class="screen-reader-text" for="mce-EMAIL-<?php echo esc_attr( $args['widget_id'] ) ?>"><?php _eti( 'Enter your Email address' ); ?></label>
								<input type="email" value="" id="mce-EMAIL-<?php echo esc_attr( $args['widget_id'] ) ?>" placeholder="<?php _eti( 'Enter your Email address' ); ?>" name="EMAIL" class="subscribe-input required email">
							</div>
							<input type="submit" value="<?php _eti( 'Subscribe' ) ; ?>" name="subscribe" class="button subscribe-submit">
					</form>
				</div>
				<?php
			}

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance               = $old_instance;
			$instance['title']      = sanitize_text_field( $new_instance['title'] );
			$instance['text']       = $new_instance['text'];
			$instance['show_icon']  = $new_instance['show_icon'];
			$instance['mailchimp']  = $new_instance['mailchimp'];
			$instance['feedburner'] = $new_instance['feedburner'];

			# WPML ----------
			do_action( 'wpml_register_single_string', JANNAH_THEME_NAME, 'widget_content_'.$this->id, $new_instance['text'] );

			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array(
				'title' => esc_html__( 'Newsletter', 'jannah'),
				'text'  => '
	<h4>With Product You Purchase</h4>
	<h3>Subscribe to our mailing list to get the new updates!</h3>
	<p>Lorem ipsum dolor sit amet, consectetur.</p>'
			);

			$instance = wp_parse_args( (array) $instance, $defaults );

			$title      = isset( $instance['title'] ) ? $instance['title'] : '';
			$feedburner = isset( $instance['feedburner'] ) ? $instance['feedburner'] : '';
			$mailchimp  = isset( $instance['mailchimp'] ) ? $instance['mailchimp'] : '';
			$text       = isset( $instance['text'] ) ? $instance['text'] : '';
			$show_icon  = isset( $instance['show_icon'] ) ? 'true' : '';


			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'jannah') ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text above the Email input field', 'jannah') ?></label>
				<textarea rows="3" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" class="widefat" ><?php echo esc_textarea( $text ) ?></textarea>
				<small><?php esc_html_e( 'Supports: Text, HTML and Shortcodes.', 'jannah') ?></small>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'show_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_icon' ) ); ?>" value="true" <?php checked( $show_icon, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_icon' ) ); ?>"><?php esc_html_e( 'Show the icon?', 'jannah') ?></label>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'mailchimp' ) ); ?>"><?php esc_html_e( 'MailChimp Form Action URL', 'jannah') ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'mailchimp' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'mailchimp' ) ); ?>" value="<?php echo esc_attr( $mailchimp ); ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'feedburner' ) ); ?>"><strong><?php esc_html_e( '- OR -', 'jannah') ?></strong> <?php esc_html_e( 'Feedburner ID', 'jannah') ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'feedburner' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'feedburner' ) ); ?>" value="<?php echo esc_attr( $feedburner ); ?>" class="widefat" type="text" />
			</p>

		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_newsletter_widget_register' );
	function tie_newsletter_widget_register(){
		register_widget( 'TIE_NEWSLETTER_WIDGET' );
	}

}
?>

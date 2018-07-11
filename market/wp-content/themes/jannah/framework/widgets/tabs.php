<?php

if( ! class_exists( 'TIE_WIDGET_TABS' )){

	/**
	 * Widget API: TIE_WIDGET_TABS class
	 */
	 class TIE_WIDGET_TABS extends WP_Widget {


		public function __construct(){
			$widget_ops = array( 'description' => 'Most Popular, Recent posts and Comments'  );
			parent::__construct( 'widget_tabs', JANNAH_THEME_NAME .' - '.esc_html__( 'Tabs', 'jannah') , $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			$posts_number = empty( $instance['posts_number'] ) ? 5 : $instance['posts_number']; ?>

			<div class="container-wrapper tabs-container-wrapper">
				<div class="widget tabs-widget">
					<div class="widget-container">
						<div class="tabs-widget">
							<div class="tabs-wrapper">

								<ul class="tabs-menu">
									<?php

										//Widget ID ----------
										$id        = explode("-", $this->get_field_id( 'widget_id' ));
										$widget_id =  $id[1] . "-" . $id[2];

										$tabs_order = 'r,p,c';
										if( ! empty( $instance['tabs_order'] ) ){
											$tabs_order = $instance['tabs_order'];
										}
										$tabs_order_array = explode( ',', $tabs_order );
										foreach ( $tabs_order_array as $tab ){

											if( $tab == 'p' ){
												echo '<li><a href="#'.$widget_id.'-popular">'. __ti( 'Popular' ) .'</a></li>';
											}

											if( $tab == 'r' ){
												echo '<li><a href="#'.$widget_id.'-recent">'. __ti( 'Recent' ) .'</a></li>';
											}

											if( $tab == 'c' ){
												echo '<li><a href="#'.$widget_id.'-comments">'. __ti( 'Comments' ) .'</a></li>';
											}

										}

									?>
								</ul><!-- ul.tabs-menu /-->

								<?php
									foreach ( $tabs_order_array as $tab ){

										if( $tab == 'p' ): ?>

											<div id="<?php echo esc_attr( $widget_id ) ?>-popular" class="tab-content tab-content-popular">
												<ul class="tab-content-elements">
													<?php

														$popular_order = 'popular';
														if( ! empty( $instance['posts_order'] ) && $instance['posts_order'] == 'viewed' ){
															$popular_order = 'views';
														}

														jannah_widget_posts( array( 'number' => $posts_number, 'order' => $popular_order ));

													?>
												</ul>
											</div><!-- .tab-content#popular-posts-tab /-->

										<?php endif;


										if( $tab == 'r' ): ?>

											<div id="<?php echo esc_attr( $widget_id ) ?>-recent" class="tab-content tab-content-recent">
												<ul class="tab-content-elements">
													<?php jannah_widget_posts( array( 'number' => $posts_number ));?>
												</ul>
											</div><!-- .tab-content#recent-posts-tab /-->

										<?php endif;


										if( $tab == 'c' ): ?>

											<div id="<?php echo esc_attr( $widget_id ) ?>-comments" class="tab-content tab-content-comments">
												<ul class="tab-content-elements">
													<?php jannah_recent_comments( $posts_number );?>
												</ul>
											</div><!-- .tab-content#comments-tab /-->

										<?php endif;
									}
								?>

							</div><!-- .tabs-wrapper-animated /-->
						</div><!-- .tabs-widget /-->
					</div><!-- .widget-container /-->
				</div><!-- .tabs-widget /-->
			</div><!-- .container-wrapper /-->
			<?php
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                 = $old_instance;
			$instance['posts_number'] = $new_instance['posts_number'];
			$instance['posts_order']  = $new_instance['posts_order'];
			$instance['tabs_order']   = $new_instance['tabs_order'];
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){

			$random_id = substr(str_shuffle( '01234567TUVWXYZ' ), 0, 5);
			$id        = explode( '-', $this->get_field_id( 'widget_id' ));
			$widget_id = $id[1]. '-'  .$random_id;

			$defaults  = array( 'posts_order' => 'popular', 'posts_number' => 5 );
			$instance  = wp_parse_args( (array) $instance, $defaults );

			$posts_number = empty( $instance['posts_number'] ) ? 5 : $instance['posts_number'];
			$posts_order  = isset( $instance['posts_order'] )  ? $instance['posts_order'] : '';
			?>

			<script>
				jQuery(document).ready(function($){

						jQuery( "#<?php echo esc_attr( $widget_id ) ?>-order" ).sortable({
							placeholder: "tie-state-highlight",
							stop: function(event, ui){
								var data = "";

								jQuery( "#<?php echo esc_attr( $widget_id ) ?>-order li" ).each(function(i, el){
									var p = jQuery( this ).data( 'tab' );
									data += p+",";
								});

								jQuery("#<?php echo esc_attr( $widget_id ) ?>-tabs-order").val(data.slice(0, -1));
							}
						});

				});
			</script>

			<div id="<?php echo esc_attr( $widget_id ) ?>-tabs">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'tabs_order' ) ); ?>"><?php esc_html_e( 'Order of tabs:', 'jannah') ?></label>

					<?php
						if( $id[2] == '__i__' ){
							echo '<p class="tie-message-hint">'. esc_html__( 'Click Save button to be able to change the order of tabs.', 'jannah') .'</p>';
						}
					?>

					<input id="<?php echo esc_attr( $widget_id ) ?>-tabs-order" name="<?php echo esc_attr( $this->get_field_name( 'tabs_order' ) ); ?>" value="<?php if( ! empty($instance['tabs_order']) ) echo esc_attr( $instance['tabs_order'] ); ?>" type="hidden" />

					<ul id="<?php echo esc_attr( $widget_id ) ?>-order" class="tab_sortable" <?php if( $id[2] == '__i__' ) echo 'style="opacity:.5;"'?>>

					<?php

						$tabs_order = 'r,p,c';
						if( ! empty( $instance['tabs_order'] ) ){
							$tabs_order = $instance['tabs_order'];
						}

						$tabs_order_array = explode( ',', $tabs_order );

						foreach ( $tabs_order_array as $tab ){

							if( $tab == 'p' ){
								echo '<li data-tab="p"> '. __ti( "Popular" ) .' </li>';
							}

							if( $tab == 'r' ){
								echo '<li data-tab="r"> '. __ti( "Recent" ) .' </li>';
							}

							if( $tab == 'c' ){
								echo '<li data-tab="c"> '. __ti( "Comments" ) .' </li>';
							}
						}
					?>
					</ul>
				</p>
			</div>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>"><?php esc_html_e( 'Popular order', 'jannah') ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_order' ) ); ?>" class="widefat">
					<option value="popular" <?php selected( $posts_order, 'popular' ) ?>><?php esc_html_e( 'Most Commented', 'jannah') ?></option>
					<option value="viewed"  <?php selected( $posts_order, 'viewed' )  ?>><?php esc_html_e( 'Most Viewed', 'jannah') ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>"><?php esc_html_e( 'Number of items to show:', 'jannah') ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_number' ) ); ?>" value="<?php echo esc_attr( $posts_number ) ?>" type="number" step="1" min="1" size="3" class="tiny-text" />
			</p>

		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_widget_tabs_register' );
	function tie_widget_tabs_register(){
		register_widget( 'TIE_WIDGET_TABS' );
	}

}
?>

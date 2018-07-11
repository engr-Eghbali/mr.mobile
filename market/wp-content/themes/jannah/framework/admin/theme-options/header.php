<?php

	//Categories ----------
	$categories = jannah_get_categories_array();


	jannah_theme_option(
		array(
			'title' => esc_html__( 'Header Settings', 'jannah' ),
			'type'  => 'tab-title',
		));


	$headers_path   = JANNAH_TEMPLATE_URL. '/framework/admin/assets/images/headers';
	$top_nav_class  = '';
	$header_class   = '';
	$main_nav_class = '';

	//Top Nav Classes ----------
	if( !jannah_get_option( 'top_nav' ) ){
		$top_nav_class .= ' tie-hide';
		$header_class  .= ' top-nav-disabled';
	}

	if( jannah_get_option( 'top_nav_dark' ) ){
		$top_nav_class .= ' top-nav-dark-skin';
	}

	if( !jannah_get_option( 'top_nav_layout' ) ){
		$top_nav_class .= ' top-nav-full';
	}

	if( jannah_get_option( 'top_nav_position' ) ){
		$header_class .= ' top-nav-below';
	}

	if( jannah_get_option( 'header_layout' ) ){
		$header_class .= ' header-layout-'.jannah_get_option( 'header_layout' );
	}

	//Top Components ----------
	$top_components = '
		<span class="top-nav-components-live_search">
			<span class="header-top-nav-components-search1 tie-alert-circle top-nav-components_search_layout-options">
				<img class="h-light-skin" src="'. esc_url( $headers_path ) .'/search-icon-light.png" alt="" />
				<img class="h-dark-skin" src="'. esc_url( $headers_path ) .'/search-icon.png" alt="" />
			</span>
			<span class="header-top-nav-components-search tie-alert-circle top-nav-components_search_layout-options">
				<img class="h-light-skin" src="'. esc_url( $headers_path ) .'/search-light.png" halt="" />
				<img class="h-dark-skin" src="'. esc_url( $headers_path ) .'/search.png" alt="" />
			</span>
		</span>

		<span class="header-top-nav-components-slide tie-alert-circle">
			<img class="h-light-skin" src="'. esc_url( $headers_path ) .'/slide-light.png" alt="" />
			<img class="h-dark-skin" src="'. esc_url( $headers_path ) .'/slide.png" alt="" />
		</span>

		<span class="header-top-nav-components-login tie-alert-circle">
			<img class="h-light-skin" src="'. esc_url( $headers_path ) .'/login-light.png" alt="" />
			<img class="h-dark-skin" src="'. esc_url( $headers_path ) .'/login.png" alt="" />
		</span>

		<span class="header-top-nav-components-random tie-alert-circle">
			<img class="h-light-skin" src="'. esc_url( $headers_path ) .'/random-light.png" alt="" />
			<img class="h-dark-skin" src="'. esc_url( $headers_path ) .'/random.png" alt="" />
		</span>
	';

	if ( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
		$top_components .= '
			<span class="header-top-nav-components-cart tie-alert-circle">
				<img class="h-light-skin" src="'. esc_url( $headers_path ) .'/cart-light.png" alt="" />
				<img class="h-dark-skin" src="'. esc_url( $headers_path ) .'/cart.png" alt="" />
			</span>
		';
	}

	if ( JANNAH_BUDDYPRESS_IS_ACTIVE ){
		$top_components .= '
			<span class="header-top-nav-components-bp_notifications tie-alert-circle">
				<img class="h-light-skin" src="'. esc_url( $headers_path ) .'/bp_notifications-light.png" alt="" />
				<img class="h-dark-skin" src="'. esc_url( $headers_path ) .'/bp_notifications.png" alt="" />
			</span>
		';
	}

	$top_components .= '
		<span class="top-nav-components-live_social">
			<span class="header-top-nav-components-follow tie-alert-circle top-nav-components_social_layout-options">
				<img class="h-light-skin" src="'. esc_url( $headers_path ) .'/follow-light.png" alt="" />
				<img class="h-dark-skin" src="'. esc_url( $headers_path ) .'/follow.png" alt="" />
			</span>
			<span class="header-top-nav-components-follow1 tie-alert-circle top-nav-components_social_layout-options">
				<img class="h-light-skin" src="'. esc_url( $headers_path ) .'/follow-icons-light.png" alt="" />
				<img class="h-dark-skin" src="'. esc_url( $headers_path ) .'/follow-icons.png" alt="" />
			</span>
		</span>
	';


	//Main Nav Classes ----------
	if( !jannah_get_option( 'main_nav' ) ){
		$main_nav_class .= ' tie-hide';
		$header_class   .= ' main-nav-disabled';
	}

	if( jannah_get_option( 'main_nav_dark' ) ){
		$main_nav_class .= ' main-nav-dark-skin';
	}

	if( !jannah_get_option( 'main_nav_layout' ) ){
		$main_nav_class .= ' main-nav-full';
	}

	if( jannah_get_option( 'main_nav_position' ) ){
		$header_class .= ' main-nav-above';
	}
	?>
<div id="header-preview-wrapper">
	<div id="header-preview" class="site-header<?php echo esc_attr( $header_class ) ?>">
		<div class="top-nav-container">
			<div class="main-nav-container">

				<div class="top-bar-wrap<?php echo esc_attr( $top_nav_class ) ?>">
					<div class="top-bar">

						<div class="tie-alignleft">
							<?php
							$date_format = 'l ,  j  F Y';
							if( jannah_get_option( 'todaydate_format' ) ){
								$date_format = jannah_get_option( 'todaydate_format' );
							}
								?>
								<span id="today-date">
									<?php echo date_i18n( $date_format, current_time( 'timestamp' ) ); ?>
								</span>


							<span id="top-nav-breaking-news" class="top-nav-area-1-options tie-alert-circle">
								<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/breaking-light.png" alt="" />
								<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/breaking.png" alt="" />
							</span>

							<span id="top-nav-menu-1" class="top-nav-area-1-options tie-alert-circle">
								<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/top-menu-light.png" alt="" />
								<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/top-menu.png" alt="" />
							</span>

							<span id="top-nav-components-1" class="components-icons top-nav-area-1-options">
								<?php echo ( $top_components ) ?>
							</span>
						</div><!-- .tie-alignleft /-->

						<div class="tie-alignright">
							<span id="top-nav-menu-2" class="top-nav-area-2-options tie-alert-circle">
								<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/top-menu-light.png" alt="" />
								<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/top-menu.png" alt="" />
							</span>

							<span id="top-nav-components-2" class="components-icons top-nav-area-2-options">
								<?php echo ( $top_components ) ?>
							</span>
						</div><!-- .tie-alignright -->

					</div><!-- .top-bar -->
				</div><!-- .top-bar-wrap -->

				<div class="header-content">
					<img class="header-top-logo" src="<?php echo esc_url( $headers_path ) ?>/header-logo.png" style="width:150px;" alt="" />
					<img class="header-top-ads" src="<?php echo esc_url( $headers_path ) ?>/header-e3lan.png" style="width:500px;" alt="" />
				</div><!-- .header-content -->

				<div class="header-main-menu-wrap<?php echo esc_attr( $main_nav_class ) ?>">
					<div class="header-main-menu">

						<img class="header-top-logo" src="<?php echo esc_url( $headers_path ) ?>/header-logo.png" style="width:150px;" alt="" />

						<div class="tie-alignleft">
							<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/menu.png" height="40" alt="" />
							<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/menu-light.png" height="40" alt="" />
						</div><!-- .tie-alignleft /-->


						<div id="main-nav-components" class="components-icons">
							<span class="main-nav-components-live_search">
								<span class="header-main-nav-components-search1 tie-alert-circle main-nav-components_search_layout-options">
									<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/search-icon-light.png" height="40" alt="" />
									<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/search-icon.png" height="40" alt="" />
								</span>
								<span class="header-main-nav-components-search tie-alert-circle main-nav-components_search_layout-options">
									<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/search-light.png" height="40" alt="" />
									<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/search.png" height="40" alt="" />
								</span>
							</span>
							<span class="header-main-nav-components-slide tie-alert-circle">
								<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/slide-light.png" height="40" alt="" />
								<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/slide.png" height="40" alt="" />
							</span>
							<span class="header-main-nav-components-login tie-alert-circle">
								<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/login-light.png" height="40" alt="" />
								<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/login.png" height="40" alt="" />
							</span>
							<span class="header-main-nav-components-random tie-alert-circle">
								<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/random-light.png" height="40" alt="" />
								<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/random.png" height="40" alt="" />
							</span>

							<?php
							if ( JANNAH_WOOCOMMERCE_IS_ACTIVE ){?>
								<span class="header-main-nav-components-cart tie-alert-circle">
									<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/cart-light.png" height="40" alt="" />
									<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/cart.png" height="40" alt="" />
								</span>
								<?php
							}
							?>

							<?php
							if ( JANNAH_BUDDYPRESS_IS_ACTIVE ){ ?>
								<span class="header-main-nav-components-bp_notifications tie-alert-circle">
									<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/bp_notifications-light.png" height="40" alt="" />
									<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/bp_notifications.png" height="40" alt="" />
								</span>
								<?php
							}
							?>

							<span class="main-nav-components-live_social">
								<span class="header-main-nav-components-follow tie-alert-circle main-nav-components_social_layout-options">
									<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/follow-light.png" height="40" alt="" />
									<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/follow.png" height="40" alt="" />
								</span>
								<span class="header-main-nav-components-follow1 tie-alert-circle main-nav-components_social_layout-options">
									<img class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/follow-icons-light.png" height="40" alt="" />
									<img class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/follow-icons.png" height="40" alt="" />
								</span>
							</span>
						</div><!-- #main-nav-components-->

					</div><!-- #main-nav-components-->
				</div><!-- .header-main-menu-wrap-->

			</div><!-- .main-nav-container /-->
		</div><!-- .top-nav-container /-->
	</div><!-- #header-preview-->
</div><!-- #header-preview-wrapper-->

	<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Header Layout', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Header Layout', 'jannah' ),
			'id'     => 'header_layout',
			'type'   => 'radio',
			'toggle' => array(
				'3' => '',
				'2' => '',
				'1' => '',),
			'options' => array(
				'3' => esc_html__( 'Layout', 'jannah' ) .' #1',
				'2'	=> esc_html__( 'Layout', 'jannah' ) .' #2',
				'1' => esc_html__( 'Layout', 'jannah' ) .' #3',
			)));
	?>

	<div class="tie-section-title tie-section-tabs header-settings-tabs">
		<a href="#main-nav-settings" class="active"><?php esc_html_e( 'Main Nav Settings', 'jannah' ) ?></a>
		<a href="#top-nav-settings"><?php esc_html_e( 'Secondry Nav Settings',  'jannah' ) ?></a>
	</div>


	<?php

	echo'<div id="top-nav-settings" class="top-main-nav-settings">';

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Enable', 'jannah' ),
				'id'     => 'top_nav',
				'type'   => 'checkbox',
				'toggle' => '.top-nav-news-all-options, #header-preview .top-bar-wrap',
			));

		echo'<div class="top-nav-news-all-options">';

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Dark Skin', 'jannah' ),
				'id'   => 'top_nav_dark',
				'type' => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Boxed Layout', 'jannah' ),
				'id'   => 'top_nav_layout',
				'type' => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Below The Header', 'jannah' ),
				'id'   =>  'top_nav_position',
				'type' => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name'   => esc_html__( "Today's date", 'jannah' ),
				'id'     => 'top_date',
				'toggle' => '#todaydate_format-item, #today-date',
				'type'   => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name'    => esc_html__( "Today's date format", 'jannah' ),
				'id'      => 'todaydate_format',
				'type'    => 'text',
				'default' => 'l ,  j  F Y',
				'hint'    => '<a target="_blank" href="http://codex.wordpress.org/Formatting_Date_and_Time">'.esc_html__( 'Documentation on date and time formatting', 'jannah' ).'</a>',
			));


		echo '<div class="top-nav-areas-live-options">';

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Left Area', 'jannah' ),
				'id'     => 'top-nav-area-1',
				'type'   => 'radio',
				'toggle' => array(
					'none'       => '',
					'components' => '#top-nav-components-1, .top-nav-components-wrapper',
					'menu'       => '#top-nav-menu-1',
					'breaking'   => '#top-nav-breaking-news, .breaking-news-all-options',),
				'options' => array(
					''           => esc_html__( 'Disable', 'jannah' ),
					'components' => esc_html__( 'Components', 'jannah' ),
					'menu'       => esc_html__( 'Menu', 'jannah' ),
					'breaking'   => esc_html__( 'Breaking News', 'jannah' ),
			)));

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Right Area', 'jannah' ),
				'id'     => "top-nav-area-2",
				'type'   => "radio",
				'toggle' => array(
					'none'       => '',
					'components' => '#top-nav-components-2, .top-nav-components-wrapper',
					'menu'       => '#top-nav-menu-2',),
				'options' => array(
					''           => esc_html__( 'Disable', 'jannah' ),
					'components' => esc_html__( 'Components', 'jannah' ),
					'menu'       => esc_html__( 'Menu', 'jannah' ),
					)));

		echo'<div class="clear"></div></div>';

		jannah_custom_header_area_options( esc_html__( 'Secondry Nav Components', 'jannah' ), 'top-nav-components' );

		echo'<div class="breaking-news-all-options top-nav-area-1-options">';

		jannah_theme_option(
			array(
				'title' => esc_html__( 'Breaking News', 'jannah' ),
				'id'    => 'breaking_news_head',
				'type'  => 'header',
			));

		jannah_theme_option(
			array(
				'name'        => esc_html__( 'Title', 'jannah' ),
				'id'          => 'breaking_title',
				'placeholder'	=> esc_html__( 'Trending', 'jannah' ),
				'type'        => 'text',
			));

		jannah_theme_option(
			array(
				'name'    => esc_html__( 'Animation Effect', 'jannah' ),
				'id'      => 'breaking_effect',
				'type'    => "select",
				'options' => array(
					'reveal'     => esc_html__( 'Typing',        'jannah' ),
					'flipY'      => esc_html__( 'Fading',        'jannah' ),
					'slideLeft'  => esc_html__( 'Sliding Left',  'jannah' ),
					'slideRight' => esc_html__( 'Sliding Right', 'jannah' ),
					'slideUp'    => esc_html__( 'Sliding Up',    'jannah' ),
					'slideDown'  => esc_html__( 'Sliding Down',  'jannah' ),
			)));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'Show the scrolling arrows?', 'jannah' ),
				'id'   => 'breaking_arrows',
				'type' => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Query Type', 'jannah' ),
				'id'     => 'breaking_type',
				'type'   => 'radio',
				'toggle' => array(
					'category' => '#breaking_cat-item, #breaking_number-item',
					'tag'      => '#breaking_tag-item, #breaking_number-item',
					'custom'   => '#breaking_custom-item'),
				'options' => array(
					'category' => esc_html__( 'Categories', 'jannah' ),
					'tag'      => esc_html__( 'Tags', 'jannah' ),
					'custom'   => esc_html__( 'Custom Text', 'jannah' ),
				)));

		jannah_theme_option(
			array(
				'name'    => esc_html__( 'Categories', 'jannah' ),
				'id'      => 'breaking_cat',
				'class'   => 'breaking_type',
				'type'    => 'select-multiple',
				'options' => $categories,
			));

		jannah_theme_option(
			array(
				'name'  => esc_html__( 'Tags', 'jannah' ),
				'hint'  => esc_html__( 'Enter a tag name, or names separated by comma.', 'jannah' ),
				'id'    => 'breaking_tag',
				'class'	=> 'breaking_type',
				'type'  => 'text',
			));

		jannah_theme_option(
			array(
				'name'    => esc_html__( 'Number of posts to show', 'jannah' ),
				'id'      => 'breaking_number',
				'class'   => 'breaking_type',
				'default' => 10,
				'type'    => 'number',
			));

			?>


		<div class="option-item breaking_type-options" id="breaking_custom-item">

			<span class="tie-label"><?php esc_html_e( 'Add Custom Text', 'jannah' ) ?></span>
			<input id="custom_text" type="text" size="56" name="custom_text" placeholder="<?php esc_html_e( 'Custom Text', 'jannah' ) ?>" value="" />
			<input id="custom_link" type="text" size="56" name="custom_link" placeholder="http://" value="" />
			<input id="breaking_news_button"  class="button" type="button" value="<?php esc_html_e( 'Add', 'jannah' ) ?>" />

			<?php

				jannah_theme_option(
					array(
						'text' => esc_html__( 'Text and Link are required.', 'jannah' ),
						'id'   => 'breaking_custom_error',
						'type' => 'error',
					));
			?>

			<script>
				jQuery(function(){
					jQuery( "#customList" ).sortable({placeholder: "tie-state-highlight"});
				});
			</script>

			<div class="clear"></div>
			<ul id="customList">
				<?php
					$breaking_custom 	= jannah_get_option( 'breaking_custom' );
					$custom_count 		= 0;

					if( ! empty( $breaking_custom ) && is_array( $breaking_custom )){
						foreach ( $breaking_custom as $custom_text ){
							$custom_count++; ?>

							<li class="parent-item">
								<div class="tie-block-head">
									<a href="<?php echo esc_attr( $custom_text['link'] ) ?>" target="_blank"><?php echo esc_html( $custom_text['text'] ) ?></a>
									<input name="tie_options[breaking_custom][<?php echo esc_attr( $custom_count ) ?>][link]" type="hidden" value="<?php echo esc_attr( $custom_text['link'] ) ?>" />
									<input name="tie_options[breaking_custom][<?php echo esc_attr( $custom_count ) ?>][text]" type="hidden" value="<?php echo esc_attr( $custom_text['text'] ) ?>" />
									<a class="del-item dashicons dashicons-trash"></a>
								</div>
							</li>
							<?php
						}
					}
				?>
			</ul>

			<script>
				var customnext = <?php echo esc_js( $custom_count+1 ); ?> ;
			</script>

		</div><!-- #breaking_custom-item /-->
	</div> <!-- Breaking News /-->

	<?php

	echo'</div><!-- .top-nav-news-all-options /-->';
	echo'</div><!-- #top-nav-settings /-->';

	echo'<div id="main-nav-settings" class="top-main-nav-settings">';

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Enable', 'jannah' ),
			'id'     => 'main_nav',
			'type'   => 'checkbox',
			'toggle' => '.main-nav-related-options, .main-nav-components-wrapper, #header-preview .header-main-menu-wrap',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Dark Skin', 'jannah' ),
			'id'    => 'main_nav_dark',
			'type'  => 'checkbox',
			'class' => 'main-nav-related',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Boxed Layout', 'jannah' ),
			'id'   => 'main_nav_layout',
			'type' => 'checkbox',
			'class' => 'main-nav-related',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Above The Header', 'jannah' ),
			'id'   => 'main_nav_position',
			'type' => 'checkbox',
			'class' => 'main-nav-related',
		));

	jannah_custom_header_area_options( esc_html__( 'Main Nav Components', 'jannah' ), 'main-nav-components' );


	echo '<div id="sticky-nav-section" class="main-nav-related-options">';

		jannah_theme_option(
			array(
				'title' => esc_html__( 'Sticky Menu', 'jannah' ),
				'type'  => 'header',
			));

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Enable', 'jannah' ),
				'id'     => 'stick_nav',
				'toggle' => '#sticky_behavior-item',
				'type'   => 'checkbox',
			));

		jannah_theme_option(
			array(
				'name'    => esc_html__( 'Sticky Menu behavior', 'jannah' ),
				'id'      => 'sticky_behavior',
				'type'    => 'radio',
				'options' => array(
					'default' => esc_html__( 'Default', 'jannah' ),
					'upwards' => esc_html__( 'When scrolling upwards', 'jannah' ),
				)));

		echo'</div>';

	echo'</div><!-- #top-nav-settings /-->';







/*-----------------------------------------------------------------------------------*/
# Header area options
/*-----------------------------------------------------------------------------------*/
function jannah_custom_header_area_options( $text_field, $area_name ){ ?>
	<div class="<?php echo esc_attr( $area_name.'-wrapper' ) ?>">

	<?php

		jannah_theme_option(
			array(
				'title' => $text_field,
				'type'  => 'header',
			));

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Search', 'jannah' ),
				'id'     => $area_name.'_search',
				'type'   => 'checkbox',
				'toggle' => "#$area_name-search, .$area_name-live_search",
			));

	?>

	<div id="<?php echo esc_attr( $area_name ) ?>-search">

		<?php

			jannah_theme_option(
				array(
					'name' => esc_html__( 'Live Search', 'jannah' ),
					'id'   => $area_name.'_live_search',
					'type' => 'checkbox',
				));

			jannah_theme_option(
				array(
					'name'   => esc_html__( 'Search Layout', 'jannah' ),
					'id'     => $area_name."_search_layout",
					'type'   => "radio",
					'toggle' => array(
						'default' => ".header-$area_name-search",
						'compact'	=> ".header-$area_name-search1, #$area_name"."_type_to_search-item" ),
					'options' => array(
						'default' => esc_html__( 'Default', 'jannah' ),
						'compact' => esc_html__( 'Compact', 'jannah' ),
				)));

			jannah_theme_option(
				array(
					'name'  => esc_html__( 'Type To Search', 'jannah' ),
					'id'    => $area_name.'_type_to_search',
					'class' => $area_name.'_search_layout',
					'type'  => 'checkbox',

				));
		?>

	</div>

	<?php

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Slide Sidebar', 'jannah' ),
				'id'     => $area_name.'_slide_area',
				'type'   => 'checkbox',
				'toggle' => ".header-$area_name-slide",
			));

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Log In', 'jannah' ),
				'id'     => $area_name.'_login',
				'type'   => 'checkbox',
				'toggle' => ".header-$area_name-login",
			));

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Random Article Button', 'jannah' ),
				'id'     => $area_name.'_random',
				'type'   => 'checkbox',
				'toggle' => ".header-$area_name-random",
			));

		if ( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
			jannah_theme_option(
				array(
					'name'   => esc_html__( 'Shopping Cart', 'jannah' ),
					'id'     => $area_name.'_cart',
					'type'   => 'checkbox',
					'toggle' => ".header-$area_name-cart",
				));
		}

		if ( JANNAH_BUDDYPRESS_IS_ACTIVE ){
			jannah_theme_option(
				array(
					'name'   => esc_html__( 'BuddyPress Notifications', 'jannah' ),
					'id'     => $area_name.'_bp_notifications',
					'type'   => 'checkbox',
					'toggle' => ".header-$area_name-bp_notifications",
				));
		}

		jannah_theme_option(
			array(
				'name'   => esc_html__( 'Social Icons', 'jannah' ),
				'id'		 => $area_name.'_social',
				'type'   => "checkbox",
				'toggle' => "#$area_name-social-icons, .$area_name-live_social",
			));

	?>

	<div id="<?php echo esc_attr( $area_name ) ?>-social-icons">

		<?php

			jannah_theme_option(
				array(
					'name'   => esc_html__( 'Social icons layout', 'jannah' ),
					'id'     => $area_name.'_social_layout',
					'type'   => 'radio',
					'toggle' => array(
						'default' => ".header-$area_name-follow1",
						'list'    => ".header-$area_name-follow",
						'grid'    => ".header-$area_name-follow",),
					'options' => array(
						'default' => esc_html__( 'Default', 'jannah' ) ,
						'list'    => esc_html__( 'Menu with names', 'jannah' ),
						'grid'    => esc_html__( 'Grid Menu', 'jannah' ),
				)));

			?>

		</div>
	</div>
<?php
}
?>

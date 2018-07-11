<?php
	if( jannah_get_option( 'main_nav' ) || jannah_get_option( 'header_layout' ) == 1 ):

		# Header Layout ----------
		$header_layout = jannah_get_option( 'header_layout', 3 );

		# Sticky Main Nav ----------
		$main_menu_class = jannah_get_option( 'stick_nav' ) ? ' fixed-enabled' : '';

		# Live Search skin ----------
		$live_search_data_skin = '';
		if( jannah_get_option( 'main-nav-components_search' ) && jannah_get_option( 'main-nav-components_live_search' ) ){
			$live_search_skin      = jannah_get_option( 'main_nav_dark' ) ? 'dark' : 'light';
			$main_menu_class      .= ' live-search-parent';
			$live_search_data_skin = 'data-skin="search-in-main-nav live-search-'. $live_search_skin .'"';
		}

		# Header Layout ----------
		$logo_width 				= '';
		$header_line_height = '';
		$has_line_height 		= '';

		if( $header_layout == 1 ){

			$logo_args = jannah_logo_args();
			extract( $logo_args );

			$logo_width			    = 'style="width:' . intval( $logo_width ). 'px"';
			$has_line_height 	  = ' has-line-height';
			$header_line_height = 'style="line-height:' . intval( $logo_height + $logo_margin_top + $logo_margin_bottom ). 'px"';
		}

	?>

<div class="main-nav-wrapper">
	<nav id="main-nav" <?php echo ( $live_search_data_skin ); ?> class="<?php echo esc_attr( $main_menu_class ) ?>" <?php echo ( $header_line_height ) ?> aria-label="<?php esc_html_e( 'Primary Navigation', 'jannah' ); ?>">
		<div class="container">

			<div class="main-menu-wrapper">

				<?php
					if( $header_layout == 1 ){ ?>
						<div class="header-layout-1-logo <?php echo esc_attr( $has_line_height ) ?>"<?php echo ( $logo_width ) ?>>
							<?php

							if( $header_layout == 1 ){
								do_action( 'jannah_before_logo' );
							}

							jannah_logo();

							?>
						</div>
						<?php
					}
				?>

				<div id="menu-components-wrap">

					<div class="main-menu main-menu-wrap tie-alignleft">
						<?php
							$custom_menu = jannah_get_object_option( false, 'cat_menu', 'tie_menu' );

							wp_nav_menu(
								array(
									'menu'            => $custom_menu,
									'container_id'    => 'main-nav-menu',
									'container_class' => 'main-menu',
									'theme_location'  => 'primary',
									'walker'          => ! jannah_is_mobile() ? new jannah_mega_menu_walker() : '',
									'fallback_cb'     => false,
									'items_wrap'      => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
								));
						?>
					</div><!-- .main-menu.tie-alignleft /-->

					<?php
						# Get components template ----------
						jannah_get_template_part( 'framework/headers/header', 'components', array( 'components_id' => 'main-nav' ) );
					?>

				</div><!-- #menu-components-wrap /-->
			</div><!-- .main-menu-wrapper /-->
		</div><!-- .container /-->
	</nav><!-- #main-nav /-->
</div><!-- .main-nav-wrapper /-->

<?php endif; ?>

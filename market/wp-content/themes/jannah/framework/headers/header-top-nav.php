<?php
	if( jannah_get_option( 'top_nav' ) ):

		# Top nav Classes ----------
		$top_nav_class   = array();
		$top_nav_class[] = jannah_get_option( 'top_date' ) ? 'date' : '';
		$top_nav_class[] = jannah_get_option( 'top-nav-area-1' );
		$top_nav_class[] = jannah_get_option( 'top-nav-area-2' );
		$top_nav_class   = implode( '-', array_filter( $top_nav_class ) );
		$top_nav_class   = ! empty( $top_nav_class ) ? 'has-' . $top_nav_class : '';

		# Class for the Breakin News ----------
		if( jannah_get_option( 'top-nav-area-1' ) == 'breaking' ){
			$top_nav_class .= ' has-breaking-news';
		}


		# Live Search skin ----------
		$live_search_data_skin = '';
		if( jannah_get_option( "top-nav-components_search" ) && jannah_get_option( "top-nav-components_live_search" ) ){
			$live_search_skin      = jannah_get_option( 'top_nav_dark' ) ? 'dark' : 'light';
			$top_nav_class        .= ' live-search-parent';
			$live_search_data_skin = 'data-skin="search-in-top-nav live-search-'. $live_search_skin .'" ';
		}

		?>

	<nav id="top-nav" <?php echo ( $live_search_data_skin ); ?>class="<?php echo esc_attr( $top_nav_class ) ?>" aria-label="<?php esc_html_e( 'Secondary Navigation', 'jannah' ); ?>">
		<div class="container">
			<div class="topbar-wrapper">

				<?php
					# Today's Date ----------
					if( jannah_get_option( 'top_date' ) ){
						$date_format = jannah_get_option( 'todaydate_format', 'l ,  j  F Y' ); ?>

						<div class="topbar-today-date">
							<span class="fa fa-clock-o" aria-hidden="true"></span>
							<strong class="inner-text"><?php echo date_i18n( $date_format, current_time( 'timestamp' ) ); ?></strong>
						</div>
						<?php
					}
				?>

				<div class="tie-alignleft">
					<?php
						# Breaking News ----------
						if( jannah_get_option( 'top-nav-area-1' ) == 'breaking' ){
							jannah_get_template_part( 'framework/parts/breaking-news', '', array(
								'type'            => 'header',
								'breaking_id'     => 'in-header',
								'breaking_title'  => jannah_get_option( 'breaking_title'  ),
								'breaking_effect' => jannah_get_option( 'breaking_effect' ),
								'breaking_arrows' => jannah_get_option( 'breaking_arrows' ),
								'breaking_type'   => jannah_get_option( 'breaking_type'   ),
								'breaking_number' => jannah_get_option( 'breaking_number' ),
								'breaking_tag'    => jannah_get_option( 'breaking_tag'    ),
								'breaking_cat'    => jannah_get_option( 'breaking_cat'    ),
								'breaking_custom' => jannah_get_option( 'breaking_custom' ),
							));
						}


						# Top Menu ----------
						if( jannah_get_option( 'top-nav-area-1' ) == 'menu' && has_nav_menu( 'top-menu' ) ){
							wp_nav_menu(
								array(
									'container_class' => 'top-menu',
									'theme_location'  => 'top-menu'
								));
						}

						# Get components template ----------
						if( jannah_get_option( 'top-nav-area-1' ) == 'components' ){
							jannah_get_template_part( 'framework/headers/header', 'components', array( 'components_id' => 'top-nav' ) );
						}
					?>
				</div><!-- .tie-alignleft /-->

				<div class="tie-alignright">
					<?php

					# Top Menu ----------
					if( jannah_get_option( 'top-nav-area-2' ) == 'menu' && has_nav_menu( 'top-menu' ) ){
						wp_nav_menu(
							array(
								'container_class' => 'top-menu',
								'theme_location'  => 'top-menu'
							));
					}

					# Get components template ----------
					if( jannah_get_option( 'top-nav-area-2' ) == 'components' ){
						jannah_get_template_part( 'framework/headers/header', 'components', array( 'components_id' => 'top-nav' ) );
					}

					?>
				</div><!-- .tie-alignright /-->

			</div><!-- .topbar-wrapper /-->
		</div><!-- .container /-->
	</nav><!-- #top-nav /-->

<?php endif; ?>

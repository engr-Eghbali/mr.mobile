<?php

	ob_start();

	if( jannah_is_mobile() ) return;



	# Search ----------
	if( jannah_get_option( $components_id.'-components_search' ) ):
		$live_search_class = jannah_get_option( "$components_id-components_live_search" ) ? 'class="is-ajax-search" ' : '';

		if( jannah_get_option( "$components_id-components_search_layout" ) == 'compact' ):?>
			<li class="search-compact-icon menu-item custom-menu-link">
				<a href="#" data-type="modal-trigger" class="tie-search-trigger">
					<span class="fa fa-search" aria-hidden="true"></span>
					<span class="screen-reader-text"><?php _eti( 'Search for' ) ?></span>
				</a>
				<span class="cd-modal-bg"></span>
			</li>
			<?php

		else: ?>
			<li class="search-bar menu-item custom-menu-link" role="search" aria-label="<?php esc_html_e( 'Search', 'jannah' ); ?>">
				<form method="get" id="search" action="<?php echo esc_url(home_url( '/' )); ?>/">
					<input id="search-input" <?php echo ( $live_search_class ); ?>type="text" name="s" title="<?php _eti( 'Search for' ) ?>" placeholder="<?php _eti( 'Search for' ) ?>" />
					<button id="search-submit" type="submit"><span class="fa fa-search" aria-hidden="true"></span></button>
				</form>
			</li>
			<?php
		endif;
	endif;



	# Slide sidebar ----------
	if( jannah_get_option( $components_id.'-components_slide_area' ) ):?>
		<li class="side-aside-nav-icon menu-item custom-menu-link">
			<a href="#">
				<span class="fa fa-navicon" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Sidebar', 'jannah' ) ?></span>
			</a>
		</li>
		<?php
	endif;



	# Login ----------
	if( jannah_get_option( $components_id.'-components_login' ) ):
		$login_icon = is_user_logged_in() ? 'user' : 'lock'; ?>
		<li class="popup-login-icon menu-item custom-menu-link">
		 	<a href="#" class="lgoin-btn tie-popup-trigger">
				<span class="fa fa-<?php echo esc_attr( $login_icon ) ?>" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php _eti( 'Log In' ) ?></span>
			</a>
		</li>
		<?php
	endif;



	# Random ----------
	if( jannah_get_option( $components_id.'-components_random' ) ):?>
		<li class="random-post-icon menu-item custom-menu-link">
			<a href="<?php echo esc_url( add_query_arg( 'random-post', 1 ) ); ?>" class="random-post" title="<?php _eti( 'Random Article' ) ?>">
				<span class="fa fa-random" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Random Post', 'jannah' ) ?></span>
			</a>
		</li>
		<?php
	endif;



	# Cart ----------
	if( jannah_get_option( $components_id.'-components_cart' ) && JANNAH_WOOCOMMERCE_IS_ACTIVE ):?>
		<li class="shopping-cart-icon menu-item custom-menu-link">
			<a href="<?php echo WC()->cart->get_cart_url() ?>" title="<?php _eti( 'View your shopping cart' ); ?>">
				<span class="shooping-cart-counter menu-counter-bubble-outer">
					<?php
						$cart_count_items = WC()->cart->get_cart_contents_count();
						if( ! empty( $cart_count_items ) ){ ?>
						<span class="menu-counter-bubble"><?php echo ( $cart_count_items ) ?></span>
					<?php } ?>
				</span><!-- .menu-counter-bubble-outer -->
				<span class="fa fa-shopping-bag" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php _eti( 'View your shopping cart' ) ?></span>
			</a>
			<div class="components-sub-menu comp-sub-menu">
				<div class="shopping-cart-details">
					<?php do_action( 'jannah_cart_menu_details' ) ?>
				</div><!-- shopping-cart-details -->
			</div><!-- .components-sub-menu /-->
		</li><!-- .shopping-cart-btn /-->
		<?php
	endif;




	# BuddyPress Notifications ----------
	if( jannah_get_option( $components_id.'-components_bp_notifications' ) && is_user_logged_in() && JANNAH_BUDDYPRESS_IS_ACTIVE ):
	$notification = jannah_bp_get_notifications(); ?>
		<li class="notifications-icon menu-item custom-menu-link">
			<a href="<?php echo esc_url( $notification['link'] ) ?>" title="<?php _eti( 'Notifications' ); ?>">
				<span class="notifications-total-outer">
					<?php if( ! empty( $notification['count'] )){ ?>
						<span class="menu-counter-bubble"><?php echo ( $notification['count'] ) ?></span>
					<?php } ?>
				</span><!-- .menu-counter-bubble-outer -->
				<span class="fa fa-bell" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php _eti( 'Notifications' ) ?></span>
			</a>
			<div class="bp-notifications-menu components-sub-menu comp-sub-menu">
				<?php echo ( $notification['data'] ) ?>
			</div><!-- .components-sub-menu /-->
		</li><!-- .notifications-btn /-->
		<?php
	endif;



	# Social ----------
	if( jannah_get_option( $components_id.'-components_social' ) ):
		if( jannah_get_option( "$components_id-components_social_layout" ) == 'list' ):?>
			<li class="list-social-icons menu-item custom-menu-link">
				<a href="#" class="follow-btn">
					<span class="fa fa-plus" aria-hidden="true"></span>
					<span class="follow-text"><?php _eti( 'Follow' ) ?></span>
				</a>
				<?php
					jannah_get_social(
						array(
							'show_name' => true,
							'before'    => '<ul class="dropdown-social-icons comp-sub-menu">',
							'after'     => '</ul><!-- #dropdown-social-icons /-->'
						));
				?>
			</li><!-- #list-social-icons /-->
			<?php

		elseif( jannah_get_option( $components_id.'-components_social_layout' ) == 'grid' ):?>
			<li class="grid-social-icons menu-item custom-menu-link">
				<a href="#" class="follow-btn">
					<span class="fa fa-plus" aria-hidden="true"></span>
					<span class="follow-text"><?php _eti( 'Follow' ) ?></span>
				</a>
				<?php
					jannah_get_social(
						array(
							'before' => '<ul class="dropdown-social-icons comp-sub-menu">',
							'after'  => '</ul><!-- #dropdown-social-icons /-->'
						));
				?>
			</li><!-- #grid-social-icons /-->
			<?php

		else:
			jannah_get_social(
				array(
					'before' => ' ',
					'after'  => ' '
				));

		endif;
	endif;




	# Show the elements ----------
	$output = ob_get_clean();

	if( ! empty( $output )){
		echo empty( $before ) ? '<ul class="components">' : $before;
		echo ( $output );
		echo empty( $after ) ? '</ul><!-- Components -->' : $before;
	}

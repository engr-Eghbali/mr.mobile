<?php jannah_get_banner( 'banner_bottom', '<div class="stream-item stream-item-above-footer">', '</div>' ); ?>

<footer id="footer" class="site-footer dark-skin">

	<?php get_template_part( 'framework/footers/footer', 'instagram' ); ?>

	<?php
	# Check if the footer sidebars area is hidden on mobiles ----------
	if( ( jannah_get_option( 'footer_widgets_area_1' ) || jannah_get_option( 'footer_widgets_area_2' ) ) && ! jannah_is_mobile_and_hidden( 'footer' )){ ?>

		<div id="footer-widgets-container">
			<div class="container">
				<?php

				# Get Footer Widgets areas ----------
				jannah_get_template_part( 'sidebar', 'footer', array( 'name' => 'area_1' ));
				jannah_get_template_part( 'sidebar', 'footer', array( 'name' => 'area_2' ));


				?>
			</div><!-- .container /-->
		</div><!-- #Footer-widgets-container /-->
		<?php
	}
	?>


	<?php
	# Check if the copyright area is hidden on mobiles ----------
	if( jannah_get_option( 'copyright_area') && ! jannah_is_mobile_and_hidden( 'copyright' ) ){

		$site_info_class = jannah_get_option( 'footer_centered' ) ? '' : 'site-info-layout-2'; ?>

		<div id="site-info" class="<?php echo esc_attr( $site_info_class ) ?>">
			<div class="container">
				<div class="tie-row">
					<div class="tie-col-md-12">

						<?php

						# Replace Footers variables ----------
						$footer_vars = array( '%year%', '%site%', '%url%' );
						$footer_val  = array( date('Y') , get_bloginfo('name') , esc_url(home_url( '/' )) );

						# First text area ----------
						if( jannah_get_option( 'footer_one' ) ){
							echo '<div class="copyright-text copyright-text-first">'. str_replace( $footer_vars , $footer_val , jannah_get_option( 'footer_one' )) . '</div>';
						}

						# Second text area ----------
						if( jannah_get_option( 'footer_two' ) ){
							echo '<div class="copyright-text copyright-text-second">'. str_replace( $footer_vars , $footer_val , jannah_get_option( 'footer_two' )) . '</div>';
						}

						# Footer Menu ----------
						if( jannah_get_option( 'footer_menu' ) && has_nav_menu( 'footer-menu' ) ){
							wp_nav_menu(
								array(
									'container_class' => 'footer-menu',
									'theme_location'  => 'footer-menu',
									'depth' => 1,
								));
						}

						# Footer social icons ----------
						if( jannah_get_option( 'footer_social' ) ){
							jannah_get_social( array( 'before' => '<ul class="social-icons">') );
						}

						?>

					</div><!-- .tie-col /-->
				</div><!-- .tie-row /-->
			</div><!-- .container /-->
		</div><!-- #site-info /-->
		<?php
	}
	?>

</footer><!-- #footer /-->

<?php do_action( 'jannah_below_footer' ); ?>

<?php
	# Go to top button ----------
	if( jannah_get_option( 'footer_top' ) ){
		echo '<a id="go-to-top" class="go-to-top-button" href="#go-to-tie-body"><span class="fa fa-angle-up"></span></a><div class="clear"></div>';
	}
?>

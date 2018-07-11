<?php

# Check if the newsletter is hidden on mobiles ----------
if( jannah_is_mobile_and_hidden( 'post_newsletter' )) return;


if( ( ( jannah_get_option( 'post_newsletter' ) && ! jannah_get_postdata( 'tie_hide_newsletter' ) ) || jannah_get_postdata( 'tie_hide_newsletter' ) == 'no' ) && ( jannah_get_option( 'post_newsletter_mailchimp' ) || jannah_get_option( 'post_newsletter_feedburner' ) )){ ?>
	<div class="container-wrapper" id="post-newsletter">
		<div class="subscribe-widget">
			<span class="fa fa-envelope newsletter-icon" aria-hidden="true"></span>

			<?php
				if( $text = jannah_get_option( 'post_newsletter_text' )){ ?>

					<div class="subscribe-widget-content">
						<?php echo do_shortcode( $text ) ?>
					</div>

					<?php
				}
			?>

			<?php

				if( $feedburner = jannah_get_option( 'post_newsletter_feedburner' )){ ?>

					<form action="https://feedburner.google.com/fb/a/mailverify" method="post" class="subscribe-form" target="popupwindow" onsubmit="window.open('https://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr( $feedburner ) ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
						<label class="screen-reader-text" for="email"><?php _eti( 'Enter your Email address' ); ?></label>
						<input class="subscribe-input required email" id="email" type="text" name="email" placeholder="<?php _eti( 'Enter your Email address' ); ?>">
						<input type="hidden" value="<?php echo esc_attr( $feedburner ) ?>" name="uri">
						<input type="hidden" name="loc" value="en_US">
						<input class="button subscribe-submit" type="submit" name="submit" value="<?php _eti( 'Subscribe' ) ; ?>">
					</form>
					<?php
				}

				elseif( $mailchimp = jannah_get_option( 'post_newsletter_mailchimp' )){ ?>
					<div id="mc_embed_signup">
						<form action="<?php echo esc_attr( $mailchimp ) ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="subscribe-form validate" target="_blank" novalidate>
							<div id="mc_embed_signup_scroll">
								<div class="mc-field-group">
									<label class="screen-reader-text" for="mce-EMAIL"><?php _eti( 'Enter your Email address' ); ?></label>
									<input type="email" value="" id="mce-EMAIL" placeholder="<?php _eti( 'Enter your Email address' ); ?>" name="EMAIL" class="subscribe-input required email" id="mce-EMAIL">
								</div>
								<div id="mce-responses" class="clear">
									<div class="response" id="mce-error-response" style="display:none"></div>
									<div class="response" id="mce-success-response" style="display:none"></div>
								</div>
								<input type="submit" value="<?php _eti( 'Subscribe' ) ; ?>" name="subscribe" id="mc-embedded-subscribe" class="button subscribe-submit">
							</div>
						</form>
					</div>
					<?php
				}
			?>

		</div><!-- .subscribe-widget /-->
	</div>

<?php
}
?>

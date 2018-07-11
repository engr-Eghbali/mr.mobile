<?php

# Instagram ----------
if( jannah_get_option( 'footer_instagram' ) && jannah_get_option( 'footer_instagram_source_id' ) && ! jannah_is_mobile_and_hidden( 'footer_instagram' )){

	if( JANNAH_INSTANOW_IS_ACTIVE ){

		if( get_option( 'instanow_access_token' ) ){
			$source       = jannah_get_option( 'footer_instagram_source', 'user' );
			$source_id    = jannah_get_option( 'footer_instagram_source_id' );
			$media_number = jannah_get_option( 'footer_instagram_rows' ) == 2 ? 12 : 6 ;
			$media_link   = jannah_get_option( 'footer_instagram_media_link', 'file' );

			$insta_settings = array(
				'media_source'   => $source,
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
				'columns_number' => 8,
				'flat'           => 'true',
			);

			echo '<div id="footer-instagram" class="footer-instagram-'. $media_number .'">';
				if( jannah_get_option( 'footer_instagram_button' )){
					echo '<a id="instagram-link" target="_blank" rel="nofollow" href="'. esc_url( jannah_get_option( 'footer_instagram_button_url' ) ) .'"><span class="fa fa-instagram" aria-hidden="true"></span> '. jannah_get_option( 'footer_instagram_button_text' ) .'</a>';
				}

				tie_insta_media( $insta_settings );
			echo '</div>';
		}

		else{
			echo '<div id="footer-instagram" class="footer-instagram-6">';
				echo'<span class="theme-notice">'. esc_html__( 'Go to the InstaNow Settings page to connect your account to the Instagram API.', 'jannah' ) .'</span>';
			echo '</div>';
		}
	}

	else{
		echo '<div id="footer-instagram" class="footer-instagram-6">';
			echo'<span class="theme-notice">'. esc_html__( 'This section requries the InstaNOW Plugin. You can install it from the Theme settings menu > Install Plugins.', 'jannah' ) .'</span>';
		echo '</div>';
	}
}

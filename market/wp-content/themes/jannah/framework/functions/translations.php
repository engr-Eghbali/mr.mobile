<?php

/*-----------------------------------------------------------------------------------*/
# Get the translated text
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( '__ti' )){

	function __ti( $text ){

		$default_text  = jannah_translation_texts();
		$sanitize_text = sanitize_title( htmlspecialchars( $text ));

		if( jannah_get_option( $sanitize_text ) ){
			return htmlspecialchars_decode( jannah_get_option( $sanitize_text ) );
		}
		elseif( array_key_exists( $text, $default_text )){
			return $default_text[ $text ];
		}
		else{
			return $text;
		}
	}

}



/*-----------------------------------------------------------------------------------*/
# Print the translated text
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( '_eti' )){

	function _eti( $text ){
		echo __ti( $text );
	}

}


/*-----------------------------------------------------------------------------------*/
# Translations texts
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_translation_texts' )){

	function jannah_translation_texts(){

		return array(
			'Share'                  => esc_html__( 'Share', 'jannah' ),
			'No More Posts'          => esc_html__( 'No More Posts', 'jannah' ),
			'View all results'       => esc_html__( 'View all results', 'jannah' ),
			'Home'                   => esc_html__( 'Home', 'jannah' ),
			'Type and hit Enter'     => esc_html__( 'Type and hit Enter', 'jannah' ),
			'page'                   => esc_html__( 'page', 'jannah' ),
			'All'                    => esc_html__( 'All', 'jannah' ),
			'First'                  => esc_html__( 'First', 'jannah' ),
			'Last'                   => esc_html__( 'Last', 'jannah' ),
			'More'                   => esc_html__( 'More', 'jannah' ),
			'%s ago'                 => esc_html__( '%s ago', 'jannah' ),
			'Menu'                   => esc_html__( 'Menu', 'jannah' ),
			'Welcome'                => esc_html__( 'Welcome', 'jannah' ),
			'Pages'                  => esc_html__( 'Pages', 'jannah' ),
			'Categories'             => esc_html__( 'Categories', 'jannah' ),
			'Tags'                   => esc_html__( 'Tags', 'jannah' ),
			'Archives'               => esc_html__( 'Archives', 'jannah' ),
			'Views'                  => esc_html__( 'Views', 'jannah' ),
			'Read More &raquo;'      => esc_html__( 'Read More &raquo;', 'jannah' ),
			'Share via Email'        => esc_html__( 'Share via Email', 'jannah' ),
			'Print'                  => esc_html__( 'Print', 'jannah' ),
			'About %s'               => esc_html__( 'About %s', 'jannah' ),
			'By %s'                  => esc_html__( 'By %s', 'jannah' ),
			'Popular'                => esc_html__( 'Popular', 'jannah' ),
			'Recent'                 => esc_html__( 'Recent', 'jannah' ),
			'Comments'               => esc_html__( 'Comments', 'jannah' ),
			'Search Results for: %s' => esc_html__( 'Search Results for: %s', 'jannah' ),
			'404 :('                 => esc_html__( '404 :(', 'jannah' ),
			'No products found'      => esc_html__( 'No products found', 'jannah' ),
			'Nothing Found'          => esc_html__( 'Nothing Found', 'jannah' ),
			'Dashboard'              => esc_html__( 'Dashboard', 'jannah' ),
			'Your Profile'           => esc_html__( 'Your Profile', 'jannah' ),
			'Log Out'                => esc_html__( 'Log Out', 'jannah' ),
			'Username'               => esc_html__( 'Username', 'jannah' ),
			'Password'               => esc_html__( 'Password', 'jannah' ),
			'Forget?'                => esc_html__( 'Forget?', 'jannah' ),
			'Remember me'            => esc_html__( 'Remember me', 'jannah' ),
			'Log In'                 => esc_html__( 'Log in', 'jannah' ),
			'Search for'             => esc_html__( 'Search for', 'jannah' ),
			'Price:'                 => esc_html__( 'Price:', 'jannah' ),
			'Quantity:'              => esc_html__( 'Quantity:', 'jannah' ),
			'Cart Subtotal:'         => esc_html__( 'Cart Subtotal:', 'jannah' ),
			'Veiw Cart'              => esc_html__( 'Veiw Cart', 'jannah' ),
			'Process To Checkout'    => esc_html__( 'Process To Checkout', 'jannah' ),
			'Go to the shop'         => esc_html__( 'Go to the shop', 'jannah' ),
			'Random Article'         => esc_html__( 'Random Article', 'jannah' ),
			'Follow'                 => esc_html__( 'Follow', 'jannah' ),
			'Check Also'             => esc_html__( 'Check Also', 'jannah' ),
			'Subscribe'              => esc_html__( 'Subscribe', 'jannah' ),
			'Related Articles'       => esc_html__( 'Related Articles', 'jannah' ),
			'Videos'                 => esc_html__( 'Videos', 'jannah' ),
			'Follow us on Flickr'    => esc_html__( 'Follow us on Flickr', 'jannah' ),
			'Follow Us'              => esc_html__( 'Follow Us', 'jannah' ),
			'Follow us on Twitter'   => esc_html__( 'Follow us on Twitter', 'jannah' ),
			'Less than a minute'     => esc_html__( 'Less than a minute', 'jannah' ),
			'%s hours read'          => esc_html__( '%s hours read', 'jannah' ),
			'1 minute read'          => esc_html__( '1 minute read', 'jannah' ),
			'%s minutes read'        => esc_html__( '%s minutes read', 'jannah' ),
			'No new notifications'   => esc_html__( 'No new notifications', 'jannah' ),
			'Notifications'          => esc_html__( 'Notifications', 'jannah' ),
			'Show More'              => esc_html__( 'Show More', 'jannah' ),
			'Load More'              => esc_html__( 'Load More', 'jannah' ),
			'Show Less'              => esc_html__( 'Show Less', 'jannah' ),
			'km/h'                   => esc_html__( 'km/h', 'jannah' ),
			'mph'                    => esc_html__( 'mph', 'jannah' ),


			'View your shopping cart'       => esc_html__( 'View your shopping cart', 'jannah' ),
			'Enter your Email address'      => esc_html__( 'Enter your Email address', 'jannah' ),
			"Don't have an account?"        => esc_html__( "Don't have an account?", 'jannah' ),
			'Your cart is currently empty.' => esc_html__( 'Your cart is currently empty.', 'jannah' ),

			'Oops! That page can&rsquo;t be found.'   => esc_html__( 'Oops! That page can&rsquo;t be found.', 'jannah' ),
			'Type your search words then press enter' => esc_html__( 'Type your search words then press enter', 'jannah' ),
			'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.'      => esc_html__( "It seems we can't find what you're looking for. Perhaps searching can help.", 'jannah' ),
			'Sorry, but nothing matched your search terms. Please try again with some different keywords.' => esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'jannah' ),

			'Adblock Detected' => esc_html__( 'Adblock Detected', 'jannah' ),
			'Please consider supporting us by disabling your ad blocker' => esc_html__( 'Please consider supporting us by disabling your ad blocker', 'jannah' ),
		);
	}

}

<?php
/**
 * Styling functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





/*-----------------------------------------------------------------------------------*/
# Insert Fonts CSS
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_insert_fonts_css' )){

	function jannah_insert_fonts_css(){

		# Print the custom fonts names ----------
		if( ! empty( $GLOBALS['tie_fonts_family'] )){

			$out = '';
			$fonts_sections  = jannah_fonts_sections();
			$is_loaded_class = '.wf-active ';

			foreach ( $GLOBALS['tie_fonts_family'] as $section => $font ){
				$elements = $fonts_sections[ $section ];
				if( is_array( $font ) ){
					$font     = $font[0];
					$elements = $is_loaded_class . str_replace( ', ', ', '.$is_loaded_class, $elements);
				}
				$out .= "\t".$elements.'{font-family: '. $font .';}'."\n";
			}

			return $out;
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Load Fonts
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_load_fonts' )){

	add_action( 'wp_enqueue_scripts', 'jannah_load_fonts', 1 );
	function jannah_load_fonts(){

		$fonts_sections     = jannah_fonts_sections();
		$default_fonts      = array(); //array( 'Roboto' );
		$custom_fonts_names = array();
		$google_fonts       = array();
		$google_early_fonts = array();
		$fontface_me_fonts  = array();
		$external_font_code = array();


		foreach( $fonts_sections as $font_section_key => $font_section_tags ){

			$font = $variants = '';

			# Google Web fonts ----------
			if( jannah_get_option( 'typography_'. $font_section_key .'_font_source' ) == 'google' ){

				if( $font = jannah_get_option( 'typography_'. $font_section_key .'_google_font' )){

					# Early access Google web font ----------
					if( strpos( $font, 'early#' ) !== false ){

						$font = str_replace( 'early#', '', $font );

						$custom_fonts_names[ $font_section_key ] = $font;
						$google_early_fonts[ $font_section_key ] = strtolower( str_replace( ' ', '', $font ) );
					}

					# Normal Google web font ----------
					else{

						// Set the google font name as array to add a prefix to it later
						// Avoid generate the default fonts hardcoded in the main style.css file
						if( ! in_array( $font, $default_fonts )){
							$custom_fonts_names[ $font_section_key ] = array( str_replace( '+', ' ', "'$font'" ) );
						}

						# Google web font variants ----------
						$font .= ':';
						if( $variants = jannah_get_option( 'typography_'. $font_section_key .'_google_variants' )){
							$font .= implode( ',', $variants );
						}

						# Google web font character sets ----------
						$font .= ':latin';
						if( $character_sets = jannah_get_option( 'typography_google_character_sets' )){
							$font .= ','.implode( ',', $character_sets );
						}

						$google_fonts[] = "'$font'";
					}
				}
			}

			# External Sources ----------
			elseif( jannah_get_option( 'typography_'. $font_section_key .'_font_source' ) == 'external' ){

				if(( $ext_head = jannah_get_option( 'typography_'. $font_section_key .'_ext_head' )) &&
					 ( $ext_font = jannah_get_option( 'typography_'. $font_section_key .'_ext_font' ))){

						$external_font_code[] = $ext_head;
						$custom_fonts_names[ $font_section_key ] = "'$ext_font'";
				}
			}

			# Web Safe fonts ----------
			elseif(( jannah_get_option( 'typography_'. $font_section_key .'_font_source' ) == 'standard' ) &&
						 ( $standard = jannah_get_option( 'typography_'. $font_section_key .'_standard_font'   ))){

							$custom_fonts_names[ $font_section_key ] = str_replace( 'safefont#', '', $standard );
			}

			# FontFace.me fonts ----------
			elseif(( jannah_get_option( 'typography_'. $font_section_key .'_font_source' ) == 'fontfaceme' ) &&
						 ( $fontfaceme = jannah_get_option( 'typography_'. $font_section_key .'_fontfaceme'   ))){

						$font = str_replace( 'faceme#', '', $fontfaceme );

						$custom_fonts_names[ $font_section_key ] = $font;
						$fontface_me_fonts[ $font_section_key ]  = strtolower( str_replace( ' ', '', $font ) );
			}

		} //endFOR


		# Google web fonts ----------
		if( ! empty( $google_fonts ) ){
			$google_fonts = implode( ', ', $google_fonts );

			$GLOBALS['tie_google_fonts'] = $google_fonts;
		}


		# External Fonts Head Code ----------
		if( ! empty( $external_font_code ) ){
			$GLOBALS['tie_external_font_code'] = $external_font_code;
		}


		# Get the Google web Early access fonts ----------
		if( ! empty( $google_early_fonts ) ){
			foreach ( $google_early_fonts as $early_font ){
				wp_enqueue_style( $early_font, '//fonts.googleapis.com/earlyaccess/'.$early_font );
			}
		}


		# Get the FontsFace.me fonts ----------
		if( ! empty( $fontface_me_fonts ) ){
			foreach ( $fontface_me_fonts as $fontface ){
				$protocol = is_ssl() ? 'https' : 'http';
				wp_enqueue_style( $fontface, $protocol . '://www.fontstatic.com/f='.$fontface );
			}
		}

		if( ! empty( $custom_fonts_names )){
			$GLOBALS['tie_fonts_family'] = $custom_fonts_names;
		}

	}

}





/*-----------------------------------------------------------------------------------*/
# Print the Google web fonts Script and external fonts code in the head section
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_load_fonts_head_area' )){

	add_action( 'wp_head', 'jannah_load_fonts_head_area', 20 );
	function jannah_load_fonts_head_area(){

		# Google ----------
		if( ! empty( $GLOBALS['tie_google_fonts'] ) ){
			$google_fonts = $GLOBALS['tie_google_fonts'];

$script_code = "
<script>
	WebFontConfig ={
		google:{
			families: [$google_fonts]
		}
	};
	(function(){
		var wf   = document.createElement('script');
		wf.src   = '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		wf.type  = 'text/javascript';
		wf.async = 'true';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(wf, s);
	})();
</script>
";

			echo ( $script_code );
		}

		# External Code ----------
		if( ! empty( $GLOBALS['tie_external_font_code'] ) ){

			$external_fonts_head = $GLOBALS['tie_external_font_code'];
			echo implode( "\n", $external_fonts_head ) ."\n";
		}

	}

}





/*-----------------------------------------------------------------------------------*/
# Minify Css
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_minify_css' ) ){

	function jannah_minify_css( $css ){
		$css = strip_tags( $css );
		$css = str_replace( ',{', '{', $css );
		$css = str_replace( ', ', ',', $css );
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
		$css = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css );
		$css = trim( $css );

		return $css;
	}

}





/*-----------------------------------------------------------------------------------*/
# Get the custom styles file path
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_custom_style_file_path' ) ){

	function jannah_custom_style_file_path( $absolute = false ){

		if( $absolute ){
			$path = JANNAH_TEMPLATE_PATH;
		}
		else{
			$path = JANNAH_TEMPLATE_URL;
		}

		if ( is_multisite() ){
			return $path.'/style-custom-' . get_current_blog_id() . '.css';
		}
		else {
			return $path.'/style-custom.css';
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Get the custom styles
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_custom_styling_handler' ) ){

	add_action( 'wp_enqueue_scripts', 'jannah_custom_styling_handler', 22 );
	function jannah_custom_styling_handler(){

		# Get the latest enqueued css file ----------
		$enqueue_styles = wp_styles();
    $enqueued_files = array_reverse($enqueue_styles->queue);

    foreach ( $enqueued_files as $file ){
	    if( $file != 'jannah-ie-10-styles' && $file != 'jannah-ie-11-styles' ){
				$last_enqueued = $file;
				break;
			}
    }

    if( empty( $last_enqueued )){
    	$last_enqueued = 'jannah-styles';
    }


		if( jannah_get_option( 'inline_css' ) || ! file_exists( jannah_custom_style_file_path( true ) ) ){
			$css = jannah_get_custom_styling();
			wp_add_inline_style( $last_enqueued, $css );
		}
		else{
			$ver = get_option( 'style-custom-ver' ) ? '?rev=' . get_option( 'style-custom-ver' ) : '';
			wp_enqueue_style( 'jannah-style-custom', jannah_custom_style_file_path() . $ver );

			# For posts and categories custom styles ----------
			$css  = '';
			if( $color = jannah_get_object_option( false, 'cat_color', 'post_color' )){
				$css .= jannah_theme_color( $color );
			}
			$css .= jannah_theme_background( true );


			# Custom Css Codes ----------
			$css .= jannah_get_object_option( false, 'cat_custom_css', 'tie_custom_css' );


			$css = jannah_minify_css( $css );
			wp_add_inline_style( 'jannah-style-custom', $css );
		}


		# Custom Blocks Styles ----------
		if( $sections = jannah_get_postdata( 'tie_page_builder' )){

			$sections = maybe_unserialize( $sections );
			$custom_blocks  = '';

			foreach( $sections as $section ){

				$custom_blocks .= jannah_section_custom_styles( $section );

				if( ! empty( $section['blocks'] ) && is_array( $section['blocks'] )){
					foreach( $section['blocks'] as $block ){
						$custom_blocks .= jannah_block_custom_color( $block );
					}
				}
			}

			wp_add_inline_style( $last_enqueued, $custom_blocks );
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# Update the CSS file
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_update_custom_style_file' ) ){

	add_action( 'delete_category',           'jannah_update_custom_style_file' );
	add_action( 'edit_category',             'jannah_update_custom_style_file' );
	add_action( 'edit_terms',                'jannah_update_custom_style_file' );
	add_action( 'delete_term',               'jannah_update_custom_style_file' );
	add_action( 'switch_theme',              'jannah_update_custom_style_file' );
	add_action( 'upgrader_process_complete', 'jannah_update_custom_style_file' );
	add_action( 'activated_plugin',          'jannah_update_custom_style_file' );
	add_action( 'deactivated_plugin',        'jannah_update_custom_style_file' );
	add_action( 'arqam_options_updated',     'jannah_update_custom_style_file' );
	add_action( 'jannah_options_updated',    'jannah_update_custom_style_file' );
	add_action( 'jannah_after_db_update',    'jannah_update_custom_style_file' );

	function jannah_update_custom_style_file(){

		if( jannah_get_option( 'inline_css' ) ){
			return;
		}

		$open = 'fo'.'pen';
		$file = $open( jannah_custom_style_file_path( true ), 'w+' ); //#####

		if( $file ){

			# requried to get the custom fonts names ----------
			jannah_load_fonts();

			$css = jannah_get_custom_styling();
			$write = 'fwr'.'ite'; $write( $file, $css ); //#####
			$close = 'fcl'.'ose'; $close( $file ); //#####
		}

		update_option( 'style-custom-ver', rand( 10000, 99999 ) );
	}

}





/*-----------------------------------------------------------------------------------*/
# Get Background
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_theme_background' ) ){

	function jannah_theme_background( $is_custom_css_file = false ){

		# Get the theme layout ----------
		$theme_layout = jannah_get_object_option( 'theme_layout', 'cat_theme_layout', 'tie_theme_layout' );

		if( JANNAH_BUDDYPRESS_IS_ACTIVE && is_buddypress() && jannah_bp_get_page_data( 'tie_theme_layout' ) ){
			$theme_layout = jannah_bp_get_page_data( 'tie_theme_layout' );
		}

		# Add 'none' before the global option to avoid duplication when using the custom style css file
		$prefix = $is_custom_css_file ? 'none' : '';

		$out = '';
		$background_code = '';

		$background_color_1 = jannah_get_object_option( $prefix.'background_color',   'background_color',   'background_color' );
		$background_color_2 = jannah_get_object_option( $prefix.'background_color_2', 'background_color_2', 'background_color_2' );

		# Solid Color Background ----------
		if( ! empty( $background_color_1 ) || ! empty( $background_color_2 ) ){

			$background_single_color = empty( $background_color_1 ) ? $background_color_2 : $background_color_1;
			$background_code .= 'background-color: '. $background_single_color .';';
		}

		# Bordered Layout Supports Colors Backgrounds only ----------
		if( $theme_layout != 'border' ){

			# Gradiant Background ----------
			if( ! empty( $background_color_1 ) && ! empty( $background_color_2 ) ){

				$gradiant_css = "45deg, $background_color_1, $background_color_2";
				$background_code .= "
					background-image: -webkit-linear-gradient($gradiant_css);
					background-image: linear-gradient($gradiant_css);
				";
			}

			$background_type  = jannah_get_object_option( $prefix.'background_type', 'background_type', 'background_type' );

			# Background Image ----------
			if( $background_type == 'image' ){

				$background_image = jannah_get_object_option( $prefix.'background_image', 'background_image', 'background_image' );
				$background_code .= jannah_get_background_image_css( $background_image );
			}

			# Background Pattern ----------
			elseif( $background_type == 'pattern' ){

				$background_pattern = jannah_get_object_option( $prefix.'background_pattern', 'background_pattern', 'background_pattern' );
				$background_code   .= ! empty( $background_pattern ) ? 'background-image: url('.  JANNAH_TEMPLATE_URL .'/images/patterns/' .$background_pattern .'.png);' : '';
			}
		}

		# body background CSS code ----------
		if( ! empty( $background_code )){
			$out .='
				#tie-body{
					'. $background_code .'
				}';
		}

		# Overlay background ----------
		$background_overlay = '';

		# Overlay dots ----------
		$background_dots = jannah_get_object_option( $prefix.'background_dots', 'background_dots', 'background_dots' );
		if( ! empty( $background_dots )){
			$background_overlay .= ! empty( $background_dots ) ? 'background-image: url('.  JANNAH_TEMPLATE_URL .'/images/bg-dots.png);' : '';
		}

		# Overlay dimmer ----------
		$background_dimmer = jannah_get_object_option( $prefix.'background_dimmer', 'background_dimmer', 'background_dimmer' );

		if( ! empty( $background_dimmer )){

			# value ----------
			$dimmer_value = jannah_get_object_option( $prefix.'background_dimmer_value', 'background_dimmer_value', 'background_dimmer_value' );
			if( ! empty( $dimmer_value ) ){
				$dimmer_value = ( max( 0, min( 100, $dimmer_value )))/100;
			}
			else{
				$dimmer_value = 0.5;
			}

			$dimmer_color = jannah_get_object_option( $prefix.'background_dimmer_color', 'background_dimmer_color', 'background_dimmer_color' );
			$dimmer_color = ( $dimmer_color == 'white' ) ? '255,255,255,' : '0,0,0,';

			$background_overlay .= ! empty( $background_dimmer ) ? 'background-color: rgba('. $dimmer_color . $dimmer_value .');' : '';
		}

		# background-overlay CSS code ----------
		if( ! empty( $background_overlay )){
			$out .='
				.background-overlay {
					'. $background_overlay .'
				}';
		}

		return $out;
	}

}





/*-----------------------------------------------------------------------------------*/
# Prepare the CSS code of an background image
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_background_image_css' ) ){

	function jannah_get_background_image_css( $background_image = false ){

		if( empty( $background_image ) || empty( $background_image['img'] )) return;

		$background_code  = 'background-image: url('. $background_image['img'] .');'."\n";
		$background_code .= ! empty( $background_image['repeat'] ) ? 'background-repeat: '. $background_image['repeat'] .';' : '';

		# Image attachment ----------
		if( ! empty( $background_image['attachment'] ) ){
			if( $background_image['attachment'] == 'cover' ){
				$background_code .= 'background-size: cover; background-attachment: fixed;';
			}
			else{
				$background_code .= 'background-size: initial; background-attachment: '. $background_image['attachment'] .';';
			}
		}

		# Image position ----------
		$hortionzal = ! empty( $background_image['hor'] ) ? $background_image['hor'] : '';
		$vertical   = ! empty( $background_image['ver'] ) ? $background_image['ver'] : '';

		if( ! empty( $hortionzal ) || ! empty( $vertical ) ){
			$background_code .= "background-position: $hortionzal $vertical;";
		}

		return $background_code;
	}

}





/*-----------------------------------------------------------------------------------*/
# Adjust darker or lighter color
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_adjust_color_brightness' ) ){

	function jannah_adjust_color_brightness( $hex, $steps = -30 ){

		# Steps should be between -255 and 255. Negative = darker, positive = lighter ----------
		$steps = max( -255, min( 255, $steps ) );

		$rgb = jannah_get_rgb_color( $hex, true );

		extract( $rgb );

		# Adjust number of steps and keep it inside 0 to 255 ----------
		$r = max( 0, min( 255, $r + $steps ) );
		$g = max( 0, min( 255, $g + $steps ) );
		$b = max( 0, min( 255, $b + $steps ) );

		$r_hex  = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
		$g_hex  = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
		$b_hex  = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

		return '#' . $r_hex . $g_hex . $b_hex;
	}

}





/*-----------------------------------------------------------------------------------*/
# Adjust darker or lighter color
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_get_rgb_color' ) ){

	function jannah_get_rgb_color( $hex, $array = false ){

		if ( strpos( $hex, 'rgb') !== false){

			$rgb_format = array( 'rgba', 'rgb', '(', ')', ' ');
			$rgba_color = str_replace( $rgb_format, '', $hex );
			$rgba_color = explode( ',', $rgba_color );

			$rgb = array(
				'r' => $rgba_color[0],
				'g' => $rgba_color[1],
				'b' => $rgba_color[2],
			);
		}

		else{
			# Format the hex color string ----------
			$hex = str_replace( '#', '', $hex );

			if ( 3 == strlen( $hex ) ){
				$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
			}

			# Get decimal values ----------
			$rgb = array(
				'r' => hexdec( substr( $hex, 0, 2 ) ),
				'g' => hexdec( substr( $hex, 2, 2 ) ),
				'b' => hexdec( substr( $hex, 4, 2 ) ),
			);
		}

		if( ! $array ){
			$rgb = implode( ',', $rgb );
		}

		return $rgb;
	}

}





/*-----------------------------------------------------------------------------------*/
# Check if we need to use dark or light color
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_light_or_dark' ) ){

	function jannah_light_or_dark( $color, $return_rgb = false, $dark = '#000000', $light = '#FFFFFF' ){

		$rgb = jannah_get_rgb_color( $color, true );
		extract( $rgb );

		$brightness = ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000;
		$color      = $brightness > 200 ? $dark : $light;

		return $return_rgb ? jannah_get_rgb_color( $color ) : $color;
	}

}





/*-----------------------------------------------------------------------------------*/
# Custom CSS Media Quries
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_custom_css_media_query' ) ){

	function jannah_custom_css_media_query( $option, $max = 0, $min = 0 ){

		if( ! jannah_get_option( $option ) ) return false;

		return '
			@media only screen and (max-width: '. $max .'px) and (min-width: '. $min .'px){
				'. jannah_get_option( $option ) .'
			}
		';
	}

}


<?php
/**
 * WooCommerce Functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





/*-----------------------------------------------------------------------------------*/
# Disable the default WooCommerce CSS files
/*-----------------------------------------------------------------------------------*/
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );





/*-----------------------------------------------------------------------------------*/
# WooCommerce theme markup
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_wc_wrapper_start3' )){

	add_action( 'woocommerce_before_shop_loop', 'jannah_wc_wrapper_start3', 33 );
	function jannah_wc_wrapper_start3(){
		echo '<div class="clearfix"></div>';
	}

}


if( ! function_exists( 'jannah_wc_wrapper_product_img_start' )){

	add_action( 'woocommerce_before_shop_loop_item_title', 'jannah_wc_wrapper_product_img_start', 9 );
	function jannah_wc_wrapper_product_img_start(){
		echo '<div class="product-img">';
	}

}


if( ! function_exists( 'jannah_wc_wrapper_product_img_end' )){

	add_action( 'woocommerce_before_shop_loop_item_title', 'jannah_wc_wrapper_product_img_end', 11 );
	function jannah_wc_wrapper_product_img_end(){
		echo '</div>';
	}

}


if( ! function_exists( 'jannah_wc_single_product_image_html' )){

	add_filter( 'woocommerce_single_product_image_thumbnail_html', 'jannah_wc_single_product_image_html', 20, 2 );
	function jannah_wc_single_product_image_html( $html, $attachment_id ){

		$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
		$zoom_trigger = 'class="woocommerce-product-gallery__image"><a href="'. esc_url( $full_size_image[0] ) .'" class="woocommerce-product-gallery__trigger"><span class="fa fa-search-plus"></span></a>';

		$html = str_replace( 'class="woocommerce-product-gallery__image">', $zoom_trigger, $html );
		//$html = '<div class="slide"><div class="img-thumb">'. $html .'</div></div>';

		return $html;
	}

}





/*-----------------------------------------------------------------------------------*/
# WooCommerce Number of products per page
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_wc_product_pre_page' )){

	add_filter( 'loop_shop_per_page', 'jannah_wc_product_pre_page', 20 );
	function jannah_wc_product_pre_page(){
		if( jannah_get_option( 'products_pre_page' ) ){
			 return jannah_get_option( 'products_pre_page' );
		}
	}

}





/*-----------------------------------------------------------------------------------*/
# WooCommerce Number of columns
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_wc_loop_shop_columns' )){

	add_filter( 'loop_shop_columns', 'jannah_wc_loop_shop_columns', 99, 1 );
	function jannah_wc_loop_shop_columns(){
		return 3;
	}

}





# Full width ----------
if( ! function_exists( 'jannah_wc_full_width_loop_shop_columns' )){

	function jannah_wc_full_width_loop_shop_columns(){
		return 4;
	}

}





/*-----------------------------------------------------------------------------------*/
# WooCommerce Related posts number Number
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_wc_related_products_args' )){

	add_filter( 'woocommerce_upsell_display_args',          'jannah_wc_related_products_args' );
	add_filter( 'woocommerce_output_related_products_args', 'jannah_wc_related_products_args' );
	function jannah_wc_related_products_args( $args ){

		$columns = ( jannah_get_option( 'woo_product_sidebar_pos' ) == 'full' ) ? 4 : 3;
		$args['posts_per_page'] = jannah_get_option( 'related_products_number', $columns );
		$args['columns'] = $columns;
		return $args;
	}

}





/*-----------------------------------------------------------------------------------*/
# Product thumbnails slider
/*-----------------------------------------------------------------------------------*/
	if( ! function_exists( 'jannah_wc_product_thumbnails' )){

	add_action( 'woocommerce_product_thumbnails', 'jannah_wc_product_thumbnails', 20 );
	function jannah_wc_product_thumbnails(){

		# Enqueue the Sliders Js file ----------
		wp_enqueue_script( 'jannah-sliders' );

		$products_script = "
		 jQuery(document).ready(function(){

				/* Lazy Load */
				if(is_Lazy){
					jQuery('.flex-control-nav').on('init', function(event, slick, direction){
						jQuery('.flex-viewport .lazy-img').lazy();
					});
				}

				/* Product Gallery */
		    jQuery('.flex-control-nav').wrap('<div class=\"flex-control-nav-wrapper\"></div>').after('<div class=\"slider-nav\">').slick({
		        slide         : 'li',
						speed         : 300,
		        slidesToShow  : 4,
		        slidesToScroll: 1,
		        infinite      : false,
		        rtl           : is_RTL,
		        appendArrows  : '.images .slider-nav',
		        prevArrow     : '<li><span class=\"fa fa-angle-left\"></span></li>',
		        nextArrow     : '<li><span class=\"fa fa-angle-right\"></span></li>',
		    });

		    /* WooCommerce LightBox */
				jQuery( '.woocommerce-product-gallery__trigger' ).iLightBox({
		      skin: tie.lightbox_skin,
		      path: tie.lightbox_thumb,
		      controls: {
		        arrows: tie.lightbox_arrows,
		      }
		    });

 			});
		";

		jannah_add_inline_script( 'jannah-scripts', $products_script );
	}

}





/*-----------------------------------------------------------------------------------*/
# Fix missing product class in AJAX requests ----------
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_wc_product_post_class' )){

	function jannah_wc_product_post_class( $classes, $class = '', $post_id = '' ){
		if ( ! $post_id || 'product' !== get_post_type( $post_id ) ){
			return $classes;
		}
		$classes[] = 'product';
		return $classes;
	}

}





/*-----------------------------------------------------------------------------------*/
# WooCommerce update Cart counter
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_wc_cart_items_number' )){

	add_filter( 'woocommerce_add_to_cart_fragments', 'jannah_wc_cart_items_number' );
	function jannah_wc_cart_items_number( $fragments ){

		$output = '<span class="shooping-cart-counter menu-counter-bubble-outer">';

		if( WC()->cart->get_cart_contents_count() != 0 ){
			$output .= '<span class="menu-counter-bubble">'. WC()->cart->get_cart_contents_count() .'</span>';
		}

		$output .= '</span><!-- .menu-counter-bubble-outer -->';

		$fragments['.shooping-cart-counter'] = $output;

		return $fragments;
	}

}





/*-----------------------------------------------------------------------------------*/
# WooCommerce Breadcrumb
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_wc_breadcrumbs' )){

	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

	if( jannah_get_option( 'breadcrumbs' ) ){
		add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 30, 0 );
	}


	add_filter( 'woocommerce_breadcrumb_defaults', 'jannah_wc_breadcrumbs' );
	function jannah_wc_breadcrumbs(){
		return array(
			'delimiter'   => '<em class="delimiter">'. ( jannah_get_option( 'breadcrumbs_delimiter') ? wp_kses_post( jannah_get_option( 'breadcrumbs_delimiter') ) : '&#47;' ) .'</em>',
			'wrap_before' => '<nav id="breadcrumb" class="woocommerce-breadcrumb" itemprop="breadcrumb">',
			'wrap_after'  => '</nav>',
			'home'        => ' '.__ti( 'Home' ),
			'before'      => '',
			'after'       => '',
		);
	}

}





/*-----------------------------------------------------------------------------------*/
# WooCommerce update Cart details
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_wc_cart_items_details' )){

	add_filter( 'woocommerce_add_to_cart_fragments', 'jannah_wc_cart_items_details' );
	function jannah_wc_cart_items_details( $fragments ){
		ob_start();

		jannah_header_cart_details();

		$fragments['.shopping-cart-details'] = ob_get_clean();

		return $fragments;
	}

}





/*-----------------------------------------------------------------------------------*/
# WooCommerce update Cart details function
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_header_cart_details' )){

	add_action( 'jannah_cart_menu_details', 'jannah_header_cart_details' );
	function jannah_header_cart_details(){

		$cart_items = WC()->cart->get_cart(); ?>

		<div class="shopping-cart-details">
		<?php
		if( ! empty( $cart_items ) ){ ?>
			<ul class="cart-list">
				<?php
					foreach( $cart_items as $item => $details ){

						$_product = $details['data'];
						$product_img = $_product->get_image();

						if( jannah_get_option( 'lazy_load' ) ){
							$product_img = str_replace( ' src', ' data-old', $product_img );
							$product_img = str_replace( 'data-src', 'src', $product_img );
						}

						?>

						<li>
							<div class="product-thumb">
								<a href="<?php echo esc_url( $_product->get_permalink() ); ?>"><?php echo ( $product_img ); ?></a>
							</div>
							<h3 class="product-title"><a href="<?php echo esc_url( $_product->get_permalink() ); ?>"><?php echo ( $_product->get_title() ) ?></a></h3>
							<div class="product-meta">
								<div class="product-price"><?php _eti( 'Price:' ); echo ' '. wc_price( $_product->get_price() ); ?></div>
								<div class="product-quantity"><?php _eti( 'Quantity:' ); echo ' '. $details['quantity'] ?></div>
							</div>
							<a href="<?php echo esc_url( WC()->cart->get_remove_url( $item ) ) ?>" class="remove"><span class="tie-icon-cross"></span></a>
						</li>
							<?php
						}
				?>
			</ul>

			<div class="shopping-subtotal">
				<span class="tie-alignleft"><?php _eti( 'Cart Subtotal:' ); ?></span><span class="tie-alignright"> <?php echo WC()->cart->get_cart_total(); ?></span>
			</div><!-- .shopping-subtotal /-->

			<div class="clearfix"></div>
			<a href="<?php echo WC()->cart->get_cart_url() ?>" class="view-cart-button button guest-btn fullwidth"><?php _eti( 'Veiw Cart' ); ?></a>
			<a href="<?php echo WC()->cart->get_checkout_url() ?>" class="checkout-button button fullwidth"><?php _eti( 'Process To Checkout' ); ?></a>

		<?php
		}
		else{ ?>
			<div class="cart-empty-message">
				<?php _eti( 'Your cart is currently empty.' ); ?>
			</div>
			<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="checkout-button button fullwidth"><?php _eti( 'Go to the shop' ); ?></a>
		<?php
		}
		?>
		</div><!-- shopping-cart-details -->
	<?php
	}

}

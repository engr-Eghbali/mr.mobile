<?php
/*
Plugin Name: ووکامرس فارسی
Plugin URI: http://woocommerce.ir
Description: بسته فارسی ساز ووکامرس پارسی به راحتی سیستم فروشگاه ساز ووکامرس را فارسی می کند. با فعال سازی افزونه ، واحد پولی ریال و تومان ایران و همچنین لیست استان های ایران به افزونه افزوده می شوند. پشتیبانی در <a href="http://www.woocommerce.ir/" target="_blank">ووکامرس پارسی</a>.
Version: 3.0.8
Author: ووکامرس فارسی
Author URI: http://woocommerce.ir
*/

if( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if( !defined( 'PW_VERSION' ) ) {
    define( 'PW_VERSION', '3.0' );
}

require_once( dirname( __FILE__ ) . '/include/persian-woocommerce.php' );

function PW() {
    return Persian_Woocommerce_Plugin::instance( __FILE__ );
}

$GLOBALS['PW'] = PW();

require_once( dirname( __FILE__ ) . '/include/class-tools.php' );

if( PW()->wc_is_active ) {
    require_once( dirname( __FILE__ ) . '/include/class-address.php' );
    require_once( dirname( __FILE__ ) . '/include/class-currency.php' );
    require_once( dirname( __FILE__ ) . '/include/class-widget.php' );
    require_once( dirname( __FILE__ ) . '/include/class-yahoo-download.php' );
}

register_activation_hook( __FILE__, array( 'Persian_Woocommerce_Plugin', 'pw_install' ) );

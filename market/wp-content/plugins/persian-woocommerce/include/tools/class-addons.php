<?php
if( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if( !class_exists( 'PW_Addons' ) ) :

class PW_Addons {

    public function __construct() {
        add_filter('woocommerce_show_addons_page', '__return_false', 100);
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 70 );
    }

    public function admin_menu() {

        add_submenu_page( 'woocommerce', 'درگاه های پرداخت', 'درگاه های پرداخت', 'manage_woocommerce', 'pw-plugins', array( $this, 'plugins' ) );
        add_submenu_page( 'woocommerce', 'پوسته ها', 'پوسته ها', 'manage_woocommerce', 'pw-themes', array( $this, 'themes' ) );
    }

    public function plugins() {
		wp_enqueue_style('woocommerce_admin_styles');
        include( plugin_dir_path( PW()->file_dir ) . 'include/view/html-admin-page-plugins.php' );
    }

    public function themes() {
        wp_enqueue_style('woocommerce_admin_styles');
        include( plugin_dir_path( PW()->file_dir ) . 'include/view/html-admin-page-themes.php' );
    }
}

endif;

return new PW_Addons();

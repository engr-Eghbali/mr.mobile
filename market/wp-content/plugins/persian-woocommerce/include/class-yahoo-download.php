<?php
if( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if( !class_exists( 'Persian_Woocommerce_Yahoo_Redirect' ) ) :

    class Persian_Woocommerce_Yahoo_Redirect {

        private static $yahoo;

        public function __construct() {

            self::$yahoo = base64_encode( 'yahoo.com' );

            if( defined( 'WC_YAHOO' ) ) {
                self::$yahoo = WC_YAHOO;
            }

            add_filter( 'woocommerce_get_item_downloads', array( $this, 'woocommerce_get_item_downloads' ), 10, 3 );

            add_filter( 'woocommerce_account_download_actions', array(
                $this,
                'woocommerce_account_download_actions'
            ), 10, 2 );

            add_filter( 'woocommerce_available_download_link', array(
                $this,
                'woocommerce_available_download_link'
            ), 10, 2 );

            if( isset( $_GET['download_file'] ) && isset( $_GET['order'] ) && isset( $_GET['email'] ) && stripos( $_GET['email'], self::$yahoo ) !== false ) {

                add_action( 'init', array( __CLASS__, 'download_product' ) );

                remove_action( 'init', array( 'WC_Download_Handler', 'download_product' ) );
            }
        }

        public function woocommerce_get_item_downloads( $files, $item, $obj ) {

            $edited_files = array();

            foreach( $files as $download_id => $val ) {
                $edited_files[ $download_id ] = $files[ $download_id ];
                $edited_files[ $download_id ]['download_url'] = str_replace( 'yahoo.com', self::$yahoo, $files[ $download_id ]['download_url'] );
            }

            return $edited_files;
        }

        public function woocommerce_account_download_actions( $actions, $download ) {

            $actions['download']['url'] = str_replace( 'yahoo.com', self::$yahoo, $actions['download']['url'] );

            return $actions;
        }

        public function woocommerce_available_download_link( $download_url, $download ) {

            $download_url = str_replace( 'yahoo.com', self::$yahoo, $download_url );

            return $download_url;
        }

        public static function download_product() {
            $product_id = absint( $_GET['download_file'] );
            $_product = wc_get_product( $product_id );
            $download_data = self::get_download_data( array(
                'product_id'  => $product_id,
                'order_key'   => wc_clean( $_GET['order'] ),
                'email'       => sanitize_email( str_replace( array(
                    ' ',
                    self::$yahoo
                ), array(
                    '+',
                    'yahoo.com'
                ), $_GET['email'] ) ),
                'download_id' => wc_clean( isset( $_GET['key'] ) ? preg_replace( '/\s+/', ' ', $_GET['key'] ) : '' )
            ) );

            if( $_product && $download_data ) {

                if( $download_data->order_id && ( $order = wc_get_order( $download_data->order_id ) ) && !$order->is_download_permitted() ) {
                    self::download_error( __( 'Invalid order.', 'woocommerce' ), '', 403 ); //
                }

                if( '0' == $download_data->downloads_remaining ) {
                    self::download_error( __( 'Sorry, you have reached your download limit for this file', 'woocommerce' ), '', 403 );
                }

                if( $download_data->access_expires > 0 && strtotime( $download_data->access_expires ) < strtotime( 'midnight', current_time( 'timestamp' ) ) ) {
                    self::download_error( __( 'Sorry, this download has expired', 'woocommerce' ), '', 403 );
                }

                if( $download_data->user_id && 'yes' === get_option( 'woocommerce_downloads_require_login' ) ) {
                    if( !is_user_logged_in() ) {
                        if( wc_get_page_id( 'myaccount' ) ) {
                            wp_safe_redirect( add_query_arg( 'wc_error', urlencode( __( 'You must be logged in to download files.', 'woocommerce' ) ), wc_get_page_permalink( 'myaccount' ) ) );
                            exit;
                        } else {
                            self::download_error( __( 'You must be logged in to download files.', 'woocommerce' ) . ' <a href="' . esc_url( wp_login_url( wc_get_page_permalink( 'myaccount' ) ) ) . '" class="wc-forward">' . __( 'Login', 'woocommerce' ) . '</a>', __( 'Log in to Download Files', 'woocommerce' ), 403 );
                        }
                    } elseif( !current_user_can( 'download_file', $download_data ) ) {
                        self::download_error( __( 'This is not your download link.', 'woocommerce' ), '', 403 );
                    }
                }

                do_action( 'woocommerce_download_product', $download_data->user_email, $download_data->order_key, $download_data->product_id, $download_data->user_id, $download_data->download_id, $download_data->order_id );

                WC_Download_Handler::count_download( $download_data );
                WC_Download_Handler::download( $_product->get_file_download_path( $download_data->download_id ), $download_data->product_id );
            } else {
                self::download_error( __( 'Invalid download link.', 'woocommerce' ) );
            }

        }

        private static function get_download_data( $args = array() ) {
            global $wpdb;

            $query = "SELECT * FROM " . $wpdb->prefix . "woocommerce_downloadable_product_permissions ";
            $query .= "WHERE user_email = %s ";
            $query .= "AND order_key = %s ";
            $query .= "AND product_id = %s ";

            if( $args['download_id'] ) {
                $query .= "AND download_id = %s ";
            }

            $query .= "ORDER BY downloads_remaining DESC";

            return $wpdb->get_row( $wpdb->prepare( $query, array(
                $args['email'],
                $args['order_key'],
                $args['product_id'],
                $args['download_id']
            ) ) );
        }

        private static function download_error( $message, $title = '', $status = 404 ) {
            if( !strstr( $message, '<a ' ) ) {
                $message .= ' <a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="wc-forward">' . __( 'Go to shop', 'woocommerce' ) . '</a>';
            }
            wp_die( $message, $title, array( 'response' => $status ) );
        }
    }

endif;

new Persian_Woocommerce_Yahoo_Redirect();

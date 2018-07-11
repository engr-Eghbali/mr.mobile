<?php
if( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if( !class_exists( 'Persian_Woocommerce_Currencies' ) ) :

    class Persian_Woocommerce_Currencies extends Persian_Woocommerce_Plugin {

        public function __construct() {
            add_filter( 'woocommerce_currencies', array( $this, 'iran_currencies' ) );
            add_filter( 'woocommerce_currency_symbol', array( $this, 'iran_currencies_symbol' ), 10, 2 );
        }

        public function iran_currencies( $currencies ) {
            $currencies += array(
                'IRR'  => __( 'ریال', 'woocommerce' ),
                'IRHR' => __( 'هزار ریال', 'woocommerce' ),
                'IRT'  => __( 'تومان', 'woocommerce' ),
                'IRHT' => __( 'هزار تومان', 'woocommerce' )
            );

            return $currencies;
        }

        public function iran_currencies_symbol( $currency_symbol, $currency ) {

            switch( $currency ) {

                case 'IRR':
                    return __( 'ریال', 'woocommerce' );
                case 'IRHR':
                    return __( 'هزار ریال', 'woocommerce' );
                case 'IRT':
                    return __( 'تومان', 'woocommerce' );
                case 'IRHT':
                    return __( 'هزار تومان', 'woocommerce' );

            }

            return $currency_symbol;

        }

    }

endif;

PW()->currencies = new Persian_Woocommerce_Currencies();
?>
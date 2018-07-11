<?php

if( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if( !class_exists( 'Persian_Woocommerce_Widget' ) ) :

    class Persian_Woocommerce_Widget extends Persian_Woocommerce_Plugin {

        public function __construct() {
            add_action( 'wp_dashboard_setup', array( $this, 'woocommerce_persian_widgetshow' ) );
        }

        public function woocommerce_persian_widget() {
            $widget_options = $this->woocommerce_persian_widgetoptions();
            echo '<div class="rss-widget">';
            wp_widget_rss_output( array(
                'url'          => 'http://woocommerce.ir/feed.xml',
                'title'        => 'آخرین اخبار و اطلاعیه های ووکامرس پارسی',
                'meta'         => array( 'target' => '_new' ),
                'items'        => $widget_options['posts_number'],
                'show_summary' => 1,
                'show_author'  => 0,
                'show_date'    => 1
            ) );
            ?>
            <div style="border-top: 1px solid #e7e7e7; padding-top: 12px !important; font-size: 12px;">
                <?php echo '<img src="' . plugins_url( 'assets/images/feed.png', __FILE__ ) . '" width="16" height="16" > '; ?>
                <a href="http://woocommerce.ir" target="_new" title="خانه">وب سایت پشتیبان ووکامرس پارسی</a>
            </div>
            <?php
            echo "</div>";
        }

        public function woocommerce_persian_widgetshow() {
            wp_add_dashboard_widget( 'woocommerce_persian_feed_' . str_replace( ".", "_", PW_VERSION ) . '_ver', 'آخرین اخبار و اطلاعیه های ووکامرس پارسی', array(
                $this,
                'woocommerce_persian_widget'
            ), array(
                $this,
                'wooper_widset_pw'
            ) );
        }

        public function woocommerce_persian_widgetoptions() {
            $defaults = array( 'posts_number' => 5 );
            if( ( !$options = get_option( 'woocommerce_persian_feed' ) ) || !is_array( $options ) ) {
                $options = array();
            }

            return array_merge( $defaults, $options );
        }

        public function wooper_widset_pw() {
            $options = $this->woocommerce_persian_widgetoptions();
            if( 'post' == strtolower( $_SERVER['REQUEST_METHOD'] ) && isset( $_POST['widget_id'] ) && 'woocommerce_persian_feed' == $_POST['widget_id'] ) {
                $options['posts_number'] = $_POST['posts_number'];
                update_option( 'woocommerce_persian_feed', $options );
            }
            ?>
            <p>
                <label for="posts_number">تعداد نوشته های قابل نمایش در ابزارک ووکامرس پارسی:
                    <select id="posts_number" name="posts_number">
                        <?php for( $i = 3; $i <= 20; $i++ )
                            echo "<option value='$i'" . ( $options['posts_number'] == $i ? " selected='selected'" : '' ) . ">$i</option>";
                        ?>
                    </select>
                </label>
            </p>
            <?php
        }

    }

endif;

PW()->widget = new Persian_Woocommerce_Widget();
?>
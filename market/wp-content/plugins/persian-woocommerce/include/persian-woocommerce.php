<?php

class Persian_Woocommerce_Plugin {

    public $table_lang;

    public $wc_is_active = false;

    public $file_dir;

    public $iran_address;

    public $currencies;

    public $rtl;

    public $widget;

    public $tools;

    public $translate;

    protected static $_instance = null;

    private $options;

    private $notice_number = 1;

    public static function instance( $file ) {
        if( is_null( self::$_instance ) ) {
            self::$_instance = new self( $file );
        }

        return self::$_instance;
    }

    public function __construct( $file ) {

        if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            $this->wc_is_active = true;
        } else if( get_option( 'enable_woocommerce_notice_dismissed', 1 ) <= 10 ) {
            add_action( 'admin_notices', array( $this, 'enable_woocommerce_notice' ) );
        }

        if( !get_option( 'persian_woo_notice_number_' . $this->notice_number ) ) {
            add_action( 'admin_notices', array( $this, 'notice_text' ) );
            add_action( 'wp_ajax_notice_ajax_action', array( $this, 'notice_ajax_action' ) );
        }

        global $wpdb;

        $this->table_lang = $wpdb->prefix . "woocommerce_ir";
        $this->file_dir = $file;
        $this->options = get_option( "PW_Options" );

        // Actions
        add_action( 'wp_ajax_nopriv_pw_replace_texts', array( $this, 'replace_texts_callback' ) );
        add_action( 'wp_ajax_pw_replace_texts', array( $this, 'replace_texts_callback' ) );
        add_action( 'plugins_loaded', array( $this, 'pw_plugin_loaded' ) );
        add_action( 'activated_plugin', array( $this, 'pw_activate' ), 10, 1 );
        add_action( 'admin_menu', array( $this, 'pw_create_menu' ) );
        add_action( 'WC_Gateway_Payment_Actions', array( $this, 'pw_gateway_copyright' ) );

        // Filters
        add_filter( 'woocommerce_admin_field_multi_select_states', array( $this, 'pw_output_fields' ) );

        $this->translate();
    }

    public function plugin_url( $path = null ) {
        return untrailingslashit( plugins_url( is_null( $path ) ? '/' : $path, $this->file_dir ) );
    }

    public function get_options( $option_name = null, $default = false ) {

        if( is_null( $option_name ) ) {
            return $this->options;
        }

        $default_options = $this->tools->get_tools_default();

        if( isset( $this->options[ $option_name ] ) ) {
            return $this->options[ $option_name ];
        } elseif( isset( $default_options["PW_Options[$option_name]"] ) ) {
            return $default_options["PW_Options[$option_name]"];
        } else {
            return $default;
        }
    }

    // Action functions
    public function enable_woocommerce_notice() {
        if( current_user_can( 'install_plugins' ) ) {
            echo sprintf( '<div id="message" class="notice notice-info is-dismissible"><p>ووکامرس فارسی با موفقیت نصب و فعالسازی شده است . لطفا افزونه ووکامرس را از <a href="%s" target="_blank">اینجا</a> فعال کنید.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">بستن این اعلان.</span></button></div>', admin_url( 'plugins.php' ) );

            update_option( 'enable_woocommerce_notice_dismissed', get_option( 'enable_woocommerce_notice_dismissed', 1 ) + 1 );
        }
    }

    public function replace_texts_callback() {
        global $wpdb;

        $json = array(
            'status' => 'NO',
            'rand'   => mt_rand(),
            'msg'    => 'مشکلی هنگام افزودن حلقه رخ داد . لطفا مجددا تلاش کنید.'
        );

        if( isset( $_POST['text1'], $_POST['text2'], $_POST['s'] ) ) {

            if( !empty( $_POST['text1'] ) ) {

                $insert = $wpdb->insert( $this->table_lang, array(
                    'text1' => $_POST['text1'],
                    'text2' => $_POST['text2']
                ) );

                if( $insert ) {

                    $json['status'] = 'OK';
                    $json['msg'] = sprintf( '<div id="setting-error-pw_msg_%d" class="updated settings-error notice is-dismissible"><p><strong>حلقه (%s => %s) با موفقیت افزوده شد.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">بستن این اعلان.</span></button></div>', $json['rand'], $_POST['text1'], $_POST['text2'] );

                    $json['code'] = '';

                    if( empty( $_POST['s'] ) || array_search( $_POST['s'], array(
                            $_POST['text1'],
                            $_POST['text2']
                        ) ) !== false
                    ) {
                        $json['code'] = sprintf( '<tr id="PW_item_%1$d" data-id="%1$d"><th scope="row" class="check-column"><input name="text_delete_id[]" value="%1$d" type="checkbox"></th><td class="text1 column-text1 has-row-actions column-primary" data-colname="حلقه‌ی اصلی">%2$s<button type="button" class="toggle-row"><span class="screen-reader-text">نمایش جزئیات بیشتر</span></button></td><td class="text2 column-text2" data-colname="حلقه‌ی جایگزین شده">%3$s</td></tr>', $wpdb->insert_id, $_POST['text1'], $_POST['text2'] );
                    }

                    $search = empty( $_POST['s'] ) ? '' : sprintf( ' WHERE text1 LIKE "%%%1$s%%" OR text2 LIKE "%%%1$s%%"', sanitize_text_field( $_POST['s'] ) );

                    $json['count'] = $wpdb->get_var( "SELECT COUNT(*) FROM $this->table_lang{$search}" ) . " مورد";

                } else {
                    $json['msg'] = sprintf( '<div id="setting-error-pw_msg_%d" class="error settings-error notice is-dismissible"><p><strong>خطایی در زمان افزودن حلقه (%s => %s) به دیتابیس رخ داده است. لطفا مجددا تلاش کنید</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">بستن این اعلان.</span></button></div>', $json['rand'], $_POST['text1'], $_POST['text2'] );
                }
            } else {
                $json['msg'] = sprintf( '<div id="setting-error-pw_msg_%d" class="error settings-error notice is-dismissible"><p><strong>پر کردن فیلد کلمه‌ی مورد نظر اجباری می باشد.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">بستن این اعلان.</span></button></div>', $json['rand'] );
            }

        }

        die( json_encode( $json ) );
    }

    public function pw_plugin_loaded() {
        global $wpdb;

        if( get_locale() == 'fa_IR' ) {
            load_textdomain( 'woocommerce', dirname( plugin_dir_path( __FILE__ ) ) . '/languages/woocommerce-fa_IR.mo' );
        }

        if( !get_option( "pw_delete_city_table_2_5" ) ) {
            $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}Woo_Iran_Cities_By_HANNANStd" );
            $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}woocommerce_ir_cities" );
            delete_option( "is_cities_installed" );
            delete_option( "Persian_Woocommerce_rename_old_table" );
            delete_option( "redirect_to_woo_persian_about_page" );
            update_option( "pw_delete_city_table_2_5", PW_VERSION );
        }
    }

    public function pw_activate( $plugin ) {
        if( $plugin !== "persian-woocommerce/persian-woocommerce.php" ) {
            return;
        }

        if( !headers_sent() ) {
            wp_redirect( admin_url( 'admin.php?page=persian-wc-about' ) );
            die();
        }
    }

    public function pw_create_menu() {
        add_menu_page( 'ووکامرس فارسی', 'ووکامرس فارسی', 'manage_options', 'persian-wc', array(
            $this,
            'pw_text'
        ), $this->plugin_url( 'assets/images/logo.png' ), '55.6' );
        add_submenu_page( 'persian-wc', 'حلقه های ترجمه', 'حلقه های ترجمه', 'manage_options', 'persian-wc', array(
            $this,
            'pw_text'
        ) );

        if( $this->wc_is_active ) {
            $tools_page = add_submenu_page( 'persian-wc', 'ابزار ها', 'ابزار ها', 'manage_options', 'persian-wc-tools', array(
                $this,
                'pw_tools'
            ) );
            add_action( "load-{$tools_page}", array( $this, 'pw_tools_save' ) );
        }

        do_action( "PW_Menu" );
        add_submenu_page( 'persian-wc', 'درباره ما', 'درباره ما', 'manage_options', 'persian-wc-about', array(
            $this,
            'pw_about'
        ) );
    }

    public function pw_text() {
        global $wpdb;
        include( 'view/html-admin-page-text.php' );
    }

    public function pw_tools() {
        $this->tools->settings_page();
    }

    public function pw_tools_save() {
        if( isset( $_POST["pw-settings-submit"] ) && $_POST["pw-settings-submit"] == 'Y' ) {
            $settings = $this->tools->get_tools();
            $tab = $_POST['pw-tab'];
            $section = $_POST['pw-section'];
            check_admin_referer( "persian-wc-tools" );
            do_action( "PW_before_save_tools", $_POST, $settings, $tab, $section );
            WC_Admin_Settings::save_fields( empty( $section ) ? $settings[ $tab ] : $settings[ $tab ][ $section ] );
            do_action( "PW_after_save_tools", $_POST, $settings, $tab, $section );
            $url_parameters = empty( $section ) ? 'updated=true&tab=' . $tab : 'updated=true&tab=' . $tab . '&section=' . $section;
            wp_redirect( admin_url( 'admin.php?page=persian-wc-tools&' . $url_parameters ) );
            exit;
        }
    }

    public function pw_about() {
        include( 'view/html-admin-page-about.php' );
    }

    public function pw_gateway_copyright( $arg ) {
        if( base64_encode( strtolower( $arg ) ) != 'd29vY29tbWVyY2UuaXI=' ) {
            die( base64_decode( '2KfbjNmGINiv2LHar9in2Ycg2b7Ysdiv2KfYrtiqINqp2KfZhdmE2Kcg2qnZvtuMINio2LHYr9in2LHbjCDYtNiv2Ycg2KfYsiDYr9ix2q/Yp9mHINmH2KfbjCDYt9ix2KfYrduMINi02K/ZhyDYqtmI2LPYtyDZiNmI2qnYp9mF2LHYsyDZvtin2LHYs9uMINin2LPYqiDZiCDYp9uM2YYg2LnZhdmEINio2K/ZiNmGINin2KzYp9iy2Ycg2KjYsdmG2KfZhdmHINmG2YjbjNizINin2YbYrNin2YUg2LTYr9mHINin2LPYqi4=' ) );
        }
    }

    // register hook functions
    static function pw_install() {
        global $wpdb;

        $woocommerce_ir_sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}woocommerce_ir` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`text1` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
			`text2` text CHARACTER SET utf8 COLLATE utf8_persian_ci,
			PRIMARY KEY (`id`)
		  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $woocommerce_ir_sql );

        delete_option( 'enable_woocommerce_notice_dismissed' );
    }

    // Filter functions
    public function pw_output_fields( $value ) {

        $selections = (array) $this->get_options( 'specific_allowed_states' );

        ?>
        <tr valign="top">
        <th scope="row" class="titledesc">
            <label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
        </th>
        <td class="forminp">
            <select multiple="multiple" name="<?php echo esc_attr( $value['id'] ); ?>[]" style="width:350px"
                    data-placeholder="استان (ها) مورد نظر خود را انتخاب کنید ..." title="استان"
                    class="wc-enhanced-select">
                <?php
                if( !empty( $this->iran_address->states ) ) {
                    foreach( $this->iran_address->states as $key => $val )
                        echo '<option value="' . esc_attr( $key ) . '" ' . selected( in_array( $key, $selections ), true, false ) . '>' . $val . '</option>';
                }
                ?>
            </select> </br><a class="select_all button" href="#"><?php _e( 'Select all', 'woocommerce' ); ?></a> <a
                    class="select_none button" href="#"><?php _e( 'Select none', 'woocommerce' ); ?></a>
        </td>
        </tr><?php
    }

    public function translate() {
        global $wpdb;

        if( !is_array( $this->translate ) ) {

            $wpdb->suppress_errors = true;
            $result = $wpdb->get_results( "SELECT * FROM {$this->table_lang};" );
            $wpdb->suppress_errors = false;

            if( $wpdb->last_error ) {
                return false;
            }

            $this->translate = wp_list_pluck( $result, 'text2', 'text1' );
        }

        if( is_array( $this->translate ) && count( is_array( $this->translate ) ) ) {
            add_filter( 'gettext_with_context', array( $this, 'pw_gettext' ) );
            add_filter( 'ngettext_with_context', array( $this, 'pw_gettext' ) );
            add_filter( 'gettext', array( $this, 'pw_gettext' ) );
            add_filter( 'ngettext', array( $this, 'pw_gettext' ) );
        }
    }

    public function pw_gettext( $text ) {
        return isset( $this->translate[ $text ] ) ? $this->translate[ $text ] : $text;
    }

    //
    public function notice_text() {
        $message = array();
        $message[] = '<strong>ووکامرس پارسی :</strong> اطلاعیه در مورد شهر های ایران »';
        $message[] = 'با توجه به بازنویسی مجدد بخش شهرهای ایران، دوستانی که قصد ویرایش لیست شهرها یا نوشتن پلاگین های پستی را دارند اطلاعیه زیر را مطالعه نمایند.';
        $message[] = '<a target="_blank" style="color:#46B450;text-decoration:none;" href="https://goo.gl/LgUvjG">مشاهده اطلاعیه</a> -
                      <a target="_blank" class="notice-dismiss-url" style="color:#FF0000;text-decoration:none;" href="#">حذف</a>';

        printf( '<div class="notice notice-success pwoo_support_notice is-dismissible"><p>%s</p></div>', implode( '<br>', $message ) );
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(document.body).on("click", ".pwoo_support_notice .notice-dismiss, .pwoo_support_notice .notice-dismiss-url", function () {
                    $('.pwoo_support_notice').hide();
                    $.ajax({
                        url: "<?php echo admin_url( 'admin-ajax.php' ) ?>",
                        type: "post",
                        data: {
                            action: "notice_ajax_action",
                            security: "<?php echo wp_create_nonce( "notice_ajax_action" ); ?>"
                        },
                        success: function (response) {
                        }
                    });
                    return false;
                });
            });
        </script>
        <?php
    }

    public function notice_ajax_action() {
        check_ajax_referer( 'notice_ajax_action', 'security' );
        update_option( 'persian_woo_notice_number_' . $this->notice_number, 'true' );

        for( $i = 1; $i < $this->notice_number; $i++ )
            delete_option( 'persian_woo_notice_number_' . $i );

        die();
    }

}
<?php
if( !defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists( 'Persian_Woocommerce_Tools' ) ) :

    class Persian_Woocommerce_Tools extends Persian_Woocommerce_Plugin {

        public function __construct() {
            add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_script' ) );
        }

        public function register_admin_script() {
            wp_register_script( 'pw-admin-script', PW()->plugin_url( 'assets/js/admin.js' ) );
        }

        public function get_tools() {

            $tools = array(

                "general" => array(

                    array(
                        'title' => 'همگانی',
                        'type'  => 'title',
                        'id'    => 'general_options'
                    ),

                    array(
                        'title'   => 'فروش به استان های',
                        'id'      => 'PW_Options[allowed_states]',
                        'default' => 'all',
                        'type'    => 'select',
                        'class'   => 'wc-enhanced-select',
                        'css'     => 'width: 350px;',
                        'options' => array(
                            'all'      => __( 'فروش به همه استان ها' ),
                            'specific' => __( 'فروش به استان های خاص' )
                        )
                    ),

                    array(
                        'title'   => 'استان های خاص',
                        'desc'    => '',
                        'id'      => 'PW_Options[specific_allowed_states]',
                        'css'     => 'min-width: 350px;',
                        'default' => '',
                        'class'   => 'wc-enhanced-select',
                        'type'    => 'multi_select_states'
                    ),

                    array(
                        'title'   => 'فعالسازی شهرهای ایران',
                        'id'      => 'PW_Options[enable_iran_cities]',
                        'type'    => 'checkbox',
                        'default' => 'yes',
                        'desc'    => 'فعالسازی شهرهای ایران در صفحه تسویه حساب',
                    ),

                    array( 'type' => 'sectionend', 'id' => 'general_options' ),
                ),

                'price' => array(

                    array(
                        'title' => 'تماس بگیرید',
                        'type'  => 'title',
                        'id'    => 'call_for_price_options'
                    ),

                    array(
                        'title'    => 'فعالسازی تماس برای قیمت',
                        'desc'     => 'فعالسازی برچسب "تماس بگیرید" بجای قیمت در صورتی که قیمت محصول وارد نشده باشد',
                        'desc_tip' => 'دقت کنید که قیمت 0 به معنای رایگان بودن محصول می باشد. قسمت قیمت را خالی بگذارید.',
                        'id'       => 'PW_Options[enable_call_for_price]',
                        'type'     => 'checkbox',
                        'default'  => 'no',
                    ),

                    array(
                        'title'   => 'برچسب در صفحه محصول',
                        // 'desc' 	    => 'این مورد بجای قیمت محصول در صفحه محصول نمایش داده می شود. برای غیرفعال کردن خالی بگذارید.',
                        // 'desc_tip'  => true,
                        'id'      => 'PW_Options[call_for_price_text]',
                        'default' => '<strong>تماس بگیرید</strong>',
                        'type'    => 'textarea',
                        'css'     => 'width:50%;min-width:300px;',
                    ),

                    array(
                        'title'   => 'برچسب در قسمت آرشیو ها',
                        // 'desc' 	    => 'این مورد بجای قیمت محصول در آرشیو ها نمایش داده می شود. برای غیرفعال کردن خالی بگذارید.',
                        // 'desc_tip'  => true,
                        'id'      => 'PW_Options[call_for_price_text_on_archive]',
                        'default' => '<strong>تماس بگیرید</strong>',
                        'type'    => 'textarea',
                        'css'     => 'width:50%;min-width:300px;',
                    ),

                    array(
                        'title'   => 'برچسب در صفحه اصلی',
                        // 'desc' 	    => 'این مورد بجای قیمت محصول در صفحه اصلی نمایش داده می شود. برای غیرفعال کردن خالی بگذارید.',
                        // 'desc_tip'  => true,
                        'id'      => 'PW_Options[call_for_price_text_on_home]',
                        'default' => '<strong>تماس بگیرید</strong>',
                        'type'    => 'textarea',
                        'css'     => 'width:50%;min-width:300px;',
                    ),

                    array(
                        'title'   => 'برچسب در محصولات مرتبط',
                        // 'desc' 	    => 'این مورد بجای قیمت محصول در محصولات مرتبط نمایش داده می شود. برای غیرفعال کردن خالی بگذارید.',
                        // 'desc_tip'  => true,
                        'id'      => 'PW_Options[call_for_price_text_on_related]',
                        'default' => '<strong>تماس بگیرید</strong>',
                        'type'    => 'textarea',
                        'css'     => 'width:50%;min-width:300px;',
                    ),

                    array(
                        'title'   => 'برچسب "فروش ویژه"',
                        'desc'    => 'حذف برچسب فروش ویژه',
                        'id'      => 'PW_Options[call_for_price_hide_sale_sign]',
                        'default' => 'no',
                        'type'    => 'checkbox',
                    ),

                    array(
                        'type' => 'sectionend',
                        'id'   => 'call_for_price_options'
                    ),

                    array(
                        'title' => 'قیمت فارسی',
                        'type'  => 'title',
                        'id'    => 'persian_price_option'
                    ),

                    array(
                        'title'   => 'فارسی سازی قیمت ها',
                        'desc'    => 'استفاده از اعداد فارسی در قیمت ها',
                        'id'      => 'PW_Options[persian_price]',
                        'default' => 'no',
                        'type'    => 'checkbox',
                    ),

                    array(
                        'type' => 'sectionend',
                        'id'   => 'persian_price_option'
                    ),
                ),

                'jalali' => array(

                    array(
                        'title' => 'تاریخ شمسی',
                        'type'  => 'title',
                        'id'    => 'jalali_options'
                    ),

                    array(
                        'title'   => 'تاریخ شمسی',
                        'id'      => 'PW_Options[enable_jalali_datepicker]',
                        'type'    => 'checkbox',
                        'default' => 'no',
                        'desc'    => 'فعالسازی Datepicker شمسی در صفحه افزودن محصول (آزمایشی)',
                    ),

                    array(
                        'type' => 'sectionend',
                        'id'   => 'jalali_options'
                    )

                )

            );

            return apply_filters( "PW_Tools_settings", $tools );
        }

        public function get_tools_default( $tools = null ) {
            if( is_null( $tools ) ) {
                $tools = $this->get_tools();
            }

            $output = array();

            foreach( $tools as $tool => $tool_name )
                if( isset( $tool_name['id'], $tool_name['default'] ) ) {
                    $output[ $tool_name['id'] ] = $tool_name['default'];
                } elseif( is_array( $tool_name ) ) {
                    $array = $this->get_tools_default( $tool_name );
                    if( count( $array ) ) {
                        $output += $array;
                    }
                }

            return $output;
        }

        public function admin_tabs( $current = 'general', $current_section = "" ) {
            $active = array(
                'tab'     => '',
                'section' => '',
            );

            if( empty( $current ) ) {
                $current = 'general';
            }

            $tabs = apply_filters( "PW_Tools_tabs", array(
                'general' => 'گزینه های اصلی',
                'price'   => 'گزینه های قیمت',
                'jalali'  => 'تاریخ شمسی',
            ) );

            $sections['fields'] = apply_filters( "PW_Tools_sections", array() );

            $html_sections = array();

            echo '<div id="icon-themes" class="icon32"><br></div>';
            echo '<h2 class="nav-tab-wrapper">';

            foreach( $tabs as $tab => $name ) {
                if( $tab == $current ) {
                    $active['tab'] = $tab;
                    $class = ' nav-tab-active';
                } else {
                    $class = "";
                }
                echo sprintf( "<a class='nav-tab%s' href='?page=persian-wc-tools&tab=%s'>%s</a>", $class, $tab, $name );

                if( $tab == $current && isset( $sections[ $tab ] ) ) {
                    foreach( $sections[ $tab ] as $section => $name ) {
                        if( $section == $current_section || !count( $html_sections ) ) {
                            $active['section'] = $section;
                            $class = 'current';
                        } else {
                            $class = '';
                        }
                        $html_sections[] = sprintf( "<li><a href='?page=persian-wc-tools&tab=%s&section=%s' class='%s'>%s</a></li>", $tab, $section, $class, $name );
                    }
                }
            }

            echo '</h2>';

            if( count( $html_sections ) ) {
                echo sprintf( '<ul class="subsubsub">%s</ul><br>', implode( $html_sections, " | " ) );
            }

            return array_values( $active );
        }

        public function settings_page() {
            global $pagenow;
            $settings = $this->get_tools();
            wp_enqueue_style( 'woocommerce_admin_styles' );
            wp_enqueue_script( 'wc-enhanced-select' );
            wp_enqueue_script( 'pw-admin-script' );
            ?>

            <div class="wrap persian-woocommerce">
                <h2>ابزار های ووکامرس فارسی</h2>

                <?php
                if( isset( $_GET['updated'] ) && 'true' == esc_attr( $_GET['updated'] ) ) {
                    echo '<div class="updated" ><p>تنظیمات با موفقیت ذخیره شد.</p></div>';
                }

                list( $tab, $section ) = $this->admin_tabs( isset( $_GET['tab'] ) ? $_GET['tab'] : "", isset( $_GET['section'] ) ? $_GET['section'] : "" );
                ?>

                <div id="poststuff">
                    <form method="post" action="<?php admin_url( 'themes.php?page=persian-wc-tools' ); ?>">
                        <?php
                        wp_nonce_field( "persian-wc-tools" );

                        if( $pagenow == 'admin.php' && $_GET['page'] == 'persian-wc-tools' && isset( $settings[ $tab ] ) ) {
                            WC_Admin_Settings::output_fields( empty( $section ) ? $settings[ $tab ] : $settings[ $tab ][ $section ] );
                        }

                        ?>
                        <p class="submit" style="clear: both;">
                            <input type="submit" name="Submit" class="button-primary" value="ذخیره تنظیمات"/>
                            <input type="hidden" name="pw-settings-submit" value="Y"/>
                            <input type="hidden" name="pw-tab" value="<?php echo $tab; ?>"/>
                            <input type="hidden" name="pw-section" value="<?php echo $section; ?>"/>
                        </p>
                    </form>
                </div>

            </div>
            <?php
        }
    }

endif;

PW()->tools = new Persian_Woocommerce_Tools();

do_action( "PW_Tools_load", PW()->get_options() );

include( "tools/class-price.php" );
include( "tools/class-datepicker.php" );
include( "tools/class-addons.php" );

<?php
if (isset($_POST['s'])) {
    if (empty($_POST['s']) && isset($_GET['s'])) {
        wp_redirect(remove_query_arg(array('s'), stripslashes($_SERVER['REQUEST_URI'])));
        exit;
    } else if (!empty($_POST['s'])) {
        wp_redirect(add_query_arg(array('s' => $_POST['s']), stripslashes($_SERVER['REQUEST_URI'])));
        exit;
    }
}

if (isset($_POST['action'], $_POST['text_delete_id'])) {
    $success = $failed = 0;
    foreach ($_POST['text_delete_id'] as $delete_id) {
        $delete = $wpdb->delete($wpdb->prefix . 'woocommerce_ir', array('id' => intval($delete_id)));
        if ($delete)
            $success++;
        else
            $failed++;
    }
    if ($success)
        add_settings_error('delete_text', 'pw_msg', sprintf('%d حلقه با موفقیت حذف شد.', $success), 'updated');
    if ($failed)
        add_settings_error('delete_text', 'pw_msg', sprintf('حذف %d حلقه با شکست مواجه شد.', $failed));
}

add_action('admin_print_footer_scripts', 'pw_text_footer');
function pw_text_footer()
{
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $("#pw_text").submit(function () {
                $("#save_loop_button").val("در حال ذخیره ...");
                jQuery.post(ajaxurl, $("#pw_text").serialize(), function (response) {

                    var obj = jQuery.parseJSON(response);

                    if (obj.status == "OK") {
                        $("#the-list").prepend(obj.code);
                        $(".displaying-num").html(obj.count);
                        document.getElementById("pw_text").reset();

                        if (obj.count == "1 مورد") {
                            $("tr.no-items").remove();
                            $(".tablenav-pages").removeClass("no-pages").addClass("one-page");
                        }
                    }

                    setTimeout(function () {
                        $("#setting-error-pw_msg_" + obj.rand).slideUp('slow', function () {
                            $("#setting-error-pw_msg_" + obj.rand).remove();
                        })
                    }, 3000);
                    $(".wrap h2#title").after(obj.msg);
                });

                setTimeout(function () {
                    $("#save_loop_button").val("ذخیره حلقه");
                }, 2000);

                return false;
            });
        });
    </script>
    <?php
}

add_action('add_meta_boxes', 'woocommerce_text_add_meta_box');
function woocommerce_text_add_meta_box()
{
    add_meta_box('add_form', 'افزودن حلقه ترجمه', 'woocommerce_text_meta_box', 'pw_text', 'side', 'high');
}

function woocommerce_text_meta_box()
{
    ?>
    <form action="" method="post" id="pw_text">
        <input type="hidden" name="s"
               value="<?php echo isset($_GET['s']) && !empty($_GET['s']) ? sanitize_text_field($_GET['s']) : ''; ?>"/>
        <input type="hidden" name="action" value="pw_replace_texts"/>
        <label for="input_text_1">کلمه‌ی مورد نظر :</label>
        <input type="text" class="widefat" id="input_text_1" name="text1"/>
        <br>
        <label for="input_text_2">جایگزین شود با :</label>
        <input type="text" class="widefat" id="input_text_2" name="text2"/>
        </div>
        <div id="major-publishing-actions">
            <div id="publishing-action">
                <span class="spinner"></span>
                <?php submit_button(esc_attr('ذخیره حلقه'), 'primary', 'submit', false, array('id' => 'save_loop_button')); ?>
            </div>
            <div class="clear"></div>
    </form>
    <?php
}

if (!class_exists('WP_List_Table'))
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class pw_text_list extends WP_List_Table
{

    var $data = array();

    function __construct()
    {
        global $status, $page, $wpdb;

        $search = "";
        $perPage = 16;
        $db_page = ($this->get_pagenum() - 1) * $perPage;

        if (isset($_GET['s']) && !empty($_GET['s'])) {
            $s = sanitize_text_field($_GET['s']);
            $search = " WHERE text1 LIKE '%{$s}%' OR text2 LIKE '%{$s}%'";
        }

        $this->data = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}woocommerce_ir`{$search} ORDER BY id DESC LIMIT $db_page, $perPage;", ARRAY_A);

        $this->set_pagination_args(array(
            'total_items' => $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}woocommerce_ir`{$search};"),
            'per_page' => $perPage
        ));

        parent::__construct(array(
            'singular' => 'text',
            'plural' => 'texts',
            'ajax' => false
        ));
    }

    function column_default($item, $column_name)
    {
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }

    function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox" />',
            'text1' => 'کلمه اصلی',
            'text2' => 'کلمه جایگزین شده',
        );
    }

    function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="text_delete_id[]" value="%s" />', $item['id']);
    }

    function prepare_items()
    {
        $this->_column_headers = array($this->get_columns(), array(), array());
        $this->items = $this->data;;
    }

    public function single_row($item)
    {
        echo "<tr id='PW_item_{$item['id']}' data-id='{$item['id']}' >";
        $this->single_row_columns($item);
        echo '</tr>';
    }

    function get_bulk_actions()
    {
        return array('delete' => 'حذف');
    }

    public function search_box($text, $input_id)
    {
        ?>
        <p class="search-box">
            <label class="screen-reader-text" for="<?php echo $input_id; ?>"><?php echo $text; ?>:</label>
            <input type="search" id="<?php echo $input_id; ?>" name="s" value="<?php _admin_search_query(); ?>"/>
            <?php submit_button($text, 'button', '', false, array('id' => 'search-submit')); ?>
        </p>
        <?php
    }

}

$PW_text_list = new pw_text_list();
do_action('add_meta_boxes', 'pw_text');

?>
<div class="wrap">

    <h2 id="title">حلقه های ترجمه</h2>


    <div class="fx-settings-meta-box-wrap">

        <div id="poststuff">

            <div id="post-body" class="metabox-holder columns-2">

                <div id="postbox-container-1" class="postbox-container">

                    <?php do_meta_boxes('pw_text', 'side', null); ?>
                    <!-- #side-sortables -->

                </div><!-- #postbox-container-1 -->

                <div id="postbox-container-2" class="postbox-container">

                    <?php settings_errors();

                    echo '<form method="POST" id="list-project">';
                    echo '<input type="hidden" name="page" value="persian-wc" />';
                    $PW_text_list->search_box('جستجو', 'PW-search-input');
                    $PW_text_list->prepare_items();
                    $PW_text_list->display();
                    echo '</form>';

                    ?>

                    <div class="clear"></div>
                    <!-- #normal-sortables -->

                </div><!-- #postbox-container-2 -->

            </div><!-- #post-body -->

            <br class="clear">

        </div><!-- #poststuff -->

    </div><!-- .fx-settings-meta-box-wrap -->

</div><!-- .wrap -->
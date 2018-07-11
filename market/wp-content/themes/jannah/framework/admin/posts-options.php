<?php
/**
 * Post Options
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*-----------------------------------------------------------------------------------*/
# Register The Meta Boxes
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_init', 'jannah_add_custom_meta_boxes' );
function jannah_add_custom_meta_boxes(){

	add_meta_box(
		'tie_post_options',
		JANNAH_THEME_NAME .' - '. esc_html__( 'Settings', 'jannah' ),
		'jannah_custom_meta_boxes',
		apply_filters( 'jannah_settings_post_types', array('post', 'page') ),
		'normal',
		'high'
	);
}


/*-----------------------------------------------------------------------------------*/
# Secondry post title
/*-----------------------------------------------------------------------------------*/
add_action('edit_form_after_title', 'jannah_secondry_post_title');
function jannah_secondry_post_title( $value ){

	$post_id      = get_the_id();
	$current_page = get_current_screen();

	if( ( ! empty( $post_id ) && get_post_type( $post_id ) != 'post' ) || $current_page->post_type != 'post' ){
		return;
	}

	$current_sub_title = get_post_meta( $post_id, 'tie_post_sub_title', true ) ? get_post_meta( $post_id, 'tie_post_sub_title', true ) : '';

	?>

	<div id="subtitlediv">
		<div id="subtitlewrap">
			<label class="screen-reader-text" id="sub-title-prompt-text" for="tie-sub-title"><?php esc_html_e( 'Enter sub title here', 'jannah' ) ?></label>
			<input type="text" name="tie_post_sub_title" size="30" value="<?php echo esc_attr( $current_sub_title ) ?>" id="tie-sub-title" placeholder="<?php esc_html_e( 'Enter sub title here', 'jannah' ) ?>" spellcheck="true" autocomplete="off">
		</div>
	</div>

	<?php
}


/*-----------------------------------------------------------------------------------*/
# Post & page Main Meta Boxes
/*-----------------------------------------------------------------------------------*/
function jannah_custom_meta_boxes(){


	$settings_tabs = array(

		'general' => array(
			'icon'  => 'admin-settings',
			'title' => esc_html__( 'General', 'jannah' ),
		),

		'layout' => array(
			'icon'	=> 'schedule',
			'title'	=> esc_html__( 'Layout', 'jannah' ),
		),

		'logo' => array(
			'icon'	=> 'lightbulb',
			'title'	=> esc_html__( 'Logo', 'jannah' ),
		),

		'sidebar' => array(
			'icon'  => 'slides',
			'title' => esc_html__( 'Sidebar', 'jannah' ),
		),

		'styles' => array(
			'icon'  => 'art',
			'title' => esc_html__( 'Styles', 'jannah' ),
		),

		'menu' => array(
			'icon'  => 'menu',
			'title' => esc_html__( 'Main Menu', 'jannah' ),
		),

		'e3lan' => array(
			'icon'  => 'megaphone',
			'title' => esc_html__( 'Advertisement', 'jannah' ),
		),

		'components' => array(
			'icon'  => 'admin-settings',
			'title' => esc_html__( 'Components', 'jannah' ),
		),
	);

	if( get_post_type() == 'post' ){
		$settings_tabs['highlights'] = array(
			'icon'  => 'editor-alignleft',
			'title' => esc_html__( 'Story Highlights', 'jannah' ),
		);
	}

	?>

	<input type="hidden" name="tie_hidden_flag" value="true" />

	<div class="tie-panel">
		<div class="tie-panel-tabs">
			<ul>
				<?php
					foreach( $settings_tabs as $tab => $settings ){

						$icon  = $settings['icon'];
						$title = $settings['title'];

						echo "
							<li class=\"tie-tabs tie-options-tab-$tab\">
								<a href=\"#tie-options-tab-$tab\">
									<span class=\"dashicons-before dashicons-$icon tie-icon-menu\"></span>
									$title
								</a>
							</li>
						";
					}
				?>
			</ul>
			<div class="clear"></div>
		</div> <!-- .tie-panel-tabs -->

		<div class="tie-panel-content">

			<?php

				foreach( $settings_tabs as $tab => $settings ){
					echo "
					<!-- $tab Settings -->
					<div id=\"tie-options-tab-$tab\" class=\"tabs-wrap\">";
						get_template_part( 'framework/admin/post-options/'. $tab );
					echo "</div>";
				}

			?>

		</div><!-- .tie-panel-content -->

		<div class="clear"></div>
	</div><!-- .tie-panel -->

	<div class="clear"></div>

  <?php
}


/*-----------------------------------------------------------------------------------*/
# Get The Post Options
/*-----------------------------------------------------------------------------------*/
function jannah_custom_post_option( $value ){

	if( empty( $value['id'] )){
		return;
	}

	$key  = $value['id'];
	$data = jannah_get_postdata( $key );

	jannah_build_option( $value, $key, $data );
}


/*-----------------------------------------------------------------------------------*/
# Save Post Options
/*-----------------------------------------------------------------------------------*/
add_action('save_post', 'jannah_save_post_options');
function jannah_save_post_options( $post_id ){

	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return $post_id;
	}

	if ( isset( $_POST['tie_hidden_flag'] )){

		$custom_meta_fields = array(

			# Misc ----------
			'tie_post_sub_title',
			'tie_primary_category',
			'tie_hide_title',
			'tie_hide_header',
			'tie_hide_footer',
			'tie_do_not_dublicate',
			'tie_header_extend_bg',

			# Post Layout ----------
			'tie_theme_layout',
			'tie_post_layout',
			'tie_featured_use_fea',
			'tie_featured_custom_bg',
			'tie_featured_bg_color',

			# Logo ----------
			'custom_logo' => array(
				'logo_setting',
				'logo_text',
				'logo',
				'logo_retina',
				'logo_retina_width',
				'logo_retina_height',
				'logo_margin',
				'logo_margin_bottom',
			),

			# Post Components ----------
			'tie_hide_meta',
			'tie_hide_tags',
			'tie_hide_categories',
			'tie_hide_author',
			'tie_hide_nav',
			'tie_hide_share_top',
			'tie_hide_share_bottom',
			'tie_hide_newsletter',
			'tie_hide_related',
			'tie_hide_check_also',

			# Post Sidebar ----------
			'tie_sidebar_pos',
			'tie_sidebar_post',
			'tie_sticky_sidebar',

			# Post Format settings ----------
			'tie_post_head',

			'tie_post_featured',
			'tie_image_uncropped',
			'tie_image_lightbox',

			'tie_post_slider',
			'tie_post_gallery',

			'tie_googlemap_url',

			'tie_video_url',
			'tie_video_self',
			'tie_embed_code',

			'tie_audio_m4a',
			'tie_audio_mp3',
			'tie_audio_oga',
			'tie_audio_soundcloud',

			# Custom Ads ----------
			'tie_hide_above',
			'tie_get_banner_above',
			'tie_hide_below',
			'tie_get_banner_below',

			# Story Highlights ----------
			'tie_highlights_text',

			# Post Color and background ----------
			'post_color',
			'tie_custom_css',
			'background_color',
			'background_type' => array(
				'background_pattern',
				'background_image',
			),
			'background_dots',
			'background_dimmer' => array(
				'background_dimmer_value',
				'background_dimmer_color',
			),

			# Custom Menu ----------
			'tie_menu',

			# Page templates ----------
			'tie_blog_excerpt' => array(
				'tie_blog_length',
			),
			'tie_blog_uncropped_image',
			'tie_blog_category_meta',
			'tie_blog_meta',
			'tie_posts_num',
			'tie_blog_cats',
			'tie_blog_layout',
			'tie_authors',
			'tie_blog_pagination',
		);

		foreach( $custom_meta_fields as $key => $custom_meta_field ){

			# Dependency Options fields ----------
			if( is_array( $custom_meta_field ) ){

				if( ! empty( $_POST[ $key ] )){

					update_post_meta( $post_id, $key, $_POST[ $key ] );

					foreach ( $custom_meta_field as $single_field ){
						if( ! empty( $_POST[ $single_field ] )){
							update_post_meta( $post_id, $single_field, $_POST[ $single_field ] );
						}
						else{
							delete_post_meta( $post_id, $single_field );
						}
					}
				}
				else{
					delete_post_meta( $post_id, $key );
				}
			}

			# Single Options fields ----------
			else{
				if( ! empty( $_POST[ $custom_meta_field ] )){
					update_post_meta( $post_id, $custom_meta_field, $_POST[ $custom_meta_field ] );
				}
				else{
					delete_post_meta( $post_id, $custom_meta_field );
				}
			}
		}
	}

	// To prevent DEMO reset from removing the posts that have been modified
	delete_post_meta( $post_id, JANNAH_THEME_FOLDER . '_demo_data' );

}

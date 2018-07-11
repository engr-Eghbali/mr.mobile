<?php
/**
 * Category options functions
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*-----------------------------------------------------------------------------------*/
# Get The Category Options
/*-----------------------------------------------------------------------------------*/
function jannah_category_option( $option ){

	$data = jannah_get_category_option( $option['id'], $option['cat'] );
	jannah_build_option( $option, 'tie_cat['.$option['id'].']', $data );
}


/*-----------------------------------------------------------------------------------*/
# Category Custom Options
/*-----------------------------------------------------------------------------------*/
add_action ( 'edit_category_form_fields', 'jannah_custom_category_options');
function jannah_custom_category_options( $category ){

	wp_enqueue_media();
	wp_enqueue_script( 'wp-color-picker' );

	$GLOBALS['category_id'] = $category->term_id;

	?>

	<tr class="form-field">
		<td colspan="2">

			<?php

			$settings_tabs = array(

				'category-layout' => array(
					'icon'  => 'admin-settings',
					'title' => esc_html__( 'Category Layout', 'jannah' ),
				),

				'layout' => array(
					'icon'	=> 'schedule',
					'title'	=> esc_html__( 'Posts Layout', 'jannah' ),
				),

				'main-slider' => array(
					'icon'	=> 'format-gallery',
					'title'	=> esc_html__( 'Slider', 'jannah' ),
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
					'title' => esc_html__( 'Styling', 'jannah' ),
				),
				'menu' => array(
					'icon'  => 'menu',
					'title' => esc_html__( 'Main Menu', 'jannah' ),
				),
			);

			?>

			<div id="poststuff">
				<div id="tie_post_options" class="postbox ">
					<h2 class="hndle ui-sortable-handle"><span><?php echo esc_html( JANNAH_THEME_NAME ) .' - '. esc_html__( 'Category Options', 'jannah' ) ?></span></h2>
					<div class="inside">
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
											get_template_part( 'framework/admin/category-options/'.$tab );
										echo "</div>";
									}

								?>

							</div><!-- .tie-panel-content -->

							<div class="clear"></div>
						</div><!-- .tie-panel -->
					</div><!-- .inside /-->
				</div><!-- #tie_post_options /-->
			</div><!-- #poststuff /-->

		</td>
	</tr>
	<?php
}


/*-----------------------------------------------------------------------------------*/
# Save Category Custom Options
/*-----------------------------------------------------------------------------------*/
add_action ('edited_category', 'jannah_save_custom_category_options');
function jannah_save_custom_category_options( $category_id ){

	if( ! empty( $_POST['tie_cat'] )){

		$tie_cats_options = get_option( 'tie_cats_options' );
		$category_data    = apply_filters( 'jannah_save_category', $_POST['tie_cat'] );

		$tie_cats_options[ $category_id ] = $category_data;
		update_option( 'tie_cats_options', $tie_cats_options, 'yes' );
	}
}

?>

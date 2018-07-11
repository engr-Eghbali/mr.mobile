<?php
/**
 * TieLabs Page Builder
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly




/*-----------------------------------------------------------------------------------*/
# Build The builder Options
/*-----------------------------------------------------------------------------------*/
function jannah_page_builder_option( $block_id, $section_id, $data, $option ){
	$id = $option['id'];

	$option['prefix'] = 'block-'. $section_id .'-'. $block_id;

	jannah_build_option( $option, 'tie_home_cats['.$section_id.'][blocks]['.$block_id.']['.$id.']', $data );
}




/*-----------------------------------------------------------------------------------*/
# Build The Section Options
/*-----------------------------------------------------------------------------------*/
function jannah_page_builder_section_option( $section_id, $data, $option ){
	$id = $option['id'];
	$option['prefix'] = 'section-'. $section_id;

	jannah_build_option( $option, 'tie_home_cats['.$section_id.'][settings]['.$id.']', $data );
}




/*-----------------------------------------------------------------------------------*/
# Clean options before store it in DB
/*-----------------------------------------------------------------------------------*/
add_action( 'save_post', 'jannah_save_page_builder' );
function jannah_save_page_builder( $post_id ){

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}

	if ( isset( $_POST['tie_hidden_flag'] )){
		# Save the builder settings ---------
		if ( ! empty( $_POST['tie_builder_active'] ) && $_POST['tie_builder_active'] == 'yes' ){
			update_post_meta( $post_id, 'tie_builder_active', 'yes' );

			# Delete the page template of the page ----------
			//delete_post_meta( $post_id, '_wp_page_template' );
		}
		else{
			delete_post_meta( $post_id, 'tie_builder_active' );
		}

		if( ! empty( $_POST['tie_home_cats'] ) ){
			$builder_data = apply_filters( 'jannah_save_blocks', $_POST['tie_home_cats'] );
			$builder_data = jannah_array_filter_recursive( $builder_data );

			update_post_meta( $post_id, 'tie_page_builder', $builder_data );
		}
		else{
			delete_post_meta( $post_id, 'tie_page_builder' );
		}

	}
}




/*-----------------------------------------------------------------------------------*/
# Page Builder Blocks
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_tie_get_builder_section', 'jannah_get_builder_section');
function jannah_get_builder_section( $section_number = false, $section = array() ){

	$section_settings = $section['settings'];
	$is_ajax = false;

	if( empty( $section_number ) && ! empty( $_REQUEST['section_id'] ) ){
		$section_number = $_REQUEST['section_id'];
		$is_ajax = true;
		$post_id = $_REQUEST['post_id'];
		$section_settings = array(
			'section_id' => 'tiepost-' . $post_id . '-' . 'tiexyz20',
		);
	}
	else{
		$post_id = get_the_id();
	}

	$section_settings = wp_parse_args( $section_settings, array(
		'section_title'    => '',
		'title'            => '',
		'url'              => '',
		'title_style'      => '',
		'title_color'      => '',
		'sidebar_position' => 'full',
		'section_width'    => '',
		'parallax'         => '',
		'parallax_effect'  => '',
		'background_img'   => '',
		'background_video' => '',
		'background_color' => '',
		'dark_skin'        => '',
		'custom_class'     => '',
		'sticky_sidebar'   => '',
		'margin_top'       => '',
		'margin_bottom'    => '',
		'section_id'       => 'tiepost-' . $post_id . '-' . 'section-'.rand(200, 3500),
	));

	?>

	<li id="tie-section-<?php echo esc_attr( $section_number ) ?>" class="tie-builder-container parent-item sidebar-<?php echo esc_attr($section_settings['sidebar_position']) ?>">

		<div class="tie-builder-section-title">
			<h4><?php esc_html_e( 'Section', 'jannah' ) ?></h4>

			<ul class='tie-block-options'>
				<li><a class="toggle-section dashicons" href="#"></a></li>
				<li><a class="edit-block-icon dashicons-edit dashicons" href="#"></a></li>
				<li><a class="del-item del-section dashicons dashicons-trash" href="#"></a></li>
			</ul>
		</div>

		<div class="tie-builder-content-area tie-popup-block tie-popup-window">

			<div class="tie-builder-item-top-container">
				<h2><?php esc_html_e( 'Edit Section', 'jannah' ) ?></h2>

				<a class="tie-primary-button button button-primary button-hero tie-edit-block-done" href="#"><?php esc_html_e( 'Done', 'jannah' ) ?></a>

				<div class="tie-section-title tie-section-tabs blocks-settings-tabs">
					<a href="#" data-target="basic-block-settings" class="active"><?php esc_html_e( 'General', 'jannah' ) ?></a>
					<a href="#" data-target="background-block-settings"><?php esc_html_e( 'Background', 'jannah' ) ?></a>
					<a href="#" data-target="design-block-settings"><?php esc_html_e( 'Styling',  'jannah' ) ?></a>
				</div>
			</div>

			<div class="tie-block-options-group">

				<?php
				echo '<div class="basic-block-settings block-settings">';

					jannah_theme_option(
						array(
							'title' => esc_html__( 'Section Title', 'jannah' ),
							'type'  => 'header',
						));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['section_title'],
						array(
							'name'   => esc_html__( 'Section Title', 'jannah' ),
							'id'     => 'section_title',
							'type'   => 'checkbox',
							'toggle' => "#section-$section_number-title-item, #section-$section_number-url-item, #section-$section_number-title_style-item, #section-$section_number-title_color-item",
						));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['title'],
						array(
							'name' => esc_html__( 'Section Title', 'jannah' ) .' '. esc_html__( '(optional)', 'jannah' ),
							'id'   => 'title',
							'type' => 'text',
						));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['url'],
						array(
							'name'        => esc_html__( 'Title URL', 'jannah' ) .' '. esc_html__( '(optional)', 'jannah' ),
							'id'          => 'url',
							'placeholder' => 'https://',
							'type'        => 'text',
						));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['title_style'],
						array(
							'name'    => esc_html__( 'Title Style', 'jannah' ),
							'id'      => 'title_style',
							'type'    => 'radio',
							'options' => array(
								''         => esc_html__( 'Default', 'jannah' ),
								'centered' => esc_html__( 'Centered', 'jannah' ),
								'big'      => esc_html__( 'Big', 'jannah' ),
							)));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['title_color'],
						array(
							'name' => esc_html__( 'Title Color', 'jannah' ),
							'id'   => 'title_color',
							'type' => 'color',
						));

					jannah_theme_option(
						array(
							'title' => esc_html__( 'Section Width', 'jannah' ),
							'type'  => 'header',
						));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['section_width'],
						array(
							'name'   => esc_html__( '100% Interior Content Width', 'jannah' ),
							'id'     => 'section_width',
							'type'   => 'checkbox',
							'hint'   => esc_html__( 'Select if the interior content is contained to site width or 100% width.', 'jannah' ),
						));

					jannah_theme_option(
						array(
							'title' => esc_html__( 'Sidebar Settings', 'jannah' ),
							'type'  => 'header',
						));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['sidebar_position'],
						array(
							'name'    => esc_html__( 'Sidebar Position', 'jannah' ),
							'id'      => 'sidebar_position',
							'prefix'  => 'section-' . $section_number,
							'type'    => 'visual',
							'class'   => 'tie-section-sidebar',
							'options' => array(
								'full'  => array( esc_html__( 'Without Sidebar', 'jannah' ) => 'sidebars/sidebar-full-width.png' ),
								'right' => array( esc_html__( 'Sidebar Right', 'jannah' ) => 'sidebars/sidebar-right.png' ),
								'left'  => array( esc_html__( 'Sidebar Left', 'jannah' ) => 'sidebars/sidebar-left.png' ),
						)));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['sticky_sidebar'],
						array(
							'name'   => esc_html__( 'Sticky Sidebar', 'jannah' ),
							'id'     => 'sticky_sidebar',
							'type'   => 'checkbox',
					));

				echo '</div>';

				echo '<div class="background-block-settings block-settings">';

					jannah_theme_option(
						array(
							'title' => esc_html__( 'Background Settings', 'jannah' ),
							'type'  => 'header',
						));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['background_color'],
						array(
							'name' => esc_html__( 'Background Color', 'jannah' ),
							'id'   => 'background_color',
							'type' => 'color',
						));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['background_img'],
						array(
							'name' => esc_html__( 'Background Image', 'jannah' ),
							'id'   => 'background_img',
							'type' => 'upload',
					));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['background_video'],
						array(
							'name' => esc_html__( 'Background Video', 'jannah' ),
							'id'   => 'background_video',
							'type' => 'text',
					));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['parallax'],
						array(
							'name'   => esc_html__( 'Parallax', 'jannah' ),
							'id'     => 'parallax',
							'type'   => 'checkbox',
							'toggle' => '#section-'. $section_number .'-parallax_effect-item',
					));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['parallax_effect'],
						array(
							'name' => esc_html__( 'Parallax Effect', 'jannah' ),
							'id'   => 'parallax_effect',
							'type' => 'select',
							'options' => array(
								'scroll'         => esc_html__( 'Scroll', 'jannah' ),
								'scale'          => esc_html__( 'Scale', 'jannah' ),
								'opacity'        => esc_html__( 'Opacity', 'jannah' ),
								'scroll-opacity' => esc_html__( 'Scroll + Opacity', 'jannah' ),
								'scale-opacity'  => esc_html__( 'Scale + Opacity', 'jannah' ),
					)));

				echo '</div>';

				echo '<div class="design-block-settings block-settings">';

					jannah_theme_option(
						array(
							'title' => esc_html__( 'Styling Settings', 'jannah' ),
							'type'  => 'header',
						));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['dark_skin'],
						array(
							'name'   => esc_html__( 'Dark Skin', 'jannah' ),
							'id'     => 'dark_skin',
							'type'   => 'checkbox',
					));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['custom_class'],
						array(
							'name'   => esc_html__( 'Custom Classes', 'jannah' ),
							'id'     => 'custom_class',
							'type'   => 'text',
					));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['margin_top'],
						array(
							'name'   => esc_html__( 'Margin Top', 'jannah' ),
							'id'     => 'margin_top',
							'type'   => 'number',
					));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['margin_bottom'],
						array(
							'name'   => esc_html__( 'Margin Bottom', 'jannah' ),
							'id'     => 'margin_bottom',
							'type'   => 'number',
					));

					jannah_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['section_id'],
						array(
							'id'      => 'section_id',
							'type'    => 'hidden'
						));

				echo '</div>';
				?>

			</div><!-- .tie-block-options-group -->
		</div><!-- tie-builder-content-area -->


		<div class="tie-builder-section-inner">

			<div class="tie-section-sidebar">
				<h4><?php esc_html_e( 'Sidebar', 'jannah' ) ?></h4>
				<a href="#" data-widgets="<?php echo esc_attr( $section_settings['section_id'] ) ?>" class="tie-manage-widgets">
					<span class="dashicons dashicons-admin-generic"></span><?php esc_html_e( 'Manage Widgets', 'jannah' ) ?>
				</a>
			</div>

			<div class="tie-builder-blocks-wrapper-outer">
				<ul class="tie-builder-blocks-wrapper" id="cat_sortable_<?php echo esc_attr( $section_number ) ?>" data-section-id="<?php echo esc_attr( $section_number ) ?>">
					<?php
					$block_id = ! empty( $GLOBALS['tie_block_id'] ) ? $GLOBALS['tie_block_id'] : 1;

					if(! empty( $section['blocks'] ) && is_array( $section['blocks'] )){
						foreach( $section['blocks'] as $block ){
							jannah_get_builder_blocks( $block_id, $section_number, $block );
							$block_id++;
						}
					}

					$GLOBALS['tie_block_id'] = $block_id;
					?>
				</ul><!-- #cat_sortable  /-->

				<div class="clear"></div>

				<div class="tie-loading-container">
					<div class="tie-saving-settings">
						<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
							<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
							<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
							<path class="checkmark__error_1" d="M38 38 L16 16 Z"/>
							<path class="checkmark__error_2" d="M16 38 38 16 Z" />
						</svg>
					</div>
				</div>

				<div class="tie-add-new-block-wrapper">
					<a href="#" data-section="<?php echo esc_attr( $section_number ) ?>" class="tie-add-new-block tie-primary-button button button-primary button-large"><span><?php esc_html_e( 'Add Block', 'jannah' ) ?></span></a>
				</div>

			</div><!-- .tie-builder-blocks-wrapper-outer -->

			<div class="clear"></div>

		</div><!-- .tie-builder-section-inner -->

		<?php
		if( $is_ajax ){
			# Visual Block Style Options ?>
			<script>
				jQuery(document).ready(function(){
					$AddedSection	= jQuery('#tie-section-<?php echo esc_js( $section_number ) ?>');
					$AddedSection.find('input:checked').parent().addClass( 'selected' );
					$AddedSection.find('.checkbox-select').click( function(event){
						event.preventDefault();
						$AddedSection.find('li').removeClass('selected');
						$AddedSection.find(':radio').removeAttr('checked');
						jQuery(this).parent().addClass('selected');
						jQuery(this).parent().find(':radio').attr('checked','checked');
					});
				});
			</script>
			<?php

			// This elements will be filtered from the Ajax request and add it to the widgets UI
			jannah_get_section_sidebar_options( $section_settings['section_id'], $section_number, $section_settings );
		}
		?>
	</li><!-- .tie-builder-container /-->
	<?php
}




/*-----------------------------------------------------------------------------------*/
# Page Builder Blocks
/*-----------------------------------------------------------------------------------*/
function jannah_get_section_sidebar_options( $section_id, $section_number, $section_settings ){

	echo '<div id="'. $section_id .'-sidebar-options" class="sections-sidebars-options">';

		jannah_page_builder_section_option(
			$number = $section_number,
			$value  = $section_settings['predefined_sidebar'],
			array(
				'name'   => esc_html__( 'Predefined Sidebar', 'jannah' ),
				'id'     => 'predefined_sidebar',
				'prefix' => 'section-' . $section_number,
				'toggle' => '#section-' . $section_number . '-sidebar_id-item',
				'type'   => 'checkbox',
			));

		jannah_page_builder_section_option(
			$number = $section_number,
			$value  = $section_settings['sidebar_id'],
			array(
				'name'    => esc_html__( 'Choose Sidebar', 'jannah' ),
				'id'      => 'sidebar_id',
				'prefix'  => 'section-' . $section_number,
				'type'    => 'select',
				'options' => jannah_get_registered_sidebars(),
			));

	echo '</div>';
}




/*-----------------------------------------------------------------------------------*/
# Page Builder Blocks
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_tie_get_builder_blocks', 'jannah_get_builder_blocks');
function jannah_get_builder_blocks( $block_id = false, $section_id = false , $block = array() ){

	$block_class_name = '';
	$categories = jannah_get_categories_array();

	if( empty( $section_id ) && ! empty( $_REQUEST['section_id'] ) ){
		$section_id = $_REQUEST['section_id'];
	}

	if( empty( $block_id ) && ! empty( $_REQUEST['block_id'] ) ){
		$block_id = $_REQUEST['block_id'];
	}

	if( empty( $block ) ){
		$block = array(
			'style'           => 'default',
			'title'           => esc_html__( 'Block Title', 'jannah' ),
			'number'          => 5,
			'excerpt'         => 'true',
			'read_more'       => 'true',
			'post_meta'       => 'true',
			'breaking_effect' => 'reveal',
		);
	}

	$block = wp_parse_args( $block, array(
		'style'  => 'default',
		'url'	   => '',
		'videos' => '',
	));


	$builder_blocks_styles = jannah_builder_blocks_styles();
	$block_style           = $block['style'];
	$style_data            = $builder_blocks_styles[ $block_style ];


	if( ! empty( $style_data ) && is_array( $style_data ) ){
		foreach ( $style_data as $style_block ){
			foreach ( $style_block as $style_class_name => $style_image ){
				$block_class_name .= $style_class_name.'-container';
				$block_class_name .= ' '; // Avoid class names error
			}
		}
	}


	# Block head BG Color ----------
	$block_head_bg = $block_head_class = '';

	if( ! empty( $block['color'] ) ){
		$block_head_class = 'block-head-'.jannah_light_or_dark( $block['color'], false, 'dark', 'light' );
		$block_head_bg    = 'style="background-color:'.$block['color'].'"';
	}
	?>

	<li id="listItem_<?php echo esc_attr( $section_id .'-'. $block_id ) ?>" class="block-item parent-item <?php echo esc_attr( $block_class_name ) ?>">

		<div class="tie-block-head <?php echo esc_attr( $block_head_class ) ?>" <?php echo ( $block_head_bg ) ?>>

			<?php
				$block_img = esc_attr( JANNAH_TEMPLATE_URL .'/framework/admin/assets/images/blocks/block-'. $block['style'] .'.png' );
				echo "<img class=\"block-small-img\" src=\" $block_img\">";
			?>

			<span class="block-preview-title"><?php if( ! empty( $block['title'] ) ) echo force_balance_tags( $block['title'] ); ?></span>
			<span class="block-e3lan-title"><?php esc_html_e( 'Ad', 'jannah' ) ?></span>
			<span class="block-tabs-title"><?php esc_html_e( 'Tabs block', 'jannah' ) ?></span>

			<ul class='tie-block-options'>
				<li><a class="edit-block-icon dashicons-edit dashicons" href="#"></a></li>
				<li><a class="del-item dashicons dashicons-trash" href="#"></a></li>
			</ul>

		</div>

		<div class="tie-builder-content-area tie-popup-block tie-popup-window">

			<div class="tie-builder-item-top-container">
				<h2><?php esc_html_e( 'Edit Block', 'jannah' ) ?></h2>

				<a class="tie-primary-button button button-primary button-hero tie-edit-block-done" href="#"><?php esc_html_e( 'Done', 'jannah' ) ?></a>

			</div>

			<div class="tie-block-options-group">

			<?php

			$block = wp_parse_args( $block, array(
				'style'           => 'default',
				'cat'             => '',
				'title'           => '',
				'order'           => 'latest',
				'woo_cats'        => '',
				'id'              => '',
				'tags'            => '',
				'custom_slider'   => '',
				'number'          => 5 ,
				'offset'          => '',
				'pagi'            => '',
				'color'           => '',
				'dark'            => '',
				'title_length'    => '',
				'excerpt'         => '',
				'excerpt_length'  => '',
				'read_more'       => '',
				'thumb_first'     => '',
				'thumb_small'     => '',
				'thumb_all'       => '',
				'more'            => '',
				'post_meta'       => '',
				'media_overlay'   => '',
				'filters'         => '',
				'custom_content'  => '',
				'content_only'    => '',
				'ad_img'          => '',
				'ad_url'          => '',
				'ad_alt'          => '',
				'ad_target'       => '',
				'ad_nofollow'     => '',
				'ad_code'         => '',
				'colored_mask'    => '',
				'animate_auto'    => '',
				'posts_category'  => '',
				'breaking_effect' => '',
				'breaking_arrows' => '',
				'lsslider'        => '',
				'revslider'       => '',
				'boxid'           => '',
			));


			jannah_page_builder_option(
				$block_id = $block_id,
				$section  = $section_id,
				$value    = $block['style'],
				array(
					'id'      => 'style',
					'type'    => 'visual',
					'class'   => 'block-style',
					'options' => $builder_blocks_styles,
				));
			?>

			<div class="tie-section-title tie-section-tabs blocks-settings-tabs">
				<a href="#" data-target="basic-block-settings" class="active"><?php esc_html_e( 'General', 'jannah' ) ?></a>
				<a href="#" data-target="advanced-block-settings" class="block-settings-advanced"><?php esc_html_e( 'Advanced Settings',  'jannah' ) ?></a>
			</div>


			<div class="basic-block-settings block-settings">

			<?php

			# Tabs Block ----------
			$tie_home_tabs = empty( $block['cat'] ) ? array() : $block['cat'] ;

			$tie_home_tabs_new = array();

			foreach ( $tie_home_tabs as $key1 => $option1 ){
				if ( array_key_exists( $option1, $categories ) ){
					$tie_home_tabs_new[$option1] = $categories[$option1];
				}
			}

			foreach ( $categories as $key2 => $option2 ){
				if ( !in_array( $key2, $tie_home_tabs ) ){
					$tie_home_tabs_new[$key2] = $option2;
				}
			}

			?>

			<div class="option-item block-cat-tabs-item-options">
				<span class="tie-label"><?php esc_html_e( 'Categories', 'jannah' ) ?></span>
				<div class="clear"></div>

				<ul class="tabs_cats">
				<?php
					foreach ( $tie_home_tabs_new as $key => $option){ ?>
						<li>
							<input name="tie_home_cats[<?php echo esc_attr( $section_id ) ?>][blocks][<?php echo esc_attr( $block_id ) ?>][cat][]" type="checkbox"<?php if ( in_array( $key, $tie_home_tabs ) ) echo ' checked'; ?> value="<?php echo esc_attr( $key ) ?>">
							<span><?php echo esc_attr( $option ) ?></span>
						</li>
					<?php
					}
				?>
				</ul>
				<div class="clear"></div>
			</div><!-- .block-cat-tabs-item-options -->

			<?php

				# Block Title ----------
				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['title'],
					array(
						'name'   => esc_html__( 'Custom Title', 'jannah' ) .' '. esc_html__( '(optional)', 'jannah' ),
						'id'     => 'title',
						'class'  => 'block-title-item',
						'type'   => 'text',
					));


				# Block URL ----------
				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['url'],
					array(
						'name'        => esc_html__( 'Title URL', 'jannah' ) .' '. esc_html__( '(optional)', 'jannah' ),
						'id'          => 'url',
						'class'       => 'block-url-item',
						'placeholder' => 'https://',
						'type'        => 'text',
					));

				# Post Order ----------
				$block_post_order = array(
					'latest'   => esc_html__( 'Recent Posts', 'jannah' ),
					'rand'     => esc_html__( 'Random Posts', 'jannah' ),
					'modified' => esc_html__( 'Last Modified Posts', 'jannah' ),
					'popular'  => esc_html__( 'Most Commented posts', 'jannah' ),
				);

				if( jannah_get_option( 'post_views' ) ){
					$block_post_order['views'] = esc_html__( 'Most Viewed posts', 'jannah' );
				}

				if( JANNAH_TAQYEEM_IS_ACTIVE ){
					$block_post_order['best'] = esc_html__( 'Best Reviews', 'jannah' );
				}

				if( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
					jannah_page_builder_option(
						$block_id =	$block_id,
						$section  = $section_id,
						$value    =	$block['woo_cats'],
						array(
							'name'    => esc_html__( 'Products Categories', 'jannah' ),
							'id'      => 'woo_cats',
							'type'    => 'select-multiple',
							'class'   => 'block-default-options block-products-item',
							'options' => jannah_get_products_categories_array(),
						));
				}

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['id'],
					array(
						'name'    => esc_html__( 'Categories', 'jannah' ),
						'id'      => 'id',
						'type'    => 'select-multiple',
						'class'   => 'block-default-options block-categories-item',
						'options' => $categories,
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['tags'],
					array(
						'name'   => esc_html__( 'Tags', 'jannah' ),
						'id'     => 'tags',
						'hint'   => esc_html__( 'Will overide the Categories option.', 'jannah' ),
						'type'   => 'text',
						'class'  => 'block-default-options block-tags-item',
					));

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['order'],
					array(
						'name'     => esc_html__( 'Sort Order', 'jannah' ),
						'id'       => 'order',
						'type'     => 'select',
						'class'    => 'block-default-options block-order-item',
						'options'  => $block_post_order,
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['number'],
					array(
						'name'   => esc_html__( 'Number of posts to show', 'jannah' ),
						'id'     => 'number',
						'type'   => 'number',
						'class'  => 'block-default-options block-number-item',
					));

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['offset'],
					array(
						'name'   => esc_html__( 'Offset - number of posts to pass over', 'jannah' ),
						'id'     => 'offset',
						'type'   => 'number',
						'class'  => 'block-default-options block-offset-item',
					));

				jannah_page_builder_option(
					$block_id	= $block_id,
					$section  = $section_id,
					$value    = $block['pagi'],
					array(
						'name'    => esc_html__( 'Pagination', 'jannah' ),
						'id'      => 'pagi',
						'type'    => 'select',
						'class'   => 'block-default-options block-pagination-item',
						'options' => array(
								''          => esc_html__( 'Disable', 'jannah' ),
								'numeric'   => esc_html__( 'Numeric', 'jannah' ),
								'next-prev' => esc_html__( 'Next and Previous Arrows', 'jannah' ),
								'show-more' => esc_html__( 'Show More', 'jannah' ),
								'load-more' => esc_html__( 'Load More', 'jannah' ),
					)));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['custom_slider'],
					array(
						'name'     => esc_html__( 'Custom Slider', 'jannah' ),
						'id'       => 'custom_slider',
						'type'     => 'select',
						'pre_text' => esc_html__( '- OR -', 'jannah' ),
						'class'    => 'block-slider-options block-custom-slider',
						'options'  => jannah_get_custom_sliders( true ),
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['custom_content'],
					array(
						'id'     => 'custom_content',
						'type'   => 'editor',
						'class'  => 'block-custom-code-item',
					));

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['ad_img'],
					array(
						'name'   => esc_html__( 'Banner Image', 'jannah' ),
						'id'     => 'ad_img',
						'type'   => 'upload',
						'class'  => 'block-e3lan-group block-e3lan-image-item',
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['ad_url'],
					array(
						'name'        => esc_html__( 'Banner URL', 'jannah' ),
						'id'          => 'ad_url',
						'type'        => 'text',
						'placeholder' => 'https://',
						'class'       => 'block-e3lan-group block-e3lan-url-item',
					));

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['ad_alt'],
					array(
						'name'   => esc_html__( 'Alternative Text For The image', 'jannah' ),
						'id'     => 'ad_alt',
						'type'   => 'text',
						'class'  => 'block-e3lan-group block-e3lan-alt-item',
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['ad_target'],
					array(
						'name'   => esc_html__( 'Open The Link In a new Tab', 'jannah' ),
						'id'     => 'ad_target',
						'type'   => 'checkbox',
						'class'  => 'block-e3lan-group block-e3lan-target-item',
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['ad_nofollow'],
					array(
						'name'	 => esc_html__( 'Nofollow?', 'jannah' ),
						'id'     => 'ad_nofollow',
						'type'   => 'checkbox',
						'class'  => 'block-e3lan-group block-e3lan-nofollow-item',
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['ad_code'],
					array(
						'name'   => esc_html__( 'Custom Ad Code', 'jannah' ),
						'id'     => 'ad_code',
						'type'   => 'textarea',
						'class'  => 'block-e3lan-group block-e3lan-code-item',
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['videos'],
					array(
						'name'   => esc_html__( 'Videos List', 'jannah' ),
						'id'     => 'videos',
						'hint'   => esc_html__( 'Enter each video url in a seprated line.', 'jannah' ) . ' <strong>' . esc_html__( 'Supports: YouTube and Vimeo videos only.', 'jannah' ).'</strong>',
						'type'   => 'textarea',
						'class'  => 'block-video-list-group',
					));




				# Slider Revolution ----------
				if( JANNAH_REVSLIDER_IS_ACTIVE ){
					echo '<div class="block-revslider-settings">';

						$rev_slider = new RevSlider();
						$rev_slider = $rev_slider->getArrSlidersShort();

						if( ! empty( $rev_slider ) && is_array( $rev_slider )){

							$arrSliders = array( '' => esc_html__( 'Choose Slider', 'jannah' ) );

							foreach( $rev_slider as $id => $item ){
								$name = empty( $item ) ? esc_html__( 'Unnamed', 'jannah' ) : $item;
								$arrSliders[ $id ] = $name . ' | #' .$id;
							}

							jannah_page_builder_option(
								$block_id = $block_id,
								$section  = $section_id,
								$value    = $block['revslider'],
								array(
									'name'    => esc_html__( 'Slider Revolution', 'jannah' ),
									'id'      => 'revslider',
									'type'    => 'select',
									'options' => $arrSliders,
								));
						}
						else{
							jannah_theme_option(
								array(
									'text' => esc_html__( 'No sliders found, add a slider first!', 'jannah' ),
									'type' => 'error',
								));
						}

					echo '</div><!-- .block-revslider-settings -->';
				}


				# LayerSlider ----------
				if( JANNAH_LS_Sliders_IS_ACTIVE ){
					echo '<div class="block-lsslider-settings">';

						$ls_sliders = LS_Sliders::find(array('limit' => 100));

						if( ! empty( $ls_sliders ) && is_array( $ls_sliders ) ){

							$arrSliders = array( '' => esc_html__( 'Choose Slider', 'jannah' ) );

							foreach( $ls_sliders as $item ){
								$name = empty( $item['name'] ) ? esc_html__( 'Unnamed', 'jannah' ) : $item['name'];
								$arrSliders[ $item['id'] ] = $name . ' | #' .$item['id'];
							}

							jannah_page_builder_option(
								$block_id = $block_id,
								$section  = $section_id,
								$value    = $block['lsslider'],
								array(
									'name'    => esc_html__( 'LayerSlider', 'jannah' ),
									'id'      => 'lsslider',
									'type'    => 'select',
									'options' => $arrSliders,
								));

						}
						else{
							jannah_theme_option(
								array(
									'text' => esc_html__( 'No sliders found, add a slider first!', 'jannah' ),
									'type' => 'error',
								));
						}

					echo '</div><!-- .block-lsslider-settings -->';
				}


			echo '</div><!-- basic-block-settings -->';


			echo '<div class="advanced-block-settings block-settings">';

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['content_only'],
					array(
						'name'   => esc_html__( 'Show the content only?', 'jannah' ),
						'id'     => 'content_only',
						'type'   => 'checkbox',
						'hint'   => esc_html__( 'Without background, padding nor borders.', 'jannah' ),
						'class'  => 'block-content-only-item',
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['filters'],
					array(
						'name'   => esc_html__( 'Ajax Filters', 'jannah' ),
						'id'     => 'filters',
						'type'   => 'checkbox',
						'hint'   => esc_html__( 'Will not appear if the numeric pagination is active.', 'jannah' ),
						'class'  => 'block-default-options block-filters-item',
					));

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['more'],
					array(
						'name'   => esc_html__( 'More Button', 'jannah' ),
						'id'     => 'more',
						'type'   => 'checkbox',
						'hint'   => esc_html__( 'Will not appear if the Block URL is empty.', 'jannah' ),
						'class'  => 'block-default-options block-more-item',
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['color'],
					array(
						'name'        => esc_html__( 'Color', 'jannah' ),
						'id'          => 'color',
						'type'        => 'color',
						'color_class' => 'tieBlocksColor',
						'class'       => 'block-color-item',
					));

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['title_length'],
					array(
						'name'   => esc_html__( 'Posts Title Length', 'jannah' ),
						'id'     => 'title_length',
						'type'   => 'number',
						'class'  => 'block-default-options block-title_length-item',
					));

				echo '<div class="excerpt-options featured-posts-options">';

					jannah_page_builder_option(
						$block_id = $block_id,
						$section  = $section_id,
						$value    = $block['excerpt'],
						array(
							'name'   => esc_html__( 'Posts Excerpt', 'jannah' ),
							'id'     => 'excerpt',
							'type'   => 'checkbox',
							'toggle' => '#block-'. $section_id .'-'. $block_id .'-excerpt_length-item',
							'class'  => 'block-default-options block-excerpt-item',
						));

					jannah_page_builder_option(
						$block_id = $block_id,
						$section  = $section_id,
						$value    = $block['excerpt_length'],
						array(
							'name'   => esc_html__( 'Posts Excerpt Length', 'jannah' ),
							'id'     => 'excerpt_length',
							'type'   => 'number',
							'class'  => 'block-default-options block-excerpt_length-item',
						));
				echo '</div>';


				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['read_more'],
					array(
						'name'   => esc_html__( 'Read More Button', 'jannah' ),
						'id'     => 'read_more',
						'type'   => 'checkbox',
						'class'  => 'block-default-options block-read_more-item',
					));

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['dark'],
					array(
						'name'   => esc_html__( 'Dark Skin', 'jannah' ),
						'id'     => 'dark',
						'type'   => 'checkbox',
						'class'  => 'block-dark-item',
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['thumb_first'],
					array(
						'name'   => esc_html__( 'Hide thumbnail for the First post', 'jannah' ),
						'id'     => 'thumb_first',
						'type'   => 'checkbox',
						'class'  => 'block-default-options block-thumb_first-item',
					));

				jannah_page_builder_option(
					$block_id	= $block_id,
					$section  = $section_id,
					$value    = $block['thumb_small'],
					array(
						'name'   => esc_html__( 'Hide small thumbnails', 'jannah' ),
						'id'     => 'thumb_small',
						'type'   => 'checkbox',
						'class'  => 'block-default-options block-thumb_small-item',
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['thumb_all'],
					array(
						'name'   => esc_html__( 'Hide thumbnails', 'jannah' ),
						'id'     => 'thumb_all',
						'type'   => 'checkbox',
						'class'  => 'block-thumb_all-item',
					));

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['post_meta'],
					array(
						'name'   => esc_html__( 'Post Meta', 'jannah' ),
						'id'     => 'post_meta',
						'type'   => 'checkbox',
						'class'  => 'block-default-options block-post_meta-item',
					));

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['posts_category'],
					array(
						'name'  => esc_html__( 'Post Primary Category', 'jannah' ),
						'id'    => 'posts_category',
						'class' => 'block-slider-options block-slider-categories-meta',
						'type'  => 'checkbox',
					));

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['colored_mask'],
					array(
						'name'  => esc_html__( 'Colored Mask', 'jannah' ),
						'id'    => 'colored_mask',
						'class' => 'block-slider-options block-slider-colored-mask',
						'type'  => 'checkbox',
					));

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['animate_auto'],
					array(
						'name'  =>  esc_html__( 'Animate Automatically', 'jannah' ),
						'id'    => 'animate_auto',
						'class' => 'block-slider-options block-slider-animate_auto',
						'type'  => 'checkbox',
					));

				jannah_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['media_overlay'],
					array(
						'name'   => esc_html__( 'Media Icon Overlay', 'jannah' ),
						'id'     => 'media_overlay',
						'type'   => 'checkbox',
						'class'  => 'block-default-options block-media-overlay-item',
					));


				echo '<div class="block-breaking-news-options">';

					jannah_page_builder_option(
						$block_id =	$block_id,
						$section  = $section_id,
						$value    =	$block['breaking_effect'],
						array(
							'name'    => esc_html__( 'Animation Effect', 'jannah' ),
							'id'      => 'breaking_effect',
							'type'    => "select",
							'options' => array(
								'reveal'     => esc_html__( 'Typing',        'jannah' ),
								'flipY'      => esc_html__( 'Fading',        'jannah' ),
								'slideLeft'  => esc_html__( 'Sliding Left',  'jannah' ),
								'slideRight' => esc_html__( 'Sliding Right', 'jannah' ),
								'slideUp'    => esc_html__( 'Sliding Up',    'jannah' ),
								'slideDown'  => esc_html__( 'Sliding Down',  'jannah' ),
						)));

					jannah_page_builder_option(
						$block_id =	$block_id,
						$section  = $section_id,
						$value    =	$block['breaking_arrows'],
						array(
							'name' => esc_html__( 'Show the scrolling arrows?', 'jannah' ),
							'id'   => 'breaking_arrows',
							'type' => 'checkbox',
					));

				echo '</div>';

			echo '</div><!-- advanced-block-settings -->';

				jannah_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['boxid'],
					array(
						'id'      => 'boxid',
						'default' => 'block_'.rand(200, 3500),
						'type'    => 'hidden'
					));


				# Visual Block Style Options
				if( ! empty( $_REQUEST['block_id'] ) ){ ?>
					<script>
						jQuery(document).ready(function(){
							$AddedBlock	= jQuery('#listItem_<?php echo esc_js( $section_id .'-'. $block_id ) ?>');
							$AddedBlock.find('input:checked').parent().addClass( 'selected' );
							$AddedBlock.find('.checkbox-select').click( function(event){
								event.preventDefault();
								$AddedBlock.find('li').removeClass('selected');
								$AddedBlock.find(':radio').removeAttr('checked');
								jQuery(this).parent().addClass('selected');
								jQuery(this).parent().find(':radio').attr('checked','checked');
							});
						});
					</script>
					<?php
				}
				?>
			</div> <!-- tie-block-options-group -->
		</div>
	</li>

	<?php
}


/*-----------------------------------------------------------------------------------*/
# Page Builder Blocks Styles Array
/*-----------------------------------------------------------------------------------*/
function jannah_builder_blocks_styles(){

	$blocks_path = 'blocks/';


	# Main Blocks ----------
	$builder_blocks_styles =
		array(
			'default'       => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '1' )  => array( 'block-blog'              => $blocks_path .'block-default.png',       'number' => 5 )),
			'li'            => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '2' )  => array( 'block-li'                => $blocks_path .'block-li.png',            'number' => 5 )),
			'1c'            => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '3' )  => array( 'block-1c'                => $blocks_path .'block-1c.png',            'number' => 5 )),
			'2c'            => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '4' )  => array( 'block-2c block-2c-cat'   => $blocks_path .'block-2c.png',            'number' => 4 )),
			'big_thumb'     => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '5' )  => array( 'block-big-thumb'         => $blocks_path .'block-big_thumb.png',     'number' => 6 )),
			'grid'          => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '6' )  => array( 'block-grid'              => $blocks_path .'block-grid.png',          'number' => 5 )),
			'row'           => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '7' )  => array( 'block-row'               => $blocks_path .'block-row.png',           'number' => 12 )),
			'tabs'          => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '8' )  => array( 'block-tabs'              => $blocks_path .'block-tabs.png',          'number' => 5 )),
			'mini'          => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '9' )  => array( 'block-mini'              => $blocks_path .'block-mini.png',          'number' => 6 )),
			'big'           => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '10' ) => array( 'block-big'               => $blocks_path .'block-big.png',           'number' => 4 )),
			'full_thumb'    => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '11' ) => array( 'block-full-thumb'        => $blocks_path .'block-full_thumb.png',    'number' => 3 )),
			'overlay-title' => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '12' ) => array( 'block-overlay-title'     => $blocks_path .'block-overlay-title.png', 'number' => 3 )),
			'content'       => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '13' ) => array( 'block-content'           => $blocks_path .'block-content.png',       'number' => 3 )),
			'timeline'      => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '14' ) => array( 'block-timeline'          => $blocks_path .'block-timeline.png',      'number' => 5 )),
			'first_big'     => array( sprintf( esc_html__( 'Block #%s', 'jannah' ), '15' ) => array( 'block-first-big'         => $blocks_path .'block-first_big.png',     'number' => 4 )),
			'scroll'        => array( sprintf( esc_html__( 'Scrolling #%s', 'jannah' ), '1' ) => array( 'block-scroll'         => $blocks_path .'block-scroll.png',        'number' => 6 )),
			'scroll_2'      => array( sprintf( esc_html__( 'Scrolling #%s', 'jannah' ), '2' ) => array( 'block-scroll2'        => $blocks_path .'block-scroll_2.png',      'number' => 6 )),
		);


	# Sliders ----------
	for( $slider = 1; $slider <= 16; $slider++ ){

		$slide_class 	= 'block-slider-container slider_'.$slider;
		$slide_img 		= $blocks_path .'block-slider_'. $slider.'.png';

		switch ($slider) {
			case 2:
			case 5:
			case 9:
			case 10:
				$number = 6;
				break;

			case 7:
			case 11:
			case 16:
				$number = 8;
				break;

			case 15:
				$number = 12;
				break;

			default:
				$number = 10;
				break;
		}


		$builder_blocks_styles[ 'slider_' . $slider ] = array( sprintf( esc_html__( 'Slider #%s', 'jannah' ), $slider ) => array( $slide_class => $slide_img, 'number' => $number ) );
	}


	# Slider Revolution ----------
	if( JANNAH_REVSLIDER_IS_ACTIVE ){
		$builder_blocks_styles['revslider'] = array( esc_html__( 'Slider Revolution', 'jannah' ) => array( 'block-sliders-plugins block-revslider' => $blocks_path .'block-revslider.png' ) );
	}

	# LayerSlider ----------
	if( JANNAH_LS_Sliders_IS_ACTIVE ){
		$builder_blocks_styles['lsslider'] = array( esc_html__( 'LayerSlider', 'jannah' ) => array( 'block-sliders-plugins block-lsslider' => $blocks_path .'block-lsslider.png' ) );
	}

	# Misc Blocks ----------
	$builder_blocks_styles +=
		array(
			'videos_list'   => array( esc_html__( 'Videos Playlist', 'jannah' ) => array( 'block-video-list'                              => $blocks_path .'block-videos_list.png' ) ),
			'breaking'      => array( esc_html__( 'News Ticker', 'jannah' )     => array( 'block-breaking'                                => $blocks_path .'block-breaking.png' ) ),
			'ad'            => array( esc_html__( 'Ad Block', 'jannah' )        => array( 'block-e3lan-1c-container block-e3lan'          => $blocks_path .'block-ad.png' ) ),
			'ad_50'         => array( esc_html__( 'Ad Block', 'jannah' )        => array( 'block-2c block-e3lan-2c-container block-e3lan' => $blocks_path .'block-ad_50.png' ) ),
			'code'          => array( esc_html__( 'Custom Content', 'jannah' )  => array( 'block-code-1c-container block-code'            => $blocks_path .'block-code.png' ) ),
			'code_50'       => array( esc_html__( 'Custom Content', 'jannah' )  => array( 'block-code-2c-container block-2c block-code'   => $blocks_path .'block-code_50.png' ) ),
		);


	# WooCommerce Block ----------
	if( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
		$builder_blocks_styles['woocommerce']        = array( sprintf( esc_html__( 'WooCommerce #%s', 'jannah' ), '1' ) => array( 'block-woocommerce-normal block-woocommerce' => $blocks_path .'block-woocommerce.png' ) );
		$builder_blocks_styles['woocommerce-slider'] = array( sprintf( esc_html__( 'WooCommerce #%s', 'jannah' ), '2' ) => array( 'block-woocommerce-slider block-woocommerce' => $blocks_path .'block-woocommerce-slider.png' ) );
	}

	return $builder_blocks_styles;
}




/*-----------------------------------------------------------------------------------*/
# Page Builder
/*-----------------------------------------------------------------------------------*/
add_action( 'edit_form_after_title', 'jannah_add_page_builder' );
function jannah_add_page_builder(){

	$post_id = get_the_id();

	$builder_active = false;
	$sections       = false;
	$builder_style  = '';
	$current_page   = get_current_screen();
	$inactive_text  = $button_text = esc_html__( 'Use the TieLabs Builder', 'jannah' );
	$active_text    =  esc_html__( 'Use the Default Editor', 'jannah' );

	if( get_post_type( $post_id ) != 'page' || $current_page->post_type != 'page' ){
		return;
	}

	# Get the stored Blocks ----------
	if( $sections = jannah_get_postdata( 'tie_page_builder') ){
		$sections = maybe_unserialize( $sections );
	}

	$button_class = 'button-primary';

	if( jannah_get_postdata( 'tie_builder_active' )){
		$builder_active = 'yes';
		$button_class   = "builder_active button-secondary";
		$builder_style  = 'display:block;';
		$button_text    = $active_text;
	}
	?>

	<a class="tie-primary-button button button-hero <?php echo esc_attr( $button_class ) ?>" data-builder="<?php echo esc_attr( $active_text ) ?>" data-editor="<?php echo esc_attr( $inactive_text ) ?>" href="" id="tie-page-builder-button"><?php echo esc_html( $button_text ); ?></a>

	<input type="hidden" id="tie_builder_active" name="tie_builder_active" value="<?php echo esc_attr( $builder_active ) ?>">


	<div id="tie-page-builder" style="<?php echo esc_attr( $builder_style ) ?>">

		<div class="tie-page-builder postbox">

			<div id="tie-page-overlay"></div>

			<ul id="tie-builder-wrapper">
				<?php

					$section_id = $block_id = 1;
					if( ! empty( $sections ) && is_array( $sections ) ){
						foreach( $sections as $section ){
							jannah_get_builder_section( $section_id, $section );
							$section_id++;
						}
					}
				?>

			</ul><!-- #tie-builder-wrapper -->

			<?php
				jannah_builder_widgets( $sections );
			?>


			<div class="tie-add-new-section-wrapper">
				<div class="tie-loading-container">
					<div class="tie-saving-settings">
						<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
							<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
							<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
							<path class="checkmark__error_1" d="M38 38 L16 16 Z"/>
							<path class="checkmark__error_2" d="M16 38 38 16 Z" />
						</svg>
					</div>
				</div>

				<a href="#" data-sections="<?php echo esc_attr( $section_id ) ?>" data-post="<?php echo get_the_id(); ?>" class="tie-add-new-section"><span class="dashicons dashicons-plus"></span> <?php esc_html_e( 'Add Section', 'jannah' ) ?></a>
			</div>



			<script>
				var tie_block_id = <?php echo ! empty( $GLOBALS['tie_block_id'] ) ? esc_js( $GLOBALS['tie_block_id'] ) : 1; ?>;
			</script>
		</div><!-- .tie-page-builder /-->
	</div><!-- #tie-page-builder /-->
	<?php
}

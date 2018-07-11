<?php
/**
 * Form elements options
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*-----------------------------------------------------------------------------------*/
# Build The options
/*-----------------------------------------------------------------------------------*/
function jannah_build_option( $value, $option_name, $data ){

	$value = wp_parse_args( $value, array(
		'class'   => '',
		'columns' => '',
	));

	extract( $value );

	// Get the option ID ----------
	$item_id      = '';
	$item_id_attr = '';
	$item_id_wrap = '';

	if( ! empty( $prefix )){
		$item_id .= $prefix.'-';
	}

	if( ! empty( $id ) ){
		$item_id .= $id;
	}

	if( ! empty( $item_id ) ){
		$item_id_attr = 'id="'. $item_id .'"';
		$item_id_wrap = 'id="'. $item_id .'-item"';
	}

	// Get the option class ----------
	$custom_class = '';
	if( ! empty( $class ) ){
		$custom_class = ' '. $class .'-options';
	}

	//Placeholder ----------
	$placeholder_attr = '';
	if( ! empty( $placeholder ) ){
		$placeholder_attr = "placeholder=\"$placeholder\"";
	}

	//Name ----------
	$name_attr = 'name="'. $option_name .'"';


	//Get the option stored data ----------
	$current_value = '';
	if( ! empty( $data ) ){
		$current_value =  $data;
	}
	elseif( ! empty( $default ) ){
		$current_value = $default;
	}

	//options without .option-item wrapper ----------
	if( ! empty( $type ) ){

		//Title ----------
		if( $type == 'header' ){
			echo "<h3 $item_id_attr class=\"tie-section-title$custom_class\">$title</h3>";
			return;
		}

		//Title ----------
		if( $type == 'tab-title' ){
			echo "<div class=\"tie-tab-head\"><h2>$title</h2>";

			do_action( 'jannah_save_button' );

			echo "<div class=\"clear\"></div></div>";

			return;
		}

	 	//Message ----------
		if( $type == 'message' || $type == 'error' ){

			$custom_class .= " tie-message-hint";
			if( $type == 'error' ){
				$custom_class .= " tie-message-error";
			}

			echo "<p $item_id_wrap class=\"$custom_class\">$text</p>";
			return;
		}

		//Hidden ----------
		if( $type == 'hidden' ){
			echo "<input $name_attr type=\"hidden\" value=\"". esc_attr($current_value) ."\">";
			return;
		}
	}

	echo "<div $item_id_wrap class=\"option-item$custom_class\">";

	if( ! empty( $pre_text ) ){
		echo "<div class=\"tie-option-pre-label\">$pre_text</div><div class=\"clear\"></div>";
	}

	if( ! empty( $name ) ){
		echo "<span class=\"tie-label\">$name</span>";
	}

	//Options Type ----------
	switch ( $type ){


		//Text Option ----------
		case 'text':
			echo"<input $item_id_attr $name_attr type=\"text\" value=\"". esc_attr($current_value) ."\" $placeholder_attr>";
		break;


		//Array Option ----------
		case 'arrayText':
			$single_name 	= $option_name.'['. $key .']';

			$current_item_value = '';
			if( ! empty( $current_value[ $key ] ) ){
				$current_item_value	= $current_value[ $key ];
			}

			echo"<input name=\"$single_name\" type=\"text\" value=\"$current_item_value\" $placeholder_attr>";
		break;


		//number Option ----------
		case 'number':
			echo"<input style=\"width:60px\" min=\"0\" max=\"1000\" $item_id_attr $name_attr type=\"number\" value=\"". esc_attr($current_value) ."\" $placeholder_attr>";
		break;


		//Checkbox Option ----------
		case 'checkbox':

			$checked = checked( $data, 'true', false );

			$toggle_data  = ! empty( $toggle ) ? "data-tie-toggle=\"$toggle\"" : '';
			$toggle_class = ! empty( $toggle ) ? "tie-toggle-option" : '';

			echo "<input $item_id_attr $name_attr class=\"tie-js-switch $toggle_class\" $toggle_data type=\"checkbox\" value=\"true\" $checked>";
		break;


		//Radio Option ----------
		case 'radio':
			echo "<div class=\"option-contents\">";
				$i = 0;
				foreach ( $options as $option_key => $option ){
					$i++;

					$checked = '';
					if ( ( ! empty(  $data ) && $data == $option_key ) || ( empty( $data ) && $i==1 ) ){
						$checked = "checked=\"checked\"";
					}

					echo "<label><input $item_id_attr $name_attr $checked type=\"radio\" value=\"$option_key\"> $option</label>";

				}
			echo "</div>
			<div class=\"clear\"></div>";

			if( ! empty( $toggle ) ){ ?>
				<script>
					jQuery(document).ready(function(){
						jQuery( '.<?php echo esc_js( $item_id ) ?>-options' ).hide();
						<?php
						if( ! empty( $toggle[ $data ] )){ ?>
							jQuery( '<?php echo esc_js( $toggle[ $data ] ) ?>' ).show();
						<?php
						}elseif( is_array( $toggle ) ){
							$first_elem = reset( $toggle ) ?>
							jQuery( '<?php echo esc_js( $first_elem ) ?>' ).show();
						<?php
						}
						?>
						jQuery("input[name='<?php echo esc_js( $option_name ) ?>']").change(function(){
							selected_val = jQuery( this ).val();
							jQuery( '.<?php echo esc_js( $item_id ) ?>-options' ).slideUp('fast');
							<?php
								foreach( $toggle as $tg_item_name => $tg_item_id ){
									if( ! empty( $tg_item_id ) ){ ?>

										if ( selected_val == '<?php echo esc_js( $tg_item_name ) ?>'){
											jQuery( '<?php echo esc_js( $tg_item_id ) ?>' ).slideDown('fast');
										}
									<?php
									}
								}
							?>
						 });
					});
				</script>
			<?php
			}
		break;


		//Select Menu Option ----------
		case 'select':
			echo "<div class=\"tie-custom-select\"><select $item_id_attr $name_attr>";
				$i = 0;
				if( ! empty( $options ) && is_array( $options )){
					foreach ( $options as $option_key => $option ){
						$i++;

						$selected = '';
						if ( ( ! empty(  $data ) && $data == $option_key ) || ( empty( $data ) && $i==1 ) ){
							$selected = 'selected="selected"';
						}

						echo"<option value=\"$option_key\" $selected>$option</option>";
					}
				}
			echo"</select></div>";

			if( ! empty( $toggle ) ){ ?>
			<script>
				jQuery(document).ready(function(){
					jQuery( '.<?php echo esc_js( $item_id ) ?>-options' ).hide();

					<?php
					if( ! empty( $toggle[ $data ] )){ ?>
						jQuery( '<?php echo esc_js( $toggle[ $data ] ) ?>' ).show();
					<?php
					}elseif( is_array( $toggle ) ){
						$first_elem = reset( $toggle ) ?>
						jQuery( '<?php echo esc_js( $first_elem ) ?>' ).show();
					<?php
					}
					?>

					jQuery("select[name='<?php echo esc_js( $option_name ) ?>']").change(function(){
						selected_val = jQuery( this ).val();
						jQuery( '.<?php echo esc_js( $item_id ) ?>-options' ).slideUp('fast');

						<?php
						foreach( $toggle as $tg_item_name => $tg_item_id ){
							if( ! empty( $tg_item_id ) ){ ?>
								if ( selected_val == '<?php echo esc_js( $tg_item_name ) ?>'){
									jQuery( '<?php echo esc_js( $tg_item_id ) ?>' ).slideDown('fast');
								}
							<?php
							}
						}

						?>
					 });
				});
			</script>
			<?php
			}
		break;


		//Select Menu Option ----------
		case 'select-multiple':
			$single_name = $option_name.'[]';

			echo"<select name=\"$single_name\" $item_id_attr multiple=\"multiple\">";

				$data = maybe_unserialize( $data );

				$i = 0;
				foreach ( $options as $option_key => $option){
					$selected = '';
					if ( ( ! empty( $data ) && !is_array( $data ) && $data == $option_key ) || ( ! empty( $data) && is_array($data) && in_array( $option_key , $data ) ) || ( empty( $data ) && $i==1 ) ){
						$selected = ' selected="selected"';
					}

					echo"<option value=\"$option_key\" $selected>$option</option>";
				}
			echo"</select>";
		break;


		//Textarea Option ----------
		case 'textarea':

			$textarea_data = '';
			if( ! empty( $data ) ){
				$textarea_data = esc_textarea( $data );
			}
			echo"<textarea $item_id_attr $name_attr type=\"textarea\" rows=\"3\">$textarea_data</textarea>";
		break;


		//Upload Option ----------
		case 'upload':
			$button_id 		 = 'upload_'.$item_id.'_button';
			$preview_id 	 = $item_id.'-preview';
			$upload_button = esc_html__( 'Upload', 'jannah' );

			echo"<div class=\"image-preview-wrapper\">
			<input $item_id_attr $name_attr class=\"tie-img-path\" type=\"text\" value=\"". esc_attr($current_value) ."\" $placeholder_attr>
			<input id=\"$button_id\" type=\"button\" class=\"tie-upload-img button\" value=\"$upload_button\">";

			if( ! empty( $hint ) ){
				echo"<span class=\"extra-text\">$hint</span>";
			}

			echo'</div>';

			$image_preview = JANNAH_TEMPLATE_URL.'/framework/admin/assets/images/empty.png';
			$hide_preview  = 'style="display:none"';

			if( ! empty( $data ) ){
				$hide_preview  = '';
				$image_preview = $data;
			}

			echo"
			<div id=\"$preview_id\" class=\"img-preview\" $hide_preview>
				<img src=\"$image_preview\" alt=\"\">
				<a class=\"del-img\"></a>
			</div>
			<div class=\"clear\"></div>";

		break;


		//Color Option ----------
		case 'color':

			$custom_color_class = 'tieColorSelector';
			if( ! empty( $color_class ) ){
				$custom_color_class = $color_class;
			}

			$theme_color = jannah_get_option( 'global_color', '#000000' );
			echo "<span class=\"tie-custom-color-picker\"><input class=\"$custom_color_class\" data-palette=\"$theme_color, #9b59b6, #3498db, #2ecc71, #f1c40f, #34495e, #e74c3c\"  style=\"width:80px;\" $item_id_attr $name_attr type=\"text\" value=\"$data\"></span>";

		break;


		//Editor Option ----------
		case 'editor':

			$editor_id = $item_id;
			$settings  = array(
				'textarea_name' => $option_name,
				'editor_height' => '400px',
				'media_buttons' => false );

			wp_editor( $data, $editor_id, $settings );
		break;


		//Visual Option ----------
		case 'visual':

			if( ! empty( $columns )){
				$columns = 'tie-options-'.$columns.'col';
			}

			echo "<ul id=\"tie_$item_id\" class=\"tie-options $columns\">";

				$i = 0;
				$images_path = JANNAH_TEMPLATE_URL .'/framework/admin/assets/images/';

				foreach ( $options as $option_key => $option ){
					$i++;

					$checked = '';
					if( ( ! empty( $data ) && $data == $option_key ) || ( empty( $data ) && $i==1 ) ){
						$checked = "checked=\"checked\"";
					}

					echo"
						<li class=\"visual-option-$option_key\">
							<input $name_attr type=\"radio\" value=\"$option_key\" $checked>
							<a class=\"checkbox-select\" href=\"#\">";

								if( is_array( $option ) ){
									foreach ( $option as $description => $img_data ){

										if( is_array( $img_data ) ){

											$img_value = reset( $img_data );
											$key = key($img_data);
											unset( $img_data[ $key ] );

											$data_attr = '';
											if( !empty( $img_data ) && is_array( $img_data ) ){
												foreach ($img_data as $data_name => $data_value) {
													$data_attr = ' data-'. $data_name .'="'. $data_value .'"';
												}
											}

											echo "<img class=\"$key\" $data_attr src=\"$images_path$img_value\">";

										}
										else{
											echo "<img src=\"$images_path$img_data\">";
										}

										if( ! empty( $description ) ){
											echo "<span>$description</span>";
										}

									}
								}
								else{
									echo "<img src=\"$images_path$option\">";
								}

							echo "</a>
						</li>";

				}

			echo"</ul>";

			if( ! empty( $toggle ) ){ ?>
				<script>
					jQuery(document).ready(function(){
						jQuery( '.<?php echo esc_js( $item_id ) ?>-options' ).hide();
						<?php
						if( ! empty( $toggle[ $data ] )){ ?>
							jQuery( '<?php echo esc_js( $toggle[ $data ] ) ?>' ).show();
						<?php
						}elseif( is_array( $toggle ) ){
							$first_elem = reset( $toggle ) ?>
							jQuery( '<?php echo esc_js( $first_elem ) ?>' ).show();
						<?php
						}
						?>

					jQuery(document).on( 'click', '#tie_<?php echo esc_js( $item_id ) ?> a', function(){
							selected_val = jQuery( this ).parent().find( 'input' ).val();
							jQuery( '.<?php echo esc_js( $item_id ) ?>-options' ).hide();
							<?php
								foreach( $toggle as $tg_item_name => $tg_item_id ){
									if( ! empty( $tg_item_id ) ){ ?>
										if ( selected_val == '<?php echo esc_js( $tg_item_name ) ?>'){
											jQuery( '<?php echo esc_js( $tg_item_id ) ?>' ).slideDown('fast');
										}
									<?php
									}
								}
							?>
						 });
					});
				</script>
			<?php
			}
		break;


		// Typography Option ----------
		case 'typography':
			$current_value = $data;

			$current_value = wp_parse_args( $current_value, array(
				'size'        => '',
				'line_height' => '',
				'weight'      => '',
				'transform' 	=> '',
			));
			?>

			<div class="tie-custom-select typography-custom-slelect">
				<select name="<?php echo esc_attr( $option_name ) ?>[size]" id="<?php echo esc_attr( $id ) ?>[size]">

					<option <?php selected( $current_value['size'], '' ); ?> <?php disabled(1,1); ?>><?php esc_html_e( 'Font Size in Pixels', 'jannah' ); ?></option>
					<option value=""><?php esc_html_e( 'Default', 'jannah' ); ?></option>
					<?php for( $i=7 ; $i<61 ; $i++){ ?>
						<option value="<?php echo esc_attr( $i ) ?>" <?php selected( $current_value['size'], $i ); ?>><?php echo esc_html( $i ) ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="tie-custom-select typography-custom-slelect">
				<select name="<?php echo esc_attr( $option_name ) ?>[line_height]" id="<?php echo esc_attr( $id ) ?>[line_height]">

					<option <?php selected( $current_value['line_height'], '' ); ?> <?php disabled(1,1); ?>><?php esc_html_e( 'Line Height', 'jannah' ); ?></option>
					<option value=""><?php esc_html_e( 'Default', 'jannah' ); ?></option>

					<?php for( $i=10 ; $i<=60 ; $i+=0.5 ){ ?>
						<option value="<?php echo esc_attr( $i/10 ) ?>" <?php selected( $current_value['line_height'], ($i/10) ); ?>><?php echo number_format_i18n( $i/10 , 2 )?></option>
					<?php } ?>
				</select>
			</div>

			<div class="tie-custom-select typography-custom-slelect">
				<select name="<?php echo esc_attr( $option_name ) ?>[weight]" id="<?php echo esc_attr( $id ) ?>[weight]">
					<option <?php selected( $current_value['weight'], '' ); ?> <?php disabled(1,1); ?>><?php esc_html_e( 'Font Weight', 'jannah' ); ?></option>
					<option value=""><?php esc_html_e( 'Default', 'jannah' ); ?></option>
					<option value="100" <?php selected( $current_value['weight'], 100 ); ?>><?php esc_html_e( 'Thin 100',        'jannah' ); ?></option>
					<option value="200" <?php selected( $current_value['weight'], 200 ); ?>><?php esc_html_e( 'Extra 200 Light', 'jannah' ); ?></option>
					<option value="300" <?php selected( $current_value['weight'], 300 ); ?>><?php esc_html_e( 'Light 300',       'jannah' ); ?></option>
					<option value="400" <?php selected( $current_value['weight'], 400 ); ?>><?php esc_html_e( 'Regular 400',     'jannah' ); ?></option>
					<option value="500" <?php selected( $current_value['weight'], 500 ); ?>><?php esc_html_e( 'Medium 500',      'jannah' ); ?></option>
					<option value="600" <?php selected( $current_value['weight'], 600 ); ?>><?php esc_html_e( 'Semi 600 Bold',   'jannah' ); ?></option>
					<option value="700" <?php selected( $current_value['weight'], 700 ); ?>><?php esc_html_e( 'Bold 700',        'jannah' ); ?></option>
					<option value="800" <?php selected( $current_value['weight'], 800 ); ?>><?php esc_html_e( 'Extra 800 Bold',  'jannah' ); ?></option>
					<option value="900" <?php selected( $current_value['weight'], 900 ); ?>><?php esc_html_e( 'Black 900',       'jannah' ); ?></option>
				</select>
			</div>

			<div class="tie-custom-select typography-custom-slelect">
				<select name="<?php echo esc_attr( $option_name ) ?>[transform]" id="<?php echo esc_attr( $id ) ?>[transform]">

					<option <?php selected( $current_value['transform'], '' ); ?> <?php disabled(1,1); ?>><?php esc_html_e( 'Capitalization', 'jannah' ); ?></option>
					<option value=""><?php esc_html_e( 'Default', 'jannah' ); ?></option>
					<option value="uppercase"  <?php selected( $current_value['transform'], 'uppercase' ); ?>><?php esc_html_e( 'UPPERCASE',  'jannah' ); ?></option>
					<option value="capitalize" <?php selected( $current_value['transform'], 'capitalize' );?>><?php esc_html_e( 'Capitalize', 'jannah' ); ?></option>
					<option value="lowercase"  <?php selected( $current_value['transform'], 'lowercase' ); ?>><?php esc_html_e( 'lowercase',  'jannah' ); ?></option>
				</select>
			</div>
			<?php
		break;


		// Fonts Option ----------
		case 'fonts':
    	echo "<input $name_attr id=\"". esc_attr( $item_id ) ."\" class=\"tie-select-font\" type=\"text\" value=\"". esc_attr( $current_value ) ."\">";
		break;


		// Background Option ----------
		case 'background':

			$current_value = maybe_unserialize( $current_value );
			?>

			<input id="<?php echo esc_attr( $item_id ) ?>-img" class="tie-img-path tie-background-path" type="text" size="56" name="<?php echo esc_attr( $option_name ) ?>[img]" value="<?php if( ! empty( $current_value['img'] )) echo esc_attr( $current_value['img'] ) ?>">
			<input id="upload_<?php echo esc_attr( $item_id ) ?>_button" type="button" class="button" value="<?php esc_html_e( 'Upload', 'jannah' )  ?>">

			<div class="tie-background-options">

				<select name="<?php echo esc_attr( $option_name ) ?>[repeat]" id="<?php echo esc_attr( $item_id ) ?>[repeat]">
					<option value=""></option>
					<option value="no-repeat" <?php if( ! empty($current_value['repeat'])) selected( $current_value['repeat'], 'no-repeat' ) ?>><?php esc_html_e( 'no-repeat', 'jannah' )         ?></option>
					<option value="repeat"    <?php if( ! empty($current_value['repeat'])) selected( $current_value['repeat'], 'repeat'    ) ?>><?php esc_html_e( 'Tile', 'jannah' )              ?></option>
					<option value="repeat-x"  <?php if( ! empty($current_value['repeat'])) selected( $current_value['repeat'], 'repeat-x'  ) ?>><?php esc_html_e( 'Tile Horizontally', 'jannah' ) ?></option>
					<option value="repeat-y"  <?php if( ! empty($current_value['repeat'])) selected( $current_value['repeat'], 'repeat-y'  ) ?>><?php esc_html_e( 'Tile Vertically', 'jannah' )   ?></option>
				</select>

				<select name="<?php echo esc_attr( $option_name ) ?>[attachment]" id="<?php echo esc_attr( $item_id ) ?>[attachment]">
					<option value=""></option>
					<option value="fixed"  <?php if( ! empty($current_value['attachment'])) selected( $current_value['attachment'], 'fixed'  ) ?>><?php esc_html_e( 'Fixed', 'jannah' )  ?></option>
					<option value="scroll" <?php if( ! empty($current_value['attachment'])) selected( $current_value['attachment'], 'scroll' ) ?>><?php esc_html_e( 'Scroll', 'jannah' ) ?></option>
					<option value="cover"  <?php if( ! empty($current_value['attachment'])) selected( $current_value['attachment'], 'cover'  ) ?>><?php esc_html_e( 'Cover', 'jannah' )  ?></option>
				</select>

				<select name="<?php echo esc_attr( $option_name ) ?>[hor]" id="<?php echo esc_attr( $item_id ) ?>[hor]">
					<option value=""></option>
					<option value="left"   <?php if( ! empty($current_value['hor'])) selected( $current_value['hor'], 'left'   ) ?>><?php esc_html_e( 'Left', 'jannah' )   ?></option>
					<option value="right"  <?php if( ! empty($current_value['hor'])) selected( $current_value['hor'], 'right'  ) ?>><?php esc_html_e( 'Right', 'jannah' )  ?></option>
					<option value="center" <?php if( ! empty($current_value['hor'])) selected( $current_value['hor'], 'center' ) ?>><?php esc_html_e( 'Center', 'jannah' ) ?></option>
				</select>

				<select name="<?php echo esc_attr( $option_name ) ?>[ver]" id="<?php echo esc_attr( $item_id ) ?>[ver]">
					<option value=""></option>
					<option value="top"    <?php if( ! empty($current_value['ver'])) selected( $current_value['ver'], 'top'    ) ?>><?php esc_html_e( 'Top', 'jannah' )    ?></option>
					<option value="bottom" <?php if( ! empty($current_value['ver'])) selected( $current_value['ver'], 'bottom' ) ?>><?php esc_html_e( 'Bottom', 'jannah' ) ?></option>
					<option value="center" <?php if( ! empty($current_value['ver'])) selected( $current_value['ver'], 'center' ) ?>><?php esc_html_e( 'Center', 'jannah' ) ?></option>
				</select>
			</div>

			<div id="<?php echo esc_attr( $item_id ) ?>-preview" class="img-preview" <?php if( empty( $current_value['img'] )) echo 'style="display:none;"' ?>>
				<img src="<?php if( ! empty($current_value['img'] )) echo esc_attr( $current_value['img'] ) ; else echo JANNAH_TEMPLATE_URL.'/framework/admin/assets/images/empty.png'; ?>" alt="">
				<a class="del-img" title="<?php esc_html_e( 'Remove', 'jannah' ) ?>"></a>
			</div>
			<?php
		break;

	}

	if( ! empty( $hint ) && $type != 'upload' ){
		echo "<span class=\"extra-text\">$hint</span>";
	}
	?>

	</div>
<?php
}

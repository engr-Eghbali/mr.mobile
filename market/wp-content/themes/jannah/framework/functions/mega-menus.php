<?php
/**
 * Mega menus module
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if( ! class_exists( 'jannah_mega_menu_walker' )){

	class jannah_mega_menu_walker extends Walker_Nav_Menu {

		private $tie_megamenu_tiny_text     = '';
		private $tie_megamenu_tiny_bg       = '';
		private $tie_megamenu_type          = '';
		private $tie_megamenu_icon          = '';
		private $tie_megamenu_image         = '';
		private $tie_megamenu_position      = '';
		private $tie_megamenu_position_y    = '';
		private $tie_megamenu_repeat        = '';
		private $tie_megamenu_min_height    = '';
		private $tie_megamenu_padding_left  = '';
		private $tie_megamenu_padding_right = '';
		private $tie_megamenu_media_overlay = '';
		private $tie_megamenu_icon_only     = '';
		private $tie_megamenu_hide_headings  = '';
		private $tie_has_children           = '';

		/**
		 * Starts the list before the elements are added.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ){
			$indent = str_repeat("\t", $depth);

			if( $depth === 0 && $this->tie_megamenu_type == 'links' ){

				$output .= "\n$indent<ul class=\"sub-menu-columns\">\n";
			}
			elseif( $depth === 1 && $this->tie_megamenu_type == 'links' ){

				$output .= "\n$indent<ul class=\"sub-menu-columns-item\">\n";
			}
			elseif( $depth === 0 && ( $this->tie_megamenu_type == 'sub-posts' || $this->tie_megamenu_type == 'sub-hor-posts' ) ){

				$output .= "\n$indent<ul class=\"sub-menu mega-cat-more-links\">\n";
			}
			elseif( $depth === 0 && $this->tie_megamenu_type == 'recent' ){

				$output .= "\n$indent<ul class=\"mega-recent-featured-list sub-list\">\n";
			}
			else{

				$output .= "\n$indent<ul class=\"sub-menu menu-sub-content\">\n";
			}
		}


		/**
		 * Ends the list of after the elements are added.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ){

			$indent  = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}


		/**
		 * Start the element output.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){

			$indent    = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;


		//By TieLabs ===========

			/**
			 * Filter the CSS class(es) applied to a menu item's <li>.
			 */
			$class_names = join( " " , apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

			if( is_single() || is_category() ){
				$class_names = str_replace( 'current-menu-ancestor', '', $class_names );
			}

			if( is_single() ){
				if( strpos( $class_names, 'current-post-ancestor' ) !== false ){
					$primary_id = jannah_get_primary_category_id();
					if( ! empty( $item->object ) && $item->object == 'category' && ! empty( $item->object_id ) && $item->object_id != $primary_id ){
						$class_names = str_replace( 'current-post-ancestor', '', $class_names );
					}
				}
			}


			$a_class = $item_output = $item_data_id = '';

			// Define the mega vars
			if( $depth === 0 ){

				$this->tie_has_children = 0;

				if( ! empty( $args->has_children ) ){
					$this->tie_has_children           = $args->has_children;
				}

				$this->tie_megamenu_type          = get_post_meta( $item->ID, 'tie_megamenu_type',          true );
				$this->tie_megamenu_columns       = get_post_meta( $item->ID, 'tie_megamenu_columns',       true );
				$this->tie_megamenu_image         = get_post_meta( $item->ID, 'tie_megamenu_image',         true );
				$this->tie_megamenu_position      = get_post_meta( $item->ID, 'tie_megamenu_position',      true );
				$this->tie_megamenu_position_y    = get_post_meta( $item->ID, 'tie_megamenu_position_y',    true );
				$this->tie_megamenu_repeat        = get_post_meta( $item->ID, 'tie_megamenu_repeat',        true );
				$this->tie_megamenu_min_height    = get_post_meta( $item->ID, 'tie_megamenu_min_height',    true );
				$this->tie_megamenu_padding_left  = get_post_meta( $item->ID, 'tie_megamenu_padding_left',  true );
				$this->tie_megamenu_padding_right = get_post_meta( $item->ID, 'tie_megamenu_padding_right', true );
				$this->tie_megamenu_media_overlay = get_post_meta( $item->ID, 'tie_megamenu_media_overlay', true );
				$this->tie_megamenu_icon_only     = get_post_meta( $item->ID, 'tie_megamenu_icon_only',     true );
				$this->tie_megamenu_hide_headings = get_post_meta( $item->ID, 'tie_megamenu_hide_headings', true );

			}

			$this->tie_megamenu_tiny_text = get_post_meta( $item->ID, 'tie_megamenu_tiny_text', true );
			$this->tie_megamenu_tiny_bg   = get_post_meta( $item->ID, 'tie_megamenu_tiny_bg',   true );
			$this->tie_megamenu_icon      = get_post_meta( $item->ID, 'tie_megamenu_icon',      true );

			//Menu Item has an icon
			if( $depth === 0 && ! empty( $this->tie_megamenu_icon ) ){
				$class_names .= ' menu-item-has-icon';
			}

			//Menu Item has icon only
			if( $depth === 0 && ! empty( $this->tie_megamenu_icon_only ) ){
				$class_names .= ' is-icon-only';
			}

			//Menu Classes
			if( $depth === 0 && ! empty( $this->tie_megamenu_type ) && $this->tie_megamenu_type != 'disable' ){
				$class_names .= ' mega-menu';

				if( ( $this->tie_megamenu_type == 'sub-posts' || $this->tie_megamenu_type == 'sub-hor-posts' ) &&  $item->object == 'category' ){

					$class_names .= ' mega-cat ';

					if( ! empty( $item->object_id ) ){
						$item_data_id = " data-id=\"$item->object_id\" ";
					}

				}elseif( $this->tie_megamenu_type == 'links' ){

					$columns     = ( ! empty( $this->tie_megamenu_columns ) ? $this->tie_megamenu_columns :  2 );
					$class_names  .= ' mega-links mega-links-'.$columns.'col ';

				}elseif( $this->tie_megamenu_type == 'recent' &&  $item->object == 'category'  ){

					$class_names .= ' mega-recent-featured ';

					if( ! empty( $item->object_id ) ){
						$item_data_id = " data-id=\"$item->object_id\" ";
					}

				}
			}

			if( $depth === 1 && $this->tie_megamenu_type == 'links' ){
				$class_names .= ' mega-link-column ';
				$a_class      = ' class="mega-links-head';

				if( ! empty( $this->tie_megamenu_hide_headings ) ){
					$a_class .= ' hide-mega-headings';
				}

				$a_class .= '" ';
			}

		// =====================

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's <li>.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			//$output .= $indent . '<li' . $id . $class_names . $item_data_id .'>';

			$output .= sprintf( '%s<li%s%s%s%s>',
				$indent,
				$id,
				$class_names,
				$item_data_id,
				in_array( 'menu-item-has-children', $item->classes ) ? ' aria-haspopup="true" aria-expanded="false" tabindex="0"' : ''
			);

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

			/**
			 * Filter the HTML attributes applied to a menu item's <a>.
			 *
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ){
				if ( ! empty( $value ) ){
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			if( ! empty( $args->before ) ){
				$item_output = $args->before;
			}

			$item_output .= '<a'.$a_class . $attributes .'>';

			if( ! empty( $this->tie_megamenu_icon ) || ( $depth === 0 && ! empty( $this->tie_megamenu_icon_only )) ){

				$tie_megamenu_icon = 'fa-exclamation-triangle';
				if( ! empty( $this->tie_megamenu_icon ) ){
					$tie_megamenu_icon = $this->tie_megamenu_icon;
				}

				$item_output .= ' <span aria-hidden="true" class="fa '.$tie_megamenu_icon.'"></span> ';

			}elseif( $depth === 2 && $this->tie_megamenu_type == 'links' ){

				$item_output .= ' <span aria-hidden="true" class="mega-links-default-icon"></span>';
			}

			$menu_item = apply_filters( 'the_title', $item->title, $item->ID );


			if( $depth === 0 && ! empty( $this->tie_megamenu_icon_only ) ){
				$menu_item = ' <span class="screen-reader-text">'. $menu_item .'</span>';
			}


			# Tiny Text ----------
			if( $this->tie_megamenu_tiny_text ){

				$label_bg = '';
				if( $this->tie_megamenu_tiny_bg ){
					$text_color = jannah_light_or_dark( $this->tie_megamenu_tiny_bg );
					$label_bg   = 'style="background-color:'.$this->tie_megamenu_tiny_bg.'; color:'.$text_color.'"';
				}

				$label_class = ( strlen( $this->tie_megamenu_tiny_text ) == 1 ) ? 'menu-tiny-circle' : '';
				$menu_item  .= ' <small class="menu-tiny-label '. $label_class .'" '.$label_bg.'>'. $this->tie_megamenu_tiny_text .'</small>';
			}


			/** This filter is documented in wp-includes/post-template.php */
			$item_output .= $args->link_before . $menu_item . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;


		//By TieLabs ===========
			if( $depth === 0 && ! empty( $this->tie_megamenu_type ) && $this->tie_megamenu_type != 'disable' ){

				$style = '';
				if ( ! empty( $this->tie_megamenu_image )){

					$style .= " background-image: url($this->tie_megamenu_image) ; background-position: $this->tie_megamenu_position_y $this->tie_megamenu_position ; background-repeat: $this->tie_megamenu_repeat ; ";
				}

				if ( ! empty( $this->tie_megamenu_padding_left ) ){

					$padding_left = $this->tie_megamenu_padding_left;
					if ( strpos( $padding_left , 'px' ) === false && strpos( $padding_left , '%' ) === false ) $padding_left .= 'px';
					$style .= " padding-left : $padding_left; ";
				}

				if ( ! empty( $this->tie_megamenu_padding_right ) ){

					$padding_right = $this->tie_megamenu_padding_right;
					if ( strpos( $padding_right , 'px' ) === false && strpos( $padding_right , '%' ) === false ) $padding_right .= 'px';
					$style .= " padding-right : $padding_right; ";
				}

				if ( ! empty( $this->tie_megamenu_min_height ) ){

					$min_height = $this->tie_megamenu_min_height;
					if ( strpos( $min_height , 'px' ) === false ) $min_height .= 'px';
					$style .= " min-height : $min_height; ";
				}

				if ( ! empty( $style ) ) $style=' style="'. $style .'"';

				$item_output .="\n<div class=\"mega-menu-block menu-sub-content\"$style>\n";
			}

		// =====================

			/**
			 * Filter a menu item's starting output.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}


		/**
		 * Ends the element output, if needed.
		 */
		public function end_el( &$output, $item, $depth = 0, $args = array() ){

		//By TieLabs ===========
			if( $depth === 0 && ! empty( $this->tie_megamenu_type ) && $this->tie_megamenu_type != 'disable' ){

				if( $this->tie_megamenu_type != 'links' ){
					$media_icon = '';
					if( ! empty( $this->tie_megamenu_media_overlay ) ){
							$media_icon = ' media-overlay';
					}

					$output .="\n<div class=\"mega-menu-content$media_icon\">\n";
				}

			//Sub Categories ===============================================================
				if( ( $this->tie_megamenu_type == 'sub-posts' || $this->tie_megamenu_type == 'sub-hor-posts' ) &&  $item->object == 'category' ){

					$no_sub_categories = $sub_categories_exists = $sub_categories = '';

					$query_args = array(
						'child_of'  => $item->object_id,
					);

					$sub_categories = get_categories( $query_args );

					//Check if the Category doesn't contain any sub categories.
					if( count($sub_categories) == 0){

						$sub_categories   = array( $item->object_id ) ;
						$no_sub_categories  = true ;

					}else{

						$sub_categories_exists = ' mega-cat-sub-exists';
					}


					//Horizontal sub categories filter ----------
					if( $this->tie_megamenu_type == 'sub-hor-posts' ){
						$sub_categories_exists .= ' horizontal-posts';
						$sub_categories_type     = ' cats-horizontal';
					}
					//Vertical sub categories filter ----------
					else{
						$sub_categories_exists .= ' vertical-posts';
						$sub_categories_type = ' cats-vertical';
					}

					$output .= "<div class=\"mega-cat-wrapper\">\n";

					if( !$no_sub_categories ){

						$output .= "<ul class=\"mega-cat-sub-categories$sub_categories_type\">\n";

						$output .= "<li><a href=\"#\" class=\"is-active is-loaded mega-sub-cat\" data-id=\"$item->object_id\">". __ti( 'All' ) ."</a></li>\n";

						foreach( $sub_categories as $category ){
							$cat_link = _jannah_good_get_term_link( $category->term_id, 'category' );
							$output  .= "<li><a href=\"$cat_link\" class=\"mega-sub-cat\" data-id=\"$category->term_id\">$category->name</a></li>\n";
						}

						$output .=  "</ul>\n";
					}

					$output .= "<div class=\"mega-cat-content$sub_categories_exists\">\n
												<div class=\"mega-ajax-content mega-cat-posts-container clearfix\">\n
												</div><!-- .mega-ajax-content -->\n";

					/*

					$output .= "
							<ul class=\"slider-arrow-nav tie-direction-nav\">
								<li><a class=\"tie-mega-pagination prev-posts pagination-disabled\" href=\"#\"><span class=\"fa fa-angle-left\" aria-hidden=\"true\"></span></a></li>
								<li><a class=\"tie-mega-pagination next-posts\" href=\"#\"><span class=\"fa fa-angle-right\" aria-hidden=\"true\"></span></a></li>
							</ul>\n";

					*/

					$output .= "
						</div><!-- .mega-cat-content -->\n
					</div><!-- .mega-cat-Wrapper -->\n";
				}


			//Recent + Check also ========================================================
				if( $this->tie_megamenu_type == 'recent' &&  $item->object == 'category' ){

					$output .= "<div class=\"mega-ajax-content\">\n</div><!-- .mega-ajax-content -->\n";
				}

			// End of Sub Categories =====================================================

				if( $this->tie_megamenu_type != 'links' ){
					$output .= "\n</div><!-- .mega-menu-content -->\n";
				}

				$output .= "\n</div><!-- .mega-menu-block --> \n";
			}
		// =====================

			$output .= "</li>\n";
		}


		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args = array() , &$output ){
			$id_field = $this->db_fields['id'];
			if ( is_object( $args[0] ) ){
				$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
			}
			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}
	} // Walker_Nav_Menu



	// Back end modification on Menus page ===============================================
	add_filter( 'wp_edit_nav_menu_walker', 'jannah_custom_nav_edit_walker',10,2 );
	function jannah_custom_nav_edit_walker($walker,$menu_id){
		return 'jannah_mega_menu_edit_walker';
	}


	// Custom icons beside the title
	add_action( 'wp_nav_menu_item_before_title', 'jannah_add_megamenu_icon_preview', 10, 4 );
	function jannah_add_megamenu_icon_preview( $item_id, $item, $depth, $args ){
		echo "<span class=\"preview-menu-item-icon fa $item->tie_megamenu_icon\"></span>";
	}


	// The Custom TieLabs menu fields
	add_action( 'wp_nav_menu_item_custom_fields', 'jannah_add_megamenu_fields', 10, 4 );
	function jannah_add_megamenu_fields( $item_id, $item, $depth, $args ){

		$theme_color = jannah_get_option( 'global_color', '#000000' );
		?>

		<div class="clear"></div>
		<br />
		<strong><?php esc_html_e( 'Jannah Custom Settings:', 'jannah' ); ?></strong> <small><em><?php esc_html_e( '(Only for Main Nav)', 'jannah' ); ?></em></small>

		<div class="clear"></div>

		<p class="description description-thin">
			<label for="edit-menu-item-megamenu-tiny-text-<?php echo esc_attr( $item_id ); ?>">
				<?php esc_html_e( 'Label Text', 'jannah' ); ?><br />
				<input type="text" id="edit-menu-item-megamenu-tiny-text-<?php echo esc_attr( $item_id ) ?>" class="widefat edit-menu-item-megamenu-tiny-text" name="menu-item-tie-megamenu-tiny-text[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->tie_megamenu_tiny_text ); ?>" />
			</label>
		</p>
		<p class="description description-thin tie-custom-color-picker">
			<label for="edit-menu-item-attr-megamenu-tiny-bg-<?php echo esc_attr( $item_id ); ?>">
				<?php esc_html_e( 'Label Background', 'jannah' ); ?><br />
				<input class="tieColorSelector" id="edit-menu-item-megamenu-tiny-bg-<?php echo esc_attr( $item_id ) ?>" name="menu-item-tie-megamenu-tiny-bg[<?php echo esc_attr( $item_id ); ?>]" data-palette="<?php echo esc_attr( $theme_color ); ?>, #9b59b6, #3498db, #2ecc71, #f1c40f, #34495e, #e74c3c"  style="width:80px;" type="text" value="<?php echo esc_attr( $item->tie_megamenu_tiny_bg ); ?>">
			</label>
		</p>

		<div class="tie-mega-menu-type">
			<p class="field-megamenu-icon description description-wide">
				<label for="edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Menu Icon', 'jannah' ); ?>
					<input type="hidden" id="edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-icon" name="menu-item-tie-megamenu-icon[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr( $item->tie_megamenu_icon ) ?>">
					<div id="preview_edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ) ?>" data-target="#edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ) ?>" class="button icon-picker fa <?php echo esc_attr( $item->tie_megamenu_icon ) ?>"></div>
				</label>
			</p>


			<p class="field-megamenu-icon-only description description-wide">
				<label for="edit-menu-item-megamenu-icon-only-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Show the icon only?', 'jannah' );?>
					<input type="checkbox" id="edit-menu-item-megamenu-icon-only-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-icon-only" name="menu-item-tie-megamenu-icon-only[<?php echo esc_attr( $item_id ) ?>]" value="true" <?php checked( $item->tie_megamenu_icon_only, 'true' ); ?>>
				</label>
			</p>

			<p class="field-megamenu-type description description-wide">
				<label for="edit-menu-item-megamenu-type-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Enable The Mega Menu?', 'jannah' ); ?>
					<select id="edit-menu-item-megamenu-type-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-type" name="menu-item-tie-megamenu-type[<?php echo esc_attr( $item_id ) ?>]">
						<option value=""><?php esc_html_e( 'Disable', 'jannah' ); ?></option>
						<?php  if( $item->object == 'category' ){  ?>
						<option value="sub-posts" <?php selected( $item->tie_megamenu_type, 'sub-posts' ); ?>><?php esc_html_e( 'Posts - Vertical Sub-Categories Filter', 'jannah' ); ?></option>
						<option value="sub-hor-posts" <?php selected( $item->tie_megamenu_type, 'sub-hor-posts' ); ?>><?php esc_html_e( 'Posts - Horizontal Sub-Categories Filter', 'jannah' ); ?></option>
						<option value="recent" <?php selected( $item->tie_megamenu_type, 'recent' ); ?>><?php esc_html_e( 'Posts - 1st Post Highlighted', 'jannah' ); ?></option>
						<?php } ?>
						<option value="links" <?php selected( $item->tie_megamenu_type, 'links' ); ?>><?php esc_html_e( 'Mega Menu Columns', 'jannah' ); ?></option>
					</select>
				</label>
			</p>

			<?php if( $item->object == 'category' ){  ?>
				<p class="field-megamenu-media-overlay description description-wide">
					<label for="edit-menu-item-megamenu-media-overlay-<?php echo esc_attr( $item_id ) ?>">
						<?php esc_html_e( 'Media Icon Overlay', 'jannah' );?>
						<input type="checkbox" id="edit-menu-item-megamenu-media-overlay-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-media-overlay" name="menu-item-tie-megamenu-media-overlay[<?php echo esc_attr( $item_id ) ?>]" value="true" <?php checked( $item->tie_megamenu_media_overlay, 'true' ); ?>>
					</label>
				</p>
			<?php } ?>

			<p class="field-megamenu-columns description description-wide">
				<label for="edit-menu-item-megamenu-columns-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Number of Mega Menu Columns', 'jannah' ); ?>
					<select id="edit-menu-item-megamenu-columns-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-columns" name="menu-item-tie-megamenu-columns[<?php echo esc_attr( $item_id ) ?>]">
						<option value=""></option>
						<option value="2" <?php selected( $item->tie_megamenu_columns, '2' ); ?>>2</option>
						<option value="3" <?php selected( $item->tie_megamenu_columns, '3' ); ?>>3</option>
						<option value="4" <?php selected( $item->tie_megamenu_columns, '4' ); ?>>4</option>
						<option value="5" <?php selected( $item->tie_megamenu_columns, '5' ); ?>>5</option>
					</select>
				</label>
			</p>

			<p class="field-megamenu-hide-headings description description-wide">
				<label for="edit-menu-item-megamenu-hide-headings-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Hide Mega Menu headings?', 'jannah' );?>
					<input type="checkbox" id="edit-menu-item-megamenu-hide-headings-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-hide-headings" name="menu-item-tie-megamenu-hide-headings[<?php echo esc_attr( $item_id ) ?>]" value="true" <?php checked( $item->tie_megamenu_hide_headings, 'true' ); ?>>
				</label>
			</p>

			<p class="field-megamenu-image description description-wide">
				<label for="edit-menu-item-megamenu-image-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Mega Menu Background Image', 'jannah' ); ?>
				</label>
				<input type="text" id="edit-menu-item-megamenu-image-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-image" name="menu-item-tie-megamenu-image[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr( $item->tie_megamenu_image ) ?>" />
				<select id="edit-menu-item-megamenu-position-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-position" name="menu-item-tie-megamenu-position[<?php echo esc_attr( $item_id ) ?>]">
					<option value=""></option>
					<option value="center" <?php selected( $item->tie_megamenu_position, 'center' ); ?>><?php esc_html_e( 'Center', 'jannah' ); ?></option>
					<option value="right" <?php selected( $item->tie_megamenu_position, 'right' ); ?>><?php esc_html_e( 'Right', 'jannah' ); ?></option>
					<option value="left" <?php selected( $item->tie_megamenu_position, 'left' ); ?>><?php esc_html_e( 'Left', 'jannah' ); ?></option>
				</select>
				<select id="edit-menu-item-megamenu-position-y-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-position-y" name="menu-item-tie-megamenu-position-y[<?php echo esc_attr( $item_id ) ?>]">
					<option value=""></option>
					<option value="center" <?php selected( $item->tie_megamenu_position_y, 'center' ); ?>><?php esc_html_e( 'Center', 'jannah' ); ?></option>
					<option value="top" <?php selected( $item->tie_megamenu_position_y, 'top' ); ?>><?php esc_html_e( 'Top', 'jannah' ); ?></option>
					<option value="bottom" <?php selected( $item->tie_megamenu_position_y, 'bottom' ); ?>><?php esc_html_e( 'Bottom', 'jannah' ); ?></option>
				</select>
				<select id="edit-menu-item-megamenu-repeat-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-repeat" name="menu-item-tie-megamenu-repeat[<?php echo esc_attr( $item_id ) ?>]">
					<option value=""></option>
					<option value="no-repeat" <?php selected( $item->tie_megamenu_repeat, 'no-repeat' ); ?>><?php esc_html_e( 'no-repeat', 'jannah' ); ?></option>
					<option value="repeat" <?php selected( $item->tie_megamenu_repeat, 'repeat' ); ?>><?php esc_html_e( 'repeat', 'jannah' ); ?></option>
					<option value="repeat-x" <?php selected( $item->tie_megamenu_repeat, 'repeat-x' ); ?>><?php esc_html_e( 'repeat-x', 'jannah' ); ?></option>
					<option value="repeat-y" <?php selected( $item->tie_megamenu_repeat, 'repeat-y' ); ?>><?php esc_html_e( 'repeat-y', 'jannah' ); ?></option>
				</select>
			</p>

			<p class="field-megamenu-styling description description-thin">
				<label for="edit-menu-item-megamenu-padding-right-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Padding Right', 'jannah' ); ?>
					<input type="text" id="edit-menu-item-megamenu-padding-right-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-padding-right" name="menu-item-tie-megamenu-padding-right[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr( $item->tie_megamenu_padding_right ) ?>" />
				</label>
			</p>

			<p class="field-megamenu-styling description description-thin">
				<label for="edit-menu-item-megamenu-padding-left-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Padding left', 'jannah' ); ?>
					<input type="text" id="edit-menu-item-megamenu-padding-left-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-padding-left" name="menu-item-tie-megamenu-padding-left[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr( $item->tie_megamenu_padding_left ) ?>" />
				</label>
			</p>

			<p class="field-megamenu-styling description description-thin">
				<label for="edit-menu-item-megamenu-min-height-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Min Height', 'jannah' ); ?>
					<input type="text" id="edit-menu-item-megamenu-min-height-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-min-height" name="menu-item-tie-megamenu-min-height[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr( $item->tie_megamenu_min_height ) ?>" />
				</label>
			</p>


		</div><!-- .tie-mega-menu-type-->
	<?php }


	// Save The custom Fields
	add_action('wp_update_nav_menu_item', 'jannah_custom_nav_update', 10, 3);
	function jannah_custom_nav_update( $menu_id, $menu_item_db_id, $args ){

		$custom_meta_fields = array(
			'menu-item-tie-megamenu-tiny-text',
			'menu-item-tie-megamenu-tiny-bg',
			'menu-item-tie-megamenu-type',
			'menu-item-tie-megamenu-columns',
			'menu-item-tie-megamenu-icon',
			'menu-item-tie-megamenu-image',
			'menu-item-tie-megamenu-position',
			'menu-item-tie-megamenu-position-y',
			'menu-item-tie-megamenu-min-height',
			'menu-item-tie-megamenu-repeat',
			'menu-item-tie-megamenu-padding-left',
			'menu-item-tie-megamenu-padding-right',
			'menu-item-tie-megamenu-icon-only',
			'menu-item-tie-megamenu-hide-headings',
			'menu-item-tie-megamenu-media-overlay',
		);

		foreach( $custom_meta_fields as $custom_meta_field ){
			$save_option_name   = str_replace( 'menu-item-', '', $custom_meta_field);
			$save_option_name   = str_replace( '-', '_', $save_option_name);

			if ( ! empty($_REQUEST[ $custom_meta_field ][ $menu_item_db_id ] ) ){
				$custom_value = $_REQUEST[ $custom_meta_field ][ $menu_item_db_id ];
				update_post_meta( $menu_item_db_id, $save_option_name, $custom_value );
			}
			else{
				delete_post_meta( $menu_item_db_id, $save_option_name );
			}
		}
	}

	/*
	 * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
	 */
	add_filter( 'wp_setup_nav_menu_item', 'jannah_custom_nav_item' );
	function jannah_custom_nav_item($menu_item){
		$menu_item->tie_megamenu_tiny_text     = get_post_meta( $menu_item->ID, 'tie_megamenu_tiny_text',     true );
		$menu_item->tie_megamenu_tiny_bg       = get_post_meta( $menu_item->ID, 'tie_megamenu_tiny_bg',       true );
		$menu_item->tie_megamenu_type          = get_post_meta( $menu_item->ID, 'tie_megamenu_type',          true );
		$menu_item->tie_megamenu_icon          = get_post_meta( $menu_item->ID, 'tie_megamenu_icon',          true );
		$menu_item->tie_megamenu_image         = get_post_meta( $menu_item->ID, 'tie_megamenu_image',         true );
		$menu_item->tie_megamenu_position      = get_post_meta( $menu_item->ID, 'tie_megamenu_position',      true );
		$menu_item->tie_megamenu_position_y    = get_post_meta( $menu_item->ID, 'tie_megamenu_position_y',    true );
		$menu_item->tie_megamenu_repeat        = get_post_meta( $menu_item->ID, 'tie_megamenu_repeat',        true );
		$menu_item->tie_megamenu_min_height    = get_post_meta( $menu_item->ID, 'tie_megamenu_min_height',    true );
		$menu_item->tie_megamenu_padding_left  = get_post_meta( $menu_item->ID, 'tie_megamenu_padding_left',  true );
		$menu_item->tie_megamenu_padding_right = get_post_meta( $menu_item->ID, 'tie_megamenu_padding_right', true );
		$menu_item->tie_megamenu_media_overlay = get_post_meta( $menu_item->ID, 'tie_megamenu_media_overlay', true );
		$menu_item->tie_megamenu_icon_only     = get_post_meta( $menu_item->ID, 'tie_megamenu_icon_only',     true );
		$menu_item->tie_megamenu_hide_headings = get_post_meta( $menu_item->ID, 'tie_megamenu_hide_headings',     true );
		return $menu_item;
	}


	/**
	 * Navigation Menu template functions
	 */
	class jannah_mega_menu_edit_walker extends Walker_Nav_Menu {
			/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker_Nav_Menu::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ){}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker_Nav_Menu::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ){}

		/**
		 * Start the element output.
		 *
		 * @see Walker_Nav_Menu::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 * @param int    $id     Not used.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){
			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

			ob_start();
			$item_id = esc_attr( $item->ID );
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			$original_title = '';
			if ( 'taxonomy' == $item->type ){
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				if ( is_wp_error( $original_title ) )
					$original_title = false;
			} elseif ( 'post_type' == $item->type ){
				$original_object = get_post( $item->object_id );
				$original_title = get_the_title( $original_object->ID );
			}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ){
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = sprintf( esc_html__( '%s (Invalid)', 'jannah' ), $item->title );
			} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ){
				$classes[] = 'pending';
				/* translators: %s: title of menu item in draft status */
				$title = sprintf( esc_html__('%s (Pending)', 'jannah'), $item->title );
			}

			$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

			$submenu_text = '';
			if ( 0 == $depth )
				$submenu_text = 'style="display: none;"';

			?>
			<li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo implode(' ', $classes ); ?>">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title">

							<?php
								//By Tielabs **************************************************

									do_action( 'wp_nav_menu_item_before_title', $item_id, $item, $depth, $args );

								// END ********************************************************
							?>

							<span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo ( $submenu_text ); ?>><?php esc_html_e( 'sub item', 'jannah' ); ?></span></span>
						<span class="item-controls">
							<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
							<span class="item-order hide-if-js">
								<a href="<?php
									echo wp_nonce_url(
										add_query_arg(
											array(
												'action' => 'move-up-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg($removed_args, esc_url(admin_url( 'nav-menus.php' )) )
										),
										'move-menu_item'
									);
								?>" class="item-move-up"><abbr title="<?php esc_html__('Move up', 'jannah'); ?>">&#8593;</abbr></a>
								|
								<a href="<?php
									echo wp_nonce_url(
										add_query_arg(
											array(
												'action' => 'move-down-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg($removed_args, esc_url(admin_url( 'nav-menus.php' )) )
										),
										'move-menu_item'
									);
								?>" class="item-move-down"><abbr title="<?php esc_html__('Move down', 'jannah'); ?>">&#8595;</abbr></a>
							</span>
							<a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" title="<?php esc_html__('Edit Menu Item', 'jannah'); ?>" href="<?php
								echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? esc_url(admin_url( 'nav-menus.php' )) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
							?>"><?php esc_html_e( 'Edit Menu Item', 'jannah' ); ?></a>
						</span>
					</dt>
				</dl>

				<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">
					<?php if( 'custom' == $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
								<?php esc_html_e( 'URL', 'jannah' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-thin">
						<label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Navigation Label', 'jannah' ); ?><br />
							<input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="description description-thin">
						<label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Title Attribute', 'jannah' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<p class="field-link-target description">
						<label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
							<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $item->target, '_blank' ); ?> />
							<?php esc_html_e( 'Open link in a new window/tab', 'jannah' ); ?>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'CSS Classes (optional)', 'jannah' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
						</label>
					</p>
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Link Relationship (XFN)', 'jannah' ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Description', 'jannah' ); ?><br />
							<textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
							<span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'jannah'); ?></span>
						</label>
					</p>


					<?php
						//By TieLabs **************************************************

							do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args );

						// END ********************************************************
					?>

					<p class="field-move hide-if-no-js description description-wide">
						<label>
							<span><?php esc_html_e( 'Move', 'jannah' ); ?></span>
							<a href="#" class="menus-move-up"><?php esc_html_e( 'Up one', 'jannah' ); ?></a>
							<a href="#" class="menus-move-down"><?php esc_html_e( 'Down one', 'jannah' ); ?></a>
							<a href="#" class="menus-move-left"></a>
							<a href="#" class="menus-move-right"></a>
							<a href="#" class="menus-move-top"><?php esc_html_e( 'To the top', 'jannah' ); ?></a>
						</label>
					</p>

					<div class="menu-item-actions description-wide submitbox">
						<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
							<p class="link-to-original">
								<?php printf( esc_html__('Original: %s', 'jannah'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>" href="<?php
						echo wp_nonce_url(
							add_query_arg(
								array(
									'action' => 'delete-menu-item',
									'menu-item' => $item_id,
								),
								esc_url(admin_url( 'nav-menus.php' ))
							),
							'delete-menu_item_' . $item_id
						); ?>"><?php esc_html_e( 'Remove', 'jannah' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr( $item_id ); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), esc_url(admin_url( 'nav-menus.php' )) ) );
							?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e('Cancel', 'jannah'); ?></a>
					</div>

					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item_id ); ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}


	} // Walker_Nav_Menu

}

<?php
/**
 * Demo Importer
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





/*-----------------------------------------------------------------------------------*/
# Jannah Demo Importer
/*-----------------------------------------------------------------------------------*/
if( ! class_exists( 'JANNAH_DEMO_IMPORTER' )){

	class JANNAH_DEMO_IMPORTER{


		public $demo_widgets      = '';
		public $logo_img_id       = '';
		public $secondry_menu_id  = '';
		public $menu_slug         = 'tie-one-click-demo-import';


		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			# INCLUDE THE MAIN DEMO IMPORTER CLASSES
			if( ! class_exists( 'PT_One_Click_Demo_Import' )){
				locate_template( 'framework/admin/inc/one-click-demo-import/one-click-demo-import.php', true, true );
			}

			# DISABLE THE DEFAULT TEXTS
			add_filter( 'pt-ocdi/plugin_intro_text', '__return_false' );

			add_filter( 'pt-ocdi/import_files',          array( $this, 'get_files' ));
			add_filter( 'pt-ocdi/plugin_page_setup',     array( $this, 'demo_page_setup' ));
			add_filter( 'jannah_about_tabs',             array( $this, '_add_about_tabs' ));

			add_action( 'import_start',                  array( $this, 'before_import' ));
			add_action( 'pt-ocdi/after_import',          array( $this, 'after_import' ));
			add_action( 'pt-ocdi/before_widgets_import', array( $this, 'reset_widgets' ));
			add_action( 'tie_demo_import_settings',      array( $this, 'import_settings' ));
			add_action( 'wxr_importer.processed.post',   array( $this, 'add_post_meta' ));
		}



		/**
		 * get_files
		 *
		 * PREPARE THE DEMOS DATA
		 */
		public function get_files(){

			if( ! class_exists( 'Parsedown' )){
				locate_template( 'framework/admin/inc/Parsedown/parsedown.php', true, true );
			}

			$Parsedown   = new Parsedown();
			$demos_data  = jannah_get_latest_theme_data( 'demos' );
			$theme_demos = array();
			$demos_count = get_option( JANNAH_THEME_FOLDER .'_demos_count' );

			$i = 0;
			if( ! empty( $demos_data ) && is_array( $demos_data )){
				foreach ( $demos_data as $demo ){
					$i++;
					$theme_demos[] = array(
						'import_file_name'            => $demo['name'],
						'import_file_url'             => $demo['xml'],
						'import_settings_file_url'    => $demo['settings'],
						'import_preview_image_url'    => $demo['img'],
						'import_demo'                 => ! empty( $demo['url'] )  ? $demo['url'] : '',
						'import_notice'               => ! empty( $demo['desc'] ) ? $Parsedown->text( $demo['desc'] ) : '',
						'new_demos'                   => ( $i > $demos_count ) ? 'true' : '',
						'import_woocommerce_file_url' => 'https://plugins.svn.wordpress.org/woocommerce/tags/2.6.4/dummy-data/dummy-data.xml?dl=1',
					);
				}
			}

			return $theme_demos;
		}



		/**
		 * demo_page_setup
		 *
		 * SETUP THE DEMO IMPORTER PAGE DATA
		 */
		 public function demo_page_setup( $settings ){

			$demos_count  = jannah_get_latest_theme_data( 'demos' ) ? count( jannah_get_latest_theme_data( 'demos' ) ) : 0 ;
			$notification = '';

			if( get_option( JANNAH_THEME_FOLDER .'_demos_count' ) < $demos_count ){
				$new_demos    = $demos_count - get_option( JANNAH_THEME_FOLDER .'_demos_count' );
				$notification = ' <span class="update-plugins tie-import-demos"><span class="update-count">'. $new_demos .'</span></span>';
			}

			$settings['parent_slug'] = 'tie-theme-options';
			$settings['page_title']  = esc_html__( 'Choose the demo which you want to import', 'jannah' );
			$settings['menu_title']  = esc_html__( 'Install Demos', 'jannah' ) . $notification;
			$settings['capability']  = 'import';
			$settings['menu_slug']   = $this->menu_slug;

			return $settings;
		}



		/**
		 * _add_about_tabs
		 *
		 * Add the Install Demos Page to the about page's tabs
		 */
		function _add_about_tabs( $tabs ){

			$tabs['demos'] = array(
				'text' => esc_html__( 'Install Demos', 'jannah' ),
				'url'  => menu_page_url( $this->menu_slug, false ),
			);

			return $tabs;
		}



		/**
		 * before_import
		 *
		 * RUN BEFORE IMPORTING THE DATA
		 */
		public function before_import(){

			# SAVE CURRENT SITE SETTINGS ----------
			if( ! get_option( JANNAH_THEME_FOLDER .'_history' ) ){

				$theme = get_option( 'stylesheet' );

				$history = array(
					'options'       => get_option( 'tie_jannah_options' ),
					'widgets'       => get_option( 'sidebars_widgets' ),
					'show_on_front' => get_option( 'show_on_front' ),
					'page_on_front' => get_option( 'page_on_front' ),
					'mods'          => get_option( 'theme_mods_'.$theme ),
					'demo'          => get_option( 'tie_jannah_installed_demo' ),
				);

				update_option( JANNAH_THEME_FOLDER .'_history', $history, 'no' );
			}
			else{

				# Taxonomies ----------
				/*
				$args = array(
					'hide_empty' => false,
					'meta_key'   => JANNAH_THEME_FOLDER . '_demo_data',
				);

				$terms = get_terms( $args );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					foreach ( $terms as $term ){
						wp_delete_term( $term->term_id, $term->taxonomy );
					}
				}*/
			}


			# Register the Footer Widgets to load its widgets ----------
			$fotter_widgets_areas = array(
				'area_1' => esc_html__( 'First Footer', 'jannah' ),
				'area_2' => esc_html__( 'Secound Footer', 'jannah' )
			);

			foreach( $fotter_widgets_areas as $name => $description ){

				register_sidebar( array(
					'id'   => 'first-footer-widget-'.$name,
					'name' => $description. ' - '.esc_html__( '1st Column', 'jannah' ),
				));

				register_sidebar( array(
					'id'   => 'second-footer-widget-'.$name,
					'name' => $description. ' - '.esc_html__( '2d Column', 'jannah' ),
				));

				register_sidebar( array(
					'id'   => 'third-footer-widget-'.$name,
					'name' => $description. ' - '.esc_html__( '3rd Column', 'jannah' ),
				));

				register_sidebar( array(
					'id'   => 'fourth-footer-widget-'.$name,
					'name' => $description. ' - '.esc_html__( '4th Column', 'jannah' ),
				));
			}

		}



		/**
		 * reset_widgets
		 *
		 * RESET WIDGETS BEFORE IMPORTING THE NEW ONE
		 */
		public function reset_widgets(){
			update_option( 'sidebars_widgets', '' );
		}



		/**
		 * import_settings
		 *
		 * IMPORT THE THEME SETTINGS
		 */
		public function import_settings( $file ){

			# Settings File ----------
			if ( ! file_exists( $file ) ){
				return new WP_Error(
					'settings_import_file_not_found',
					esc_html__( 'Settings import file could not be found.', 'jannah' )
				);
			}

			# Get file contents and decode. ----------
			$data = OCDI_Helpers::data_from_file( $file );

			if ( is_wp_error( $data ) ){
				return $data;
			}

			$settings = json_decode( $data, true );


			# Default data ----------
			$settings = wp_parse_args( $settings, array(
				'tie_options'  => '',
				'homepage'     => '',
				'home_data'    => '',
				'widgets'      => '',
				'post_content' => '',
			));


			# Logo ----------
			$logo_data = $this->get_logo();


			# Categories and Posts ----------
			$thumbnails_ids = $this->get_thumbnails();
			$categories_ids = $this->insert_posts( $thumbnails_ids, $settings['post_content'] );


			# Menus ----------
			$main_menu_id = ! empty( $settings['single_menu'] ) ?  $this->insert_single_main_menu( $categories_ids ) : $this->insert_main_menu( $categories_ids );
			$this->secondry_menu_id = $this->insert_secondry_menu( $categories_ids );

			set_theme_mod( 'nav_menu_locations', array(
				'primary'     => $main_menu_id,
				'top-menu'    => $this->secondry_menu_id,
				'404-menu'    => $this->secondry_menu_id,
				'footer-menu' => $this->secondry_menu_id,
			));


			# Theme Settings ----------
			$default_data  = jannah_default_theme_settings();
			$default_data  = $default_data['tie_options'];

			unset( $default_data['main_nav'] );
			unset( $default_data['main_nav_dark'] );
			unset( $default_data['main_nav_layout'] );
			unset( $default_data['main_nav_position'] );

			unset( $default_data['main-nav-components_search'] );
			unset( $default_data['main-nav-components_search_layout'] );
			unset( $default_data['main-nav-components_slide_area'] );
			unset( $default_data['main-nav-components_login'] );
			unset( $default_data['main-nav-components_random'] );
			unset( $default_data['main-nav-components_social'] );
			unset( $default_data['main-nav-components_social_layout'] );

			unset( $default_data['top_nav'] );
			unset( $default_data['top_date'] );
			unset( $default_data['top_nav_dark'] );
			unset( $default_data['top_nav_layout'] );
			unset( $default_data['top_nav_position'] );

			unset( $default_data['main-nav-components_search'] );
			unset( $default_data['main-nav-components_search_layout'] );
			unset( $default_data['main-nav-components_slide_area'] );
			unset( $default_data['main-nav-components_login'] );
			unset( $default_data['main-nav-components_random'] );
			unset( $default_data['main-nav-components_social'] );
			unset( $default_data['main-nav-components_social_layout'] );

			unset( $default_data['footer_widgets_area_1'] );
			unset( $default_data['footer_widgets_area_2'] );
			unset( $default_data['copyright_area'] );
			unset( $default_data['widgets_icon'] );
			unset( $default_data['mobile_menu_active'] );

			$default_data['social'] = array(
				'facebook'  => '#',
				'twitter'   => '#',
				'youtube'   => '#',
				'instagram' => '#',
			);

			$theme_settings = ! empty( $settings['tie_options'] ) ? $settings['tie_options'] : array();
			$theme_settings = array_merge( $theme_settings, $logo_data );

			$options = wp_parse_args( $theme_settings, $default_data );


			$bg_areas = array(
				'header_background_img',
				'footer_background_img',
				'mobile_menu_background_image',
				'background_image',
			);

			foreach ( $bg_areas as $area ) {

				if( ! empty( $options[ $area ]['img'] ) ){

					$args = array(
						'post_type'      => array( 'attachment' ),
						'post_status'    => 'inherit',
						'meta_key'       => 'tie_demo_'.$area,
						'posts_per_page' => 200,
						'fields'         => 'ids',
					);

					$img = get_posts( $args );

					if( ! empty( $img[0] )){
						$img = wp_get_attachment_image_src( $img[0], 'full' );
						$options[ $area ]['img'] = $img[0];
					}
				}
			}



			jannah_save_theme_options( array( 'tie_options' => $options ));


			# HomePage ----------
			$homepage = array(
				'post_name'      => 'tiehome',
				'post_title'     => 'TieLabs HomePage',
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'comment_status' => 'closed'
			);

			$homepage_id = wp_insert_post( $homepage );

			if( ! empty( $homepage_id ) ){

				# Create the Blocks ----------
				$sections = ! empty( $settings['homepage'] ) ? $settings['homepage'] : array();

				# Prepare the Categories Array ----------
				$cats_ids = array();
				foreach( $categories_ids as $cat_id ){
					$cats_ids[] = $cat_id;
				}

				$section_number = 1;

				foreach( $sections as $section_index => $section_data ){

					# Section ID ----------
					$section_data['settings']['section_id'] = str_replace( 'xxxxxx', $homepage_id, $section_data['settings']['section_id'] );

					# Section Bg ----------
					if( ! empty( $section_data['settings']['background_img'] )){
						$args = array(
							'post_type'      => array( 'attachment' ),
							'post_status'    => 'inherit',
							'meta_key'       => 'tie_demo_section_'.$section_number,
							'posts_per_page' => 200,
							'fields'         => 'ids',
						);

						$img = get_posts( $args );

						if( ! empty( $img[0] )){
							$img = wp_get_attachment_image_src( $img[0], 'full' );
							$section_data['settings']['background_img'] = $img[0];
						}
					}

					# Blocks ----------
					foreach( $section_data['blocks'] as $id => $block ) {

						if( ! empty( $block['filters'] ) ){
							$block['id'] = $cats_ids;
							$section_data['blocks'][ $id ] = $block;
						}

						if( ! empty( $block['style'] ) && $block['style'] == 'tabs' ){
							$block['cat'] = $cats_ids;
							$section_data['blocks'][ $id ] = $block;
						}
					}

					$sections[ $section_index ] = $section_data;

					$section_number++;
				}

				$sections = apply_filters( 'jannah_save_blocks', $sections );
				$sections = jannah_array_filter_recursive( $sections );


				# Add Custom meta data so we be able to remove it later ----------
				update_post_meta( $homepage_id, JANNAH_THEME_FOLDER . '_demo_data', $homepage_id );

				# Set the page as a homepage ----------
				update_option ( 'show_on_front', 'page' );
				update_option ( 'page_on_front', $homepage_id );

				# Store the page builder elements ----------
				update_post_meta( $homepage_id, 'tie_builder_active',	'yes' );
				update_post_meta( $homepage_id, 'tie_page_builder', $sections );


				# Custom Widgets ----------
				if( ! empty( $settings['widgets'] )){
					$this->demo_widgets = $settings['widgets'];
				}


				# Custom Page data ----------
				$custom_page_data = ! empty( $settings['home_data'] ) ? $settings['home_data'] : '';
				if( ! empty( $custom_page_data ) && is_array( $custom_page_data ) ){
					foreach( $custom_page_data as $key => $value ){
						update_post_meta( $homepage_id, $key, $value );
					}
				}

			}


			# Widgets ----------
			$insert_widgets = $this->insert_widgets();

		}



		/**
		 * after_import
		 *
		 * RUN AFTER IMPORTING THE DATA
		 */
		public function after_import( $selected_import ){

		}



		/**
		 * insert_widgets
		 *
		 * Insert theme Widgets
		 */
		private function insert_widgets(){

			$sidebars = array();
			$widgets  = array();
			$widgtes_list = $this->get_widgets();

			$theme_sidebars = array(
				'first-footer-widget-area_1',
				'second-footer-widget-area_1',
				'third-footer-widget-area_1',
				'fourth-footer-widget-area_1',
				'first-footer-widget-area_2',
				'second-footer-widget-area_2',
				'third-footer-widget-area_2',
				'fourth-footer-widget-area_2',
			);

			foreach( $theme_sidebars as $sidebar ){
				$widgets [ $sidebar ] = $widgtes_list[ $sidebar ];
			}

			$widgets['primary-widget-area'] = $widgtes_list['primary-widget-area'];
			$widgets['slide-sidebar-area']  = $widgtes_list['slide-sidebar-area'];

			if ( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
				$widgets['shop-widget-area'] = $widgtes_list['woocommerce'];
			}

			if( get_option( 'show_on_front' ) == 'page' ){
				$frontpage_id = get_option( 'page_on_front' );

				$sections = get_post_meta( $frontpage_id, 'tie_page_builder', true );
				$sections = maybe_unserialize( $sections );

				$count = 0;
				foreach( $sections as $section_data ){

					if( ! empty( $section_data['settings']['sidebar_position'] ) && $section_data['settings']['sidebar_position'] != 'full' ){
						$count++;

						$sidebar_id = $section_data['settings']['section_id'];
						$sidebars[ $sidebar_id ] = array();
						$widgets [ $sidebar_id ] = $widgtes_list['section_'.$count];
					}

				}
			}


			$custom_widgets = get_option( 'tie_sidebars_widgets', array() );
			$custom_widgets[ $frontpage_id ] = $sidebars;
			update_option( 'tie_sidebars_widgets', $custom_widgets );

			$widget_importer = new OCDI_Widget_Importer();

			$widget_importer->import_data( (object) $widgets, $sidebars );

		}



		/**
		 * get_thumbnails
		 *
		 * GET ALL THUMBNAILS
		 */
		private function get_thumbnails(){

			# Get All Featured Images ----------
			$args = array(
				'post_type'      => array( 'attachment' ),
				'post_status'    => 'inherit',
				'meta_key'       => JANNAH_THEME_FOLDER . '_demo_data',
				'posts_per_page' => 200,
				'fields'         => 'ids',
			);

			# To Avoid setting any product image as a featured image for the imported posts
			if ( JANNAH_WOOCOMMERCE_IS_ACTIVE ){
				$args['date_query'] = array(
					array(
						'after' => '1 January 2016', // All the WooCoomerce images' puplish dates are in 2013
					),
				);
			}

			$thumbnails = get_posts( $args );

			# Remove the logo from the set ----------
			$logo_key = array_search( $this->logo_img_id, $thumbnails);
			unset( $thumbnails[ $logo_key ] );

			return $thumbnails;
		}



		/**
		 * create_gallery
		 *
		 * FOR THE SLIDER POST FORMAT
		 */
		private function create_gallery( $thumbnails ){

			$gallery = array();

			foreach( $thumbnails as $id ){
				$gallery[] = array(
					'id' => $id
				);
			}

			return $gallery;
		}



		/**
		 * get_logo
		 *
		 * GET THE LOGO
		 */
		private function get_logo(){

			$args = array(
				'post_type'      => array( 'attachment' ),
				'post_status'    => 'inherit',
				'meta_key'       => 'tie_demo_logo',
				'posts_per_page' => 200,
				'fields'         => 'ids',
			);

			$logo = get_posts( $args );

			if( ! empty( $logo[0] )){
				$logo = $this->logo_img_id = $logo[0];

				$logo_img = wp_get_attachment_image_src( $logo, 'full' );

				return array(
					'logo' => $logo_img[0],
					'logo_retina' => $logo_img[0],
					'logo_retina_width'  => intval( $logo_img[1]/2 ),
					'logo_retina_height' => intval( $logo_img[2]/2 ),
				);
			}

			return array();
		}





		/**
		 * get_widgets
		 *
		 * RETURN WIDGETS
		 */
		private function get_widgets(){

			$default_widgets = '{
				"primary-widget-area":{
					"widget_tabs-1":{
						"posts_number":"5",
						"posts_order":"popular",
						"tabs_order":"p,r,c,t"
				  },
				  "social-1":{
						"title":"Social",
							"tran_bg":null,
							"center":"true"
				  },
				  "stream-item-widget-1":{
						"title":"Advertisement",
						"tran_bg":"true",
						"new_window":"true",
						"nofollow":"true",
						"e3lan_img":"https:\/\/placehold.it\/336x280",
						"e3lan_url":"#",
						"e3lan_code":""
				  },
				  "login-widget-1":{
						"title":"Login"
				  },
				  "tie-slider-widget-1":{
						"cat_posts_title":"",
						"no_of_posts":"5",
						"custom_slider":"",
						"slider_only":"true"
				  },
					"posts-list-widget-1":{
						"title":"Popular Posts",
						"no_of_posts":"5",
						"posts_order":"views",
						"media_overlay":null,
						"cats_id":null,
						"style":"7",
						"offset":""
				  },
					"author-bio-widget-1":{
						"title":"About",
						"img":"https:\/\/placehold.it\/150x150",
						"text_code":"Egyptian, Father, Husband, I design and develop #WordPress themes & plugins, founder of @tielabs",
						"circle":"true",
						"center":"true",
						"social_icons":"true"
				  },
					"tie-newsletter-1":{
						"title":"Newsletter",
						"text":"\t<h4>With Product You Purchase<\/h4>\r\n\t<h3>Subscribe to our mailing list to get the new updates!<\/h3>\r\n\t<p>Lorem ipsum dolor sit amet, consectetur.<\/p>",
						"mailchimp":"#",
						"feedburner":""
				  },
				  "tie-widget-categories-1":{
						"title":"Categories",
						"depth":"true"
				  }
			  },

				"slide-sidebar-area":{
			    "posts-list-widget-2":{
						"title":"Popular Posts",
						"no_of_posts":"5",
						"posts_order":"views",
						"media_overlay":null,
						"cats_id":null,
						"style":"3",
						"offset":""
			    },
			    "posts-list-widget-3":{
						"title":"Most Commented",
						"no_of_posts":"6",
						"posts_order":"popular",
						"media_overlay":null,
						"cats_id":null,
						"style":"2",
						"offset":""
			    },
			    "comments_avatar-widget-1":{
						"title":"Recent Comments",
						"no_of_comments":"5"
			    }
				 },

				"woocommerce":{
			    "woocommerce_product_search-1":{
						"title":"Search Product"
			    },
			    "woocommerce_price_filter-1":{
						"title":"Filter by price"
			    },
			    "woocommerce_layered_nav-1":{
						"title":"Filter by",
						"display_type":"list",
						"query_type":"and"
			    },
			    "woocommerce_layered_nav_filters-1":{
						"title":"Active Filters"
			    },
			    "woocommerce_product_categories-1":{
						"title":"Product Categories",
						"orderby":"name",
						"dropdown":0,
						"count":0,
						"hierarchical":"1",
						"show_children_only":0
			    },
			    "woocommerce_products-1":{
						"title":"Featured Products",
						"number":"5",
						"show":"onsale",
						"orderby":"date",
						"order":"desc",
						"hide_free":0,
						"show_hidden":0
			    },
			    "woocommerce_top_rated_products-1":{
						"title":"Top Rated Products",
						"number":"5"
			    },
					"woocommerce_product_tag_cloud-1":{
						"title":"Product Tags"
					}
				},

				"section_1":{
			    "widget_tabs-2":{
						"posts_number":"5",
						"posts_order":"popular",
						"tabs_order":"p,r,c,t"
			    },
			    "posts-list-widget-4":{
						"title":"Popular Posts",
						"no_of_posts":"4",
						"posts_order":"views",
						"media_overlay":null,
						"cats_id":null,
						"style":"5",
						"offset":""
			    },
			    "social-2":{
						"title":"Social",
			 			"tran_bg":null,
			 			"center":"true"
			    },
			    "stream-item-widget-1":{
						"title":"Advertisement",
						"tran_bg":"true",
						"new_window":"true",
						"nofollow":"true",
						"e3lan_img":"https:\/\/placehold.it\/336x280",
						"e3lan_url":"#",
						"e3lan_code":""
			    }
				},

				"section_2":{
			    "tie-slider-widget-2":{
						"cat_posts_title":"",
						"no_of_posts":"5",
						"custom_slider":"",
						"slider_only":"true"
			    },
					"tie-newsletter-2":{
						"title":"Newsletter",
						"text":"\t<h4>With Product You Purchase<\/h4>\r\n\t<h3>Subscribe to our mailing list to get the new updates!<\/h3>\r\n\t<p>Lorem ipsum dolor sit amet, consectetur.<\/p>",
						"mailchimp":"#",
						"feedburner":""
			    },
			    "tie-widget-categories-2":{
						"title":"Categories",
						"depth":"true"
			    }
				 },

				"section_3":{
			    "posts-list-widget-5":{
						"title":"Check Also",
						"no_of_posts":"5",
						"posts_order":"rand",
						"media_overlay":true,
						"cats_id":null,
						"style":"3",
						"offset":""
			    },
			    "posts-list-widget-6":{
						"title":"Last Updated",
						"no_of_posts":"5",
						"posts_order":"modified",
						"media_overlay":true,
						"cats_id":null,
						"style":"7",
						"offset":""
			    }
			  },

				"section_4":{
			    "stream-item-widget-2":{
					"title":"Advertisement",
					"tran_bg":"true",
					"new_window":"true",
					"nofollow":"true",
					"e3lan_img":"https:\/\/placehold.it\/336x280",
					"e3lan_url":"#",
					"e3lan_code":""
			   }
				},

				"first-footer-widget-area_1":{
			    "posts-list-widget-7":{
						"title":"Most Viewed Posts",
						"no_of_posts":"3",
						"posts_order":"views",
						"media_overlay":null,
						"cats_id":null,
						"style":"2"
			    }
				 },

				"second-footer-widget-area_1":{
			    "posts-list-widget-8":{
						"title":"Last Modified Posts",
						"no_of_posts":"9",
						"posts_order":"modified",
						"media_overlay":null,
						"cats_id":null,
						"style":"6"
			    }
				 },

				"third-footer-widget-area_1":{
					"posts-list-widget-9":{
						"title":"Check Also",
						"no_of_posts":"2",
						"posts_order":"latest",
						"media_overlay":null,
						"cats_id":null,
						"style":"5"
			    }
				 },

				"fourth-footer-widget-area_1":{
			    "tie-widget-categories-3":{
						"title":"Categories",
						"depth":"true"
			    }
				 },

				"first-footer-widget-area_2":{
			    "author-bio-widget-2":{
						"title":"",
						"img":"https:\/\/placehold.it\/333x54",
						"text_code":"",
						"circle":null,
						"center":null,
						"social_icons":null,
						"margin_top":"30px",
						"margin_bottom":"0px"
			    },
			    "social-3":{
						"title":"Social",
						"tran_bg":"true",
						"center":null
			    }
				},

				"second-footer-widget-area_2":{
					"author-bio-widget-3":{
						"title":"About",
						"img":"",
						"text_code":"Jannah is a Clean Responsive WordPress Newspaper, Magazine, News and Blog theme. Packed with options that allow you to completely customize your website to your needs.",
						"circle":null,
						"center":null,
						"social_icons":null,
						"margin_top":"",
						"margin_bottom":""
			    }
				 },

				"third-footer-widget-area_2":{
			    "tie-newsletter-4":{
						"title":"Newsletter",
						"text":"",
						"mailchimp":"#",
						"feedburner":""
			    }
				},

				"fourth-footer-widget-area_2":{
			    "categories-1":{
						"title":"",
						"count":1,
						"hierarchical":1,
						"dropdown":0
			    }
				}
			}';


			$default_widgets  = json_decode( $default_widgets, true );
			$imported_widgets = $this->demo_widgets;

			// Change the mnu widget ID
			foreach ( $imported_widgets as $sidebar => $widget ){
				foreach( $widget as $widget_id => $widget_data ){
					if( ! empty( $widget_data['nav_menu'] )){
						$widget_data['nav_menu'] = $this->secondry_menu_id;
						$imported_widgets[ $sidebar ][ $widget_id ] = $widget_data;
					}
				}
			}

			return wp_parse_args( $imported_widgets, $default_widgets );
		}



		/**
		 * insert_comments
		 *
		 * INSERT COMMENTS ON THE POST
		 */
		private function insert_comments( $post_id ){

			$commenter_email  = 'bp.def.data+'. rand(1,25) .'@gmail.com';
			$commenters_names = array(
				'Edward Huckaby',
				'Carolyn Donnelly',
				'Donald Allbright',
				'James Kim',
				'Ashlee Merritt',
				'Georgia Waltrip',
				'Michael Eubanks',
				'Candelaria Allen',
				'Ernest Baker',
				'Ivy Torres',
			);

			$comment_data = array(
		    'comment_post_ID'      => $post_id,
		    'comment_author'       => $commenters_names[ array_rand( $commenters_names ) ],
		    'comment_author_email' => $commenter_email,
		    'comment_author_url'   => 'https://wordpress.org/',
		    'comment_content'      => 'Hi, this is a comment.
					To get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard.',
		    'comment_type'         => '',
		    'comment_parent' => 0,
		    'comment_author_IP' => '127.0.0.1',
		    'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
		    'comment_date' => current_time('mysql'),
		    'comment_approved' => 1,
			);

			wp_insert_comment( $comment_data );

		}



		/**
		 * insert_main_menu
		 *
		 * INSERT THE MAIN MENU
		 */
		private function insert_main_menu( $categories_ids ){

			# Check if the menu is exist ----------
			$menu_name = 'TieLabs Main Menu';

			# Delete the menu if exists ----------
			wp_delete_nav_menu( $menu_name );

			# Create the new menu ----------
			$main_menu_id = wp_create_nav_menu( $menu_name );

			# Add Custom meta data so we be able to remove it later ----------
			update_term_meta( $main_menu_id, JANNAH_THEME_FOLDER . '_demo_data', $main_menu_id );


			# Set up default menu items ----------
		  $menu_item_db_id = wp_update_nav_menu_item( $main_menu_id, 0, array(
		    'menu-item-title'  => esc_html__('Home', 'jannah'),
		    'menu-item-url'    => esc_url(home_url( '/' )),
		    'menu-item-status' => 'publish',
		   ));


		  // -----------
		  $menu_item_db_id = wp_update_nav_menu_item( $main_menu_id, 0, array(
		    'menu-item-status'    => 'publish',
		    'menu-item-type'      => 'taxonomy',
		    'menu-item-object-id' => $categories_ids['world'],
		    'menu-item-object'    => 'category',
			));
			update_post_meta( $menu_item_db_id, 'tie_megamenu_type', 'sub-posts' );


		  // -----------
		  $menu_item_db_id = wp_update_nav_menu_item( $main_menu_id, 0, array(
		    'menu-item-status'    => 'publish',
		    'menu-item-type'      => 'taxonomy',
		    'menu-item-object-id' => $categories_ids['world'],
		    'menu-item-object'    => 'category',
			));
			update_post_meta( $menu_item_db_id, 'tie_megamenu_type', 'sub-hor-posts' );


		  // -----------
		  $menu_item_db_id = wp_update_nav_menu_item( $main_menu_id, 0, array(
		    'menu-item-status'    => 'publish',
		    'menu-item-type'      => 'taxonomy',
		    'menu-item-object-id' => $categories_ids['tech'],
		    'menu-item-object'    => 'category',
			));
			update_post_meta( $menu_item_db_id, 'tie_megamenu_type', 'recent' );


		  // -----------
		  $menu_item_db_id = wp_update_nav_menu_item( $main_menu_id, 0, array(
		    'menu-item-status'    => 'publish',
		    'menu-item-type'      => 'taxonomy',
		    'menu-item-object-id' => $categories_ids['life-style'],
		    'menu-item-object'    => 'category',
			));
			update_post_meta( $menu_item_db_id, 'tie_megamenu_type', 'recent' );
			update_post_meta( $menu_item_db_id, 'tie_megamenu_media_overlay', 'true' );

			# Category Posts ----------
			$args = array(
				'post_type'      => 'post',
				'category'       => $categories_ids['life-style'],
				'posts_per_page' => 5,
				'fields'         => 'ids',
			);
		  update_post_meta( $menu_item_db_id, 'tie_megamenu_icon', 'fa-coffee' );

			$sub_posts = get_posts( $args );

			foreach( $sub_posts as $post_id ){

				wp_update_nav_menu_item( $main_menu_id, 0, array(
			    'menu-item-parent-id' => $menu_item_db_id,
			    'menu-item-status'    => 'publish',
			    'menu-item-type'      => 'post_type',
			    'menu-item-object-id' => $post_id,
			    'menu-item-object'    => 'post',
				));
			}


		  // -----------
		  $menu_item_db_id = wp_update_nav_menu_item( $main_menu_id, 0, array(
		    'menu-item-title'  =>  esc_html__('More', 'jannah'),
		    'menu-item-url'    => '#',
		    'menu-item-status' => 'publish',
		   ));
		  update_post_meta( $menu_item_db_id, 'tie_megamenu_type',   'links' );
		  update_post_meta( $menu_item_db_id, 'tie_megamenu_columns', 4 );

		  for( $i=1; $i < 5; $i++ ){

		  	$sub_menu = wp_update_nav_menu_item( $main_menu_id, 0, array(
			    'menu-item-parent-id' => $menu_item_db_id,
			    /* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
			    'menu-item-title'     =>  esc_html__('Menu Title', 'jannah') . ' #'.$i ,
		    	'menu-item-url'       => '#',
			    'menu-item-status'    => 'publish',
				));

				for($j=1; $j < 6; $j++){
			  	wp_update_nav_menu_item( $main_menu_id, 0, array(
				    'menu-item-parent-id' => $sub_menu,
				    /* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				    'menu-item-title'     =>  esc_html__('Sub Menu', 'jannah') . ' #'.$j ,
			    	'menu-item-url'       => '#',
				    'menu-item-status'    => 'publish',
					));
				}
		  }


		  // -----------
		  $menu_item_db_id = wp_update_nav_menu_item( $main_menu_id, 0, array(
		    'menu-item-title'      =>  esc_html__('Buy now!', 'jannah'),
		    'menu-item-attr-title' =>  esc_html__('Buy now!', 'jannah'),
		    'menu-item-url'        => jannah_get_purchase_link( array( 'utm_source' => 'demo-content', 'utm_content' => 'main-menu' ) ),
		    'menu-item-status'     => 'publish',
		   ));
		  update_post_meta( $menu_item_db_id, '_menu_item_target',      'true' );
		  update_post_meta( $menu_item_db_id, 'tie_megamenu_icon_only', 'true' );
		  update_post_meta( $menu_item_db_id, 'tie_megamenu_icon',      'fa-smile-o' );


		  return $main_menu_id;
		}



		/**
		 * insert_single_main_menu
		 *
		 * INSERT THE SINGLE MAIN MENU
		 */
		private function insert_single_main_menu( $categories_ids ){

			$menu_name = 'TieLabs Main Single Menu';

			# Delete the menu if exists ----------
			wp_delete_nav_menu( $menu_name );

			# Create the new menu ----------
			$main_menu_id = wp_create_nav_menu( $menu_name );

			# Add Custom meta data so we be able to remove it later ----------
			update_term_meta( $main_menu_id, JANNAH_THEME_FOLDER . '_demo_data', $main_menu_id );


			# Set up default menu items ----------
		  $menu_item_db_id = wp_update_nav_menu_item( $main_menu_id, 0, array(
		    'menu-item-title'  => esc_html__('Home', 'jannah'),
		    'menu-item-url'    => '#',
		    'menu-item-status' => 'publish',
		   ));

		  $menu_icon = is_rtl() ? 'fa-align-left' : 'fa-align-right';
		  update_post_meta( $menu_item_db_id, 'tie_megamenu_icon',      $menu_icon );
		  update_post_meta( $menu_item_db_id, 'tie_megamenu_icon_only', 'true' );

		  foreach ($categories_ids as $id ){
			  wp_update_nav_menu_item( $main_menu_id, 0, array(
			  	'menu-item-parent-id' => $menu_item_db_id,
			    'menu-item-status'    => 'publish',
			    'menu-item-type'      => 'taxonomy',
			    'menu-item-object-id' => $id,
			    'menu-item-object'    => 'category',
				));
		  }


		  return $main_menu_id;
		}



		/**
		 * insert_secondry_menu
		 *
		 * INSERT THE SECONDRY MENU
		 */
		private function insert_secondry_menu( $categories_ids ){

			# Check if the menu is exist ----------
			$menu_name = 'TieLabs Secondry Menu';

			# Delete the menu if exists ----------
			wp_delete_nav_menu( $menu_name );

			# Create the new menu ----------
		  $secondry_menu_id = wp_create_nav_menu( $menu_name );

			# Add Custom meta data so we be able to remove it later ----------
			update_term_meta( $secondry_menu_id, JANNAH_THEME_FOLDER . '_demo_data', $secondry_menu_id );


			# Set up default menu items ----------
		  $menu_item_db_id = wp_update_nav_menu_item( $secondry_menu_id, 0, array(
		    'menu-item-title'  => esc_html__('Home', 'jannah'),
		    'menu-item-url'    => esc_url(home_url( '/' )),
		    'menu-item-status' => 'publish',
		   ));

		  $menu_item_db_id = wp_update_nav_menu_item( $secondry_menu_id, 0, array(
		  	/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
		    'menu-item-title'  =>  esc_html__('About', 'jannah'),
		    'menu-item-url'    => '#',
		    'menu-item-status' => 'publish',
		   ));

		  $menu_item_db_id = wp_update_nav_menu_item( $secondry_menu_id, 0, array(
		  	/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
		    'menu-item-title'  =>  esc_html__('Team', 'jannah'),
		    'menu-item-url'    => '#',
		    'menu-item-status' => 'publish',
		   ));

		  $menu_item_db_id = wp_update_nav_menu_item( $secondry_menu_id, 0, array(
		    'menu-item-status'    => 'publish',
		    'menu-item-type'      => 'taxonomy',
		    'menu-item-object-id' => $categories_ids['world'],
		    'menu-item-object'    => 'category',
			));

		  $menu_item_db_id = wp_update_nav_menu_item( $secondry_menu_id, 0, array(
		    'menu-item-status'    => 'publish',
		    'menu-item-type'      => 'taxonomy',
		    'menu-item-object-id' => $categories_ids['tech'],
		    'menu-item-object'    => 'category',
			));

		  $menu_item_db_id = wp_update_nav_menu_item( $secondry_menu_id, 0, array(
		    'menu-item-title'      =>  esc_html__('Buy now!', 'jannah'),
		    'menu-item-attr-title' =>  esc_html__('Buy now!', 'jannah'),
		    'menu-item-url'        => 'https://themeforest.net/item/i/19659555?ref=tielabs&utm_source=demo-content&utm_medium=link&utm_campaign=jannah&utm_content=secondry-menu',
		    'menu-item-status'     => 'publish',
		   ));


		  return $secondry_menu_id;
		}



		/**
		 * insert_posts
		 *
		 * INSERT POSTS AND CATEGORIES
		 */
		private function insert_posts( $thumbnails, $post_content ){

			# Posts and Categories data ----------
			$categories_ids  = array();
			$cats_options    = array();

			/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
			$cat_descreption = esc_html__( 'WordPress is a favorite blogging tool of mine and I share tips and tricks for using WordPress here.', 'jannah' );

			# If there is no a custom post content - get the local post content.
			if( empty( $post_content )){
				$rtl = is_rtl() ? '-rtl' : '';
				$get_contents = 'file'.'_get'.'_contents'; //#####
				$post_content = $get_contents( JANNAH_TEMPLATE_URL .'/framework/admin/inc/one-click-demo-import/data/post-content'.$rtl.'.txt' );
			}

			# If it can not get the local post content use the category description.
			if( empty( $post_content )){
				$post_content = $cat_descreption;
			}


			// Categories and Posts data ----------
			$categories = array(
				'world' => array(
					/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
					'title'  => esc_html__( 'World', 'jannah' ),
					'custom_options' => array(
						'category_layout'         => '',
						'category_pagination'     => 'next-prev',
						'featured_posts'          => 'true',
						'featured_posts_style'    => 2,
						'featured_posts_category' => 'true',
						'featured_posts_date'     => 'true',
						'cat_color'               => '#e67e22'
					),
					'posts' => array(
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'After all is said and done, more is said than done', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Knowledge is power', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'The Future Of Possible', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Xbox boss talks Project Scorpio price', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Hibs and Ross County fans on final', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Tip of the day: That man again', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Hibs and Ross County fans on final', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Spieth in danger of missing cut', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Persuasion is often more effectual than force', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'One swallow does not make the spring', 'jannah' ),
					),
				),

					'travel' => array(
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						'title'  => esc_html__( 'Travel', 'jannah' ),
						'parent' => 'world',
						'custom_options' => array(
							'category_layout'         => 'full_thumb',
							'category_pagination'     => 'numeric',
							'featured_posts'          => 'true',
							'featured_posts_style'    => 16,
							'featured_posts_category' => 'true',
							'featured_posts_date'     => 'true',
							'cat_color'               => '#2ecc71'
						),
						'posts'  => array(
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Getting There is Half the FUN!', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Goa Tourism Appealing Visitors From Across the Globe', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Fontainebleau A Forgotten Treasure', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'I know it hurts to say goodbye, but it is time for me to fly', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'What We See When We Look at Travel Photography', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'How to make perfect vanilla cupcakes', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'The ultimate guide to herbal teas', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Making fruit and veg fun for kids', 'jannah' ),
						),
					),

					'games' => array(
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						'title'  => esc_html__( 'Games', 'jannah' ),
						'parent' => 'world',
						'custom_options' => array(
							'category_layout'         => 'timeline',
							'category_pagination'     => 'numeric',
							'featured_posts'          => 'true',
							'featured_posts_style'    => 7,
							'featured_posts_category' => 'true',
							'featured_posts_date'     => 'true',
							'cat_color'               => '#9b59b6'
						),
						'posts'  => array(
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'New Heroes of the Storm Characters Bring Portals', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'There May Be No Consoles in the Future, EA Exec Says', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Play This Game for Free on Steam This Weekend', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'The Game Officially Announced, Watch the Trailer Here', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Here What is in the game $80 Deluxe Edition', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Nintendo Details Next Miitomo Update', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Killing Floor 2 New Sharpshooter Class Detailed', 'jannah' ),
						),
					),

					'foods' => array(
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						'title'  => esc_html__( 'Foods', 'jannah' ),
						'parent' => 'world',
						'custom_options' => array(
							'category_layout'         => 'masonry',
							'category_pagination'     => 'numeric',
							'featured_posts'          => 'true',
							'featured_posts_style'    => 9,
							'featured_posts_category' => 'true',
							'featured_posts_date'     => 'true',
							'cat_sidebar_pos'         => 'full',
							'cat_color'               => '#34495e'
						),
						'posts'  => array(
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Quinoa new recipes, feta & broad bean salad', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Cooking with kids - how to get them involved', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( '6 Ways Drinking Warm Water Can Heal Your Body', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Ice Cream Maker Free Chocolate', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'Growing vegetables at home, six of the best', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'At Value-Focused Hotels, the Free Breakfast Gets Bigger', 'jannah' ),
							/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
							esc_html__( 'A Refined Seattle Restaurant, Hold the Table Linens', 'jannah' ),
						)
					),

				'business' => array(
					/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
					'title'  => esc_html__( 'Business', 'jannah' ),
					'custom_options' => array(
						'category_layout'         => 'overlay',
						'category_pagination'     => 'numeric',
						'featured_posts'          => 'true',
						'featured_posts_style'    => 3,
						'featured_posts_category' => 'true',
						'featured_posts_date'     => 'true',
						'cat_sidebar_pos'         => 'one-column',
						'cat_color'               => '#795548'
					),
					'posts'  => array(
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'December home sales rebound? Here is the secret', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Why people are flocking to Oregon', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Weekly mortgage applications pop on stock sell-off', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Apartment vacancies rise for first time in 6 years', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'China stock swoon could boost US real estate', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Why homeowners are leaving billions on the table', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Lock in now! Stock sell-off sinks mortgage rates', 'jannah' ),
					)
				),

				'tech' => array(
					/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
					'title'  => esc_html__( 'Tech', 'jannah' ),
					'custom_options' => array(
						'category_pagination'          => 'load-more',
						'featured_posts'               => 'true',
						'featured_posts_style'         => 16,
						'featured_posts_media_overlay' => 'true',
						'featured_posts_colored_mask'  => 'true',
						'featured_posts_category'      => 'true',
						'featured_posts_date'          => 'true',
						'cat_color'                    => '#4CAF50'
					),
					'posts'  => array(
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Former Microsoft CEO Ballmer does about-face on Linux technology', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Bosch looking to smart devices to get ahead in the cloud', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Signs of life for Apple stock as Wall St', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'YNAP sees slightly slower sales growth after strong 2015', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Senators close to finishing encryption penalties', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'NASA plans to fix Mars spacecraft leak then launch in 2018', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Apple sets March 21 event, Wall Street sees new, smaller iPhone', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Samsung Elec says preorders for Galaxy S7 phones stronger', 'jannah' ),
					)
				),

				'life-style' => array(
					/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
					'title'  => esc_html__( 'Life Style', 'jannah' ),
					'custom_options' => array(
						'featured_posts'               => 'true',
						'featured_posts_style'         => 13,
						'featured_posts_category'      => 'true',
						'featured_posts_date'          => 'true',
					),
					'posts'  => array(
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'After all is said and done, more is said than done', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Knowledge is power', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'The Future Of Possible', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Xbox boss talks Project Scorpio price', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Hibs and Ross County fans on final', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Tip of the day: That man again', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Hibs and Ross County fans on final', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Spieth in danger of missing cut', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'Persuasion is often more effectual than force', 'jannah' ),
						/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
						esc_html__( 'One swallow does not make the spring', 'jannah' ),
					)
				),
			);

			// Tags ----------
			$tags = array(
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'Life Style', 'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'Tech',       'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'Business',   'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'Foods',      'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'Games',      'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'Travel',     'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'World',      'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'Timeline',   'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'Content',    'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'Classic',    'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'About',      'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'Team',       'jannah' ),
				/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
				esc_html__( 'color',      'jannah' ),
			);


			// Posts Formats ----------
			$gallery = $this->create_gallery( $thumbnails );

			$posts_formats = array(

				'image' => array(
					'tie_post_head' => 'thumb',
					'tie_image_uncropped' => 'yes',
					'tie_image_lightbox'  => 'yes',
				),

				'slider' => array(
					'tie_post_head'    => 'slider',
					'tie_post_gallery' => $gallery,
				),

				'youtube' => array(
					'tie_post_head' => 'video',
					'tie_video_url' => esc_url( 'https://www.youtube.com/watch?v=Qpvm70FwulM' ),
				),

				'vimeo' => array(
					'tie_post_head' => 'video',
					'tie_video_url' => esc_url( 'https://vimeo.com/173524321' ),
				),

				'maps' => array(
					'tie_post_head' => 'map',
					'tie_googlemap_url' => esc_url( 'https://www.google.com.eg/maps/place/New+York,+NY,+USA/@40.7925557,-74.0875857,15.83z/data=!4m5!3m4!1s0x89c24fa5d33f083b:0xc80b8f06e177fe62!8m2!3d40.7127837!4d-74.0059413?hl=en' ),
				),

				'soundcloud' => array(
					'tie_post_head'        => 'audio',
					'tie_audio_soundcloud' => esc_url( 'https://soundcloud.com/u2news-2-0/at-the-bbc-with-u2' ),
				),

				'audio' => array(
					'tie_post_head' => 'audio',
					'tie_audio_mp3' => esc_url( 'https://files.freemusicarchive.org/music%2Fno_curator%2FTours%2FEnthusiast%2FTours_-_01_-_Enthusiast.mp3' ),
				),

			);


			# Insert The Categories ----------
			foreach ( $categories as $cat => $settings ){

				$cat_data = array(
					'cat_name'             => $settings['title'],
					'category_description' => $cat_descreption,
					'category_nicename'    => 'tie-'.$cat,
				);

				if( ! empty( $settings['parent'] ) && ! empty( $categories_ids[ $settings['parent'] ] ) ){
					$cat_data['category_parent'] = $categories_ids[ $settings['parent'] ];
				}

				$cat_id = ( $id = category_exists( $settings['title'] ) ) ? $id : wp_insert_category( $cat_data );

				// Add Custom meta data so we be able to remove it later ----------
				update_term_meta( $cat_id, JANNAH_THEME_FOLDER . '_demo_data', $cat_id );


				# Insert Posts ----------
				if( ! empty( $cat_id ) ){

					if( ! empty( $settings['custom_options'] ) && is_array( $settings['custom_options'] ) ){
						$cats_options[ $cat_id ] = $settings['custom_options'];
					}

					$categories_ids[ $cat ] = $cat_id;

					foreach ( $settings['posts'] as $title ) {

						$post_data = array(
						  'post_title'    => wp_strip_all_tags( $title ),
						  'post_content'  => $post_content,
						  'post_status'   => 'publish',
						  'post_category' => array( $cat_id ),
						);

						// Insert the post into the database ----------
						$post_id = wp_insert_post( $post_data );

						// Assign random featured image for the posts ----------
						set_post_thumbnail( $post_id, $thumbnails[ array_rand( $thumbnails ) ] );

						// Assign tags ----------
						wp_set_post_tags( $post_id, $tags[ array_rand( $tags ) ], true );

						// Add Custom meta data so we be able to remove it later ----------
						$post_layout  = rand(1,8);
						$post_options = $posts_formats[ array_rand( $posts_formats ) ];
						$post_options['tie_post_layout'] = $post_layout;

						if( $post_layout ==  4 || $post_layout ==  5 || $post_layout ==  8 ){
							$post_options['tie_featured_custom_bg'] = wp_get_attachment_url( $thumbnails[ array_rand( $thumbnails )] );

							// Add heighlight texts for some posts -----------
							$post_options['tie_highlights_text'] = array(
								/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
								esc_html__( 'Knowledge is power', 'jannah' ),
								/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
								esc_html__( 'The Future Of Possible', 'jannah' ),
								/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
								esc_html__( 'Hibs and Ross County fans on final', 'jannah' ),
								/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
								esc_html__( 'Tip of the day: That man again', 'jannah' ),
								/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
								esc_html__( 'Hibs and Ross County fans on final', 'jannah' ),
								/* translators: Used as a place holder in the demo content, you can replace it with any suitable text in your language */
								esc_html__( 'Spieth in danger of missing cut', 'jannah' ),
							);
						}

						// Number Of Views ----------
						$post_options['tie_views'] = rand( 135, 6000 );


						foreach( $post_options as $key => $value ){
							update_post_meta( $post_id, $key, $value );
						}

						// Add Custom meta data so we be able to remove it later ----------
						update_post_meta( $post_id, JANNAH_THEME_FOLDER . '_demo_data', $post_id );

						// Insert Comment ----------
						$this->insert_comments( $post_id );
					}
				}
			}

			# Update the custom categories settings ----------
			if( ! empty( $cats_options ) ){
				update_option( 'tie_cats_options', $cats_options, 'yes' );
			}

			return $categories_ids;
		}



		/**
		 * add_post_meta
		 *
		 * ADD CUSTOM META FIELD FOR THE IMPORTED DATA
		 */
		public function add_post_meta( $post_id, $data, $meta, $comments, $terms ){
			update_post_meta( $post_id, JANNAH_THEME_FOLDER . '_demo_data', $post_id );
		}



		/**
		 * _uninstall
		 *
		 * REMOVE IMPORTED DATA
		 */
		public static function _uninstall(){

			if( ! get_option( JANNAH_THEME_FOLDER .'_history' ) ) return;

			# Posts, Pages, etc ----------
			$args = array(
				'post_type'      => array( 'page', 'post', 'tie_slider', 'revision', 'product' ),
				'meta_key'       => JANNAH_THEME_FOLDER . '_demo_data',
				'post_status'    => array( 'any', 'trash', 'auto-draft' ),
				'posts_per_page' => 200,
				'fields'         => 'ids',
			);

			$the_query = new WP_Query( $args );

			if ( ! empty( $the_query->posts ) ){
				foreach ( $the_query->posts as $post ){
					wp_delete_post( $post, true );
				}
			}

			# Attachment ----------
			$args = array(
				'post_type'      => array( 'attachment' ),
				'post_status'    => 'inherit',
				'meta_key'       => JANNAH_THEME_FOLDER . '_demo_data',
				'posts_per_page' => 200,
				'fields'         => 'ids',
			);

			$the_query = new WP_Query( $args );

			if ( ! empty( $the_query->posts ) ){
				foreach ( $the_query->posts as $post ){
					wp_delete_attachment( $post, true );
				}
			}

			# Taxonomies ----------
			$args = array(
				'hide_empty' => false,
				'meta_key'   => JANNAH_THEME_FOLDER . '_demo_data',
			);

			$terms = get_terms( $args );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
				foreach ( $terms as $term ){
					wp_delete_term( $term->term_id, $term->taxonomy );
				}
			}

			# Install the previous site settings ----------
			self::_install_history();
		}



		/**
		 * _install_history
		 *
		 * INSTALL SAVED SITE SETTINGS HISTORY
		 */
		private static function _install_history(){

			$theme   = get_option( 'stylesheet' );
			$default = jannah_default_theme_settings();
			$history = get_option( JANNAH_THEME_FOLDER .'_history' );

			$history = wp_parse_args( $history, array(
				'options'       => $default['tie_options'],
				'widgets'       => '',
				'show_on_front' => 'posts',
				'page_on_front' => '',
				'mods'          => '',
			));

			update_option( 'tie_jannah_options',        $history['options'] );
			update_option( 'sidebars_widgets',          $history['widgets'] );
			update_option( 'show_on_front',             $history['show_on_front'] );
			update_option( 'page_on_front',             $history['page_on_front'] );
			update_option( 'theme_mods_'.$theme,        $history['mods'] );
			update_option( 'tie_jannah_installed_demo', $history['demo'] );


			delete_option( JANNAH_THEME_FOLDER .'_history' );


			# Redirect to the Done page ----------
			echo "<script type='text/javascript'>window.location='". add_query_arg( array( 'page' => 'tie-one-click-demo-import', 'uninstall-demo' => 'done' ), admin_url( 'admin.php' )) ."';</script>";

			exit;
		}

	}

	new JANNAH_DEMO_IMPORTER();
}

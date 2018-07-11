<?php


/*-----------------------------------------------------------------------------------*/
# Blocks Ajax Load More
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_blocks_load_more' )){

	add_action( 'wp_ajax_nopriv_jannah_blocks_load_more', 'jannah_blocks_load_more' );
	add_action( 'wp_ajax_jannah_blocks_load_more', 'jannah_blocks_load_more' );
	function jannah_blocks_load_more(){

		$block = $_REQUEST['block'];
		$style = $block['style'];
		$count = 0;

		if( ! empty( $_REQUEST['page'] ) ){
			$block['target_page'] = $_REQUEST['page'];
		}

		# WooCommerce number of columns ----------
		if( $block['style'] == 'woocommerce' && JANNAH_WOOCOMMERCE_IS_ACTIVE ){

			# Full Width section ----------
			if( $_REQUEST['width'] == 'full' ){
				$g = 'full';
				add_filter( 'loop_shop_columns', 'jannah_wc_full_width_loop_shop_columns', 99, 1 );
			}
			else{
				$g = 'single';
				remove_filter( 'loop_shop_columns', 'jannah_wc_full_width_loop_shop_columns', 99, 1 );
			}
		}


		# Run the query ----------
		$block_query = jannah_query( $block );

		ob_start();

		if( $block_query->have_posts() ){
			while ( $block_query->have_posts() ){

				$block_query->the_post();
				$count++;

				if( $block['style'] == 'woocommerce' && JANNAH_WOOCOMMERCE_IS_ACTIVE ){

					# Fix missing product class ----------
					add_filter( 'post_class', 'jannah_wc_product_post_class', 20, 3 );

					woocommerce_get_template_part( 'content', 'product' );
				}
				else{
					jannah_get_template_part( 'framework/loops/loop', $style, array( 'block' => $block, 'count' => $count ) );
				}
			}

			$hide_next = $hide_prev = false;

			if( $block_query->query_vars['new_max_num_pages'] == 1 || ( $block_query->query_vars['new_max_num_pages'] == $block_query->query_vars['paged'])){
				$hide_next = true;
			}

			if( empty( $block_query->query_vars['paged'] ) || $block_query->query_vars['paged'] == 1 ){
				$hide_prev = true;
			}

			wp_send_json( wp_json_encode(
				array(
					'hide_next' => $hide_next,
					'hide_prev' => $hide_prev,
					'code'      => ob_get_clean(),
					'button'    => __ti( 'No More Posts' ),
				)));
		}
		else{
			wp_send_json( wp_json_encode(
				array(
					'hide_next' => true,
					'hide_prev' => $hide_prev,
					'code'      => __ti( 'No More Posts' ),
					'button'    => __ti( 'No More Posts' ),
				)));
		}

		die;
	}

}





/*-----------------------------------------------------------------------------------*/
# Archives Ajax Load More
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_archives_load_more' )){

	add_action( 'wp_ajax_nopriv_jannah_archives_load_more', 'jannah_archives_load_more' );
	add_action( 'wp_ajax_jannah_archives_load_more', 'jannah_archives_load_more' );
	function jannah_archives_load_more(){

		$query     = stripslashes( $_REQUEST['query'] );
		$query     = json_decode ( str_replace( '\'', '"', $query ), true );
		$max_pages = $_REQUEST['max'];
		$layout    = $_REQUEST['layout'];
		$settings  = stripslashes( $_REQUEST['settings'] );
		$settings  = json_decode ( str_replace( '\'', '"', $settings ), true );

		$query['paged'] = (int) $_REQUEST['page'];

		$block_query = new WP_Query( $query );

		ob_start();

		if( $block_query->have_posts() ){
			while ( $block_query->have_posts() ){

				$block_query->the_post();

				jannah_get_template_part( 'framework/loops/loop', $layout, array( 'block' => $settings ) );
			}

			# Disable the Load more button ----------
			$hide_next = false;

			if( $block_query->max_num_pages == 1 || ( $block_query->max_num_pages == $block_query->query_vars['paged'])){
				$hide_next = true;
			}


			wp_send_json( wp_json_encode(
				array(
					'hide_next' => $hide_next,
					'code' 		  => ob_get_clean(),
					'button'    => __ti( 'No More Posts' ),
				)));
		}
		else{

			wp_send_json( wp_json_encode(
				array(
					'hide_next' => true,
					'code'      => '<li>'. __ti( 'No More Posts' ) .'</li>',
					'button'    => __ti( 'No More Posts' ),
				)));
		}

		die;
	}

}





/*-----------------------------------------------------------------------------------*/
# Meag Menu Pagination
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_mega_menu_load_ajax' )){

	add_action('wp_ajax_nopriv_jannah_mega_menu_load_ajax', 'jannah_mega_menu_load_ajax');
	add_action('wp_ajax_jannah_mega_menu_load_ajax', 'jannah_mega_menu_load_ajax');
	function jannah_mega_menu_load_ajax(){

		$block['id']       = $_REQUEST['id'];
		$block['number']   = $_REQUEST['number'];
		$is_featurd_layout = false;
		$thumbnail         = 'jannah-image-large';
		$count = 0;

		if( ! empty( $_REQUEST['featured'] ) && 'false' !== $_REQUEST['featured'] ){
			$is_featurd_layout = true;
			$thumbnail         = 'jannah-image-small';
		}

		$block_query = jannah_query( $block );

		if( $block_query->have_posts() ){
			while ( $block_query->have_posts() ){

				$block_query->the_post();
				$count++;

				if( $is_featurd_layout && $count == 1 ){

					get_template_part( 'framework/loops/loop', 'mega-menu-featured' );

					echo " <div class=\"mega-check-also\">\n<ul>";
				}
				else{

					jannah_get_template_part( 'framework/loops/loop', 'mega-menu-default', array( 'thumbnail' => $thumbnail ) );

				}
			}

			if( $is_featurd_layout ){
				echo "</ul>\n</div><!-- mega-check-also -->\n";
			}
		}
		else{
			echo '<div class="ajax-no-more-posts">'. __ti( 'Nothing Found' ) .'</div>';
		}

		die;
	}

}



/*-----------------------------------------------------------------------------------*/
# Ajax Search
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'jannah_ajax_search' )){

	add_action('wp_ajax_nopriv_jannah_ajax_search', 'jannah_ajax_search');
	add_action('wp_ajax_jannah_ajax_search', 'jannah_ajax_search');
	function jannah_ajax_search(){

		$search_qry	= $_REQUEST['query'];

		$search_json = array(
			'query'       => 'Unit',
			'suggestions' => array(),
		);

		$args = array(
			's'                   => $search_qry,
			'post_type'           => 'post',
			'no_found_rows'       => true,
			'posts_per_page'      => 4,
			'post_status'			    => 'publish',
			'ignore_sticky_posts' => true,
		);

		# Exclude specific categoies from search ----------
		if ( jannah_get_option( 'search_cats' ) ){
			$args['cat'] = jannah_get_option( 'search_cats' );
		}

		$block_query = new WP_Query( $args );

		if( $block_query->have_posts() ){

			while ( $block_query->have_posts() ){

				ob_start();
				$block_query->the_post();

				get_template_part( 'framework/loops/loop', 'live-search' );
				$search_json["suggestions"][] = array(
					'layout'   => ob_get_clean(),
					'value'    => get_the_title(),
					'url'      => get_permalink(),
				);
			}

			$search_json['suggestions'][] = array(
				'layout'   => '<div class="widget-post-list"><a class="button fullwidth" href="'. esc_url(home_url('?s=' . urlencode( $search_qry ) )) .'">'. __ti( 'View all results' ) .'</a></div>',
				'value'    => $search_qry,
				'url'      => esc_url(home_url('?s=' . urlencode( $search_qry ))),
			);

		}
		else{
			//echo '<div>'.__ti( 'Nothing Found' ).'</div>';
		}

		echo json_encode( $search_json );
		die;

	}

}

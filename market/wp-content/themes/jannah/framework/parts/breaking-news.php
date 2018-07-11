<?php

	# Enqueue the Sliders Js file ----------
	wp_enqueue_script( 'jannah-sliders' );


	# Check if the breaking news is hidden on mobiles ----------
	if( $type == 'header' && jannah_is_mobile_and_hidden( 'breaking_news' )) return;


	# Cache field key ----------
	$cache_key = 'breaking-news';


	# Classes and attr. ----------
	$breaking_attr  = '';
	$breaking_class = 'breaking';


	# Effect type ----------
	if( ! empty( $breaking_effect ) ){
		$breaking_attr .= ' data-type="'. $breaking_effect .'"';

		if( $breaking_effect == 'slideUp' || $breaking_effect == 'slideDown' ){
			$breaking_class .= ' up-down-controls';
		}
	}


	# Breaking News arrows ----------
	if( ! empty( $breaking_arrows ) ){
		$breaking_attr  .= ' data-arrows="true"';
		$breaking_class .= ' controls-is-active';
	}
	?>

	<div class="<?php echo esc_attr( $breaking_class ) ?>">

		<span class="breaking-title">
			<span class="fa fa-bolt" aria-hidden="true"></span>
			<span class="breaking-title-text"><?php echo ! empty( $breaking_title ) ? $breaking_title : esc_html__( 'Trending', 'jannah' ); ?></span>
		</span>

		<ul id="breaking-news-<?php echo esc_attr( $breaking_id ) ?>" class="breaking-news"<?php echo ( $breaking_attr ) ?>>

			<?php

				if( $breaking_type != 'custom' ){

					# Get the Cached data ----------
					if ( $type == 'header' && jannah_get_option( 'cache' ) && ( false !== ( $cached_data = get_transient( JANNAH_CACHE_KEY )) ) && ! ( defined( 'WP_CACHE' ) && WP_CACHE ) ){
						if( isset( $cached_data[ $cache_key ] )){
							$cached_breaking_news = $cached_data[ $cache_key ];
						}
					}

					# It wasn't there, so render the Breaking news and save it as a transient ----------
					if( empty( $cached_breaking_news )){

						ob_start();

						# Category or Tags ----------
						if( $type == 'header' ){

							$args = array(
								'number' => ( ! empty( $breaking_number ) ? $breaking_number : 10 ),
								'update_post_meta_cache' => false,
								'update_post_term_cache' => false,
							);

							if( $breaking_type == 'tag' ){
								$args['tags'] = $breaking_tag;
							}
							else{
								$args['id'] = $breaking_cat;
							}
						}
						else{
							$args = $breaking_block;
						}


						$breaking_query = jannah_query( $args );

						if( $breaking_query->have_posts() ){
							while( $breaking_query->have_posts() ){ $breaking_query->the_post(); ?>

								<li class="news-item">
									<a href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								</li>

								<?php
							}
						}

						wp_reset_postdata();

						$cached_breaking_news = ob_get_clean();

						if( $type == 'header' ){
							$GLOBALS[ JANNAH_CACHE_KEY ][ $cache_key ] = $cached_breaking_news;
						}
					}

					echo ( $cached_breaking_news );
				}

				else{

					if( ! empty( $breaking_custom ) && is_array( $breaking_custom ) ){
						$count = 0;
						foreach ($breaking_custom as $custom_text){
							$count++;

							$text = $link = '';

							# WPML ----------
							if( ! empty( $custom_text['text'] ) ){
								$text = ( $type == 'block' ) ? $custom_text['text'] : apply_filters( 'wpml_translate_single_string', $custom_text['text'], JANNAH_THEME_NAME, 'Breaking News Custom Text #'.$count );
							}

							if( ! empty( $custom_text['link'] ) ){
								$link = ( $type == 'block' ) ? $custom_text['link'] : apply_filters( 'wpml_translate_single_string', $custom_text['link'], JANNAH_THEME_NAME, 'Breaking News Custom Link #'.$count );
							}
							?>

							<li class="news-item">
								<a href="<?php echo esc_url( $link ) ?>" title="<?php echo esc_attr( $text ) ?>"><?php echo esc_html( $text ); ?></a>
							</li>

							<?php
						}
					}

				}
			?>

		</ul>
	</div><!-- #breaking /-->

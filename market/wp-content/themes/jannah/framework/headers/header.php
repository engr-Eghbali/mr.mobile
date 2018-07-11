<?php
	# Header theme layout ----------
	$header_layout = jannah_get_option( 'header_layout', 3 );

	# Rainbow Line ----------
	if( jannah_get_option( 'rainbow_header' ) ){
		echo '<div class="rainbow-line"></div>';
	}
?>

<header id="theme-header" <?php jannah_header_class(); ?>>
	<?php
		# Top Nav Above the Header ----------
		if( ! jannah_get_option( 'top_nav_position' ) ){
			get_template_part( 'framework/headers/header', 'top-nav' );
		}

		# Main Nav above the Header ----------
		if( jannah_get_option( 'main_nav_position' ) ){
			get_template_part( 'framework/headers/header', 'main-nav' );
		}

		# Header Content area ----------
		if( $header_layout != 1 ){
			get_template_part( 'framework/headers/header', 'content' );
		}

		# Main Nav Below the Header ----------
		if( ! jannah_get_option( 'main_nav_position' ) ){
			get_template_part( 'framework/headers/header', 'main-nav' );
		}

		# Top Nav Below the Header ----------
		if( jannah_get_option( 'top_nav_position' ) ){
			get_template_part( 'framework/headers/header', 'top-nav' );
		}
	?>
</header>

<?php
	# Get the Header AD for Layout 1 ----------
	if( $header_layout == 1 ){
		jannah_get_banner( 'banner_top', '<div class="stream-item-top-wrapper"><div class="stream-item stream-item-top">', '</div></div><div class="clearfix"></div><!-- .tie-col /-->' );
	}

	# Below Header banner ----------
	jannah_get_banner( 'banner_below_header', '<div class="stream-item stream-item-below-header">', '</div>' );

	# Get the main slider for the categories ----------
	get_template_part('framework/parts/category-slider');

	# Get single post below header layouts ----------
	get_template_part( 'framework/headers/header', 'posts-layout' );
?>

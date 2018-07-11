<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Sidebars Settings', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Sidebars Settings', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Sticky Sidebar', 'jannah' ),
			'id'     => 'sticky_sidebar',
			'type'   => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Widgets icon', 'jannah' ),
			'id'    => 'widgets_icon',
			'type'  => 'checkbox',
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Default Sidebar Position', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'id'      => 'sidebar_pos',
			'type'    => 'visual',
			'options' => array(
				'right'	     => array( esc_html__( 'Sidebar Right', 'jannah' ) => 'sidebars/sidebar-right.png' ),
				'left'	     => array( esc_html__( 'Sidebar Left', 'jannah' ) => 'sidebars/sidebar-left.png' ),
				'full'	     => array( esc_html__( 'Without Sidebar', 'jannah' ) => 'sidebars/sidebar-full-width.png' ),
				'one-column' => array( esc_html__( 'One Column', 'jannah' ) => 'sidebars/sidebar-one-column.png' ),
			)));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Add Custom Sidebar', 'jannah' ),
			'type'  => 'header',
		));

	?>

	<div class="option-item">

		<span class="tie-label"><?php esc_html_e( 'Sidebar Name', 'jannah' ) ?></span>

		<input id="sidebarName" type="text" size="56" style="direction:ltr; text-laign:left" name="sidebarName" value="">
		<input id="sidebarAdd" class="button" type="button" value="<?php esc_html_e( 'Add', 'jannah' ) ?>">

		<?php

			jannah_theme_option(
				array(
					'text' => esc_html__( 'Please add a name for the sidebar.', 'jannah' ),
					'id'   => 'custom_sidebar_error',
					'type' => 'error',
				));

		?>

		<ul id="sidebarsList">

			<?php

				$sidebars = jannah_get_option( 'sidebars' );
				if( ! empty( $sidebars ) && is_array( $sidebars ) ){
					foreach ( $sidebars as $sidebar ){ ?>
						<li class="parent-item">
							<div class="tie-block-head">
								<?php echo esc_html( $sidebar ) ?>
								<input id="tie_sidebars" name="tie_options[sidebars][]" type="hidden" value="<?php echo esc_attr( $sidebar ) ?>" />
								<a class="del-custom-sidebar del-item dashicons dashicons-trash"></a>
							</div>
						</li>
						<?php
					}
				}

			?>

		</ul>
	</div>

	<?php



	echo "<div id=\"custom-sidebars\">";

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Custom Sidebars', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Home Sidebar', 'jannah' ),
			'id'      => 'sidebar_home',
			'type'    => 'select',
			'options' => jannah_get_registered_sidebars(),
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Single Page Sidebar', 'jannah' ),
			'id'      => 'sidebar_page',
			'type'    => 'select',
			'options' => jannah_get_registered_sidebars(),
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Single Article Sidebar', 'jannah' ),
			'id'      => 'sidebar_post',
			'type'    => 'select',
			'options' => jannah_get_registered_sidebars(),
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Archives Sidebar', 'jannah' ),
			'id'      => 'sidebar_archive',
			'type'    => 'select',
			'options' => jannah_get_registered_sidebars(),
		));

	echo "</div>";

?>

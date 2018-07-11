<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Advanced Settings', 'jannah' ),
			'type'  => 'tab-title',
		));

	jannah_theme_option(
		array(
			'type'  => 'header',
			'title' => esc_html__( 'Post views settings', 'jannah' ),
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Post views settings', 'jannah' ),
			'id'      => 'tie_post_views',
			'type'    => 'select',
			'options' => array(
				''       => esc_html__( 'Disable', 'jannah' ),
				'theme'  => esc_html__( "Theme's module", 'jannah' ),
				'plugin' => esc_html__( 'Third party post views plugin', 'jannah' ),
			),
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Post meta field', 'jannah' ),
			'id'      => 'views_meta_field',
			'type'    => 'text',
			'default' => 'tie_views',
			'hint'    => esc_html__( 'Chnage this if you have used a post views plugin before.', 'jannah' ),
		));

	jannah_theme_option(
		array(
			'type'  => 'header',
			'title' => esc_html__( 'Advanced Settings', 'jannah' ),
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Cache', 'jannah' ),
			'id'   => 'cache',
			'type' => 'checkbox',
			'hint' => esc_html__( 'If enabled, some static parts like widgets, main menu and breaking news will be cached to reduce MySQL queries. Saving the theme settings, adding/editing/removing posts, adding comments, updating menus, activating/deactivating plugins, adding/editing/removing terms or updating WordPress, will flush the cache.', 'jannah' ),
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Minified CSS and JS files', 'jannah' ),
			'id'   => 'minified_files',
			'type' => 'checkbox',
		));


	if ( JANNAH_BWPMINIFY_IS_ACTIVE ){
		jannah_theme_option(
			array(
				'name' => esc_html__( 'Move CSS files to the footer', 'jannah' ),
				'id'   => 'styles_to_footer',
				'type' => 'checkbox',
			));
	}

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Notify on theme updates', 'jannah' ),
			'id'   => 'notify_theme',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Add a link to the theme options page to the Toolbar', 'jannah' ),
			'id'   => 'theme_toolbar',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'Disable GIF Featured Images', 'jannah' ),
			'id'   => 'disable_featured_gif',
			'type' => 'checkbox',
		));

	jannah_theme_option(
		array(
			'type'  => 'header',
			'title' => esc_html__( 'WordPress Login page Logo', 'jannah' ),
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'WordPress Login page Logo', 'jannah' ),
			'id'   => 'dashboard_logo',
			'type' => 'upload',
		));

	jannah_theme_option(
		array(
			'name' => esc_html__( 'WordPress Login page Logo URL', 'jannah' ),
			'id'   => 'dashboard_logo_url',
			'type' => 'text',
		));


	jannah_theme_option(
		array(
			'type'  => 'header',
			'title' => esc_html__( 'Reset All Settings', 'jannah' ),
		));
		?>

		<div class="option-item">
			<a id="tie-reset-settings" class="tie-primary-button button button-primary button-hero tie-button-red" href="<?php print wp_nonce_url( admin_url( 'admin.php?page=tie-theme-options&reset-settings' ), 'reset-theme-settings', 'reset_nonce' ) ?>" data-message="<?php esc_html_e( 'This action can not be Undo. Clicking "OK" will reset your theme options to the default installation. Click "Cancel" to stop this operation.', 'jannah'); ?>"><?php echo esc_html__( 'Reset All Settings', 'jannah' ); ?></a>
		</div>


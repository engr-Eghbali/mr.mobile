<?php

if( get_post_type() == 'page' ){

	# Categories options for the page templates ----------
	echo '<div id="tie-page-template-categories" class="tie-page-templates-options">';

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Masonry Page', 'jannah' ),
			'id'    => 'tie_categories_title',
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'id'      => 'tie_blog_layout',
			'type'    => 'visual',
			'columns' => 5,
			'options' => array(
				'masonry'        => array( esc_html__( 'Masonry', 'jannah' ).' #1' => 'archives/masonry.png' ),
				'overlay'        => array( esc_html__( 'Masonry', 'jannah' ).' #2' => 'archives/overlay.png' ),
				'overlay-spaces' => array( esc_html__( 'Masonry', 'jannah' ).' #3' => 'archives/overlay-spaces.png' ),
			)));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Uncropped featured image', 'jannah' ),
			'id'      => "tie_blog_uncropped_image",
			'type'   => 'checkbox',
		));

	jannah_custom_post_option(
		array(
			'name'   => esc_html__( 'Post Meta', 'jannah' ),
			'id'     => 'tie_blog_meta',
			'type'   => 'checkbox',
		));

	jannah_custom_post_option(
		array(
			'name'   => esc_html__( 'Categories Meta', 'jannah' ),
			'id'     => 'tie_blog_category_meta',
			'type'   => 'checkbox',
		));

	jannah_custom_post_option(
		array(
			'name'   => esc_html__( 'Posts Excerpt', 'jannah' ),
			'id'     => 'tie_blog_excerpt',
			'toggle' => '#tie_blog_length-item',
			'type'   => 'checkbox',
		));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Posts Excerpt Length', 'jannah' ),
			'id'   => 'tie_blog_length',
			'type' => 'number',
		));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Categories', 'jannah' ),
			'id'      => 'tie_blog_cats',
			'type'    => 'select-multiple',
			'options' => jannah_get_categories_array(),
		));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Number of posts to show', 'jannah' ),
			'id'   => 'tie_posts_num',
			'type' => 'number',
		));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Pagination', 'jannah' ),
			'id'      => 'tie_blog_pagination',
			'type'    => 'radio',
			'options' => array(
				''          => esc_html__( 'Default',           'jannah' ),
				'next-prev' => esc_html__( 'Next and Previous', 'jannah' ),
				'numeric'   => esc_html__( 'Numeric',           'jannah' ),
				'load-more' => esc_html__( 'Load More',         'jannah' ),
				'infinite'  => esc_html__( 'Infinite Scroll',   'jannah' ),
			)));

	echo '</div>';


	# Authors options for the page templates ----------
	$get_roles  = wp_roles();
	$user_roles = $get_roles->get_names();

	echo '<div id="tie-page-template-authors" class="tie-page-templates-options">';

	jannah_theme_option(
		array(
			'title' => esc_html__( 'User Roles', 'jannah' ),
			'id'    => 'tie_authors_title',
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'User Roles', 'jannah' ),
			'id'      => 'tie_authors',
			'type'    => 'select-multiple',
			'options' => $user_roles,
		));

	echo '</div>';


	# Header and Footer Settings ----------
	jannah_theme_option(
		array(
			'title' => esc_html__( 'Header and Footer Settings', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Hide the Header', 'jannah' ),
			'id'   => 'tie_hide_header',
			'type' => 'checkbox',
		));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Hide the Footer', 'jannah' ),
			'id'   => 'tie_hide_footer',
			'type' => 'checkbox',
		));


	# Hide Page title ----------
	echo '<div id="tie_hide_page_title_option">';

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Hide the page title', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Hide the page title', 'jannah' ),
			'id'   => 'tie_hide_title',
			'type' => 'checkbox',
		));

	echo '</div>';


	# Do Not Dublicate Posts ----------
	echo '<div id="tie_do_not_dublicate_option">';

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Don\'t dulicate posts', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'name' => esc_html__( 'Don\'t dulicate posts', 'jannah' ),
			'id'   => 'tie_do_not_dublicate',
			'type' => 'checkbox',
		));

	echo '</div>';

}


elseif( get_post_type() == 'post' ){
	jannah_theme_option(
		array(
			'title' => esc_html__( 'Primary Category', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Primary Category', 'jannah' ),
			'id'      => 'tie_primary_category',
			'type'    => 'select',
			'hint'     => esc_html__( 'If the posts has multiple categories, the one selected here will be used for settings and it appears in the category labels.', 'jannah' ),
			'options' => jannah_get_categories_array( true ),
		));

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Post format', 'jannah' ),
			'type'  => 'header',
		));

	jannah_custom_post_option(
		array(
			'id'      => 'tie_post_head',
			'type'    => 'visual',
			'columns' => 6,
			'toggle'  => array(
					'standard' => '#tie_post_featured-item',
					'thumb'    => '#tie_image_uncropped-item, #tie_image_lightbox-item',
					'video'    => '#tie_embed_code-item, #tie_video_url-item, #tie_video_self-item',
					'audio'    => '#tie_audio_mp3-item, #tie_audio_m4a-item, #tie_audio_oga-item, #tie_audio_soundcloud-item, #tie_audio_soundcloud_play-item , #tie_audio_soundcloud_visual-item',
					'slider'   => '#tie_post_slider-item, #tie_gallery_format_options',
					'map'      => '#tie_googlemap_url-item',),
			'options' => array(
					'standard' => array( esc_html__( 'Standard', 'jannah' ) => 'formats/format-standard.png' ),
					'thumb'    => array( esc_html__( 'Image', 'jannah' ) => 'formats/format-img.png' ),
					'video'    => array( esc_html__( 'Video', 'jannah' ) => 'formats/format-video.png' ),
					'audio'    => array( esc_html__( 'Audio', 'jannah' ) => 'formats/format-audio.png' ),
					'slider'   => array( esc_html__( 'Slider', 'jannah' ) => 'formats/format-slider.png' ),
					'map'      => array( esc_html__( 'Map', 'jannah' ) => 'formats/format-map.png' ),
		)));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Show the featured image', 'jannah' ),
			'id'      => "tie_post_featured",
			'type'    => "select",
			'class'   => 'tie_post_head',
			'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Yes', 'jannah' ),
					'no'  => esc_html__( 'No', 'jannah' ),
		)));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Uncropped featured image', 'jannah' ),
			'id'      => "tie_image_uncropped",
			'type'    => "select",
			'class'   => 'tie_post_head',
			'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Yes', 'jannah' ),
					'no'  => esc_html__( 'No', 'jannah' ),
		)));

	jannah_custom_post_option(
		array(
			'name'    => esc_html__( 'Featured image lightbox', 'jannah' ),
			'id'      => "tie_image_lightbox",
			'type'    => "select",
			'class'   => 'tie_post_head',
			'options' => array(
					''    => esc_html__( 'Default', 'jannah' ),
					'yes' => esc_html__( 'Yes', 'jannah' ),
					'no'  => esc_html__( 'No', 'jannah' ),
		)));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'Embed Code', 'jannah' ),
			'id'    => 'tie_embed_code',
			'type'  => 'textarea',
			'class' => 'tie_post_head',
		));

	jannah_custom_post_option(
		array(
			'name'     => esc_html__( 'Self Hosted Video', 'jannah' ),
			'id'       => 'tie_video_self',
			'pre_text' => esc_html__( '- OR -', 'jannah' ),
			'type'     => 'text',
			'class'    => 'tie_post_head',
		));

	jannah_custom_post_option(
		array(
			'name'     => esc_html__( 'Video URL', 'jannah' ),
			'id'       => 'tie_video_url',
			'pre_text' => esc_html__( '- OR -', 'jannah' ),
			'type'     => 'text',
			'hint'     => esc_html__( 'supports : YouTube, Vimeo, Viddler, Qik, Hulu, FunnyOrDie, DailyMotion, WordPress.tv and blip.tv', 'jannah' ),
			'class'    => 'tie_post_head',
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'MP3 file URL', 'jannah' ),
			'id'    => 'tie_audio_mp3',
			'type'  => 'text',
			'class' => 'tie_post_head',
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'M4A file URL', 'jannah' ),
			'id'    => 'tie_audio_m4a',
			'type'  => 'text',
			'class' => 'tie_post_head',
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'OGA file URL', 'jannah' ),
			'id'    => 'tie_audio_oga',
			'type'  => 'text',
			'class' => 'tie_post_head',
		));

	jannah_custom_post_option(
		array(
			'name'     => esc_html__( 'SoundCloud URL', 'jannah' ),
			'id'       => 'tie_audio_soundcloud',
			'pre_text' => esc_html__( '- OR -', 'jannah' ),
			'type'     => 'text',
			'class'    => 'tie_post_head',
		));

	jannah_custom_post_option(
		array(
			'name'  => esc_html__( 'Google Maps URL', 'jannah' ),
			'id'    => 'tie_googlemap_url',
			'type'  => 'text',
			'class' => 'tie_post_head',
		));

?>
	<div class="tie_post_head-options" id="tie_gallery_format_options">
		<input id="tie_upload_image" type="button" class="tie-primary-button button button-primary button-large" value="<?php esc_html_e( 'Add Image', 'jannah' ) ?>">

		<ul id="tie-gallery-items" class="option-item">
			<?php

				if( $gallery = jannah_get_postdata( 'tie_post_gallery' )){
					$gallery = maybe_unserialize( $gallery );
				}

				$i=0;
				if( ! empty( $gallery ) && is_array( $gallery )){
					foreach( $gallery as $slide ){
						$i++; ?>

						<li id="listItem_<?php echo esc_attr( $i ) ?>"  class="ui-state-default">
							<div class="gallery-img img-preview"><?php echo wp_get_attachment_image( $slide['id'] , 'thumbnail' );  ?>
								<input id="tie_post_gallery[<?php echo esc_attr( $i ) ?>][id]" name="tie_post_gallery[<?php echo esc_attr( $i ) ?>][id]" value="<?php echo esc_attr( $slide['id'] ) ?>" type="hidden" />
								<a class="del-img-all"></a>
							</div>
						</li>

						<?php
					}
				}
			?>
		</ul>
	</div>

	<script>
		var nextImgCell = <?php echo esc_js( $i+1 ) ?>;

		jQuery(document).ready(function(){
			jQuery(function(){
				jQuery( "#tie-gallery-items" ).sortable({placeholder: "tie-state-highlight"});
			});

			// Uploading files ----------
			var tie_slider_uploader;
			jQuery(document).on("click", "#tie_upload_image" , function( event ){
				event.preventDefault();
				tie_slider_uploader = wp.media.frames.tie_slider_uploader = wp.media({
					title: '<?php esc_html_e( 'Add Image', 'jannah' ) ?>',
					library: {type: 'image'},
					button: {text: '<?php esc_html_e( 'Select', 'jannah' ) ?>'},
					multiple: true,
				});

				tie_slider_uploader.on( 'select', function(){
					var selection = tie_slider_uploader.state().get('selection');
					selection.map( function( attachment ){
						attachment = attachment.toJSON();
						jQuery('#tie-gallery-items').append('\
							<li id="listItem_'+ nextImgCell +'" class="ui-state-default">\
								<div class="gallery-img img-preview">\
									<img src="'+attachment.url+'" alt=""><input id="tie_post_gallery['+ nextImgCell +'][id]" name="tie_post_gallery['+ nextImgCell +'][id]" value="'+attachment.id+'" type="hidden">\
									<a class="del-img-all"></a>\
								</div>\
							</li>\
						');

						nextImgCell ++;
					});
				});
				tie_slider_uploader.open();
			});
		});
	</script>
	<?php

	jannah_custom_post_option(
		array(
			'name'     => esc_html__( 'Custom Slider', 'jannah' ),
			'id'       => 'tie_post_slider',
			'type'     => 'select',
			'pre_text' => esc_html__( '- OR -', 'jannah' ),
			'class'    => 'tie_post_head',
			'options'  => jannah_get_custom_sliders( true ),
	));
} // is post
?>

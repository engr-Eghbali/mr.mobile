<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Translations Settings', 'jannah' ),
			'type'  => 'tab-title',
		));

	$translation_texts = jannah_translation_texts();

	foreach ( $translation_texts as $id => $text ){
		# Print the sections title ----------
		jannah_theme_option(
			array(
				'id'          => sanitize_title( $id ),
				'name'        => htmlspecialchars( $text ),
				'placeholder' => htmlspecialchars( $text ),
				'type'        => 'text',
			));
	}

?>

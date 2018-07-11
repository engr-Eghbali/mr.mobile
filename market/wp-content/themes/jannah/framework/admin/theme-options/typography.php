<?php

jannah_theme_option(
	array(
		'title' =>	esc_html__( 'Typography Settings', 'jannah' ),
		'type'  => 'tab-title',
	));

$fonts_sections = array(
	'body'         => esc_html__( 'Body Font Family',         'jannah' ),
	'headings'     => esc_html__( 'Headings Font Family',     'jannah' ),
	'menu'         => esc_html__( 'Primary menu Font Family', 'jannah' ),
	'blockquote'   => esc_html__( 'Blockquote Font Family',   'jannah' ),
);

foreach( $fonts_sections as $font_section_key => $font_section_text ){

	jannah_theme_option(
		array(
			'title' => $font_section_text,
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Source', 'jannah' ),
			'id'      => 'typography_'. $font_section_key .'_font_source',
			'type'    => 'select',
			'options' => array(
				''           => esc_html__( 'Theme Defaults', 'jannah' ),
				'standard'   => esc_html__( 'Standard Fonts', 'jannah' ),
				'google'     => esc_html__( 'Google Fonts', 'jannah' ),
				'fontfaceme' => esc_html__( 'FontFace.me Fonts', 'jannah' ),
				'external'   => esc_html__( 'Any external fonts (e.g. Typekit)', 'jannah' ),),
			'toggle' => array(
				''           => '',
				'standard'   => '#typography_'. $font_section_key .'_standard_font-item',
				'google'     => '#typography_'. $font_section_key .'_google_font_hint-item, #typography_'. $font_section_key .'_google_font-item, #typography_'. $font_section_key .'_google_variants-item, #typography_'. $font_section_key .'_google_char-item',
				'fontfaceme' => '#typography_'. $font_section_key .'_fontfaceme-item',
				'external'   => '#typography_'. $font_section_key .'_ext_font-item, #typography_'. $font_section_key .'_ext_head-item',
		)));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Font Family', 'jannah' ),
			'id'    => 'typography_'. $font_section_key .'_standard_font',
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'fonts',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Font Family', 'jannah' ),
			'id'    => 'typography_'. $font_section_key .'_google_font',
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'fonts',
		));

	jannah_theme_option(
		array(
			'id'    => 'typography_'. $font_section_key .'_google_font_hint',
			'text'  => '<strong>'. esc_html__( 'Tip:', 'jannah' ) .'</strong> '. esc_html__( 'Choosing a lot of Variants may make your pages slow to load.', 'jannah' ),
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'message',
		));

	jannah_theme_option(
		array(
			'name'    => esc_html__( 'Font Variants', 'jannah' ),
			'id'      => 'typography_'. $font_section_key .'_google_variants',
			'class'   => 'typography_'. $font_section_key .'_font_source',
			'hint'    => esc_html__( 'Please, make sure that chosen font supports chosen weight.', 'jannah' ),
			'type'    => 'select-multiple',
			'options' => array(
				'100'       => esc_html__( 'Thin 100',               'jannah' ),
				'100italic' => esc_html__( 'Thin 100 Italic',        'jannah' ),
				'200'       => esc_html__( 'Extra 200 Light',        'jannah' ),
				'200italic' => esc_html__( 'Extra 200 Light Italic', 'jannah' ),
				'300'       => esc_html__( 'Light 300',              'jannah' ),
				'300italic' => esc_html__( 'Light 300 Italic',       'jannah' ),
				'regular'   => esc_html__( 'Regular 400',            'jannah' ),
				'italic'    => esc_html__( 'Regular 400 Italic',     'jannah' ),
				'500'       => esc_html__( 'Medium 500',             'jannah' ),
				'500italic' => esc_html__( 'Medium 500 Italic',      'jannah' ),
				'600'       => esc_html__( 'Semi 600 Bold',          'jannah' ),
				'600italic' => esc_html__( 'Semi 600 Bold Italic',   'jannah' ),
				'700'       => esc_html__( 'Bold 700',               'jannah' ),
				'700italic' => esc_html__( 'Bold 700 Italic',        'jannah' ),
				'800'       => esc_html__( 'Extra 800 Bold',         'jannah' ),
				'800italic' => esc_html__( 'Extra 800 Bold Italic',  'jannah' ),
				'900'       => esc_html__( 'Black 900',              'jannah' ),
				'900italic' => esc_html__( 'Black 900 Italic',       'jannah' ),
			)));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Font Family', 'jannah' ),
			'id'    => 'typography_'. $font_section_key .'_fontfaceme',
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'fonts',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Embed code for the &lt;head&gt; section', 'jannah' ),
			'id'    => 'typography_'. $font_section_key .'_ext_head',
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'textarea',
		));

	jannah_theme_option(
		array(
			'name'  => esc_html__( 'Font Family', 'jannah' ),
			'id'    => 'typography_'. $font_section_key .'_ext_font',
			'hint'  => esc_html__( "Enter the value for 'font-family' attribute, also you can specify the stack of the fonts.", 'jannah' ),
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'text',
		));

} //end foreach;


jannah_theme_option(
	array(
		'title' =>	esc_html__( 'Google Web Font Character sets', 'jannah' ),
		'type'  => 'header',
	));

jannah_theme_option(
	array(
		'text'  => '<strong>'. esc_html__( 'Tip:', 'jannah' ) .'</strong> '. esc_html__( 'Choosing a lot of Character sets may make your pages slow to load.', 'jannah' ),
		'type'  => 'message',
	));

jannah_theme_option(
	array(
		'name'    => esc_html__( 'Google Web Font Character sets', 'jannah' ),
		'id'      => 'typography_google_character_sets',
		'class'   => 'typography_font_source',
		'hint'    => esc_html__( 'Latin charset by default. Include additional character sets for fonts (make sure at http://www.google.com/fonts/ before that charset is available for chosen font)', 'jannah' ),
		'type'    => 'select-multiple',
		'options' => array(
			'latin-ext'    => 'latin-ext',
			'cyrillic-ext' => 'cyrillic-ext',
			'cyrillic'     => 'cyrillic',
			'devanagari'   => 'devanagari',
			'greek'        => 'greek',
			'greek-ext'    => 'greek-ext',
			'khmer'        => 'khmer',
			'vietnamese'   => 'vietnamese',
		)));

jannah_theme_option(
	array(
		'title' =>	esc_html__( 'Font Sizes, Weights and Line Heights', 'jannah' ),
		'type'  => 'header',
	));

jannah_theme_option(
	array(
		'text'  => '<strong>'. esc_html__( 'Font Weight Tips:', 'jannah' ) .'</strong> <br />'.esc_html__( "- If you use a google font, make sure to load the font weight in 'Google Font Variants' field that corresponds to the one in parenthesis here.", 'jannah' ) .'<br />'. esc_html__( "- Browser standard fonts in general support only 'Normal (400)' and 'Bold (700)' font weights.", 'jannah' ),
		'type'  => 'message',
	));

$fonts_settings = array(
	'body'                   => esc_html__( 'Body', 'jannah' ),
	'site_title'             => esc_html__( 'Header Site name', 'jannah' ),
	'top_menu'               => esc_html__( 'Secondary Menu', 'jannah' ),
	'top_menu_sub'           => esc_html__( 'Secondary sub menus', 'jannah' ),
	'main_nav'               => esc_html__( 'Main Navigation', 'jannah' ),
	'main_nav_sub'           => esc_html__( 'Main Navigation sub menus', 'jannah' ),
	'mobile_menu'            => esc_html__( 'Mobile Menu', 'jannah' ),
	'breaking_news'          => esc_html__( 'Breaking News Label', 'jannah' ),
	'breaking_news_posts'    => esc_html__( 'Breaking News post titles', 'jannah' ),
	'breadcrumbs'            => esc_html__( 'Breadcrumbs', 'jannah' ),
	'buttons'                => esc_html__( 'Buttons', 'jannah' ),
	'post_cat_label'         => esc_html__( 'Post Categories Label', 'jannah' ),
	'single_post_title'      => esc_html__( 'Single Post Title', 'jannah' ),
	'post_title_blocks'      => esc_html__( 'Post Titles in Homepage Blocks', 'jannah' ),
	'post_small_title_blocks'=> esc_html__( 'Small Post Titles in Homepage Blocks', 'jannah' ),
	'post_entry'             => esc_html__( 'Single Post Page Contet', 'jannah' ),
	'blockquote'             => esc_html__( 'Blockquotes', 'jannah' ),
	'boxes_title'            => esc_html__( 'Blocks Titles', 'jannah' ),
	'widgets_title'          => esc_html__( 'Widgets Titles', 'jannah' ),
	'copyright'              => esc_html__( 'Copyright Area', 'jannah' ),
	'footer_widgets_title'   => esc_html__( 'Footer Widgets Titles', 'jannah' ),
	'post_heading_h1'        => esc_html__( 'Post Heading:', 'jannah' ) .' H1',
	'post_heading_h2'        => esc_html__( 'Post Heading:', 'jannah' ) .' H2',
	'post_heading_h3'        => esc_html__( 'Post Heading:', 'jannah' ) .' H3',
	'post_heading_h4'        => esc_html__( 'Post Heading:', 'jannah' ) .' H4',
	'post_heading_h5'        => esc_html__( 'Post Heading:', 'jannah' ) .' H5',
	'post_heading_h6'        => esc_html__( 'Post Heading:', 'jannah' ) .' H6',
);


foreach( $fonts_settings as $font_section_key => $font_section_text ){
	jannah_theme_option(
		array(
			'name' => $font_section_text,
			'id'    => 'typography_'. $font_section_key,
			'type'  => 'typography',
		));
}


?>

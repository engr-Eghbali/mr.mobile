<?php
// Get content width
$content_max_width       = absint( $this->get( 'content_max_width' ) );

// Get template colors
$theme_color             = jannah_get_option( 'amp_bg_color', '#ffffff' );
$text_color              = jannah_light_or_dark( $theme_color );
$post_title              = jannah_get_option( 'amp_title_color', $text_color );
$muted_text_color        = jannah_get_option( 'amp_meta_color', '#888888' );
$border_color            = '#ccc';
$link_color              = jannah_get_option( 'amp_links_color', '#0088ff' );

$header_background_color = jannah_get_option( 'amp_header_color', '#0088ff' );
$header_color            = jannah_light_or_dark( $header_background_color );

$footer_background_color = jannah_get_option( 'amp_footer_color', '#222222' );
$footer_color            = jannah_light_or_dark( $footer_background_color );

$text_decoration         = jannah_get_option( 'amp_links_underline' ) ? 'underline' : 'none';


/*
	We don't use the sanitize_hex_color in this file to allow RGBA colors.
*/

?>
/* Generic WP styling */

.alignright {
	float: right;
}

.alignleft {
	float: left;
}

.aligncenter {
	display: block;
	margin-left: auto;
	margin-right: auto;
}

.amp-wp-enforced-sizes {
	/** Our sizes fallback is 100vw, and we have a padding on the container; the max-width here prevents the element from overflowing. **/
	max-width: 100%;
	margin: 0 auto;
}

.amp-wp-unknown-size img {
	/** Worst case scenario when we can't figure out dimensions for an image. **/
	/** Force the image into a box of fixed dimensions and use object-fit to scale. **/
	object-fit: contain;
}

/* Template Styles */

.amp-wp-content,
.amp-wp-title-bar div {
	<?php if ( $content_max_width > 0 ) : ?>
	margin: 0 auto;
	max-width: <?php echo sprintf( '%dpx', $content_max_width ); ?>;
	<?php endif; ?>
}

html {
	background: <?php echo esc_attr( $header_background_color ); ?>;
}

body {
	background: <?php echo esc_attr( $theme_color ); ?>;
	color: <?php echo esc_attr( $text_color ); ?>;
	font-weight: 300;
	line-height: 1.75em;

	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", "Open Sans", sans-serif;
	padding-bottom: 0;
}

p,
ol,
ul,
figure {
	margin: 0 0 1em;
	padding: 0;
}

a,
a:visited {
	color: <?php echo esc_attr( $link_color ); ?>;

	text-decoration: none;
}

a:hover,
a:active,
a:focus {
	color: <?php echo esc_attr( $text_color ); ?>;

	text-decoration: <?php echo esc_attr( $text_decoration ); ?>;
}

/* Quotes */

blockquote {
	color: <?php echo esc_attr( $text_color ); ?>;
	background: rgba(127,127,127,.125);
	margin: 8px 0 24px 0;
	padding: 16px;

	border: 0 solid <?php echo esc_attr( $link_color ); ?>;
	border-left-width: 4px;
}

blockquote p:last-child {
	margin-bottom: 0;
}

/* UI Fonts */

.amp-wp-meta,
.amp-wp-header div,
.amp-wp-title,
.wp-caption-text,
.amp-wp-tax-category,
.amp-wp-tax-tag,
.amp-wp-comments-link,
.amp-wp-footer p,
.back-to-top {
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen-Sans", "Ubuntu", "Cantarell", "Helvetica Neue", sans-serif;
}

/* Header */

.amp-wp-header {
	background-color: <?php echo esc_attr( $header_background_color ); ?>;

	box-shadow: 0 0 24px 0 rgba(0, 0, 0, 0.25);
}

.amp-wp-header div {
	color: <?php echo esc_attr( $header_color ); ?>;
	font-size: 1em;
	font-weight: 400;
	margin: 0 auto;
	max-width: calc(700px - 32px);
	position: relative;

	padding: 1em 16px;
}

.amp-wp-header a {
	color: <?php echo esc_attr( $header_color ); ?>;
	text-decoration: none;
}

/* Site Icon */

.amp-wp-header .amp-wp-site-icon {
	/** site icon is 32px **/
	background-color: <?php echo esc_attr( $header_color ); ?>;
	border: 1px solid <?php echo esc_attr( $header_color ); ?>;
	position: absolute;
	right: 18px;
	top: 10px;
}

/* Article */

.amp-wp-article {
	color: <?php echo esc_attr( $text_color ); ?>;
	font-weight: 400;
	margin: 1.5em auto;
	max-width: 700px;
	overflow-wrap: break-word;
	word-wrap: break-word;
}

/* Article Header */

.amp-wp-article-header {
	align-items: center;
	align-content: stretch;
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
	margin: 1.5em 16px 1.5em;
}

.amp-wp-title {
	color: <?php echo esc_attr( $post_title ); ?>;
	display: block;
	flex: 1 0 100%;
	font-weight: bold;
	margin: 0 0 .625em;
	width: 100%;
	font-size: 2em;
	line-height: 1.2;
}

/* Article Meta */

.amp-wp-meta {
	color: <?php echo esc_attr( $muted_text_color ); ?>;
	display: inline-block;
	flex: 2 1 50%;
	font-size: .875em;
	line-height: 1.5em;
	margin: 0;
	padding: 0;
}

.amp-wp-article-header .amp-wp-meta:last-of-type {
	text-align: right;
}

.amp-wp-article-header .amp-wp-meta:first-of-type {
	text-align: left;
}

.amp-wp-byline amp-img,
.amp-wp-byline .amp-wp-author {
	display: inline-block;
	vertical-align: middle;
}

.amp-wp-byline amp-img {
	border: 1px solid <?php echo esc_attr( $link_color ); ?>;
	border-radius: 50%;
	position: relative;
	margin-right: 6px;
}

.amp-wp-posted-on {
	text-align: right;
}

/* Featured image */

.amp-wp-article-featured-image {
	margin: 0 0 1em;
}
.amp-wp-article-featured-image amp-img {
	margin: 0 auto;
}
.amp-wp-article-featured-image.wp-caption .wp-caption-text {
	margin: 0 18px;
}

/* Article Content */

.amp-wp-article-content {
	margin: 0 16px;
}

.amp-wp-article-content ul,
.amp-wp-article-content ol {
	margin-left: 1em;
}

.amp-wp-article-content amp-img {
	margin: 0 auto;
}

.amp-wp-article-content amp-img.alignright {
	margin: 0 0 1em 16px;
}

.amp-wp-article-content amp-img.alignleft {
	margin: 0 16px 1em 0;
}

/* Captions */

.wp-caption {
	padding: 0;
}

.wp-caption.alignleft {
	margin-right: 16px;
}

.wp-caption.alignright {
	margin-left: 16px;
}

.wp-caption .wp-caption-text {
	border-bottom: 1px solid <?php echo esc_attr( $border_color ); ?>;
	color: <?php echo esc_attr( $muted_text_color ); ?>;
	font-size: .875em;
	line-height: 1.5em;
	margin: 0;
	padding: .66em 10px .75em;
}

/* AMP Media */

amp-carousel {
	background: <?php echo esc_attr( $border_color ); ?>;
	margin: 0 -16px 1.5em;
}
amp-iframe,
amp-youtube,
amp-instagram,
amp-vine {
	background: <?php echo esc_attr( $border_color ); ?>;
	margin: 0 -16px 1.5em;
}

.amp-wp-article-content amp-carousel amp-img {
	border: none;
}

amp-carousel > amp-img > img {
	object-fit: contain;
}

.amp-wp-iframe-placeholder {
	background: <?php echo esc_attr( $border_color ); ?> url( <?php echo esc_url( $this->get( 'placeholder_image_url' ) ); ?> ) no-repeat center 40%;
	background-size: 48px 48px;
	min-height: 48px;
}

/* Article Footer Meta */

.amp-wp-article-footer .amp-wp-meta {
	display: block;
}

.amp-wp-tax-category,
.amp-wp-tax-tag {
	color: <?php echo esc_attr( $muted_text_color ); ?>;
	font-size: .875em;
	line-height: 1.5em;
	margin: 1.5em 16px;
}

.amp-wp-comments-link {
	color: <?php echo esc_attr( $muted_text_color ); ?>;
	font-size: .875em;
	line-height: 1.5em;
	text-align: center;
	margin: 2.25em 0 1.5em;
}

.amp-wp-comments-link a {
	border-style: solid;
	border-color: <?php echo esc_attr( $border_color ); ?>;
	border-width: 1px 1px 2px;
	border-radius: 4px;
	background-color: transparent;
	color: <?php echo ( $link_color ); ?>;
	cursor: pointer;
	display: block;
	font-size: 14px;
	font-weight: 600;
	line-height: 18px;
	margin: 0 auto;
	max-width: 200px;
	padding: 11px 16px;
	text-decoration: none;
	width: 50%;
	-webkit-transition: background-color 0.2s ease;
			transition: background-color 0.2s ease;
}


/** TIELABS CUSTOM STYLES AND ELEMENTS **/

<?php if( jannah_get_option( 'amp_logo' ) ):?>
	/* Custom Logo */
	.amp-wp-header a {
		background-image: url( '<?php echo esc_attr( jannah_get_option( 'amp_logo' ) ); ?>' );
		background-repeat: no-repeat;
		background-size: contain;
		background-position: center center;
		display: block;
		height: 35px;
		width: 215px;
		margin: 0 auto;
		text-indent: -9999px;
	}
<?php endif; ?>


/* TieLabs AMP Footer */
.top a{
	background-color: <?php echo esc_attr( $footer_background_color ); ?>;
	padding: 5px;
	width: 30px;
	margin: 0 auto;
	display: block;
	text-align: center;
	text-decoration: none;
}
.top a:hover,
.top a:focus{
	text-decoration: none;
}
.footer {
  background-color: <?php echo esc_attr( $footer_background_color ); ?>;
  padding: 1.5em 1em;
  color: <?php echo esc_attr( $footer_color ); ?>;
  text-align: center;
}
.footer-links a,
.footer-links a:hover,
.footer-links a:active,
.footer-links a:visited,
.top a,
.top a:hover,
.top a:active,
.top a:visited {
  color: <?php echo esc_attr( $footer_color ); ?>;
}
.footer-logo {
  display: block;
  background-repeat: no-repeat;
  background-size: contain;
  background-position: center;
  height: 50px;
  width: 200px;
  margin: auto;
  margin-bottom: 1.5em;
}

<?php if( jannah_get_option( 'amp_footer_logo' ) ):?>
	.footer-logo {
		background-image: url( '<?php echo esc_attr( jannah_get_option( 'amp_footer_logo' ) ); ?>' );
	}
<?php endif; ?>


.footer-links {
  text-align: center;
  padding-bottom: 1em;
  line-height: 1;
}
.footer-links a {
  display: inline-block;
  padding: 0 10px;
  font-size: 12px;
}
.footer-colophon {
  font-size: 10px;
}

/* TieLabs Related Posts */
.amp-related-posts{
	margin-top: 50px;
}
.amp-related-posts span{
	display: block;
	font-weight: bold;
	font-size: 24px;
}
.amp-related-posts a{
	display: block;
	padding: 5px 10px;
}

/* TieLabs ADS */
.amp-wp-content amp-ad {
	margin: 10px auto;
	display: block;
	text-align: center;
}

/* TieLabs Share Buttons */
.social{
	margin: 10px 0;
	text-align: center;
}

amp-social-share {
	background-size: 30px 30px;
	margin: 0 3px;
}

/* TieLabs carousel */
amp-carousel {
	background: transparent;
}

/* TieLabs Misc */
.amp-featured{
	margin-bottom: 10px;
}

.wp-audio-shortcode{
	min-width: 100%;
}

.review_wrap{
	display: none;
}

<?php if( is_rtl() ): ?>
body {
	direction: rtl;
	unicode-bidi: embed;
}

.amp-wp-article-header .amp-wp-meta:first-of-type {
	text-align: right;
}

.amp-wp-article-header .amp-wp-meta:last-of-type {
	text-align: left;
}

<?php endif; ?>

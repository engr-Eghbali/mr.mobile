<?php
/**
 * This template used for blocks and archives layouts
 *
 * @package Jannah
 */
?>

<li <?php jannah_post_class( 'post-item' ); ?>>

	<?php
	# Get the Post Meta info ----------
	if( ! empty( $block['post_meta'] )){
		jannah_the_post_meta();
	}
	?>

	<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php jannah_the_title( $block['title_length'] ); ?></a></h3>
	<div class="entry"><?php the_content( __ti( 'Read More &raquo;' ) ) ?></div>

</li>

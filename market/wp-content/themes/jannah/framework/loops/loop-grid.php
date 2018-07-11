<?php
/**
 * This template used for blocks layouts
 *
 * @package Jannah
 */



if( $block['style'] != 'row' && $count == 1 ):

	$background = jannah_get_option( 'lazy_load' ) ? 'data-src="'. esc_attr( jannah_thumb_src( 'jannah-image-post' ) ) .'"' : 'style="'. esc_attr( jannah_thumb_src_bg( 'jannah-image-post' ) ) .'"'; ?>

	<li>
		<a href="<?php the_permalink() ?>" <?php jannah_post_class( 'post-thumb' ); ?> <?php echo ( $background ); ?>>
			<?php jannah_the_score( 'large' ); ?>
			<div class="post-thumb-overlay">
				<span class="icon"></span>
			</div>
		</a>
	</li>

<?php else:

	$background = jannah_get_option( 'lazy_load' ) ? 'data-src="'. esc_attr( jannah_thumb_src( 'jannah-image-large' ) ) .'"' : 'style="'. esc_attr( jannah_thumb_src_bg( 'jannah-image-large' ) ) .'"'; ?>

	<li>
		<a href="<?php the_permalink() ?>" <?php jannah_post_class( 'post-thumb' ); ?> <?php echo ( $background ); ?>>
			<div class="post-thumb-overlay">
		    <span class="icon"></span>
		  </div>
		</a>
	</li>

<?php endif; ?>

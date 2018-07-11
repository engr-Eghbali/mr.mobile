<?php
/**
 * This template used for archives layouts
 *
 * @package Jannah
 */
?>

<div <?php jannah_post_class( 'container-wrapper post-element' ); ?>>
	<div style="<?php echo jannah_thumb_src_bg( 'jannah-image-grid' ) ?>" class="slide">
		<a href="<?php the_permalink() ?>" class="all-over-thumb-link"></a>

		<div class="thumb-overlay">

			<?php

				# Get the Post Category ----------
				if( ! is_category() && $block['category_meta'] ){
					jannah_the_category( '<h5 class="post-cat-wrap">', '</h5>');
				}

			?>

			<div class="thumb-content">

				<?php
					if( $block['post_meta'] ){
						jannah_the_post_meta( array( 'author' => false, 'comments' => false, 'views' => false ), '<div class="thumb-meta">', '</div>' );
					}
				?>

				<h3 class="thumb-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>

				<?php if( $block['excerpt'] ): ?>
					<div class="thumb-desc">
						<?php jannah_the_excerpt( $block['excerpt_length'] ) ?>
					</div><!-- .thumb-desc -->
				<?php endif; ?>

			</div> <!-- .thumb-content /-->
		</div><!-- .thumb-overlay /-->
	</div><!-- .slide /-->
</div><!-- .container-wrapper /-->

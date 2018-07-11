<?php
/**
 * This template used for archives layouts
 *
 * @package Jannah
 */
?>

<div <?php jannah_post_class( 'container-wrapper post-element' ); ?>>
	<div class="entry-archives-header">
		<div class="entry-header-inner">

			<?php
				# Get the Post Category ----------
				if( ! is_category() && $block['category_meta'] ){
					jannah_the_category( '<h5 class="post-cat-wrap">', '</h5>');
				}
			?>

			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title() ?></a></h3>

			<?php
				# Get the Post Meta info ----------
				if( $block['post_meta'] ){
					jannah_the_post_meta( array( 'author' => false ));
				}
			?>

		</div><!-- .entry-header-inner /-->
	</div><!-- .entry-header /-->

	<div class="clearfix"></div>

	<div class="featured-area">
		<?php
			# Get the post thumbnail ----------
			if ( has_post_thumbnail() ){
				jannah_post_thumbnail( $block['uncropped_image'], 'large' );
			}
		?>
	</div>

	<?php if( $block['excerpt'] ): ?>
		<div class="entry-content">
			<p><?php jannah_the_excerpt( $block['excerpt_length'] ); ?></p>
			<a class="more-link" href="<?php the_permalink() ?>"><?php _eti( 'Read More &raquo;' ) ?></a>
		</div><!-- .entry-content /-->
	<?php endif; ?>

</div><!-- .container-wrapper :: single post /-->
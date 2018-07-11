<?php
/**
 * This template used for blocks layouts
 *
 * @package Jannah
 */


if( $count == 1 ) :

	$background = jannah_get_option( 'lazy_load' ) ? 'data-src="'. esc_attr( jannah_thumb_src( 'jannah-image-grid' ) ) .'"' : 'style="'. esc_attr( jannah_thumb_src_bg( 'jannah-image-grid' ) ) .'"'; ?>

	<li <?php jannah_post_class( 'post-item' ); ?>>
		<div class="big-thumb-left-box-inner" <?php echo ( $background ); ?>>
			<?php
			# Get the post thumbnail ----------
			if ( has_post_thumbnail() ){
				jannah_post_thumbnail( false, 'large' );
			}
			?>

			<div class="post-overlay">
				<div class="post-content">

					<?php
					# Get the Post Meta info ----------
					if( ! empty( $block['post_meta'] )){
						jannah_the_post_meta( '', '<div class="thumb-meta">', '</div>' );
					}
					?>

					<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php jannah_the_title( $block['title_length'] ); ?></a></h3>

				</div>
			</div>
		</div>
	</li><!-- .first-post -->

<?php else:

	#Set custom class for the post without thumb ----------
	$post_without_thumb = '';
	if ( ! has_post_thumbnail() || ! empty( $block['thumb_small'] )){
		$post_without_thumb = ' no-small-thumbs';
	}
	?>

	<li <?php jannah_post_class( 'post-item'.$post_without_thumb ); ?>>
		<?php
		# Get the post thumbnail ----------
		if ( has_post_thumbnail() && empty( $block['thumb_small'] ) ){
			jannah_post_thumbnail();
		}
		?>

		<div class="post-details">

			<?php
			# Get the Post Meta info ----------
			if( ! empty( $block['post_meta'] )){
				jannah_the_post_meta( array( 'author' => false, 'comments' => false, 'views' => false, 'review' => true ) );
			}
			?>

			<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php jannah_the_title( $block['title_length'] ); ?></a></h3>
		</div><!-- .post-details /-->
	</li>

<?php endif; ?>

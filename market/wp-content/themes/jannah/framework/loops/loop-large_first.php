<?php
/**
 * This template used for blocks layouts
 *
 * @package Jannah
 */


if( $count == 1 ) :

	# Set custom class for the post without thumb ----------
	$post_without_thumb = '';
	if ( ! has_post_thumbnail() || ! empty( $block['thumb_first'] ) ){
		$post_without_thumb = ' no-small-thumbs';
	}
	?>
	<li <?php jannah_post_class( 'post-item'.$post_without_thumb ); ?>>
		<?php
		# Get the post thumbnail ----------
		if ( has_post_thumbnail() && empty( $block['thumb_first'] ) ){
			jannah_post_thumbnail( 'jannah-image-large', 'large' );
		}
		?>

		<div class="post-details">

			<?php
			# Get the Post Meta info ----------
			if( ! empty( $block['post_meta'] )){
				jannah_the_post_meta();
			}
			?>

			<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php jannah_the_title( $block['title_length'] ); ?></a></h3>

			<?php
				if( ! empty( $block['excerpt'] )){ ?>
					<p class="post-excerpt"><?php jannah_the_excerpt( $block['excerpt_length'] ) ?></p>
					<?php
				}

				if( ! empty( $block['read_more'] )){ ?>
					<a class="more-link" href="<?php the_permalink() ?>"><?php _eti( 'Read More &raquo;' ) ?></a>
					<?php
				}
			?>

		</div><!-- .post-details /-->

	</li><!-- .first-post -->

<?php else:

	# Set custom class for the post without thumb ----------
	$post_without_thumb = '';
	if ( ! has_post_thumbnail() || ! empty( $block['thumb_small'] ) ){
		$post_without_thumb = ' no-small-thumbs';
	}
	?>

	<li <?php jannah_post_class( 'post-item'.$post_without_thumb ); ?>>
		<?php
		#Get the post thumbnail ----------
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

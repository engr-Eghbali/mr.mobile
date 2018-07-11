<?php
/**
 * This template used for blocks layouts
 *
 * @package Jannah
 */
?>

<div <?php jannah_post_class( 'slide' ); ?>>

	<?php if ( has_post_thumbnail() ): ?>
		<div class="slide-img">
			<?php jannah_post_thumbnail( 'jannah-image-large' ); ?>
		</div><!-- .slide-img /-->
	<?php endif; ?>

	<div class="slide-content">

		<?php
			# Get the Post Meta info ----------
			if( ! empty( $block['post_meta'] )){
				jannah_the_post_meta( array( 'author' => false ) );
			}
		?>

		<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php jannah_the_title( $block['title_length'] ); ?></a></h3>

		<?php
			# Get the review score for the posts with stars ----------
			if( ! empty( $block['post_meta'] )){
				echo '<div class="post-meta">'. jannah_get_score( 'stars' ) .'</div>';
			}
		?>

	</div>
</div><!-- .Slide /-->

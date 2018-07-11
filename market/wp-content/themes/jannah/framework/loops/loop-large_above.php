<?php
/**
 * This template used for blocks layouts
 *
 * @package Jannah
 */
?>


<li <?php jannah_post_class( 'post-item' ); ?>>

	<?php

	if( $count == 1 ) :

		# Get the post thumbnail ----------
		if ( has_post_thumbnail() ){
			jannah_post_thumbnail( 'jannah-image-post', 'large' );
		}
		?>

		<div class="clearfix"></div>

		<div class="post-overlay">
			<?php jannah_the_category( '<h5 class="post-cat-wrap">', '</h5>'); ?>

			<div class="post-content">
				<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php jannah_the_title( $block['title_length'] ); ?></a></h3>

				<?php
				# Get the Post Meta info ----------
				if( ! empty( $block['post_meta'] ) ){
					jannah_the_post_meta( '', '<div class="thumb-meta">', '</div><!-- .thumb-meta -->' );
				}
				?>

			</div><!-- .post-content -->
		</div><!-- .post-overlay -->

		<?php
	else:

		# Get the post thumbnail ----------
		if ( has_post_thumbnail() ){
			jannah_post_thumbnail( 'jannah-image-large' );
		} ?>

		<div class="clearfix"></div>

		<div class="post-overlay">
			<div class="post-content">

				<?php
				# Get the Post Meta info ----------
				if( ! empty( $block['post_meta'] ) ){
					jannah_the_post_meta( array( 'author' => false, 'views' => false ) );
				}
				?>

				<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php jannah_the_title( $block['title_length'] ); ?></a></h3>

				<?php
				# Get the review score for the posts with stars ----------
				if( ! empty( $block['post_meta'] )){
					echo '<div class="post-meta">'. jannah_get_score( 'stars' ) .'</div>';
				}
				?>

			</div><!-- .post-content -->
		</div><!-- .post-overlay -->

	<?php endif; ?>

</li>

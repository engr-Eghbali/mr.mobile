<?php
/**
 * This template used for blocks layouts
 *
 * @package Jannah
 */


# Set custom class for the post without thumb ----------
$post_without_thumb = '';
if ( ! has_post_thumbnail() || ! empty( $block['thumb_all'] )){
	$post_without_thumb = ' no-small-thumbs';
}
?>

<li <?php jannah_post_class( 'post-item'.$post_without_thumb ); ?>>

	<?php
	# Get the Post Meta info ----------
	if( ! empty( $block['post_meta'] )){
		jannah_the_post_meta( array( 'author' => false, 'comments' => false, 'review' => true ) );
	}
	?>

	<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php jannah_the_title( $block['title_length'] ); ?></a></h3>

	<?php
	# Get the post thumbnail ----------
	if ( has_post_thumbnail() && empty( $block['thumb_all'] ) ){
		jannah_post_thumbnail( 'jannah-image-small', false );
	}
	?>

	<?php
		if( ! empty( $block['excerpt'] )){ ?>
			<div class="post-details">
				<p class="post-excerpt"><?php jannah_the_excerpt( $block['excerpt_length'] ) ?></p>
			</div>
			<?php
		}
	?>

</li>

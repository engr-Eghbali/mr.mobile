<?php
/**
 * This template used for blocks and archives layouts
 *
 * @package Jannah
 */
?>

<?php

	# Set custom class for the post without thumb ----------
	$post_without_thumb = '';
	if ( ! has_post_thumbnail() || ! empty( $block['thumb_small'] ) ){
		$post_without_thumb = ' no-small-thumbs';
	}

?>

<li <?php jannah_post_class( 'post-item'.$post_without_thumb, false, true ); ?>>

	<?php
	# Get the post thumbnail ----------
	if ( has_post_thumbnail() && empty( $block['thumb_all'] ) ){
		jannah_post_thumbnail( 'jannah-image-large', 'large' );
	}



	# Get the Post Meta info ----------
	if( ! empty( $block['post_meta'] )){
		jannah_the_post_meta();
	}
	?>

	<div class="post-details">
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

	</div>

</li>

<?php
/**
 * This template used for blocks and archives layouts
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
	if( empty( $GLOBALS['timeline_time'] ) || $GLOBALS['timeline_time'] != get_the_time('M Y') ){
		echo '<div class="year-month"><span>'. get_the_time('M') .'</span><em>- '. get_the_time('Y') .' -</em></div>';
	}

	$GLOBALS['timeline_time'] = get_the_time('M Y');
	?>

	<div class="clearfix"></div>
	<div class="day-month"><span><?php echo get_the_time('j F') ?></span></div>

	<div class="post-item-inner">

		<?php
		# Get the post thumbnail ----------
		if ( has_post_thumbnail() && empty( $block['thumb_all'] )){
			jannah_post_thumbnail( 'jannah-image-large', 'large' );
		}
		?>

		<div class="post-details">

			<?php
			# Get the Post Meta info ----------
			if( ! empty( $block['post_meta'] )){
				jannah_the_post_meta( array( 'date' => false ) );
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
		</div><!-- .post-details -->
	</div><!-- .post-item-inner -->

</li>

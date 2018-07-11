<?php
/**
 * This template used for blocks layouts
 *
 * @package Jannah
 */
?>

<div <?php jannah_post_class( 'slide' ); ?>>

	<?php
	if ( has_post_thumbnail() ){
		jannah_post_thumbnail( 'jannah-image-large', 'large' );
	}
	?>

	<div class="post-overlay">
		<div class="post-content">
			<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php jannah_the_title( $block['title_length'] ); ?></a></h3>
		</div>
	</div>

</div><!-- .Slide /-->

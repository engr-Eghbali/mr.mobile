<?php

# Set custom class for the post without thumb ----------
$post_without_thumb = '';
if ( ! has_post_thumbnail() ){
	$post_without_thumb = ' no-small-thumbs';
}

?>

<li <?php jannah_post_class( 'mega-menu-post' . $post_without_thumb ) ?>>

	<?php
	if ( has_post_thumbnail() ){ ?>

		<div class="post-thumbnail">
			<a class="post-thumb" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<div class="post-thumb-overlay">
					<span class="icon"></span>
				</div>

				<?php the_post_thumbnail( $thumbnail ) ?>
			</a>
		</div><!-- .post-thumbnail /-->
		<?php
	}
	?>

	<div class="post-details">

		<h3 class="post-box-title">
			<a class="mega-menu-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		</h3>

		<?php jannah_the_post_meta( array( 'author' => false, 'comments' => false, 'views' => false ) ); ?>

	</div>

</li>

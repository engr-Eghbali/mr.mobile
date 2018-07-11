<div <?php jannah_post_class( 'mega-recent-post' ) ?>>

	<?php
	if( has_post_thumbnail() ){ ?>

		<div class="post-thumbnail">
			<a class="post-thumb" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<div class="post-thumb-overlay">
					<span class="icon"></span>
				</div>

				<?php the_post_thumbnail( 'jannah-image-post' ) ?>
			</a>
		</div><!-- .post-thumbnail /-->
		<?php
	}

	jannah_the_post_meta();
	?>

	<h3 class="post-box-title">
		<a class="mega-menu-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	</h3>

</div><!-- mega-recent-post -->

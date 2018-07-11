<li <?php jannah_post_class( 'widget-post-list' ); ?>>

	<?php
	$post_without_thumb = ' no-small-thumbs';
	if ( has_post_thumbnail() ):
		$post_without_thumb = ''; ?>

		<div class="post-widget-thumbnail">
			<a class="post-thumb" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

				<div class="post-thumb-overlay">
					<span class="icon"></span>
				</div>
			</a>

			<?php
			if( $count == 1 ){
				$thumbnail = ! empty( $thumbnail_first ) ? $thumbnail_first : $thumbnail;
				$review    = ! empty( $review_first )    ? $review_first    : $review;
			}

			jannah_post_thumbnail( $thumbnail, $review );
			?>
		</div><!-- post-alignleft /-->
	<?php endif; ?>

	<div class="post-widget-body<?php echo esc_attr( $post_without_thumb ) ?>">
		<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a></h3>

		<div class="post-meta">
			<?php

			jannah_get_time();

			if( ! empty( $thumbnail_first ) && $count == 1 ){

			}
			elseif( ! empty( $show_score ) ){
				jannah_the_score( 'stars' );
			}
			?>
		</div>

	</div>

</li>

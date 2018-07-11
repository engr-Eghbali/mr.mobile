<?php

	if( empty( $videos_data ) ) return;

	# Enqueue the Sliders Js file ----------
	wp_enqueue_script( 'jannah-sliders' );


	# Variables ----------
	$youtube_thumbnail_base = 'https://i.ytimg.com/vi/';
	$youtube_player_base    = 'https://www.youtube.com/embed/';
	$vimeo_thumbnail_base   = 'https://i.vimeocdn.com/video/';
	$vimeo_player_base      = 'https://player.vimeo.com/video/';
	$playlist_has_title     = ! empty( $title ) ? ' playlist-has-title' : '';
	$videos_count           = count( $videos_data );
	$videos_list            = array();
	$youtube_videos         = get_option( 'tie_youtube_videos' );
	$vimeo_videos           = get_option( 'tie_vimeo_videos' );


	# Get Videos ----------
	foreach ( $videos_data as $video ){

		# Youtube ----------
		if( $video['type'] == 'y' ){

			$video_id = $video['id'];

			if( ! empty( $youtube_videos[ $video_id ] )){
				$video_data          = $youtube_videos[ $video_id ];
				$video_data['thumb'] = $youtube_thumbnail_base. $video_id .'/default.jpg';
				$video_data['id']    = $youtube_player_base. $video_id .'?enablejsapi=1&amp;rel=0&amp;showinfo=0';
			}
		}

		# Vimeo ----------
		elseif( $video['type'] == 'v' ){

			$video_id = $video['id'];

			if( ! empty( $vimeo_videos[ $video_id ] )){
				$video_data          = $vimeo_videos[ $video_id ];
				$video_data['thumb'] = $vimeo_thumbnail_base. $video_data['thumb'];
				$video_data['id']    = $vimeo_player_base. $video_id .'?api=1&amp;title=0&amp;byline=0';
			}
		}

		$videos_list[] = $video_data;
	}

	?>

	<div class="videos-block">
		<div class="video-playlist-wrapper">

			<?php
				# Loader icon ----------
				jannah_get_ajax_loader();
			?>

			<div class="video-player-wrapper">
				<?php foreach( $videos_list as $video ): ?>
					<iframe class="video-frame" id="video-<?php echo esc_attr( $id ) ?>-1" src="<?php echo esc_attr( $video['id'] ) ?>" width="100%" height="434" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen async></iframe>
				<?php break; endforeach; ?>
			</div><!-- .video-player-wrapper -->

		</div><!-- .video-playlist-wrapper /-->

		<div class="video-playlist-nav-wrapper">
			<div class="container">

				<?php if( ! empty( $title ) ): ?>
					<div class="playlist-title">
						<div class="playlist-title-icon"><span class="fa fa-play" aria-hidden="true"></span></div>
						<h2><?php echo esc_html( $title ) ?></h2>
						<span class="videos-number">
							<span class="video-playing-number">1</span> / <span class="video-totlal-number"><?php echo ( $videos_count ) ?></span> <?php _eti( 'Videos' ); ?>
						</span>
					</div> <!-- .playlist-title /-->
				<?php endif; ?>

				<div data-height="window" class="video-playlist-nav has-custom-scroll<?php echo esc_attr( $playlist_has_title ) ?>">

					<?php
					$video_number = 0;
					foreach( $videos_list as $video ):
						$video_number++;
						?>
						<a data-name="video-<?php echo esc_attr( $id. '-' .$video_number ) ?>" data-src="<?php echo esc_attr( $video['id'] ) ?>" class="video-playlist-item">
							<div class="video-number"><?php echo esc_attr( $video_number ) ?></div>
							<div class="video-play-icon"><span class="fa fa-play" aria-hidden="true"></span></div>
							<div class="video-paused-icon"><span class="fa fa-pause" aria-hidden="true"></span></div>
							<div style="background-image: url(<?php echo esc_attr( $video['thumb'] ) ?>) " class="video-thumbnail"></div>
							<div class="video-info">
								<h2><?php echo esc_attr( $video['title'] ) ?></h2>
								<span class="video-duration"><?php echo esc_attr( $video['duration'] ) ?></span>
							</div><!-- .video-info -->
						</a><!-- video-playlist-item -->
						<?php
					endforeach;
					?>

				</div><!-- .video-playlist-nav /-->
			</div><!-- .container /-->
		</div><!-- .video-playlist-nav-wrapper /-->
	</div><!-- .videos-block /-->

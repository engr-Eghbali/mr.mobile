<div class="container">
	<div class="tie-row logo-row">

		<?php

		$header_layout = jannah_get_option( 'header_layout', 3 );

		?>

		<div class="tie-col-md-4 logo-container">
			<?php

			do_action( 'jannah_before_logo' );

			jannah_logo();

			?>
		</div><!-- .tie-col /-->

		<?php
		# Get the Header AD ----------
		jannah_get_banner( 'banner_top', '<div class="tie-col-md-8 stream-item-top-wrapper"><div class="stream-item stream-item-top">', '</div></div><!-- .tie-col /-->' );
		?>

	</div><!-- .tie-row /-->
</div><!-- .container /-->

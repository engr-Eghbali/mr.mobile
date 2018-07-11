<?php
/*
if( function_exists( 'bp_is_user' ) && bp_is_user() ){
	return;
}
*/


if( ! jannah_get_postdata( 'tie_hide_title' ) ){
	$title_tag = is_front_page() ? 'h2' : 'h1'; ?>

	<header class="entry-header-outer">
		<?php jannah_breadcrumbs() ?>
		<div class="entry-header">
			<<?php echo esc_attr( $title_tag ) ?> class="post-title entry-title"><?php the_title(); ?></h<?php echo esc_attr( $title_tag ) ?>>
		</div><!-- .entry-header /-->
	</header><!-- .entry-header-outer /-->

	<?php
}
?>

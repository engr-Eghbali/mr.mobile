<?php
/**
 * The template for displaying the footer
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

			<?php
				do_action( 'jannah_after_main_content' );

				# Show the footer if it is enabled ----------
				if( apply_filters( 'jannah_is_footer_active', true ) ){
					get_template_part( 'framework/footers/footer' );
				}
			?>


		</div><!-- #tie-wrapper /-->

		<?php get_sidebar( 'slide' ); ?>

	</div><!-- #tie-container /-->
</div><!-- .background-overlay /-->

<?php wp_footer();?>
</body>
</html>

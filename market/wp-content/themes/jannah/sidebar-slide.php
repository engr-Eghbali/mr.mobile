<?php
/**
 * The template for the sidebar containing the slide widget area
 *
 * @package Jannah
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<?php
  if(
    apply_filters( 'jannah_is_header_active', true ) &&
    (
      (
        ( jannah_get_option( 'top_nav' )  &&  jannah_get_option( 'top-nav-components_slide_area' )) ||
        ( jannah_get_option( 'main_nav' ) && jannah_get_option( 'main-nav-components_slide_area' ))
      ) || jannah_get_option( 'mobile_menu_active' )
    )
  ): ?>

  <aside class="side-aside normal-side tie-aside-effect dark-skin" aria-label="<?php esc_html_e( 'Secondary Sidebar', 'jannah' ); ?>">
    <div data-height="100%" class="side-aside-wrapper has-custom-scroll">

      <a href="#" class="tie-btn-close close-side-aside">
        <span class="tie-icon-cross" aria-hidden="true"></span>
        <span class="screen-reader-text"><?php esc_html_e( 'Close', 'jannah' ); ?></span>
      </a><!-- .close-side-aside /-->


      <?php $class = ! jannah_get_option( 'mobile_menu_icons' ) ? 'hide-menu-icons' : ''; ?>

      <div id="mobile-container">

        <div id="mobile-menu" class="<?php echo esc_attr( $class ) ?>"></div><!-- #mobile-menu /-->

        <div class="mobile-social-search">
          <?php

          # Social Networks ----------
          if( jannah_get_option( 'mobile_menu_social' ) ){ ?>
            <div id="mobile-social-icons" class="social-icons-widget solid-social-icons">
              <?php jannah_get_social(); ?>
            </div><!-- #mobile-social-icons /-->
            <?php
          }

          # Search ----------
          if( jannah_get_option( 'mobile_menu_search' ) ){ ?>
            <div id="mobile-search">
              <?php get_search_form(); ?>
            </div><!-- #mobile-search /-->
            <?php
          }

          ?>
        </div><!-- #mobile-social-search /-->

      </div><!-- #mobile-container /-->


      <?php if( ! jannah_is_mobile() &&
              ( ( jannah_get_option( 'top_nav' ) && jannah_get_option( 'top-nav-components_slide_area' )) ||
                ( jannah_get_option( 'main_nav' ) && jannah_get_option( 'main-nav-components_slide_area' )))){ ?>

        <div id="slide-sidebar-widgets">
          <?php dynamic_sidebar( 'slide-sidebar-area' ); ?>
        </div>
      <?php } ?>

    </div><!-- .side-aside-wrapper /-->
  </aside><!-- .side-aside /-->

<?php endif; ?>

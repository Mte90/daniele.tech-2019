<?php
/**
 * Right sidebar check.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

</div><!-- #closing the primary container -->

<?php

$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );

if ( is_home() || is_front_page() ) {
	get_template_part( 'sidebar-templates/sidebar', 'homepage' );
} elseif ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) {
	get_template_part( 'sidebar-templates/sidebar', 'right' );
}

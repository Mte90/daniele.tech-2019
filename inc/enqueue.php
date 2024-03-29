<?php
/**
 * Understrap enqueue scripts
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'understrap_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function understrap_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.css' );
		wp_enqueue_style( 'understrap-styles', get_stylesheet_directory_uri() . '/css/theme.css', array(), $css_version );

		wp_enqueue_script( 'jquery' );

		wp_enqueue_style( 'google-fonts', 'https://fonts.bunny.net/css?family=Oxygen:400,700&display=swap', array(), $css_version );
		wp_enqueue_style( 'fontawesome-solid', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/solid.min.css', array(), $css_version );
		wp_enqueue_style( 'fontawesome-brands', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/brands.min.css', array(), $css_version );
		wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/fontawesome.min.css', array(), $css_version );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.js' );
		wp_enqueue_script( 'understrap-scripts', get_template_directory_uri() . '/js/theme.js', array('jquery'), $js_version, true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // endif function_exists( 'understrap_scripts' ).

add_action( 'wp_enqueue_scripts', 'understrap_scripts' );

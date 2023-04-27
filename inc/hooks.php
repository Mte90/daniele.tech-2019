<?php
/**
 * Custom hooks.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'understrap_site_info' ) ) {
	/**
	 * Add site info hook to WP hook library.
	 */
	function understrap_site_info() {
		do_action( 'understrap_site_info' );
	}
}

if ( ! function_exists( 'understrap_add_site_info' ) ) {
	add_action( 'understrap_site_info', 'understrap_add_site_info' );

	/**
	 * Add site info content.
	 */
	function understrap_add_site_info() {
		$site_info = sprintf(
			'<a href="%1$s">%2$s</a><span class="sep"> | </span>%3$s',
			esc_url( __( 'https://www.classicpress.net/', 'understrap' ) ),
			sprintf(
				/* translators:*/
				esc_html__( 'Proudly powered by %s', 'understrap' ),
				'ClassicPress'
			),
			sprintf( // WPCS: XSS ok.
				/* translators:*/
				esc_html__( '%1$sTheme%2$s by Daniele Scasciafratte based on understrap', 'understrap' ),
				'<a href="https://github.com/Mte90/daniele.tech-2019">',
				'</a>'
			)
		);

		echo apply_filters( 'understrap_site_info_content', $site_info ); // WPCS: XSS ok.
	}
}


add_action( 'nav_menu_item_title', 'add_span_menu_item' );

function add_span_menu_item( $title ) {
	return '<span>' . $title . '</span>';
}

function gfont_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = '//fonts.bunny.net';
		$hints[] = '//www.google.com';
		$hints[] = '//stats.g.doubleclick.net';
	}

	return $hints;
}

add_filter( 'wp_resource_hints', 'gfont_resource_hints', 10, 2 );

function wpseo_disable_rel_author( $link ) {
    return false;
}
add_filter( 'wpseo_author_link', 'wpseo_disable_rel_author' );

if ( is_admin() ) {
    add_filter( 'list_terms_exclusions', 'hide_specific_category', 10, 2 );
    function hide_specific_category( $exclusions, $args ) {
        $exclusions = ' AND ( t.term_id NOT IN (281,283) )';
        return $exclusions;
    }
}

add_filter('the_content', function($content){
	// crayon filter regex
	$regex =
		// opening tag, language identifier (optional)
		'/<pre\s+class="nums:false lang:([a-z]+?)([^"]*)"\s*>' .

		// case insensitive, multiline
		'/im';

	// apply filter regex
	return preg_replace_callback($regex, function($match){
		return '<pre class="EnlighterJSRAW" data-enlighter-linenumbers="false" data-enlighter-language="' . esc_attr($match[1]) . '">';
	}, $content);
}, 1);

add_action( 'wp_enqueue_scripts', function() {
	if ( is_front_page() || is_archive() ) {
		wp_dequeue_style( 'enlighter-local-css' );
		wp_deregister_style( 'enlighter-local-css' );
	}
}, 200 );

add_filter( 'get_the_excerpt', 'replace_post_excerpt_filter' );

function replace_post_excerpt_filter($output) {
    $yoast = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);
    if (empty($yoast)) {
		return $output;
    }
    return $yoast;
}

add_filter( 'feed_link', 'add_lang_for_italian' );

function add_lang_for_italian($url) {
    if ( pll_current_language() == 'it' ) {
        return $url . '?lang=';
    }
    return $url;
}

add_filter('bsi_text', function($text) {
  return str_replace(' - Daniele Mte90 Scasciafratte', '', $text);
}, 100);

add_filter('feed_links_show_comments_feed', '__return_false');

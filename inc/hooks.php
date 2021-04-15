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
		$hints[] = '//fonts.googleapis.com';
		$hints[] = '//fonts.gstatic.com';
		$hints[] = '//cdnjs.cloudflare.com';
		$hints[] = '//mte90-mte90net.netdna-ssl.com';
		$hints[] = '//www.google.com';
		$hints[] = '//stats.g.doubleclick.net';
	}

	return $hints;
}

add_filter( 'wp_resource_hints', 'gfont_resource_hints', 10, 2 );

add_action( 'cmb2_admin_init', 'register_demo_metabox' );
function register_demo_metabox() {
	$prefix   = '_cmb_';
	$cmb_demo = new_cmb2_box(
        array(
		'id'           => 'mte_gp_metabox',
		'title'        => esc_html__( 'Link', 'understrap' ),
		'object_types' => array( 'guest_post' ), // Post type
        'context'      => 'normal',
	    'priority'     => 'high',
	    'show_names'   => true, // Show field names on the left
	)
        );
	$cmb_demo->add_field(
        array(
            'name' => __( 'Link', 'understrap' ),
            'id'   => $prefix . 'gp_link',
            'type' => 'text_url',
        )
    );
}

function theme_post_types() {
    $labels = array(
        'name'               => _x( 'Guest Posts', 'Post Type General Name', 'understrap' ),
        'singular_name'      => _x( 'Guest Post', 'Post Type Singular Name', 'understrap' ),
        'menu_name'          => __( 'Guest Post', 'understrap' ),
        'parent_item_colon'  => __( 'Parent Item:', 'understrap' ),
        'all_items'          => __( 'All Items', 'understrap' ),
        'view_item'          => __( 'View Item', 'understrap' ),
        'add_new_item'       => __( 'Add New Item', 'understrap' ),
        'add_new'            => __( 'Add New', 'understrap' ),
        'edit_item'          => __( 'Edit Item', 'understrap' ),
        'update_item'        => __( 'Update Item', 'understrap' ),
        'search_items'       => __( 'Search Item', 'understrap' ),
        'not_found'          => __( 'Not found', 'understrap' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'understrap' ),
    );
    $args   = array(
        'label'               => __( 'guest_post', 'understrap' ),
        'description'         => __( 'Guest Post', 'understrap' ),
        'labels'              => $labels,
        'supports'            => array( 'title' ),
        'taxonomies'          => array( 'category' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 11,
        'can_export'          => true,
        'has_archive'         => 'false',
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'rewrite'             => array( 'slug' => 'guest-post' ),
    );
    register_post_type( 'guest_post', $args );

    $labels = array(
        'name'               => _x( 'Books', 'Post Type General Name', 'understrap' ),
        'singular_name'      => _x( 'Book', 'Post Type Singular Name', 'understrap' ),
        'menu_name'          => __( 'Books Review', 'understrap' ),
        'parent_item_colon'  => __( 'Parent Item:', 'understrap' ),
        'all_items'          => __( 'All Items', 'understrap' ),
        'view_item'          => __( 'View Item', 'understrap' ),
        'add_new_item'       => __( 'Add New Item', 'understrap' ),
        'add_new'            => __( 'Add New', 'understrap' ),
        'edit_item'          => __( 'Edit Item', 'understrap' ),
        'update_item'        => __( 'Update Item', 'understrap' ),
        'search_items'       => __( 'Search Item', 'understrap' ),
        'not_found'          => __( 'Not found', 'understrap' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'understrap' ),
    );
    $args   = array(
        'label'              => __( 'books-review', 'understrap' ),
        'description'        => __( 'Books Review', 'understrap' ),
        'labels'             => $labels,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'         => array( 'category' ),
        'hierarchical'       => false,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true,
        'menu_position'      => 12,
        'can_export'         => true,
        'has_archive'        => 'true',
        'publicly_queryable' => true,
        'capability_type'    => 'page',
    );
    register_post_type( 'books-review', $args );

}

add_action( 'init', 'theme_post_types', 0 );
function append_query_string( $url ) {
    if ( 'guest_post' === get_post_type( get_the_ID() ) ) {
        return get_post_meta( get_the_ID(), '_cmb_gp_link', true );
    }

    return $url;
}

add_action( 'get_header', 'guest_redirect' );
function guest_redirect() {
    if ( is_single() ) {
        $url = append_query_string( '' );
        if ( !empty( $url ) ) {
            wp_redirect( $url, 301 );
            exit;
        }
    }
}

add_filter( 'the_permalink', 'append_query_string' );
add_filter( 'the_permalink_rss', 'guest_post_permalink' );
function guest_post_permalink( $link ) {
    $id = url_to_postid( $link );
    if ( 'guest_post' === get_post_type( $id ) ) {
        return get_post_meta( $id, '_cmb_gp_link', true );
    }

    return $link;
}

function wpseo_disable_rel_author( $link ) {
    return false;
}
add_filter( 'wpseo_author_link', 'wpseo_disable_rel_author' );

function feed_request( $qv ) {
    if ( isset( $qv[ 'feed' ] ) && !isset( $qv[ 'post_type' ] ) ) {
        $qv[ 'post_type' ] = array( 'post', 'guest_post', 'books-review' );
    }

    return $qv;
}
add_filter( 'request', 'feed_request' );

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
		wp_dequeue_style( 'github-oembed' );
		wp_deregister_style( 'github-oembed' );
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

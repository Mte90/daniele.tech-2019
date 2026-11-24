<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'body_class', 'understrap_body_classes' );

if ( ! function_exists( 'understrap_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	function understrap_body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}
}

// Removes tag class from the body_class array to avoid Bootstrap markup styling issues.
add_filter( 'body_class', 'understrap_adjust_body_class' );

if ( ! function_exists( 'understrap_adjust_body_class' ) ) {
	/**
	 * Setup body classes.
	 *
	 * @param string $classes CSS classes.
	 *
	 * @return mixed
	 */
	function understrap_adjust_body_class( $classes ) {
		foreach ( $classes as $key => $value ) {
			if ( 'tag' == $value ) {
				unset( $classes[ $key ] );
			}
		}

		return $classes;

	}
}

// Filter custom logo with correct classes.
add_filter( 'get_custom_logo', 'understrap_change_logo_class' );

if ( ! function_exists( 'understrap_change_logo_class' ) ) {
	/**
	 * Replaces logo CSS class.
	 *
	 * @param string $html Markup.
	 *
	 * @return mixed
	 */
	function understrap_change_logo_class( $html ) {
		$html = str_replace( 'class="custom-logo"', 'class="img-fluid"', $html );
		$html = str_replace( 'class="custom-logo-link"', 'class="navbar-brand custom-logo-link"', $html );
		$html = str_replace( 'alt=""', 'title="Home" alt="logo"', $html );

		return $html;
	}
}

/**
 * Display navigation to next/previous post when applicable.
 */

if ( ! function_exists( 'understrap_post_nav' ) ) {
	function understrap_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="container navigation post-navigation">
			<h2 class="sr-only"><?php _e( 'Post navigation', 'understrap' ); ?></h2>
			<div class="row nav-links justify-content-between">
				<?php
				if ( get_previous_post_link() ) {
					previous_post_link( '<span class="nav-previous">%link</span>', _x( '<i class="fa fa-angle-left"></i>&nbsp;%title', 'Previous post link', 'understrap' ) );
				}

				if ( get_next_post_link() ) {
					next_post_link( '<span class="nav-next">%link</span>', _x( '%title&nbsp;<i class="fa fa-angle-right"></i>', 'Next post link', 'understrap' ) );
				}
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}

/**
 * Add a pingback url auto-discovery header for single posts of any post type.
 */
function understrap_pingback() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'understrap_pingback' );

/**
 * Add mobile-web-app meta.
 */
function understrap_mobile_web_app_meta() {
	echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
	echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
	echo '<meta name="apple-mobile-web-app-title" content="' . esc_attr( get_bloginfo( 'name' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '">' . "\n";
}
add_action( 'wp_head', 'understrap_mobile_web_app_meta' );

function get_home_photo_carousel() {
	$photos = glob( realpath( get_template_directory() . '/img/foto' ) . '/*.*' );
	shuffle( $photos );
	$html   = '';
	$active = ' active';
	foreach ( $photos as &$photo ) {
		$html  .= '<div class="carousel-item' . $active . '" data-interval="2600">
			<img alt="Photo of me" src="' . str_replace( get_template_directory(), get_stylesheet_directory_uri(), $photo ) . '" />
			</div>';
		$active = '';
	}

	return $html;
}

function get_last_5_from_cat( $id, $item = 10 ) {
	// get the localized id
	$pl_id = $id;
	if(function_exists('pll_get_term')) {
		$pl_id    = pll_get_term( $id );
	}
	if(empty($pl_id)) {
		$pl_id = $id;
	}
	$out      = '<h3>' . get_cat_name( $pl_id ) . '</h3>';
	$out     .= '<ul>';
	$args     = array(
		'cat'              => array( $pl_id, $id ),
		'posts_per_page'   => $item,
		'order'            => 'DESC',
		'orderby'          => 'date',
		'category__not_in' => 272,
		'lang'			 => 'it,en',
	);
    if ( $id === 272 ) {
        unset($args['category__not_in']);
    }
	$catquery = new WP_Query( $args );

	while ( $catquery->have_posts() ) {
		$catquery->the_post();
		$out .= '<li><a href="' . get_the_permalink() . '">' . str_replace( 'My free software and open source activities of ' , '', get_the_title() ) . '</a></li>' . "\n";
	};
	$out .= '</ul>';

	$out .= '<span class="btn btn-success archive"><a href="' . get_category_link( $pl_id ) . '">' . __( 'Archive', 'understrap' ) . '</a></span>' . "\n";
	return $out;
}

function gh_month_pr( $atts ){
	$a = shortcode_atts( array(
		'date_end' => '',
		'date_before' => '',
		'month' => '',
		'year'  => date("Y"),
		'full' => ''
	), $atts );
	// `full` enables the previous-report link and the projects list: `full="..."` arrives as named attribute, a bare `full` as positional.
	$is_full = ! empty( $a['full'] ) || in_array( 'full', array_values( $atts ), true );
	$output_intro = ( ! empty( $a['month'] ) && $is_full ) ? gh_month_prev_report_link( $a['month'], $a['year'] ) : '';
	if ( !empty( $a[ 'month' ] ) ) {
		$dateString = $a[ 'year' ] . '-' . $a[ 'month' ] . '-04';
		$a[ 'date_before' ] = $a[ 'year' ] . '-' . $a[ 'month' ] . '-01';
		$a[ 'date_end' ] = date("Y-m-t", strtotime($dateString));
	}
	$output_gl = $output_gh = $output = '';

	if ( is_user_logged_in() || false === ( $output_gh = get_transient( 'github_month_status_'. $a[ 'month' ] . '_' . $a[ 'year' ] ) ) ) {
		$url = "https://api.github.com/search/issues?q=is:pr%20created:" . $a[ 'date_before' ] . ".." . $a[ 'date_end' ] . "%20author:mte90";
		$response = wp_remote_get( $url );
		$repos = json_decode( wp_remote_retrieve_body( $response ) );

		$output_gh = '<h3>GitHub</h3><ul>';

		foreach ($repos->items as $repo) {
			$output_gh .= '<li>';
			$output_gh .= '<a href="' . $repo->html_url . '" target="_blank">';
			$name = explode('/', $repo->html_url);
			$output_gh .= $name[3] . '/' . $name[4] . ' - ' . $repo->title;
			$output_gh .= '</a>';
			$output_gh .= '</li>';
		}

		$output_gh .= '</ul>';
		$url = "https://api.github.com/search/issues?q=is:issue%20created:" . trim( $a[ 'date_before' ] ) . ".." . trim( $a[ 'date_end' ] ) . "%20author:mte90";
		$response = wp_remote_get( $url );
		$repos = json_decode( wp_remote_retrieve_body( $response ) );
		$closed = $open = 0;
		foreach ($repos->items as $repo) {
            if( $repo->state === 'closed' ) {
                $closed++;
            } else if( $repo->state === 'open' ) {
                $open++;
            }
		}
		$output_gh .= '<a href="https://github.com/issues?q=archived%3Afalse+author%3AMte90+sort%3Aupdated-desc+created%3A%3E%3D' . $a[ 'date_before' ] . '+updated%3A%3C%3D' . $a[ 'date_end' ] . '+is%3Aissue+" target="_blank">This month on GitHub I opened ' . $open . ' tickets and closed ' . $closed . '.</a><br><br>';
		set_transient( 'github_month_status_' . $a[ 'month' ] . '_' . $a[ 'year' ], $output_gh, WEEK_IN_SECONDS);
	}

	$output = $output_intro . $output_gh;

	if ( false === ( $output_gl = get_transient( 'gitlab_month_status_'. $a[ 'month' ] . '_' . $a[ 'year' ] ) ) ) {
		$a[ 'date_end' ] = date("Y-m-t", strtotime($dateString));
		$url = "https://gitlab.com/api/v4/merge_requests?author_username=Mte90&created_after=" . trim( $a[ 'date_before' ] ) . "T08:00:00Z&created_before=" . trim( $a[ 'date_end' ] ) . "T24:00:00Z";
		$response = wp_remote_get( $url,array(
			'headers'     => array(
				'Authorization' => 'Bearer ' . GITLAB_TOKEN,
			),
		) );
		$repos = json_decode( wp_remote_retrieve_body( $response ) );

		$output_gl = '<h3>GitLab</h3>';
		if(is_object($repos) && $repos->error) {
			$output_gl .= "Token expired";
			$output .= $output_gl;
			return $output;
		}

		$output_gl .= '<ul>';

		foreach ($repos as $repo) {
			$name = explode('/', $repo->web_url);
			if ( $name[3] === 'codeat' ) {
				continue;
			}

			$output_gl .= '<li>';
			$output_gl .= '<a href="' . $repo->web_url . '" target="_blank">';
			$output_gl .= $name[3] . '/' . $name[4] . ' - ' . $repo->title;
			$output_gl .= '</a>';
			$output_gl .= '</li>';
		}

		$output_gl .= '</ul>';
		$url = "https://gitlab.com/api/v4/issues?author_username=Mte90&created_after=" . $a[ 'date_before' ] . "T08:00:00Z%20&created_before=" . $a[ 'date_end' ] . "T24:00:00Z";
		$response = wp_remote_get( $url,array(
			'headers'     => array(
				'Authorization' => 'Bearer ' . GITLAB_TOKEN,
			),
		) );
		$issues = json_decode( wp_remote_retrieve_body( $response ) );
		$closed = $open = 0;
		foreach ($issues as $issue) {
			$name = explode('/', $issue->web_url);
			if ( $name[3] === 'codeat' ) {
				continue;
			}

            if( $issue->state === 'closed' ) {
                $closed++;
            } else if( $issue->state === 'opened' ) {
                $open++;
            }
		}
		$output_gl .= '<a href="https://gitlab.com/dashboard/issues/?author_username=Mte90" target="_blank">This month on GitLab I opened ' . $open . ' tickets and closed ' . $closed . '.</a><br><br>';
		set_transient( 'gitlab_month_status_' . $a[ 'month' ] . '_' . $a[ 'year' ], $output_gl, WEEK_IN_SECONDS);
	}

	$output .= $output_gl;

	if ( ! empty( $a['month'] ) && $is_full ) {
		$output .= gh_month_projects( $a['month'], $a['year'] );
	}

	return $output;
}
add_shortcode( 'gh_month_pr', 'gh_month_pr' );

function gh_month_prev_report_link( $month, $year ) {
	$previous = ( new DateTime( $year . '-' . $month . '-01' ) )->modify( 'first day of previous month' );
	$slug     = 'my-free-software-and-open-source-activities-of-' . strtolower( $previous->format( 'F' ) ) . '-' . $previous->format( 'Y' );
	$query    = new WP_Query( array(
		'post_type'      => 'post',
		'name'           => $slug,
		'lang'           => 'en',
		'posts_per_page' => 1,
		'no_found_rows'  => true,
	) );
	if ( empty( $query->posts ) ) {
		return '';
	}
	return '<p>What has happened this month? In the meantime, to read the previous report, go <a href="' . esc_url( get_permalink( $query->posts[0] ) ) . '">here</a>.</p>';
}

function gh_month_github_get( $path ) {
	$response = wp_remote_get( 'https://api.github.com/' . $path );
	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		return null;
	}
	$data = json_decode( wp_remote_retrieve_body( $response ) );
	return is_array( $data ) ? $data : null;
}

function gh_month_projects( $month, $year ) {
	$transient_key = 'github_month_projects_' . $month . '_' . $year;
	if ( ! is_user_logged_in() && false !== ( $cached = get_transient( $transient_key ) ) ) {
		return $cached;
	}

	$start    = sprintf( '%s-%02d-01T00:00:00Z', $year, $month );
	$end      = date( 'Y-m-t', strtotime( $year . '-' . $month . '-04' ) ) . 'T23:59:59Z';
	$projects = array();

	foreach ( array( 'users/mte90/repos', 'orgs/CodeAtCode/repos' ) as $repos_path ) {
		$page = 1;
		do {
			$repos = gh_month_github_get( $repos_path . '?per_page=100&page=' . $page );
			if ( null === $repos ) {
				// GitHub request failed (rate limit or outage): drop the section and retry in a few minutes instead of showing an error to visitors.
				set_transient( $transient_key, '', 5 * MINUTE_IN_SECONDS );
				return '';
			}
			foreach ( $repos as $repo ) {
				// Forks carry no releases of their own, and a release published in range always moves `pushed_at` past the month start.
				if ( $repo->fork || $repo->pushed_at < $start ) {
					continue;
				}
				$releases = gh_month_github_get( 'repos/' . $repo->full_name . '/releases?per_page=100' );
				if ( null === $releases ) {
					set_transient( $transient_key, '', 5 * MINUTE_IN_SECONDS );
					return '';
				}
				$latest = null;
				foreach ( $releases as $release ) {
					if ( $release->published_at < $start || $release->published_at > $end ) {
						continue;
					}
					if ( null === $latest || $release->published_at > $latest->published_at ) {
						$latest = $release;
					}
				}
				if ( null !== $latest ) {
					$projects[] = array(
						'url'  => $latest->html_url,
						'name' => $repo->full_name . ' ' . $latest->tag_name,
						'date' => $latest->published_at,
					);
				}
			}
			$page++;
		} while ( count( $repos ) === 100 );
	}

	usort( $projects, function ( $left, $right ) {
		return strcmp( $right['date'], $left['date'] );
	} );

	$output = '';
	if ( ! empty( $projects ) ) {
		$output = '<h3>Projects</h3><ul>';
		foreach ( $projects as $project ) {
			$output .= '<li><a href="' . esc_url( $project['url'] ) . '">' . esc_html( $project['name'] ) . '</a> – ' . gmdate( 'Y/m/d', strtotime( $project['date'] ) ) . '</li>';
		}
		$output .= '</ul>';
	}
	set_transient( $transient_key, $output, WEEK_IN_SECONDS );
	return $output;
}

add_shortcode( 'alert', 'daniele_alert' );
function daniele_alert( $atts, $content = null ) {
	return '<div class="alert alert-warning">' . $content . '</div>';
}

function remove_pages_from_search($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts','remove_pages_from_search');

remove_action( 'wp_head', 'feed_links_extra', 3 );
add_filter( 'wpseo_robots', 'noindex_subcategory_pages' );

function noindex_subcategory_pages( $robotsstr ) {
	if ( is_archive() && is_paged() && intval(get_query_var('paged')) > 10 ) {
		return 'noindex,follow';
	}

	return $robotsstr;
}

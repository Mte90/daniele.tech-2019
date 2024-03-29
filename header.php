<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-M1X9XPS3F8"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-M1X9XPS3F8');
	</script>
</head>

<body <?php body_class(); ?>>

<div class="site" id="page">

	<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">

		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

		<nav class="navbar navbar-expand-md navbar-dark bg-info">

		<?php if ( 'container' === $container ) : ?>
			<div class="container mw-100" >
		<?php endif; ?>

		<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a> The Open Source Multiversal Guy

		<?php if ( 'container' === $container ) : ?>
			</div>
		<?php endif; ?>

		</nav>

	</div>

	<nav class="navbar navbar-expand-sm navbar-dark navbar-left bg-info d-md-block">
		<button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
			<span class="navbar-toggler-icon"></span>
		</button>

<?php
wp_nav_menu(
	array(
		'theme_location'  => 'primary',
		'container_class' => 'collapse navbar-collapse',
		'container_id'    => 'navbarNavDropdown',
		'menu_class'      => 'navbar-nav ml-auto',
		'fallback_cb'     => '',
		'menu_id'         => 'main-menu',
		'depth'           => 2,
		'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
	)
);
?>
	</nav>

	<nav class="navbar navbar-expand-sm navbar-dark navbar-right bg-info d-md-block">
		<button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarSocial" aria-controls="navbarSocial" aria-expanded="false" aria-abel="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
			<span class="fa fa-share-alt"></span>
		</button>

<?php
wp_nav_menu(
	array(
		'theme_location'  => 'social',
		'container_class' => 'collapse navbar-collapse',
		'container_id'    => 'navbarSocial',
		'menu_class'      => 'navbar-nav ml-auto',
		'fallback_cb'     => '',
		'menu_id'         => 'social-menu',
		'depth'           => 2,
		'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
	)
);
?>
	</nav>

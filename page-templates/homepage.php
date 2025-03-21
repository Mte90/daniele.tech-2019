<?php
/**
 * Template Name: HomePage
 *
 * Template for HomePage.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="home-page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?> mw-100" id="content">

		<div class="row">

			<div class="col-md-9 content-area" id="primary">

				<main class="site-main" id="main" role="main">
					<div class="container mw-100 category-block">
						<div class="row">
							<div class="col-md-6">
								<?php echo get_last_5_from_cat( 272 ); ?>
							</div>
							<div class="col-md-6">
								<?php echo get_last_5_from_cat( 75 ); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<?php echo get_last_5_from_cat( 290 ); ?>
							</div>
							<div class="col-md-6">
								<?php echo get_last_5_from_cat( 85 ); ?>
							</div>
						</div>
					</div>
				</main>

			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div>

	</div><!-- #content -->

</div><!-- #full-width-page-wrapper -->

<?php
get_footer();

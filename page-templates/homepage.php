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

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row">

			<div class="col-md-8 content-area" id="primary">

				<main class="site-main" id="main" role="main">
					<div class="container category-block">
						<div class="row">
							<div class="col-md-6">
								<p>
                                    <a href="https://daniele.tech/2020/07/contribute-to-open-source-the-right-way-2nd-edition-download-the-free-open-book-now"><img class="wp-image-4261 size-medium aligncenter" src="https://daniele.tech/wp-content/uploads/2020/07/cover-300x279.png" alt="" width="300" height="279" /></a>
								</p>
							</div>
							<div class="col-md-6">
								<p>
                                    <img class="aligncenter wp-image-4335 size-medium" src="https://daniele.tech/wp-content/uploads/2020/12/Open_source1-300x300.png" alt="" width="300" height="300" />
                                </p>
							</div>
						</div>
					</div>
					<div class="container category-block">
						<div class="row">
							<div class="col-md-6">
								<?php echo get_last_5_from_cat( 294 ); ?>
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

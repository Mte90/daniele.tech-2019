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
                                    <a href="https://daniele.tech/2022/09/contribute-to-open-source-the-right-way-3nd-edition/"><img class="wp-image-4261 size-medium aligncenter" src="https://daniele.tech/wp-content/uploads/2022/09/cover-2022-1-300x300.png" alt="" width="300" height="300" /></a>
								</p>
							</div>
							<div class="col-md-6">
								<p>
                                    <a href="https://daniele.tech/podcast/"><img class="aligncenter wp-image-4335 size-medium" src="https://daniele.tech/wp-content/uploads/2020/12/Open_source1-300x300.png" alt="" width="300" height="300" /></a>
                                </p>
							</div>
						</div>
					</div>
					<div class="container category-block">
						<div class="row">
							<div class="col-md-6">
								<?php echo get_last_5_from_cat( 272, 10 ); ?>
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

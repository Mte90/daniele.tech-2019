<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">
		<ul>
		<?php
		pll_the_languages( array( 'show_flags' => 1 ) );
		echo '</ul>';
		the_title( '<h1 class="entry-title">', '</h1>' );
		?>

		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

<?php
wp_link_pages(
	array(
		'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
		'after'  => '</div>',
	)
);
?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

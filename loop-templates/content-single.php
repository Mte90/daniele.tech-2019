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
		pll_the_languages( array( 'show_flags' => 1, 'hide_if_no_translation' => 1, 'hide_current' => 1 ) );
		echo '</ul>';
		the_title( '<h1 class="entry-title">', '</h1>' );
		?>

		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php
			echo '<div class="alert alert-success" role="alert">';
			_e( '<a href="https://daniele.tech/2022/09/contribute-to-open-source-the-right-way-3rd-edition/">"Contribute to Open Source: the right way"</a> is my free and open source book, about... <i>Open Source</i>!<br>It will help you improve your skills and understand how to start this journey!', 'understrap' );
			echo '</div>';
			if ( pll_current_language() === 'it' ) {
				echo '<div class="alert alert-success" role="alert">';
				_e( 'Ascolta il mio podcast settimanale <a href="https://daniele.tech/podcast/"><b>Opinioni in Open Source</b><a/>!', 'understrap' );
				echo '</div>';
			}

			the_content();
		?>

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

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
			if ( get_post_type( get_the_ID() ) === 'books-review' ) {
				echo '<div class="alert alert-success" role="alert">';
				_e( 'This is a review of a book that I read and I want to suggest. I am not getting money of it also because I don\'t put links of online shops. It is not a professional review!', 'understrap' );
				echo '</div>';
			}
			the_content();

			echo '<div class="alert alert-success" role="alert">';
			_e( 'I published a free and open source book... <b>"Contribute to Open Source: the right way"</b>! You can <a href="https://daniele.tech/2020/07/contribute-to-open-source-the-right-way-2nd-edition-download-the-free-open-book-now/">download your copy for free</a> :-D', 'understrap' );
			echo '</div>';
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

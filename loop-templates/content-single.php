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

		<?php
			if ( get_post_type( get_the_ID() ) === 'books-review' ) {
				echo '<div class="alert alert-success" role="alert">';
				_e( 'This is a review of a book that I read and I want to suggest. I am not getting money of it also because I don\'t put links of online shops. It is not a professional review!', 'understrap' );
				echo '</div>';
			}
			the_content();

			echo '<div class="alert alert-success" role="alert">';
			_e( 'I published a free and open source book... about "Contribute to Open Source: the right way"! You can <a href="https://daniele.tech/2019/10/contribute-to-opensource-the-right-way-book/">download your copy for free</a> :-D', 'understrap' );
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

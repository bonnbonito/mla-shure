<?php
/**
 * The template for displaying login/register page.
 * Template Name: Register
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MLAShure
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'login' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();

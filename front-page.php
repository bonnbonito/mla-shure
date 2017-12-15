<?php
/**
 * The template for displaying front page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MLAShure
 */

get_header(); ?>

	<div class="front-banner">
		<div class="ui container">
			<div class="ui segment vertical">
				<div class="ui two column grid stackable middle aligned fullheight">
					<div class="column">
						<h1>Learn Basic and Advanced Mathematic & Much More</h1>
						<h3>Lorem ipsum dolor sit amet, ne virtute alienum usu. Etiam delicatissimi mea an, est nihil equidem eloquentiam ne. </h3>
					</div>
					<div class="column">
						<?php get_template_part('template-parts/front', 'form'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'front' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
